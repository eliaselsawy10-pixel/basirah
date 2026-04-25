<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
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
                $isContact = stripos($product->category, 'contact') !== false || stripos($product->name, 'contact') !== false || stripos($product->category, 'color') !== false || stripos($product->name, 'lens') !== false;
            }
        }

        // Pre-fill form from session if user is returning to edit
        $sessionRx = session('prescription');

        return view('prescriptions.create', compact('product', 'isContact', 'sessionRx'));
    }

    /**
     * Process an uploaded prescription image via OCR (Google Cloud Vision).
     * Extracts SPH, CYL, AXIS, and PD using structured Regex (Egyptian Style).
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
            // 2. Store image temporarily for GCP Vision wrapper to read
            $file = $request->file('prescription_image');
            $tempPath = $file->store('ocr_uploads', 'local');
            $fullPath = storage_path('app/private/' . $tempPath);

            // 3. Initialize Google Cloud Vision Client
            // Utilizing the service-account.json explicitly
            $client = new ImageAnnotatorClient([
                'credentials' => storage_path('app/google/service-account.json')
            ]);

            // 4. Perform Document Text Detection (Best for dense handwriting / tables)
            $response = $client->documentTextDetection(file_get_contents($fullPath));

            // Handle any vision API-level errors
            if ($response->getError()) {
                throw new \Exception('Google Vision Error: ' . $response->getError()->getMessage());
            }

            $annotation = $response->getFullTextAnnotation();
            $fullText = $annotation ? $annotation->getText() : '';

            // Clean up resources immediately
            $client->close();
            @unlink($fullPath);

            // 5. Verification: Was any text actually detected?
            if (empty(trim($fullText))) {
                return response()->json([
                    'success' => false,
                    'message' => 'The image is too blurry or no text was detected. Please upload a clearer image.',
                    'raw_text' => ''
                ], 422); // 422 Unprocessable Entity
            }

            // 6. Smart Extraction (Regex Logic for Egyptian Table Styles)
            $extractedData = $this->extractViaRegex($fullText);

            // 7. Data Validation (Error Handling if extraction yields nothing)
            $missingRight = is_null($extractedData['right']['sph']);
            $missingLeft = is_null($extractedData['left']['sph']);

            if ($missingRight && $missingLeft) {
                return response()->json([
                    'success' => false,
                    'message' => 'We could read the text, but couldn\'t find a standard SPH/CYL/AXIS pattern. Please verify handwriting or enter manually.',
                    'data' => $extractedData,
                    'raw_text' => rtrim($fullText) // Helpful for frontend debugging
                ], 422);
            }

            // Success Response
            return response()->json([
                'success' => true,
                'message' => 'Prescription data extracted successfully!',
                'data' => $extractedData,
            ]);

        } catch (\Exception $e) {
            Log::error('OCR Failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while reading the prescription. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Regex Extraction Logic for Egyptian Style Prescriptions
     * Looks for Row Indicators (Right/OD/يمين) and immediately captures the following numbers in sequence.
     */
    private function extractViaRegex(string $text): array
    {
        // 1. Pre-process Text
        // Clean spaces between signs and numbers (- 4.5 -> -4.5)
        $cleaned = preg_replace('/([+-])\s+(\d)/', '$1$2', ltrim($text));
        $cleaned = str_replace(',', '.', $cleaned);

        // Standardizing OCR common mistakes
        $replacements = [
            '-' => '-',
            'O' => '0',
            'o' => '0',
            'S' => '5',
        ];
        $cleaned = strtr($cleaned, $replacements);

        $data = [
            'right' => ['sph' => null, 'cyl' => null, 'axis' => null],
            'left' => ['sph' => null, 'cyl' => null, 'axis' => null],
            'pd' => null,
        ];

        // 3. Regex Patterns (Standard Optical Format)
        $rightPattern = '/(?:Right|OD|R\.?E?)\b[^\d+-]*([+-]?\d+\.?\d*)(?:[^\d+-]*([+-]?\d+\.?\d*))?(?:[^\d+-]*(\d{1,3}))?/iu';
        $leftPattern = '/(?:Left|OS|L\.?E?)\b[^\d+-]*([+-]?\d+\.?\d*)(?:[^\d+-]*([+-]?\d+\.?\d*))?(?:[^\d+-]*(\d{1,3}))?/iu';
        $pdPattern = '/(?:PD|P\.D|IPD)[^\d]*(\d{2}(?:\.\d{1,2})?)/iu';

        // Right Eye Execution
        if (preg_match($rightPattern, $cleaned, $matches)) {
            $data['right']['sph'] = isset($matches[1]) && is_numeric($matches[1]) ? (float) $matches[1] : null;
            $data['right']['cyl'] = isset($matches[2]) && is_numeric($matches[2]) ? (float) $matches[2] : null;
            $data['right']['axis'] = isset($matches[3]) && is_numeric($matches[3]) ? (int) $matches[3] : null;
        }

        // Left Eye Execution
        if (preg_match($leftPattern, $cleaned, $matches)) {
            $data['left']['sph'] = isset($matches[1]) && is_numeric($matches[1]) ? (float) $matches[1] : null;
            $data['left']['cyl'] = isset($matches[2]) && is_numeric($matches[2]) ? (float) $matches[2] : null;
            $data['left']['axis'] = isset($matches[3]) && is_numeric($matches[3]) ? (int) $matches[3] : null;
        }

        // PD Execution
        if (preg_match($pdPattern, $cleaned, $matches)) {
            if (isset($matches[1]) && is_numeric($matches[1])) {
                $pdVal = (float) $matches[1];
                if ($pdVal >= 40 && $pdVal <= 85) {
                    $data['pd'] = $pdVal;
                }
            }
        }

        return $data;
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
            'od_sph'     => 'required',
            'od_cyl'     => 'nullable',
            'od_axis'    => 'nullable|numeric',
            'os_sph'     => 'required',
            'os_cyl'     => 'nullable',
            'os_axis'    => 'nullable|numeric',
            'pd_value'   => $isContact ? 'nullable|numeric' : 'required|numeric',
            'od_bc'      => $isContact ? 'required_if:type,contact|numeric' : 'nullable',
            'od_dia'     => $isContact ? 'required_if:type,contact|numeric' : 'nullable',
            'os_bc'      => $isContact ? 'required_if:type,contact|numeric' : 'nullable',
            'os_dia'     => $isContact ? 'required_if:type,contact|numeric' : 'nullable',
            'product_id' => 'required|exists:products,id',
            'type'       => 'required|in:eyeglasses,contact',
        ]);

        // ── 2. Build the prescription data array ───────────────────
        // When switching types, null out the irrelevant fields
        // so stale data doesn't linger in the same row.
        $prescriptionData = [
            'product_id' => $request->product_id,
            'type'       => $request->type,
            // Common fields (both types)
            'od_sph'     => $request->od_sph,
            'od_cyl'     => $request->od_cyl,
            'od_axis'    => $request->od_axis,
            'os_sph'     => $request->os_sph,
            'os_cyl'     => $request->os_cyl,
            'os_axis'    => $request->os_axis,
            // Contact-lens-only fields (null for eyeglasses)
            'od_bc'      => $isContact ? $request->od_bc  : null,
            'od_dia'     => $isContact ? $request->od_dia : null,
            'os_bc'      => $isContact ? $request->os_bc  : null,
            'os_dia'     => $isContact ? $request->os_dia : null,
            // PD (typically null for contacts)
            'pd_value'   => $request->pd_value,
        ];

        // ── 3. Session-First Storage ──────────────────────────────
        // Persists throughout the visit, survives page navigations.
        // Cleared only on logout (session()->invalidate()).
        session()->put('prescription', $prescriptionData);

        // ── 4. Smart Database Update (Anti-Duplicate Rule) ────────
        // updateOrCreate targets [user_id + status='submitted']
        // → One active prescription row per user, always updated in-place
        // → Only becomes 'ordered' after successful checkout
        $prescription = Prescription::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'status'  => 'submitted',
            ],
            $prescriptionData
        );

        // ── 5. Redirect based on type ─────────────────────────────
        if ($isContact) {
            // Add the contact lens product to the cart for checkout display
            $product = \App\Models\Product::find($request->product_id);
            if ($product) {
                $cart = session()->get('cart', []);
                if (isset($cart[$product->id])) {
                    $cart[$product->id]['quantity']++;
                } else {
                    $cart[$product->id] = [
                        'name'        => $product->name,
                        'description' => $product->description ?? '',
                        'price'       => $product->price,
                        'quantity'    => 1,
                        'image'       => $product->image,
                    ];
                }
                session()->put('cart', $cart);
            }
            return redirect()->route('checkout.index')->with('success', 'Prescription attached!');
        }

        return redirect()->route('lenses.select', ['id' => $prescription->id]);
    }
}
