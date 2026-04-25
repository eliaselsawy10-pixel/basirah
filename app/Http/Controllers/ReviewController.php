<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    /**
     * Store a new review (site-level or product-specific).
     * Requires authentication.
     */
    public function store(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Authentication required.'], 401);
        }

        $validated = $request->validate([
            'product_id' => 'nullable|exists:products,id',
            'rating'     => 'required|integer|min:1|max:5',
            'comment'    => 'required|string|min:5|max:1000',
        ]);

        $review = Review::create([
            'user_id'       => auth()->id(),
            'product_id'    => $validated['product_id'] ?? null,
            'reviewer_name' => auth()->user()->name,
            'rating'        => $validated['rating'],
            'comment'       => $validated['comment'],
        ]);

        return response()->json([
            'success'  => true,
            'message'  => 'Thank you for your review!',
            'review'   => [
                'id'            => $review->id,
                'reviewer_name' => $review->reviewer_name,
                'rating'        => $review->rating,
                'comment'       => $review->comment,
                'date'          => $review->created_at->format('M d, Y'),
            ],
        ]);
    }
}
