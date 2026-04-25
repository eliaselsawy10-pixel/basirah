@extends('admin.layouts.app')
@section('title', 'Users')
@section('page-title', 'Users')

@section('content')
<div class="filter-bar">
    <div class="filter-tabs">
        @foreach(['all' => 'All', 'patient' => 'Patients', 'doctor' => 'Doctors', 'admin' => 'Admins'] as $key => $label)
        <a href="{{ route('admin.users.index', ['role' => $key]) }}" class="filter-tab {{ (request('role', 'all') == $key) ? 'active' : '' }}">{{ $label }}</a>
        @endforeach
    </div>
    <div class="admin-search">
        <i class="fas fa-search"></i>
        <form method="GET" action="{{ route('admin.users.index') }}" style="margin:0">
            <input type="hidden" name="role" value="{{ request('role', 'all') }}">
            <input type="text" name="search" placeholder="Search by name or email..." value="{{ request('search') }}" class="admin-input" style="padding-left:38px">
        </form>
    </div>
    @if(request('role') === 'doctor')
    <a href="{{ route('admin.users.create') }}" class="btn-admin btn-admin-primary" style="margin-left:auto">
        <i class="fas fa-user-plus"></i> Add Doctor
    </a>
    @endif
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr><th>Name</th><th>Email</th><th>Role</th><th>Joined</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr id="user-row-{{ $user->id }}">
                    <td><strong>{{ $user->name }}</strong></td>
                    <td>{{ $user->email }}</td>
                    <td><span class="badge-role {{ $user->role }}">{{ ucfirst($user->role) }}</span></td>
                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-admin btn-admin-outline btn-admin-sm"><i class="fas fa-edit"></i></a>
                            @if($user->id !== auth()->id())
                            <button class="btn-admin btn-admin-danger btn-admin-sm btn-delete-user" data-id="{{ $user->id }}"><i class="fas fa-trash"></i></button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center;color:var(--text-secondary);padding:40px;">No users found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center mt-3 admin-pagination">{{ $users->links() }}</div>
</div>
@endsection

@push('script')
<script>
$(document).on('click', '.btn-delete-user', function() {
    const id = $(this).data('id');
    Swal.fire({
        title: 'Delete User?', text: 'This will permanently delete this user and their data.', icon: 'warning',
        showCancelButton: true, confirmButtonColor: '#ef4444', confirmButtonText: 'Yes, delete'
    }).then(result => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/admin/users/' + id, type: 'DELETE',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(res) {
                    $('#user-row-' + id).fadeOut(300, function() { $(this).remove(); });
                    Swal.fire({ icon: 'success', title: 'Deleted!', text: res.message, timer: 1500, showConfirmButton: false });
                },
                error: function(xhr) {
                    Swal.fire({ icon: 'error', title: 'Error', text: xhr.responseJSON?.message || 'Could not delete user.' });
                }
            });
        }
    });
});
</script>
@endpush
