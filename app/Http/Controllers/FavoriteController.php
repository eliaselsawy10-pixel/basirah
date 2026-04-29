<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display the user's favorites / wishlist page.
     */
    public function index()
    {
        $favorites = Favorite::with('product')
            ->where('user_id', Auth::id())
            ->get()
            ->keyBy('product_id');

        return view('favorites.index', compact('favorites'));
    }

    /**
     * Remove an item from favorites (AJAX).
     */
    public function destroy($id)
    {
        $deleted = Favorite::where('user_id', Auth::id())
            ->where('product_id', $id)
            ->delete();

        if ($deleted) {
            $count = Favorite::where('user_id', Auth::id())->count();

            return response()->json([
                'success' => true,
                'isEmpty' => $count === 0,
                'count'   => $count,
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Item not found.'], 404);
    }

    /**
     * Add an item to favorites (AJAX).
     */
    public function store(Request $request)
    {
        $request->validate(['product_id' => 'required|integer|exists:products,id']);

        $productId = $request->input('product_id');

        // Toggle: if already favorited, remove it
        $existing = Favorite::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            $existing->delete();
            $count = Favorite::where('user_id', Auth::id())->count();
            return response()->json([
                'success'  => true,
                'action'   => 'removed',
                'count'    => $count,
            ]);
        }

        Favorite::create([
            'user_id'    => Auth::id(),
            'product_id' => $productId,
        ]);

        $count = Favorite::where('user_id', Auth::id())->count();

        return response()->json([
            'success' => true,
            'action'  => 'added',
            'count'   => $count,
        ]);
    }
}
