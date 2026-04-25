<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Display the user's favorites / wishlist page.
     */
    public function index()
    {
        // Demo favorite items (replace with database/session in production)
        $favorites = session()->get('favorites', []);

        return view('favorites.index', compact('favorites'));
    }

    /**
     * Remove an item from favorites (AJAX).
     */
    public function destroy($id)
    {
        $favorites = session()->get('favorites', []);

        if (isset($favorites[$id])) {
            unset($favorites[$id]);
            session()->put('favorites', $favorites);

            return response()->json([
                'success' => true,
                'isEmpty' => empty($favorites),
                'count'   => count($favorites),
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Item not found.'], 404);
    }

    /**
     * Add an item to favorites.
     */
    public function store(Request $request)
    {
        $request->validate(['product_id' => 'required|integer|exists:products,id']);

        $productId = $request->input('product_id');
        $favorites = session()->get('favorites', []);

        if (!isset($favorites[$productId])) {
            // Load from DB
            $product = \App\Models\Product::findOrFail($productId);
            $favorites[$productId] = [
                'name'     => $product->name,
                'category' => $product->category,
                'price'    => $product->price,
                'image'    => $product->image,
                'inStock'  => $product->stock > 0,
            ];
            session()->put('favorites', $favorites);
        }

        return response()->json([
            'success' => true,
            'count'   => count($favorites),
        ]);
    }
}
