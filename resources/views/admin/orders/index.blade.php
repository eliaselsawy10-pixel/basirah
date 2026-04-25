@extends('admin.layouts.app')
@section('title', 'Orders')
@section('page-title', 'Orders')

@section('content')
<div class="filter-bar">
    <div class="filter-tabs">
        @foreach(['all' => 'All', 'pending' => 'Pending', 'processing' => 'Processing', 'shipped' => 'Shipped', 'delivered' => 'Delivered', 'cancelled' => 'Cancelled'] as $key => $label)
        <a href="{{ route('admin.orders.index', ['status' => $key]) }}" class="filter-tab {{ (request('status', 'all') == $key) ? 'active' : '' }}">
            {{ $label }} <span style="opacity:0.6">({{ $statusCounts[$key] ?? 0 }})</span>
        </a>
        @endforeach
    </div>
    <div class="admin-search">
        <i class="fas fa-search"></i>
        <form method="GET" action="{{ route('admin.orders.index') }}" style="margin:0">
            <input type="hidden" name="status" value="{{ request('status', 'all') }}">
            <input type="text" name="search" placeholder="Search by ID, name, city..." value="{{ request('search') }}" class="admin-input" style="padding-left:38px">
        </form>
    </div>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>City</th>
                    <th>Payment</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><strong>#{{ $order->id }}</strong></td>
                    <td>{{ $order->full_name }}</td>
                    <td>{{ $order->city }}</td>
                    <td>{{ $order->payment_method == 'credit_card' ? 'Credit Card' : 'Digital Wallet' }}</td>
                    <td><strong>${{ number_format($order->total, 2) }}</strong></td>
                    <td><span class="badge-status {{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn-admin btn-admin-outline btn-admin-sm"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" style="text-align:center;color:var(--text-secondary);padding:40px;">No orders found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center mt-3 admin-pagination">{{ $orders->links() }}</div>
</div>
@endsection
