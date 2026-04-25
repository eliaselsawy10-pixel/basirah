@extends('admin.layouts.app')
@section('title', $product ? 'Edit Product' : 'Add Product')
@section('page-title', $product ? 'Edit Product' : 'Add Product')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="admin-card">
                <form action="{{ $product ? route('admin.products.update', $product->id) : route('admin.products.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if($product) @method('PUT') @endif

                    @if($errors->any())
                        <div class="admin-alert admin-alert-danger">
                            <i class="fas fa-exclamation-circle"></i>
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- ═══════════════════════════════════════════════
                    BASIC INFO
                    ═══════════════════════════════════════════════ --}}
                    <h5 class="mb-3"
                        style="font-weight:700; color:#1D3557; border-bottom:2px solid #e2e8f0; padding-bottom:10px;">
                        <i class="fas fa-info-circle me-2"></i>Basic Information
                    </h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-8">
                            <label class="admin-label">Product Name *</label>
                            <input type="text" name="name" class="admin-input"
                                value="{{ old('name', $product->name ?? '') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="admin-label">Category *</label>
                            <select name="category" class="admin-input admin-select" required>
                                <option value="">Select...</option>
                                @foreach(['Men', 'Women', 'Kids', 'Contact Lenses'] as $cat)
                                    <option value="{{ $cat }}" {{ old('category', $product->category ?? '') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="admin-label">Description</label>
                            <textarea name="description" class="admin-input"
                                rows="3">{{ old('description', $product->description ?? '') }}</textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="admin-label">Price ($) *</label>
                            <input type="number" name="price" class="admin-input" step="0.01" min="0"
                                value="{{ old('price', $product->price ?? '') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="admin-label">Stock *</label>
                            <input type="number" name="stock" class="admin-input" min="0"
                                value="{{ old('stock', $product->stock ?? 0) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="admin-label">Brand</label>
                            <input type="text" name="brand" class="admin-input"
                                value="{{ old('brand', $product->brand ?? '') }}">
                        </div>
                        <div class="col-md-4 frame-only-field">
                            <label class="admin-label">Material</label>
                            <input type="text" name="material" class="admin-input"
                                value="{{ old('material', $product->material ?? '') }}">
                        </div>
                        <div class="col-md-4 frame-only-field">
                            <label class="admin-label">Face Shapes</label>
                            <input type="text" name="face_shapes" class="admin-input" placeholder="oval,round,square"
                                value="{{ old('face_shapes', $product->face_shapes ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="admin-label">Color Family</label>
                            <input type="text" name="color_family" class="admin-input"
                                value="{{ old('color_family', $product->color_family ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="admin-label">Replacement</label>
                            <input type="text" name="replacement" class="admin-input"
                                value="{{ old('replacement', $product->replacement ?? '') }}">
                        </div>
                        <div class="col-md-4 d-flex align-items-end gap-4">
                            <label class="d-flex align-items-center gap-2" style="cursor:pointer;">
                                <input type="checkbox" name="is_best_seller" value="1" {{ old('is_best_seller', $product->is_best_seller ?? false) ? 'checked' : '' }}>
                                <span class="admin-label mb-0">Best Seller</span>
                            </label>
                            <label class="d-flex align-items-center gap-2" style="cursor:pointer;">
                                <input type="checkbox" name="is_new_arrival" value="1" {{ old('is_new_arrival', $product->is_new_arrival ?? false) ? 'checked' : '' }}>
                                <span class="admin-label mb-0">New Arrival</span>
                            </label>
                        </div>
                    </div>

                    {{-- ═══════════════════════════════════════════════
                    PRODUCT IMAGES (Main + 2 Sub-Photos)
                    ═══════════════════════════════════════════════ --}}
                    <h5 class="mb-3"
                        style="font-weight:700; color:#1D3557; border-bottom:2px solid #e2e8f0; padding-bottom:10px;">
                        <i class="fas fa-images me-2"></i>Product Images
                    </h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="admin-label">Main Photo</label>
                            <input type="file" name="image" class="admin-input" accept="image/*">
                            @if($product && $product->image)
                                <div class="mt-2">
                                    <img src="{{ asset($product->image) }}" alt="Main"
                                        style="width:80px;height:80px;object-fit:contain;border:1px solid #e2e8f0;border-radius:8px;padding:4px;">
                                </div>
                            @endif
                        </div>
                        <div class="col-md-4 frame-only-field">
                            <label class="admin-label">Sub Photo 1</label>
                            <input type="file" name="sub_image_1" class="admin-input" accept="image/*">
                            @if($product && $product->images->count() > 0)
                                <div class="mt-2">
                                    <img src="{{ asset($product->images[0]->image_path) }}" alt="Sub 1"
                                        style="width:80px;height:80px;object-fit:contain;border:1px solid #e2e8f0;border-radius:8px;padding:4px;">
                                </div>
                            @endif
                        </div>
                        <div class="col-md-4 frame-only-field">
                            <label class="admin-label">Sub Photo 2</label>
                            <input type="file" name="sub_image_2" class="admin-input" accept="image/*">
                            @if($product && $product->images->count() > 1)
                                <div class="mt-2">
                                    <img src="{{ asset($product->images[1]->image_path) }}" alt="Sub 2"
                                        style="width:80px;height:80px;object-fit:contain;border:1px solid #e2e8f0;border-radius:8px;padding:4px;">
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- ═══════════════════════════════════════════════
                    FRAME OPTIONS
                    ═══════════════════════════════════════════════ --}}
                    <h5 class="mb-3 frame-only-section"
                        style="font-weight:700; color:#1D3557; border-bottom:2px solid #e2e8f0; padding-bottom:10px;">
                        <i class="fas fa-glasses me-2"></i>Frame Options
                    </h5>

                    {{-- Frame Materials --}}
                    <div class="mb-3 frame-only-section">
                        <label class="admin-label">Frame Materials <small
                                class="text-muted">(comma-separated)</small></label>
                        <input type="text" name="frame_materials_input" class="admin-input"
                            placeholder="e.g. Titanium Alloy, Premium Acetate"
                            value="{{ old('frame_materials_input', $product && $product->frame_materials ? implode(', ', $product->frame_materials) : '') }}">
                        <small class="text-muted">Enter material names separated by commas</small>
                    </div>

                    {{-- Frame Colors (3 color slots) --}}
                    <div class="mb-3 frame-only-section">
                        <label class="admin-label">Frame Colors <small class="text-muted">(up to 3 colors)</small></label>
                        @php
                            $colors = old('frame_color_names')
                                ? array_map(function ($n, $h) {
                                    return ['name' => $n, 'hex' => $h]; }, old('frame_color_names'), old('frame_color_hexes', []))
                                : ($product && $product->frame_colors ? $product->frame_colors : []);
                        @endphp
                        <div class="row g-2">
                            @for($i = 0; $i < 3; $i++)
                                <div class="col-md-4">
                                    <div
                                        style="border:1px solid #e2e8f0; border-radius:10px; padding:12px; background:#f8fafc;">
                                        <label class="admin-label" style="font-size:0.75rem;">Color {{ $i + 1 }} Name</label>
                                        <input type="text" name="frame_color_names[]" class="admin-input mb-2"
                                            placeholder="e.g. Black" value="{{ $colors[$i]['name'] ?? '' }}">
                                        <label class="admin-label" style="font-size:0.75rem;">Hex Code</label>
                                        <div class="d-flex align-items-center gap-2">
                                            <input type="color" name="frame_color_hexes[]"
                                                value="{{ $colors[$i]['hex'] ?? '#000000' }}"
                                                style="width:42px;height:38px;border:1px solid #ddd;border-radius:6px;padding:2px;cursor:pointer;">
                                            <input type="text" class="admin-input hex-text-input"
                                                value="{{ $colors[$i]['hex'] ?? '#000000' }}" style="flex:1;" readonly>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>

                    {{-- Frame Sizes (3 size slots) --}}
                    <div class="mb-4 frame-only-section">
                        <label class="admin-label">Frame Sizes <small class="text-muted">(up to 3 sizes)</small></label>
                        @php
                            $sizes = old('frame_size_values')
                                ? array_map(function ($v, $l) {
                                    return ['value' => $v, 'label' => $l]; }, old('frame_size_values'), old('frame_size_labels', []))
                                : ($product && $product->frame_sizes ? $product->frame_sizes : []);
                        @endphp
                        <div class="row g-2">
                            @for($i = 0; $i < 3; $i++)
                                <div class="col-md-4">
                                    <div
                                        style="border:1px solid #e2e8f0; border-radius:10px; padding:12px; background:#f8fafc;">
                                        <label class="admin-label" style="font-size:0.75rem;">Size Value</label>
                                        <input type="text" name="frame_size_values[]" class="admin-input mb-2"
                                            placeholder="e.g. small" value="{{ $sizes[$i]['value'] ?? '' }}">
                                        <label class="admin-label" style="font-size:0.75rem;">Display Label</label>
                                        <input type="text" name="frame_size_labels[]" class="admin-input"
                                            placeholder="e.g. Small (48-18)" value="{{ $sizes[$i]['label'] ?? '' }}">
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3 mt-4 pt-3" style="border-top:1px solid #f1f5f9">
                        <a href="{{ route('admin.products.index') }}" class="btn-admin btn-admin-outline">Cancel</a>
                        <button type="submit" class="btn-admin btn-admin-primary">
                            <i class="fas fa-save"></i> {{ $product ? 'Update' : 'Create' }} Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            // Sync color picker → text display
            document.querySelectorAll('input[type="color"]').forEach(picker => {
                const textInput = picker.closest('.d-flex').querySelector('.hex-text-input');
                picker.addEventListener('input', () => { textInput.value = picker.value; });
            });

            // Toggle frame-only sections based on category
            function toggleFrameSections() {
                const category = document.querySelector('select[name="category"]').value;
                const isColorLens = (category === 'Contact Lenses');
                document.querySelectorAll('.frame-only-field, .frame-only-section').forEach(el => {
                    el.style.display = isColorLens ? 'none' : '';
                });
            }
            document.querySelector('select[name="category"]').addEventListener('change', toggleFrameSections);
            toggleFrameSections(); // run on page load
        </script>
    @endpush
@endsection