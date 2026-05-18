<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Prescription;

class PrescriptionController extends Controller
{
    /**
     * Show the form for creating a new prescription.
     * Pre-fills from session data if the user returns to edit.
     */
    public function create(Request $request)
    {
        $product = null;
        $isContact = false;

        if ($request->has('product_id')) {
            $product = \App\Models\Product::find($request->product_id);
            if ($product) {
                $isContact = $product->is_contact_lens;
            }
        }

        // Pre-fill form from session if user is returning to edit
        $sessionRx = session('prescription');

        return view('prescriptions.create', compact('product', 'isContact', 'sessionRx'));
    }

    /**
     * Process an uploaded prescription image via Google Gemini 2.5 Flash.
     * Sends the image to Gemini with a structured prompt and receives
     * extracted SPH, CYL, AXIS, and PD as clean JSON.
     */
    public function ocr(Request $request): JsonResponse
    {
        // 1. Validate the Upload
        $request->validate([
            'prescription_image' => [
                'required',
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:5120', // 5MB limit
            ],
        ], [
            'prescription_image.required' => 'Please upload a prescription image.',
            'prescription_image.image' => 'The file must be a valid image.',
            'prescription_image.mimes' => 'Please upload a JPEG, PNG, or WebP image.',
        ]);

        try {
            // 2. Read the image and encode as base64
            $file = $request->file('prescription_image');
            $imageData = base64_encode(file_get_contents($file->getRealPath()));
            $mimeType = $file->getMimeType();

            // 3. Bring API key from .env file. 
            $apiKey = config('services.gemini.api_key');

            if (empty($apiKey)) {
                throw new \Exception('Gemini API key is not configured. Please add GEMINI_API_KEY to your .env file.');
            }

            $geminiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . $apiKey;

            $systemPrompt = <<<PROMPT
You are an expert optical prescription reader. Analyze this optical prescription image and extract the refraction data.

Extract the following values for BOTH eyes:
- **Right Eye (OD)**: SPH (Sphere), CYL (Cylinder), AXIS
- **Left Eye (OS)**: SPH (Sphere), CYL (Cylinder), AXIS
- **PD** (Pupillary Distance) if visible

Rules:
1. SPH and CYL values should include their sign (+ or -). Example: +1.25, -2.00
2. AXIS is always a whole number between 0 and 180.
3. PD is typically between 40 and 80 mm.
4. If a value is not found or unreadable, use null.
5. Return ONLY a valid JSON object with no extra text, no markdown, no code fences.

Return format:
{"right":{"sph":null,"cyl":null,"axis":null},"left":{"sph":null,"cyl":null,"axis":null},"pd":null}
PROMPT;

            // 4. Send request to Gemini 2.5 Flash
            $response = Http::timeout(60)->post($geminiUrl, [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $systemPrompt,
                            ],
                            [
                                'inline_data' => [
                                    'mime_type' => $mimeType,
                                    'data' => $imageData,
                                ],
                            ],
                        ],
                    ],
                ],
                // Settings for AI itself. 
                'generationConfig' => [
                    'temperature' => 0.1,
                    'maxOutputTokens' => 500,
                    'responseMimeType' => 'application/json',
                ],
            ]);

            // 5. Handle API errors
            if ($response->failed()) {
                $errorBody = $response->json();
                $errorMessage = $errorBody['error']['message'] ?? 'Unknown Gemini API error';
                Log::error('Gemini API Error', [
                    'status' => $response->status(),
                    'error' => $errorMessage,
                ]);
                throw new \Exception('Gemini API returned an error: ' . $errorMessage);
            }

            // 6. Extract the text response from Gemini
            $responseData = $response->json();
            $generatedText = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? '';

            if (empty(trim($generatedText))) {
                return response()->json([
                    'success' => false,
                    'message' => 'The image is too blurry or no prescription data was detected. Please upload a clearer image.',
                ], 422);
            }

            // 7. Parse the JSON from Gemini's response
            $jsonText = trim($generatedText);
            // Decode JSON String into Array
            // Before:
            // {"right":{"sph":1.25},"left":{"sph":1.00}}
            // After:
            // [
            //     "right" => ["sph" => 1.25],
            //     "left" => ["sph" => 1.00]
            // ]
            $extractedData = json_decode($jsonText, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::warning('Gemini returned non-JSON response', [
                    'raw_response' => $generatedText,
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'We could not parse the prescription data. The handwriting may be unclear — please enter values manually.',
                ], 422);
            }

            // 8. Normalize and validate the extracted data structure
            $normalizedData = $this->normalizeGeminiResponse($extractedData);

            // 9. Check if we got any usable data
            $missingRight = is_null($normalizedData['right']['sph']);
            $missingLeft = is_null($normalizedData['left']['sph']);

            if ($missingRight && $missingLeft) {
                return response()->json([
                    'success' => false,
                    'message' => 'We could read the image, but couldn\'t find standard SPH/CYL/AXIS values. Please verify the image or enter data manually.',
                    'data' => $normalizedData,
                ], 422);
            }

            // Success Response
            return response()->json([
                'success' => true,
                'message' => 'Prescription data extracted successfully!',
                'data' => $normalizedData,
            ]);

        } catch (\Exception $e) {
            Log::error('Gemini OCR Failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while reading the prescription. Please try again or enter values manually.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Normalize and validate the data structure returned by Gemini.
     * Ensures consistent types and safe defaults.
     */
    private function normalizeGeminiResponse(array $data): array
    {
        $normalized = [
            'right' => ['sph' => null, 'cyl' => null, 'axis' => null],
            'left' => ['sph' => null, 'cyl' => null, 'axis' => null],
            'pd' => null,
        ];

        // Right Eye (OD)
        if (isset($data['right']) && is_array($data['right'])) {
            $normalized['right']['sph'] = $this->parseNumeric($data['right']['sph'] ?? null);
            $normalized['right']['cyl'] = $this->parseNumeric($data['right']['cyl'] ?? null);
            $normalized['right']['axis'] = $this->parseAxis($data['right']['axis'] ?? null);
        }

        // Left Eye (OS)
        if (isset($data['left']) && is_array($data['left'])) {
            $normalized['left']['sph'] = $this->parseNumeric($data['left']['sph'] ?? null);
            $normalized['left']['cyl'] = $this->parseNumeric($data['left']['cyl'] ?? null);
            $normalized['left']['axis'] = $this->parseAxis($data['left']['axis'] ?? null);
        }

        // Pupillary Distance
        if (isset($data['pd']) && is_numeric($data['pd'])) {
            $pd = (float) $data['pd'];
            $normalized['pd'] = ($pd >= 40 && $pd <= 85) ? $pd : null;
        }

        return $normalized;
    }

    /**
     * Parse a numeric value (SPH/CYL) from Gemini output.
     * Handles strings like "+1.25", "-2.00", or raw floats.
     */
    private function parseNumeric($value): ?float
    {
        if (is_null($value))
            return null;
        if (is_numeric($value))
            return round((float) $value, 2);
        // Handle string values with sign
        if (is_string($value)) {
            $cleaned = trim(str_replace(['–', '—'], '-', $value));
            if (is_numeric($cleaned))
                return round((float) $cleaned, 2);
        }
        return null;
    }

    /**
     * Parse an AXIS value — must be an integer between 0 and 180.
     */
    private function parseAxis($value): ?int
    {
        if (is_null($value))
            return null;
        if (is_numeric($value)) {
            $axis = (int) round((float) $value);
            return ($axis >= 0 && $axis <= 180) ? $axis : null;
        }
        return null;
    }

    /**
     * Store/update prescription data.
     *
     * Strategy — Session-First + Anti-Duplicate:
     * 1. Validate input
     * 2. Build a clean data array
     * 3. Store in session (persists for the whole visit)
     * 4. updateOrCreate in DB targeting [user_id, status='submitted']
     *    → This guarantees ONE active medical profile row per user
     *    → If the user changes measurements, the same row is updated
     * 5. Null out irrelevant fields when switching between types
     * 6. Redirect to lens selection (eyeglasses) or checkout (contacts)
     */
    public function storeManual(Request $request)
    {
        $isContact = $request->input('type') === 'contact';

        // ── 1. Validation ──────────────────────────────────────────
        $request->validate([
            'od_sph' => 'required',
            'od_cyl' => 'nullable',
            'od_axis' => 'nullable|numeric',
            'os_sph' => 'required',
            'os_cyl' => 'nullable',
            'os_axis' => 'nullable|numeric',
            'pd_value' => $isContact ? 'nullable|numeric' : 'required|numeric',
            'od_bc' => $isContact ? 'required_if:type,contact|numeric' : 'nullable',
            'od_dia' => $isContact ? 'required_if:type,contact|numeric' : 'nullable',
            'os_bc' => $isContact ? 'required_if:type,contact|numeric' : 'nullable',
            'os_dia' => $isContact ? 'required_if:type,contact|numeric' : 'nullable',
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:eyeglasses,contact',
        ]);

        // ── 2. Build the prescription data array ───────────────────
        // When switching types, null out the irrelevant fields
        // so stale data doesn't linger in the same row.
        $prescriptionData = [
            'product_id' => $request->product_id,
            'type' => $request->type,
            // Common fields (both types)
            'od_sph' => $request->od_sph,
            'od_cyl' => $request->od_cyl,
            'od_axis' => $request->od_axis,
            'os_sph' => $request->os_sph,
            'os_cyl' => $request->os_cyl,
            'os_axis' => $request->os_axis,
            // Contact-lens-only fields (null for eyeglasses)
            'od_bc' => $isContact ? $request->od_bc : null,
            'od_dia' => $isContact ? $request->od_dia : null,
            'os_bc' => $isContact ? $request->os_bc : null,
            'os_dia' => $isContact ? $request->os_dia : null,
            // PD (typically null for contacts)
            'pd_value' => $request->pd_value,
        ];

        // ── 3. Session-First Storage ──────────────────────────────
        // Persists throughout the visit, survives page navigations.
        // Cleared only on logout (session()->invalidate()).
        session()->put('prescription', $prescriptionData);

        // ── 4. Smart Database Update (Anti-Duplicate Rule) ────────
        // updateOrCreate targets [user_id + status='submitted']
        //  One active prescription row per user, always updated in-place
        //  Only becomes 'ordered' after successful checkout
        $prescription = Prescription::updateOrCreate(['user_id' => Auth::id(), 'status' => 'submitted',], $prescriptionData);

        // ── 5. Redirect based on type ─────────────────────────────
        if ($isContact) {
            // Direct checkout for contact lenses — skip the cart entirely
            $product = \App\Models\Product::find($request->product_id);
            if ($product) {
                session()->put('contact_lens_order', [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_image' => $product->image,
                    'price' => $product->price,
                    'prescription_id' => $prescription->id,
                ]);
            }
            return redirect()->route('checkout.index')->with('success', 'Prescription attached!');
        }

        return redirect()->route('lenses.select', ['id' => $prescription->id]);
    }
}
