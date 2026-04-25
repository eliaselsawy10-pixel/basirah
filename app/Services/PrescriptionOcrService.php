<?php

namespace App\Services;

use Google\Cloud\Vision\V1\AnnotateImageRequest;
use Google\Cloud\Vision\V1\Feature;
use Google\Cloud\Vision\V1\Feature\Type;
use Google\Cloud\Vision\V1\Image;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PrescriptionOcrService
{
    /**
     * Confidence threshold below which a value gets flagged for review.
     */
    protected float $confidenceThreshold;

    /**
     * Known label patterns for row identification.
     */
    protected array $rightEyePatterns = ['right', 'rt', 'od', 'r.e', 'r.e.', 'ر', 'يمين'];
    protected array $leftEyePatterns  = ['left', 'lt', 'os', 'l.e', 'l.e.', 'ل', 'يسار'];

    /**
     * Known label patterns for column identification.
     */
    protected array $sphPatterns  = ['sph', 'sphere', 'spher', 'sp', 'spi', 'كرة'];
    protected array $cylPatterns  = ['cyl', 'cylinder', 'cylindre', 'cy', 'اسطوانة'];
    protected array $axisPatterns = ['axis', 'ax', 'axe', 'axes', 'محور'];
    protected array $pdPatterns   = ['pd', 'p.d', 'p.d.', 'pupil', 'pupillary', 'بعد'];

    public function __construct()
    {
        $this->confidenceThreshold = (float) config('services.ocr.confidence_threshold', 0.75);
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  1. IMAGE PRE-PROCESSING
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Enhance the prescription image for better OCR accuracy.
     *
     * Applies: Greyscale → Contrast boost → Sharpen
     * Returns the path to the processed temporary file.
     */
    public function preprocess(string $imagePath): string
    {
        $manager = new ImageManager(new Driver());
        $image   = $manager->read($imagePath);

        // Convert to greyscale — removes color noise
        $image->greyscale();

        // Boost contrast — makes faint handwriting stand out (+30 is moderate)
        $image->contrast(30);

        // Sharpen — crisps up edges of handwritten characters
        $image->sharpen(15);

        // Save to a temp file
        $processedPath = storage_path('app/private/ocr_temp_' . uniqid() . '.jpg');
        $image->toJpeg(quality: 90)->save($processedPath);

        return $processedPath;
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  2. GOOGLE VISION API CALL
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Send image to Google Cloud Vision and get full text annotations.
     *
     * Uses DOCUMENT_TEXT_DETECTION for structured output with bounding boxes.
     *
     * @return array{fullText: string, pages: array, words: array}
     */
    public function callVisionApi(string $imagePath): array
    {
        $credentialsPath = base_path(config('services.google_vision.credentials'));

        $client = new ImageAnnotatorClient([
            'credentials' => $credentialsPath,
        ]);

        try {
            $imageContent = file_get_contents($imagePath);
            $image = (new Image())->setContent($imageContent);

            $feature = (new Feature())->setType(Type::DOCUMENT_TEXT_DETECTION);

            $request = (new AnnotateImageRequest())
                ->setImage($image)
                ->setFeatures([$feature]);

            $response = $client->batchAnnotateImages([$request]);
            $annotateResponse = $response->getResponses()[0];

            if ($annotateResponse->getError()) {
                $errorMessage = $annotateResponse->getError()->getMessage();
                Log::error('Google Vision API error', ['error' => $errorMessage]);
                throw new \RuntimeException("Vision API error: {$errorMessage}");
            }

            $fullTextAnnotation = $annotateResponse->getFullTextAnnotation();

            if (!$fullTextAnnotation) {
                return ['fullText' => '', 'pages' => [], 'words' => []];
            }

            // Extract all words with their bounding boxes and confidence scores
            $words = $this->extractWordsFromAnnotation($fullTextAnnotation);

            return [
                'fullText' => $fullTextAnnotation->getText(),
                'words'    => $words,
            ];
        } finally {
            $client->close();
        }
    }

    /**
     * Extract every word with its bounding box and confidence from the annotation.
     */
    protected function extractWordsFromAnnotation($fullTextAnnotation): array
    {
        $words = [];

        foreach ($fullTextAnnotation->getPages() as $page) {
            foreach ($page->getBlocks() as $block) {
                foreach ($block->getParagraphs() as $paragraph) {
                    foreach ($paragraph->getWords() as $word) {
                        // Assemble the word text from symbols
                        $wordText = '';
                        $symbolConfidences = [];

                        foreach ($word->getSymbols() as $symbol) {
                            $wordText .= $symbol->getText();
                            $symbolConfidences[] = $symbol->getProperty()
                                ? $symbol->getProperty()->getDetectedBreak()
                                    ? $symbol->getConfidence()
                                    : $symbol->getConfidence()
                                : $symbol->getConfidence();
                        }

                        // Average confidence of all symbols in this word
                        $avgConfidence = count($symbolConfidences) > 0
                            ? array_sum($symbolConfidences) / count($symbolConfidences)
                            : 0.0;

                        // Get bounding box
                        $boundingBox = $word->getBoundingBox();
                        $vertices = [];
                        if ($boundingBox) {
                            foreach ($boundingBox->getVertices() as $vertex) {
                                $vertices[] = [
                                    'x' => $vertex->getX(),
                                    'y' => $vertex->getY(),
                                ];
                            }
                        }

                        // Calculate center point for zone mapping
                        $centerX = 0;
                        $centerY = 0;
                        if (count($vertices) === 4) {
                            $centerX = ($vertices[0]['x'] + $vertices[2]['x']) / 2;
                            $centerY = ($vertices[0]['y'] + $vertices[2]['y']) / 2;
                        }

                        $words[] = [
                            'text'       => $wordText,
                            'confidence' => round($avgConfidence, 4),
                            'vertices'   => $vertices,
                            'centerX'    => $centerX,
                            'centerY'    => $centerY,
                        ];
                    }
                }
            }
        }

        return $words;
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  3. BOUNDING BOX COORDINATE LOGIC — FIELD MAPPING
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Map detected words to prescription fields using bounding box coordinates.
     *
     * ALGORITHM:
     * ┌────────────────────────────────────────────────────────────┐
     * │  Step 1: Find row anchors (Right/Left labels → Y coords)  │
     * │  Step 2: Find column anchors (SPH/CYL/AXIS → X coords)   │
     * │  Step 3: For each numeric word, assign to the nearest     │
     * │          row+column zone based on its center coordinates   │
     * │  Step 4: Find PD value near its label                     │
     * └────────────────────────────────────────────────────────────┘
     */
    public function mapFieldsByBoundingBox(array $words): array
    {
        $result = [
            'right' => ['sph' => null, 'cyl' => null, 'axis' => null],
            'left'  => ['sph' => null, 'cyl' => null, 'axis' => null],
            'pd'    => null,
        ];

        // — Step 1: Find row anchors ——————————————————————————————————————
        $rightRowY = null;
        $leftRowY  = null;
        $pdAnchor  = null;

        // — Step 2: Find column anchors ———————————————————————————————————
        $sphColumnX  = null;
        $cylColumnX  = null;
        $axisColumnX = null;

        foreach ($words as $word) {
            $lower = mb_strtolower(trim($word['text']));

            // Row labels
            if ($this->matchesAny($lower, $this->rightEyePatterns)) {
                $rightRowY = $word['centerY'];
            }
            if ($this->matchesAny($lower, $this->leftEyePatterns)) {
                $leftRowY = $word['centerY'];
            }

            // Column headers
            if ($this->matchesAny($lower, $this->sphPatterns)) {
                $sphColumnX = $word['centerX'];
            }
            if ($this->matchesAny($lower, $this->cylPatterns)) {
                $cylColumnX = $word['centerX'];
            }
            if ($this->matchesAny($lower, $this->axisPatterns)) {
                $axisColumnX = $word['centerX'];
            }

            // PD label
            if ($this->matchesAny($lower, $this->pdPatterns)) {
                $pdAnchor = $word;
            }
        }

        // — Step 3: If we couldn't find explicit row/column anchors,
        //   fall back to positional heuristics ————————————————————————————
        if (!$rightRowY || !$leftRowY) {
            return $this->fallbackParsing($words, $result);
        }

        // Define Y-tolerance: half the distance between rows
        $rowSpread  = abs($leftRowY - $rightRowY);
        $yTolerance = $rowSpread * 0.6; // generous overlap allowance

        // Column tolerance: if column headers found, use generous X range
        $columnAnchors = array_filter([
            'sph'  => $sphColumnX,
            'cyl'  => $cylColumnX,
            'axis' => $axisColumnX,
        ]);

        // — Step 4: Assign each numeric word to a field ———————————————————
        foreach ($words as $word) {
            $numericValue = $this->extractNumericValue($word['text']);
            if ($numericValue === null) {
                continue;
            }

            // Determine which row: Right or Left
            $distToRight = abs($word['centerY'] - $rightRowY);
            $distToLeft  = abs($word['centerY'] - $leftRowY);

            if ($distToRight > $yTolerance && $distToLeft > $yTolerance) {
                // This number isn't near either row — might be PD or noise
                continue;
            }

            $eye = ($distToRight <= $distToLeft) ? 'right' : 'left';

            // Determine which column
            $column = $this->findClosestColumn($word['centerX'], $columnAnchors);

            if ($column && $result[$eye][$column] === null) {
                $result[$eye][$column] = [
                    'value'      => $numericValue,
                    'confidence' => $word['confidence'],
                    'flagged'    => $word['confidence'] < $this->confidenceThreshold,
                    'raw_text'   => $word['text'],
                ];
            }
        }

        // — Step 5: Find PD value ————————————————————————————————————————
        $result['pd'] = $this->findPdValue($words, $pdAnchor);

        return $result;
    }

    /**
     * Find the closest column header for a given X coordinate.
     */
    protected function findClosestColumn(float $x, array $columnAnchors): ?string
    {
        if (empty($columnAnchors)) {
            return null;
        }

        $closest  = null;
        $minDist  = PHP_FLOAT_MAX;

        foreach ($columnAnchors as $name => $anchorX) {
            if ($anchorX === null) continue;

            $dist = abs($x - $anchorX);
            if ($dist < $minDist) {
                $minDist  = $dist;
                $closest  = $name;
            }
        }

        return $closest;
    }

    /**
     * Find the PD value: the closest number to the PD label.
     */
    protected function findPdValue(array $words, ?array $pdAnchor): ?array
    {
        if (!$pdAnchor) {
            // Try to find any word matching common PD value format (2-3 digit number, 50–80 range)
            foreach ($words as $word) {
                $value = $this->extractNumericValue($word['text']);
                if ($value !== null && $value >= 40 && $value <= 80 && floor($value) == $value) {
                    return [
                        'value'      => (int) $value,
                        'confidence' => $word['confidence'],
                        'flagged'    => $word['confidence'] < $this->confidenceThreshold,
                        'raw_text'   => $word['text'],
                    ];
                }
            }
            return null;
        }

        // Find the closest numeric word to the PD anchor
        $closestWord = null;
        $minDistance  = PHP_FLOAT_MAX;

        foreach ($words as $word) {
            $value = $this->extractNumericValue($word['text']);
            if ($value === null) continue;

            // PD is typically 40–80mm
            if ($value < 30 || $value > 85) continue;

            $distance = sqrt(
                pow($word['centerX'] - $pdAnchor['centerX'], 2) +
                pow($word['centerY'] - $pdAnchor['centerY'], 2)
            );

            if ($distance < $minDistance) {
                $minDistance  = $distance;
                $closestWord = $word;
            }
        }

        if (!$closestWord) {
            return null;
        }

        $value = $this->extractNumericValue($closestWord['text']);

        return [
            'value'      => is_float($value) ? $value : (int) $value,
            'confidence' => $closestWord['confidence'],
            'flagged'    => $closestWord['confidence'] < $this->confidenceThreshold,
            'raw_text'   => $closestWord['text'],
        ];
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  4. FALLBACK: SEQUENTIAL PARSING
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Fallback parser when row/column headers can't be found via coordinates.
     *
     * Scans the full OCR text looking for numeric patterns after known labels.
     */
    protected function fallbackParsing(array $words, array $result): array
    {
        // Collect all numbers with their positions sorted top-to-bottom, left-to-right
        $numbers = [];
        foreach ($words as $word) {
            $value = $this->extractNumericValue($word['text']);
            if ($value !== null) {
                $numbers[] = [
                    'value'      => $value,
                    'confidence' => $word['confidence'],
                    'raw_text'   => $word['text'],
                    'x'          => $word['centerX'],
                    'y'          => $word['centerY'],
                ];
            }
        }

        // Sort by Y first, then by X (reading order)
        usort($numbers, function ($a, $b) {
            $yDiff = $a['y'] - $b['y'];
            // If on roughly the same line (within 20px), sort by X
            if (abs($yDiff) < 20) {
                return $a['x'] <=> $b['x'];
            }
            return $yDiff <=> 0;
        });

        // Expect 6 refraction values (Right: SPH CYL AXIS, Left: SPH CYL AXIS)
        // followed by PD
        $fields = ['sph', 'cyl', 'axis'];

        // Filter out potential PD values (whole numbers 40-80)
        $refractionNumbers = [];
        $pdCandidates = [];

        foreach ($numbers as $num) {
            if ($num['value'] >= 40 && $num['value'] <= 80 && floor($num['value']) == $num['value']) {
                $pdCandidates[] = $num;
            } else {
                $refractionNumbers[] = $num;
            }
        }

        // Assign first 3 numbers to Right eye, next 3 to Left eye
        foreach ($refractionNumbers as $i => $num) {
            $eye   = $i < 3 ? 'right' : 'left';
            $field = $fields[$i % 3] ?? null;

            if ($field && isset($result[$eye][$field])) {
                $result[$eye][$field] = [
                    'value'      => $num['value'],
                    'confidence' => $num['confidence'],
                    'flagged'    => $num['confidence'] < $this->confidenceThreshold,
                    'raw_text'   => $num['raw_text'],
                ];
            }

            if ($i >= 5) break; // Only need 6 values
        }

        // PD: take the best candidate
        if (!empty($pdCandidates)) {
            $pd = $pdCandidates[0];
            $result['pd'] = [
                'value'      => (int) $pd['value'],
                'confidence' => $pd['confidence'],
                'flagged'    => $pd['confidence'] < $this->confidenceThreshold,
                'raw_text'   => $pd['raw_text'],
            ];
        }

        return $result;
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  5. UTILITY METHODS
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Extract a numeric value from OCR text, handling common misreads.
     *
     * Handles:
     *  - "-4.5", "+1.25", "180", "68"
     *  - OCR misreads like "−4.5" (en-dash), "1.2S" (S→5), "O.75" (O→0)
     */
    public function extractNumericValue(string $text): ?float
    {
        // Normalize the text
        $text = trim($text);

        // Replace common OCR misread characters
        $replacements = [
            '−' => '-',  // en-dash → minus
            '–' => '-',  // em-dash → minus
            'O' => '0',  // letter O → zero
            'o' => '0',  // lowercase o → zero
            'S' => '5',  // S → 5
            'l' => '1',  // lowercase L → 1
            'I' => '1',  // uppercase I → 1
            'B' => '8',  // B → 8
            'G' => '6',  // G → 6
            'Z' => '2',  // Z → 2
            'T' => '7',  // T → 7 (in number context only)
            ' ' => '',   // remove spaces
        ];

        $cleaned = $text;
        foreach ($replacements as $from => $to) {
            $cleaned = str_replace($from, $to, $cleaned);
        }

        // Match numeric pattern: optional sign, digits, optional decimal
        if (preg_match('/^([+-]?\d+\.?\d*)$/', $cleaned, $matches)) {
            return (float) $matches[1];
        }

        return null;
    }

    /**
     * Check if a string matches any pattern in the list.
     */
    protected function matchesAny(string $text, array $patterns): bool
    {
        foreach ($patterns as $pattern) {
            if ($text === $pattern || str_contains($text, $pattern)) {
                return true;
            }
        }
        return false;
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  6. MAIN ENTRY POINT
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Process a prescription image and return structured data.
     *
     * @param string $imagePath Path to the uploaded image
     * @return array Structured result with confidence scores
     */
    public function process(string $imagePath): array
    {
        // Step 1: Pre-process the image
        $processedPath = $this->preprocess($imagePath);

        try {
            // Step 2: Call Google Vision API
            $apiResult = $this->callVisionApi($processedPath);

            if (empty($apiResult['words'])) {
                return [
                    'success'  => false,
                    'message'  => 'No text detected in the image. Please ensure the prescription is clear and well-lit.',
                    'data'     => null,
                    'warnings' => [],
                ];
            }

            // Step 3: Map fields using bounding box coordinates
            $mappedFields = $this->mapFieldsByBoundingBox($apiResult['words']);

            // Step 4: Build response with warnings
            $warnings = $this->collectWarnings($mappedFields);

            return [
                'success'   => true,
                'data'      => $mappedFields,
                'raw_text'  => $apiResult['fullText'],
                'warnings'  => $warnings,
            ];
        } finally {
            // Clean up temp file
            if (file_exists($processedPath)) {
                unlink($processedPath);
            }
        }
    }

    /**
     * Generate user-friendly warnings for flagged fields.
     */
    protected function collectWarnings(array $mappedFields): array
    {
        $warnings = [];
        $labels = [
            'right' => 'Right Eye',
            'left'  => 'Left Eye',
        ];

        foreach (['right', 'left'] as $eye) {
            foreach (['sph', 'cyl', 'axis'] as $field) {
                $data = $mappedFields[$eye][$field] ?? null;
                if ($data === null) {
                    $warnings[] = strtoupper($field) . " ({$labels[$eye]}) could not be detected. Please enter manually.";
                } elseif ($data['flagged']) {
                    $pct = round($data['confidence'] * 100);
                    $warnings[] = strtoupper($field) . " ({$labels[$eye]}) has low confidence ({$pct}%). Please verify the value: {$data['value']}";
                }
            }
        }

        $pd = $mappedFields['pd'] ?? null;
        if ($pd === null) {
            $warnings[] = "P.D. could not be detected. Please enter manually.";
        } elseif ($pd['flagged']) {
            $pct = round($pd['confidence'] * 100);
            $warnings[] = "P.D. has low confidence ({$pct}%). Please verify the value: {$pd['value']}";
        }

        return $warnings;
    }
}
