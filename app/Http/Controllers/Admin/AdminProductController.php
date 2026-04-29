<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        ]);

        // Handle main image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
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

        // Auto-set Color 1 image to the main product image
        $this->syncColor1Image($product);

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
        ]);

        // Handle main image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
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

        // Auto-set Color 1 image to the main product image
        $this->syncColor1Image($product);

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
     * Parse 3 color name + hex pairs (with optional per-color images) into a JSON-ready array.
     */
    private function parseFrameColors(Request $request): ?array
    {
        $names          = $request->input('frame_color_names', []);
        $hexes          = $request->input('frame_color_hexes', []);
        $existingImages = $request->input('frame_color_existing_images', []);
        $colors         = [];

        foreach ($names as $i => $name) {
            $name = trim($name);
            $hex  = trim($hexes[$i] ?? '#000000');
            if (empty($name)) {
                continue;
            }

            $imagePath = $existingImages[$i] ?? '';

            // Upload new color image if provided
            if ($request->hasFile("frame_color_images.$i")) {
                $file      = $request->file("frame_color_images.$i");
                $filename = Str::uuid() . '_color' . ($i + 1) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/products'), $filename);
                $imagePath = 'images/products/' . $filename;
            }

            $colors[] = [
                'name'  => $name,
                'hex'   => $hex,
                'image' => $imagePath ?: '',
            ];
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
     * Upload the sub-image (same color, different angle) into product_images table.
     */
    private function handleSubImages(Request $request, Product $product): void
    {
        if ($request->hasFile('sub_image_1')) {
            $file     = $request->file('sub_image_1');
            $filename = Str::uuid() . '_sub.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/products'), $filename);
            $path = 'images/products/' . $filename;

            $existing = $product->images()->orderBy('id')->first();
            if ($existing) {
                $existing->update(['image_path' => $path]);
            } else {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }
    }

    /**
     * Auto-set Color 1's image to the main product image path.
     */
    private function syncColor1Image(Product $product): void
    {
        $colors = $product->frame_colors;
        if (!empty($colors) && isset($colors[0])) {
            $colors[0]['image'] = $product->image ?? '';
            $product->update(['frame_colors' => $colors]);
        }
    }
}
