@extends('admin.layouts.app')
@section('title', 'Prescriptions')
@section('page-title', 'Prescriptions')

@section('content')
<div class="filter-bar">
    <div class="filter-tabs">
        @foreach(['all' => 'All', 'submitted' => 'Submitted', 'ordered' => 'Ordered'] as $key => $label)
        <a href="{{ route('admin.prescriptions.index', ['status' => ($key === 'all' ? null : $key)]) }}" class="filter-tab {{ (request('status', 'all') == $key || (!request('status') && $key === 'all')) ? 'active' : '' }}">{{ $label }}</a>
        @endforeach
    </div>
    <div class="filter-tabs">
        @foreach(['all' => 'All Types', 'eyeglasses' => 'Eyeglasses', 'contact' => 'Contact'] as $key => $label)
        <a href="{{ route('admin.prescriptions.index', array_merge(request()->except('type'), $key === 'all' ? [] : ['type' => $key])) }}" class="filter-tab {{ (request('type', 'all') == $key || (!request('type') && $key === 'all')) ? 'active' : '' }}">{{ $label }}</a>
        @endforeach
    </div>
    <div class="admin-search">
        <i class="fas fa-search"></i>
        <form method="GET" action="{{ route('admin.prescriptions.index') }}" style="margin:0">
            <input type="text" name="search" placeholder="Search by user..." value="{{ request('search') }}" class="admin-input" style="padding-left:38px">
        </form>
    </div>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr><th>User</th><th>Product</th><th>Type</th><th>OD (SPH/CYL/AXIS)</th><th>OS (SPH/CYL/AXIS)</th><th>PD</th><th>Status</th><th>Date</th></tr>
            </thead>
            <tbody>
                @forelse($prescriptions as $rx)
                <tr>
                    <td><strong>{{ $rx->user->name ?? 'N/A' }}</strong></td>
                    <td>{{ $rx->product->name ?? '—' }}</td>
                    <td><span class="badge-status {{ $rx->type == 'eyeglasses' ? 'processing' : 'confirmed' }}">{{ ucfirst($rx->type ?? 'N/A') }}</span></td>
                    <td>{{ $rx->od_sph ?? '—' }} / {{ $rx->od_cyl ?? '—' }} / {{ $rx->od_axis ?? '—' }}</td>
                    <td>{{ $rx->os_sph ?? '—' }} / {{ $rx->os_cyl ?? '—' }} / {{ $rx->os_axis ?? '—' }}</td>
                    <td>{{ $rx->pd_value ?? '—' }}</td>
                    <td><span class="badge-status {{ $rx->status ?? 'pending' }}">{{ ucfirst($rx->status ?? 'N/A') }}</span></td>
                    <td>{{ $rx->created_at->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="8" style="text-align:center;color:var(--text-secondary);padding:40px;">No prescriptions found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center mt-3 admin-pagination">{{ $prescriptions->links() }}</div>
</div>
@endsection
