<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    /**
     * Display the shopping cart page.
     */
    public function index()
    {
        // Clear any previous checkout flow sessions so they don't persist
        // when the user navigates back from checkout
        session()->forget('lens_order');
        session()->forget('frame_only_order');

        // Cart items
        $cartItems = session()->get('cart', []);

        // Calculate totals
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $shipping  = 0; // Free shipping
        $taxRate   = 0.08; // 8% tax
        $tax       = round($subtotal * $taxRate, 2);
        $total     = round($subtotal + $shipping + $tax, 2);

        return view('cart.index', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total'));
    }

    /**
     * Add an item to the shopping cart.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        // If item already in cart and user hasn't confirmed, ask first
        if (isset($cart[$product->id]) && !$request->boolean('force')) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success'         => false,
                    'already_in_cart' => true,
                    'message'         => 'This item is already in your cart.',
                    'current_qty'     => $cart[$product->id]['quantity'],
                ]);
            }
        }

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                'name'           => $product->name,
                'description'    => $product->description ?? '',
                'price'          => $product->price,
                'quantity'       => 1,
                'image'          => $product->image,
                'frame_material' => $request->input('frame_material', ''),
                'frame_color'    => $request->input('frame_color', ''),
                'frame_size'     => $request->input('frame_size', ''),
            ];
        }

        session()->put('cart', $cart);

        // Clear any previous checkout flow sessions when starting a new cart-based flow
        session()->forget('lens_order');
        session()->forget('frame_only_order');

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success'    => true,
                'message'    => 'Product added to cart successfully!',
                'cart_count' => array_sum(array_column($cart, 'quantity')),
                'cartCount'  => array_sum(array_column($cart, 'quantity'))
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    /**
     * Update the quantity of a cart item (AJAX).
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);

            // Recalculate totals
            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            $taxRate = 0.08;
            $tax     = round($subtotal * $taxRate, 2);
            $total   = round($subtotal + $tax, 2);

            return response()->json([
                'success'      => true,
                'quantity'     => $cart[$id]['quantity'],
                'itemSubtotal' => number_format($cart[$id]['price'] * $cart[$id]['quantity'], 2),
                'subtotal'     => number_format($subtotal, 2),
                'tax'          => number_format($tax, 2),
                'total'        => number_format($total, 2),
                'cartCount'    => array_sum(array_column($cart, 'quantity')),
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Item not found.'], 404);
    }

    /**
     * Remove an item from the cart (AJAX).
     */
    public function destroy($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);

            // Recalculate totals
            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            $taxRate = 0.08;
            $tax     = round($subtotal * $taxRate, 2);
            $total   = round($subtotal + $tax, 2);

            return response()->json([
                'success'   => true,
                'subtotal'  => number_format($subtotal, 2),
                'tax'       => number_format($tax, 2),
                'total'     => number_format($total, 2),
                'cartCount' => array_sum(array_column($cart, 'quantity')),
                'isEmpty'   => empty($cart),
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Item not found.'], 404);
    }


}
