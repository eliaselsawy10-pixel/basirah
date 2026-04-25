@extends('admin.layouts.app')
@section('title', 'Reviews')
@section('page-title', 'Reviews')

@section('content')
<div class="filter-bar">
    <div class="filter-tabs">
        @foreach(['all' => 'All', 'site' => 'Site Reviews', 'product' => 'Product Reviews'] as $key => $label)
        <a href="{{ route('admin.reviews.index', ['type' => $key]) }}" class="filter-tab {{ (request('type', 'all') == $key) ? 'active' : '' }}">{{ $label }}</a>
        @endforeach
    </div>
    <div class="filter-tabs">
        <a href="{{ route('admin.reviews.index', array_merge(request()->except('rating'), [])) }}" class="filter-tab {{ !request('rating') ? 'active' : '' }}">All Stars</a>
        @for($i = 5; $i >= 1; $i--)
        <a href="{{ route('admin.reviews.index', array_merge(request()->except('rating'), ['rating' => $i])) }}" class="filter-tab {{ request('rating') == $i ? 'active' : '' }}">{{ $i }}★</a>
        @endfor
    </div>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr><th>Reviewer</th><th>Rating</th><th>Comment</th><th>Product</th><th>Date</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                <tr id="review-row-{{ $review->id }}">
                    <td><strong>{{ $review->reviewer_name }}</strong></td>
                    <td>
                        <div class="star-rating">
                            @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= $review->rating ? '' : 'empty' }}"></i>
                            @endfor
                        </div>
                    </td>
                    <td style="max-width:300px;">{{ Str::limit($review->comment, 80) }}</td>
                    <td>{{ $review->product ? $review->product->name : 'Site Review' }}</td>
                    <td>{{ $review->created_at->format('M d, Y') }}</td>
                    <td>
                        <button class="btn-admin btn-admin-danger btn-admin-sm btn-delete-review" data-id="{{ $review->id }}"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;color:var(--text-secondary);padding:40px;">No reviews found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center mt-3 admin-pagination">{{ $reviews->links() }}</div>
</div>
@endsection

@push('script')
<script>
$(document).on('click', '.btn-delete-review', function() {
    const id = $(this).data('id');
    Swal.fire({
        title: 'Delete Review?', text: 'This will permanently remove this review.', icon: 'warning',
        showCancelButton: true, confirmButtonColor: '#ef4444', confirmButtonText: 'Yes, delete'
    }).then(result => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/admin/reviews/' + id, type: 'DELETE',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(res) {
                    $('#review-row-' + id).fadeOut(300, function() { $(this).remove(); });
                    Swal.fire({ icon: 'success', title: 'Deleted!', timer: 1500, showConfirmButton: false });
                }
            });
        }
    });
});
</script>
@endpush
