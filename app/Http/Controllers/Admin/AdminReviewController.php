<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    /**
     * List all reviews (site-level and product-level).
     */
    public function index(Request $request)
    {
        $query = Review::with(['user', 'product']);

        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        if ($request->filled('type')) {
            if ($request->type === 'site') {
                $query->whereNull('product_id');
            } elseif ($request->type === 'product') {
                $query->whereNotNull('product_id');
            }
        }

        $reviews = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Delete a review.
     */
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return response()->json(['success' => true, 'message' => 'Review deleted successfully!']);
    }
}
