@extends('admin.layouts.app')
@section('title', 'Products')
@section('page-title', 'Products')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div class="filter-bar mb-0">
        <div class="admin-search">
            <i class="fas fa-search"></i>
            <form method="GET" action="{{ route('admin.products.index') }}" style="margin:0">
                <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}" class="admin-input" style="padding-left:38px">
            </form>
        </div>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn-admin btn-admin-primary">
        <i class="fas fa-plus"></i> Add Product
    </a>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Brand</th>
                    <th>Flags</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr id="product-row-{{ $product->id }}">
                    <td>
                        @if($product->image)
                        <img src="{{ asset($product->image) }}" alt="" class="product-thumb">
                        @else
                        <div class="product-thumb d-flex align-items-center justify-content-center" style="background:#f1f5f9;"><i class="fas fa-image" style="color:#94a3b8"></i></div>
                        @endif
                    </td>
                    <td><strong>{{ $product->name }}</strong></td>
                    <td>{{ $product->category }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>
                        @if($product->stock <= 5)
                        <span style="color:var(--danger);font-weight:600">{{ $product->stock }}</span>
                        @else
                        {{ $product->stock }}
                        @endif
                    </td>
                    <td>{{ $product->brand ?? '—' }}</td>
                    <td>
                        @if($product->is_best_seller)<span class="badge bg-warning text-dark" style="font-size:0.68rem">Best Seller</span>@endif
                        @if($product->is_new_arrival)<span class="badge bg-info text-white" style="font-size:0.68rem">New</span>@endif
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-admin btn-admin-outline btn-admin-sm"><i class="fas fa-edit"></i></a>
                            <button class="btn-admin btn-admin-danger btn-admin-sm btn-delete-product" data-id="{{ $product->id }}"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" style="text-align:center;color:var(--text-secondary);padding:40px;">No products found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center mt-3 admin-pagination">
        {{ $products->links() }}
    </div>
</div>
@endsection

@push('script')
<script>
$(document).on('click', '.btn-delete-product', function() {
    const id = $(this).data('id');
    Swal.fire({
        title: 'Delete Product?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        confirmButtonText: 'Yes, delete'
    }).then(result => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/admin/products/' + id,
                type: 'DELETE',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(res) {
                    $('#product-row-' + id).fadeOut(300, function() { $(this).remove(); });
                    Swal.fire({ icon: 'success', title: 'Deleted!', text: res.message, timer: 1500, showConfirmButton: false });
                }
            });
        }
    });
});
</script>
@endpush
