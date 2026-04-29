<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * All products page — with sidebar filters & sorting.
     * Accepts GET params: face_shape, min_price, max_price, best_sellers,
     *                     new_arrivals, material[], brand, sort, category
     */
    public function index(Request $request)
    {
        $query = Product::where('category', '!=', 'Contact Lenses');

        // -- Search --
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('brand', 'like', '%' . $search . '%');
            });
        }

        // -- Category (set by navbar Men/Women/Kids links) --
        if ($request->filled('category')) {
            $query->where('category', $request->category);
            $selectedCategory = $request->category;
        }

        // -- Face shape --
        if ($request->filled('face_shape') && $request->face_shape !== 'all') {
            $query->where('face_shapes', 'like', '%' . $request->face_shape . '%');
        }

        // -- Price range --
        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float) $request->min_price);
        }
        if ($request->filled('max_price') && (int) $request->max_price < 500) {
            $query->where('price', '<=', (float) $request->max_price);
        }

        // -- Quick filters --
        if ($request->boolean('best_sellers')) {
            $query->where('is_best_seller', true);
        }
        if ($request->boolean('new_arrivals')) {
            $query->where('is_new_arrival', true);
        }

        // -- Frame material (multi-check) --
        if ($request->filled('material')) {
            $materials = (array) $request->material;
            $query->whereIn('material', $materials);
        }

        // -- Brand --
        if ($request->filled('brand') && $request->brand !== 'all') {
            $query->where('brand', $request->brand);
        }

        // -- Sorting --
        switch ($request->get('sort', 'popular')) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default: // popular / most sold = best sellers first
                $query->orderByDesc('is_best_seller')->orderBy('name');
                break;
        }

        $products = $query->paginate(12)->withQueryString();

        return view('Products.index', [
            'products'         => $products,
            'selectedCategory' => $selectedCategory ?? null,
            'filters'          => $request->only([
                'search', 'face_shape', 'min_price', 'max_price',
                'best_sellers', 'new_arrivals', 'material', 'brand', 'sort', 'category',
            ]),
        ]);
    }

    /**
     * Category shortcut  /category/Men  etc.
     * Delegates to index() so all filters still work.
     */
    public function filter(Request $request, $type)
    {
        $request->merge(['category' => $type]);
        return $this->index($request);
    }

    public function show($id)
    {
        // Clear any previous checkout flow sessions when browsing a new product
        session()->forget('lens_order');
        session()->forget('frame_only_order');

        $product = Product::with('images')->findOrFail($id);

        // Related products: same category first, then fill with random
        $relatedProducts = Product::where('id', '!=', $id)
                                  ->where('category', $product->category)
                                  ->where('category', '!=', 'Contact Lenses')
                                  ->inRandomOrder()
                                  ->take(4)
                                  ->get();

        // If not enough from same category, fill with random others
        if ($relatedProducts->count() < 4) {
            $fill = Product::where('id', '!=', $id)
                           ->where('category', '!=', 'Contact Lenses')
                           ->whereNotIn('id', $relatedProducts->pluck('id'))
                           ->inRandomOrder()
                           ->take(4 - $relatedProducts->count())
                           ->get();
            $relatedProducts = $relatedProducts->merge($fill);
        }

        // Product reviews — show up to 10, with total count for "load more"
        $productReviews = \App\Models\Review::forProduct($id)->latest()->take(10)->get();
        $reviewCount    = \App\Models\Review::forProduct($id)->count();
        $avgRating      = \App\Models\Review::forProduct($id)->avg('rating') ?? 0;

        return view('products.show', compact(
            'product', 'relatedProducts', 'productReviews', 'reviewCount', 'avgRating'
        ));
    }

    public function colorLenses(Request $request)
    {
        $query = Product::where('category', 'Contact Lenses');

        // -- Brands --
        if ($request->filled('brand')) {
            $brands = (array) $request->brand;
            $query->whereIn('brand', $brands);
        }

        // -- Color Family --
        if ($request->filled('color_family')) {
            $query->where('color_family', $request->color_family);
        }

        // -- Replacement --
        if ($request->filled('replacement')) {
            $query->where('replacement', $request->replacement);
        }

        // -- Price range --
        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float) $request->min_price);
        }
        if ($request->filled('max_price')) {
            // Usually we'd skip if max_price is the slider maximum. In the view, the max slider isn't specified but let's say 250 is the max
            if ((int) $request->max_price < 500) {
                $query->where('price', '<=', (float) $request->max_price);
            }
        }

        // -- Sorting --
        switch ($request->get('sort', 'popular')) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default: // popular usually means best seller, here we can just order by name
                $query->orderBy('name');
                break;
        }

        $query->withCount('reviews')->withAvg('reviews', 'rating');

        $lenses = $query->paginate(12)->withQueryString();

        return view('Products.color-lenses', [
            'products' => $lenses,
            'filters'  => $request->only([
                'brand', 'color_family', 'replacement', 'min_price', 'max_price', 'sort'
            ])
        ]);
    }
}
