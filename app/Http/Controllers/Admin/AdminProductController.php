<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    /**
     * Paginated product list with search.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('brand', 'like', "%{$s}%")
                  ->orWhere('category', 'like', "%{$s}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show create product form.
     */
    public function create()
    {
        return view('admin.products.form', ['product' => null]);
    }

    /**
     * Store a new product.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'category'       => 'required|string|max:100',
            'stock'          => 'required|integer|min:0',
            'material'       => 'nullable|string|max:100',
            'brand'          => 'nullable|string|max:100',
            'face_shapes'    => 'nullable|string|max:255',
            'is_best_seller' => 'nullable|boolean',
            'is_new_arrival' => 'nullable|boolean',
            'color_family'   => 'nullable|string|max:100',
            'replacement'    => 'nullable|string|max:100',
            'sub_image_1'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sub_image_2'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Handle main image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/products'), $filename);
            $validated['image'] = 'images/products/' . $filename;
        }

        $validated['is_best_seller'] = $request->boolean('is_best_seller');
        $validated['is_new_arrival'] = $request->boolean('is_new_arrival');

        // Build frame options JSON
        $validated['frame_materials'] = $this->parseFrameMaterials($request);
        $validated['frame_colors']    = $this->parseFrameColors($request);
        $validated['frame_sizes']     = $this->parseFrameSizes($request);

        $product = Product::create($validated);

        // Handle sub-image uploads → product_images table
        $this->handleSubImages($request, $product);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully!');
    }

    /**
     * Show edit product form.
     */
    public function edit($id)
    {
        $product = Product::with('images')->findOrFail($id);
        return view('admin.products.form', compact('product'));
    }

    /**
     * Update an existing product.
     */
    public function update(Request $request, $id)
    {
        $product = Product::with('images')->findOrFail($id);

        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'category'       => 'required|string|max:100',
            'stock'          => 'required|integer|min:0',
            'material'       => 'nullable|string|max:100',
            'brand'          => 'nullable|string|max:100',
            'face_shapes'    => 'nullable|string|max:255',
            'is_best_seller' => 'nullable|boolean',
            'is_new_arrival' => 'nullable|boolean',
            'color_family'   => 'nullable|string|max:100',
            'replacement'    => 'nullable|string|max:100',
            'sub_image_1'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sub_image_2'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Handle main image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/products'), $filename);
            $validated['image'] = 'images/products/' . $filename;
        }

        $validated['is_best_seller'] = $request->boolean('is_best_seller');
        $validated['is_new_arrival'] = $request->boolean('is_new_arrival');

        // Build frame options JSON
        $validated['frame_materials'] = $this->parseFrameMaterials($request);
        $validated['frame_colors']    = $this->parseFrameColors($request);
        $validated['frame_sizes']     = $this->parseFrameSizes($request);

        $product->update($validated);

        // Handle sub-image uploads → product_images table
        $this->handleSubImages($request, $product);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Delete a product.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['success' => true, 'message' => 'Product deleted successfully!']);
    }

    /* ================================================================
     *  PRIVATE HELPERS — Parse frame options from form inputs
     * ================================================================ */

    /**
     * Parse comma-separated frame materials into an array.
     */
    private function parseFrameMaterials(Request $request): ?array
    {
        $input = $request->input('frame_materials_input', '');
        if (empty(trim($input))) {
            return null;
        }

        return array_values(array_filter(array_map('trim', explode(',', $input))));
    }

    /**
     * Parse 3 color name + hex pairs into a JSON-ready array.
     */
    private function parseFrameColors(Request $request): ?array
    {
        $names = $request->input('frame_color_names', []);
        $hexes = $request->input('frame_color_hexes', []);
        $colors = [];

        foreach ($names as $i => $name) {
            $name = trim($name);
            $hex  = trim($hexes[$i] ?? '#000000');
            if (!empty($name)) {
                $colors[] = ['name' => $name, 'hex' => $hex];
            }
        }

        return !empty($colors) ? $colors : null;
    }

    /**
     * Parse 3 size value + label pairs into a JSON-ready array.
     */
    private function parseFrameSizes(Request $request): ?array
    {
        $values = $request->input('frame_size_values', []);
        $labels = $request->input('frame_size_labels', []);
        $sizes  = [];

        foreach ($values as $i => $value) {
            $value = trim($value);
            $label = trim($labels[$i] ?? '');
            if (!empty($value) && !empty($label)) {
                $sizes[] = ['value' => $value, 'label' => $label];
            }
        }

        return !empty($sizes) ? $sizes : null;
    }

    /**
     * Upload sub-images and save/replace in product_images table.
     * Each product should have exactly 2 sub-images.
     */
    private function handleSubImages(Request $request, Product $product): void
    {
        $existingImages = $product->images()->orderBy('id')->get();

        foreach (['sub_image_1', 'sub_image_2'] as $index => $field) {
            if ($request->hasFile($field)) {
                $file     = $request->file($field);
                $filename = time() . '_sub' . ($index + 1) . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/products'), $filename);
                $path = 'images/products/' . $filename;

                if (isset($existingImages[$index])) {
                    // Replace existing sub-image
                    $existingImages[$index]->update(['image_path' => $path]);
                } else {
                    // Create new sub-image
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                    ]);
                }
            }
        }
    }
}
