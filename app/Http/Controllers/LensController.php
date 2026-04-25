<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prescription;
use App\Models\Product;

class LensController extends Controller
{
    /**
     * Display the select-lenses page with the frame product info.
     */
    public function selectLenses($id)
    {
        $prescription = Prescription::findOrFail($id);
        $product = Product::findOrFail($prescription->product_id);

        return view('prescriptions.select-lenses', compact('prescription', 'product'));
    }

    /**
     * Store the lens configuration in session and redirect to checkout.
     */
    public function proceedToCheckout(Request $request)
    {
        $request->validate([
            'prescription_id' => 'required|exists:prescriptions,id',
            'product_id'      => 'required|exists:products,id',
            'frame_price'     => 'required|numeric',
            'lens_type'       => 'required|string',
            'lens_type_price' => 'required|numeric',
            'lens_material'       => 'required|string',
            'lens_material_price' => 'required|numeric',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Build enhancements array from the submitted data
        $enhancements = [];
        if ($request->has('enhancements')) {
            foreach ($request->enhancements as $enh) {
                $enhancements[] = [
                    'name'  => $enh['name'],
                    'price' => (float) $enh['price'],
                ];
            }
        }

        $enhancementsTotal = array_sum(array_column($enhancements, 'price'));

        $subtotal = (float) $request->frame_price
                  + (float) $request->lens_type_price
                  + (float) $request->lens_material_price
                  + $enhancementsTotal;

        // Store the lens order config in session
        session()->put('lens_order', [
            'prescription_id'    => $request->prescription_id,
            'product_id'         => $request->product_id,
            'product_name'       => $product->name,
            'product_image'      => $product->image,
            'frame_price'        => (float) $request->frame_price,
            'lens_type'          => $request->lens_type,
            'lens_type_price'    => (float) $request->lens_type_price,
            'lens_material'      => $request->lens_material,
            'lens_material_price'=> (float) $request->lens_material_price,
            'enhancements'       => $enhancements,
            'enhancements_total' => $enhancementsTotal,
            'subtotal'           => $subtotal,
        ]);

        // Remove the frame from the cart to prevent double-counting
        // (the frame is now represented in the lens_order above)
        $cart = session()->get('cart', []);
        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            session()->put('cart', $cart);
        }

        // Clear any frame_only_order to avoid conflicts
        session()->forget('frame_only_order');

        return redirect()->route('checkout.index');
    }
}
