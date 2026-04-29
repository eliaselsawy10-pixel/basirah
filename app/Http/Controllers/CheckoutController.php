<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Prescription;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page.
     * Supports two order types:
     *  - 'eyeglasses' → from lens_order session (frame + lenses)
     *  - 'cart'        → from cart session (contact lenses, frame-only, etc.)
     */
    public function index(Request $request)
    {
        $orderItems  = [];
        $subtotal    = 0;
        $taxRate     = config('shop.tax_rate', 0.08);
        $shipping    = 0; // Free shipping
        $orderType        = 'cart';
        $lensOrder        = session()->get('lens_order');
        $contactLensOrder = session()->get('contact_lens_order');
        $cartItems        = session()->get('cart', []);

        // ── Frame-only direct checkout (from product detail page) ──
        if ($request->filled('frame_only')) {
            // Clear any lens_order session to prevent conflicts with direct checkout
            session()->forget('lens_order');

            $product = Product::findOrFail($request->frame_only);
            $orderType = 'frame_only';

            $orderItems[] = [
                'name'     => $product->name . ' (Frame Only)',
                'image'    => $product->image,
                'price'    => $product->price,
                'quantity' => 1,
            ];

            $subtotal = $product->price;

            // Store in session so checkout process can access it
            session()->put('frame_only_order', [
                'product_id'     => $product->id,
                'product_name'   => $product->name,
                'product_image'  => $product->image,
                'price'          => $product->price,
                'frame_material' => $request->input('frame_material', ''),
                'frame_color'    => $request->input('frame_color', ''),
                'frame_size'     => $request->input('frame_size', ''),
            ]);
        } elseif ($contactLensOrder) {
            // ── Contact lens direct order (no cart) ──
            session()->forget(['frame_only_order', 'lens_order']);
            $orderType = 'contact_lens';

            $orderItems[] = [
                'name'     => $contactLensOrder['product_name'] . ' (Contact Lens)',
                'image'    => $contactLensOrder['product_image'],
                'price'    => $contactLensOrder['price'],
                'quantity' => 1,
            ];

            $subtotal = $contactLensOrder['price'];
        } elseif ($lensOrder) {
            // Clear any frame_only_order session to prevent conflicts
            session()->forget('frame_only_order');

            // ── Eyeglasses order (frame + lenses) ──
            $orderType = 'eyeglasses';

            // Frame line item
            $orderItems[] = [
                'name'     => $lensOrder['product_name'] . ' (Frame)',
                'image'    => $lensOrder['product_image'],
                'price'    => $lensOrder['frame_price'],
                'quantity' => 1,
            ];

            // Lens Type line item
            if ($lensOrder['lens_type_price'] > 0) {
                $orderItems[] = [
                    'name'     => $lensOrder['lens_type'] . ' Lenses',
                    'image'    => null,
                    'price'    => $lensOrder['lens_type_price'],
                    'quantity' => 1,
                ];
            }

            // Lens Material line item
            $orderItems[] = [
                'name'     => $lensOrder['lens_material'] . ' Lenses',
                'image'    => null,
                'price'    => $lensOrder['lens_material_price'],
                'quantity' => 1,
            ];

            // Enhancement line items
            if (!empty($lensOrder['enhancements'])) {
                foreach ($lensOrder['enhancements'] as $enh) {
                    $orderItems[] = [
                        'name'     => $enh['name'],
                        'image'    => null,
                        'price'    => $enh['price'],
                        'quantity' => 1,
                    ];
                }
            }

            $subtotal = $lensOrder['subtotal'];

            // Also merge any OTHER cart items (e.g. accessories)
            // Skip the frame product — it's already included in the lens_order above
            foreach ($cartItems as $cartKey => $item) {
                if ($cartKey == $lensOrder['product_id']) {
                    continue; // Frame is already in the lens_order, don't double-count
                }
                $orderItems[] = [
                    'name'     => $item['name'],
                    'image'    => $item['image'],
                    'price'    => $item['price'],
                    'quantity' => $item['quantity'],
                ];
                $subtotal += $item['price'] * $item['quantity'];
            }
        } else {
            // ── Cart-based order (frame-only, etc.) ──
            foreach ($cartItems as $item) {
                $orderItems[] = [
                    'name'     => $item['name'],
                    'image'    => $item['image'],
                    'price'    => $item['price'],
                    'quantity' => $item['quantity'],
                ];
                $subtotal += $item['price'] * $item['quantity'];
            }
        }

        $tax   = round($subtotal * $taxRate, 2);
        $total = round($subtotal + $shipping + $tax, 2);

        return view('checkout.index', compact(
            'orderItems',
            'subtotal',
            'shipping',
            'tax',
            'total',
            'orderType',
            'lensOrder'
        ));
    }

    /**
     * Process the checkout / place the order.
     *
     * Post-Purchase Transition:
     * 1. Validate shipping & payment
     * 2. Validate stock availability
     * 3. Create Order + OrderItems in a DB transaction
     * 4. Decrement product stock
     * 5. Transition prescription status: 'submitted' → 'ordered'
     * 6. Clear all session data (cart, lens_order, frame_only_order, prescription)
     * 7. Redirect to confirmation
     */
    public function process(Request $request)
    {
        // ── 1. Validate shipping & payment fields ─────────────────
        $validated = $request->validate([
            'full_name'      => 'required|string|max:255',
            'address'        => 'required|string|max:500',
            'city'           => 'required|string|max:100',
            'zip_code'       => 'required|string|max:20',
            'payment_method' => 'required|in:credit_card,digital_wallets',
        ]);

        $lensOrder        = session('lens_order');
        $cartItems        = session('cart', []);
        $frameOnlyOrder   = session('frame_only_order');
        $contactLensOrder = session('contact_lens_order');

        // ── 2. Build order items & calculate totals ───────────────
        $taxRate     = config('shop.tax_rate', 0.08);
        $shipping    = 0;
        $subtotal    = 0;
        $dbItems     = []; // Items to insert into order_items table
        $stockChecks = []; // [product_id => quantity] for stock validation

        if ($frameOnlyOrder) {
            // Frame-only order
            $subtotal = $frameOnlyOrder['price'];
            $dbItems[] = [
                'product_id'     => $frameOnlyOrder['product_id'],
                'product_name'   => $frameOnlyOrder['product_name'] . ' (Frame Only)',
                'product_price'  => $frameOnlyOrder['price'],
                'purchase_type'  => 'frame_only',
                'frame_material' => $frameOnlyOrder['frame_material'] ?? null,
                'frame_color'    => $frameOnlyOrder['frame_color'] ?? null,
                'frame_size'     => $frameOnlyOrder['frame_size'] ?? null,
                'quantity'       => 1,
                'line_total'     => $frameOnlyOrder['price'],
            ];
            $stockChecks[$frameOnlyOrder['product_id']] = 1;
        } elseif ($lensOrder) {
            // Eyeglasses order (frame + lenses)
            $lensPrice = ($lensOrder['lens_type_price'] ?? 0)
                       + ($lensOrder['lens_material_price'] ?? 0)
                       + ($lensOrder['enhancements_total'] ?? 0);

            $dbItems[] = [
                'product_id'      => $lensOrder['product_id'],
                'product_name'    => $lensOrder['product_name'],
                'product_price'   => $lensOrder['frame_price'],
                'lens_type'       => $lensOrder['lens_type'] ?? null,
                'lens_material'   => $lensOrder['lens_material'] ?? null,
                'lens_price'      => $lensPrice,
                'enhancements'    => !empty($lensOrder['enhancements']) ? $lensOrder['enhancements'] : null,
                'purchase_type'   => 'frame_lens',
                'frame_material'  => $lensOrder['frame_material'] ?? null,
                'frame_color'     => $lensOrder['frame_color'] ?? null,
                'frame_size'      => $lensOrder['frame_size'] ?? null,
                'prescription_id' => $lensOrder['prescription_id'] ?? null,
                'quantity'        => 1,
                'line_total'      => $lensOrder['subtotal'],
            ];
            $subtotal = $lensOrder['subtotal'];
            $stockChecks[$lensOrder['product_id']] = 1;

            // Include any additional cart items (accessories, etc.)
            foreach ($cartItems as $cartKey => $item) {
                if ($cartKey == $lensOrder['product_id']) continue;

                $lineTotal = $item['price'] * $item['quantity'];
                $dbItems[] = [
                    'product_id'     => $cartKey,
                    'product_name'   => $item['name'],
                    'product_price'  => $item['price'],
                    'purchase_type'  => 'frame_only',
                    'frame_material' => $item['frame_material'] ?? null,
                    'frame_color'    => $item['frame_color'] ?? null,
                    'frame_size'     => $item['frame_size'] ?? null,
                    'quantity'       => $item['quantity'],
                    'line_total'     => $lineTotal,
                ];
                $subtotal += $lineTotal;
                $stockChecks[$cartKey] = ($stockChecks[$cartKey] ?? 0) + $item['quantity'];
            }
        } elseif ($contactLensOrder) {
            // Contact lens direct order
            $subtotal = $contactLensOrder['price'];
            $dbItems[] = [
                'product_id'      => $contactLensOrder['product_id'],
                'product_name'    => $contactLensOrder['product_name'] . ' (Contact Lens)',
                'product_price'   => $contactLensOrder['price'],
                'purchase_type'   => 'contact_lens',
                'prescription_id' => $contactLensOrder['prescription_id'] ?? null,
                'quantity'        => 1,
                'line_total'      => $contactLensOrder['price'],
            ];
            $stockChecks[$contactLensOrder['product_id']] = 1;
        } else {
            // Cart-based order
            foreach ($cartItems as $cartKey => $item) {
                $lineTotal = $item['price'] * $item['quantity'];
                $dbItems[] = [
                    'product_id'     => $cartKey,
                    'product_name'   => $item['name'],
                    'product_price'  => $item['price'],
                    'purchase_type'  => 'frame_only',
                    'frame_material' => $item['frame_material'] ?? null,
                    'frame_color'    => $item['frame_color'] ?? null,
                    'frame_size'     => $item['frame_size'] ?? null,
                    'quantity'       => $item['quantity'],
                    'line_total'     => $lineTotal,
                ];
                $subtotal += $lineTotal;
                $stockChecks[$cartKey] = ($stockChecks[$cartKey] ?? 0) + $item['quantity'];
            }
        }

        // ── 3. Validate stock availability ────────────────────────
        foreach ($stockChecks as $productId => $requiredQty) {
            $product = Product::find($productId);
            if (!$product) {
                return redirect()->back()->with('error', 'One of the products in your order is no longer available.');
            }
            if ($product->stock < $requiredQty) {
                return redirect()->back()->with('error', "Sorry, \"{$product->name}\" only has {$product->stock} item(s) left in stock.");
            }
        }

        $tax   = round($subtotal * $taxRate, 2);
        $total = round($subtotal + $shipping + $tax, 2);

        // ── 4. Create Order + OrderItems in a transaction ─────────
        $order = DB::transaction(function () use ($validated, $subtotal, $shipping, $total, $dbItems, $stockChecks) {
            $order = Order::create([
                'user_id'        => Auth::id(),
                'full_name'      => $validated['full_name'],
                'address'        => $validated['address'],
                'city'           => $validated['city'],
                'zip_code'       => $validated['zip_code'],
                'payment_method' => $validated['payment_method'],
                'subtotal'       => $subtotal,
                'shipping'       => $shipping,
                'total'          => $total,
                'status'         => 'pending',
            ]);

            foreach ($dbItems as $item) {
                $order->items()->create($item);
            }

            // ── 5. Decrement stock ────────────────────────────────
            foreach ($stockChecks as $productId => $qty) {
                Product::where('id', $productId)->decrement('stock', $qty);
            }

            return $order;
        });

        // ── 6. Post-Purchase Transition ───────────────────────────
        // Change the user's 'submitted' prescription to 'ordered'
        // so it becomes permanent history and won't be overwritten.
        Prescription::where('user_id', Auth::id())
            ->where('status', 'submitted')
            ->update(['status' => 'ordered']);

        // ── 7. Clear all checkout session data ────────────────────
        session()->forget(['cart', 'lens_order', 'frame_only_order', 'contact_lens_order', 'prescription']);

        // ── 8. Redirect to order confirmation ─────────────────────
        return redirect()->route('checkout.confirmation', $order->id)
            ->with('success', 'Order placed successfully! Your order #' . $order->id . ' is being processed.');
    }

    /**
     * Display the order confirmation page.
     */
    public function confirmation($id)
    {
        $order = Order::with('items')->where('user_id', Auth::id())->findOrFail($id);

        return view('checkout.confirmation', compact('order'));
    }
}
