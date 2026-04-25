@extends('admin.layouts.app')
@section('title', 'Order #' . $order->id)
@section('page-title', 'Order #' . $order->id)

@section('content')
<div class="row g-4">
    <!-- Order Info -->
    <div class="col-lg-8">
        <div class="admin-card mb-4">
            <div class="admin-card-header">
                <div class="admin-card-title">Order Items</div>
                <span class="badge-status {{ $order->status }}">{{ ucfirst($order->status) }}</span>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr><th>Product</th><th>Type</th><th>Lens</th><th>Qty</th><th>Total</th></tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    @if($item->product && $item->product->image)
                                    <img src="{{ asset($item->product->image) }}" alt="" class="product-thumb">
                                    @endif
                                    <div>
                                        <strong>{{ $item->product_name }}</strong>
                                        @if($item->lens_type)<br><small style="color:var(--text-secondary)">{{ $item->lens_type }}</small>@endif
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge-status {{ $item->purchase_type == 'frame_lens' ? 'processing' : 'pending' }}">{{ $item->purchase_type == 'frame_lens' ? 'Frame + Lens' : 'Frame Only' }}</span></td>
                            <td>{{ $item->lens_price > 0 ? '$' . number_format($item->lens_price, 2) : '—' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td><strong>${{ number_format($item->line_total, 2) }}</strong></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Financials -->
        <div class="admin-card">
            <div class="admin-card-header"><div class="admin-card-title">Order Summary</div></div>
            <div class="d-flex justify-content-between mb-2"><span style="color:var(--text-secondary)">Subtotal</span><span>${{ number_format($order->subtotal, 2) }}</span></div>
            <div class="d-flex justify-content-between mb-2"><span style="color:var(--text-secondary)">Shipping</span><span>${{ number_format($order->shipping, 2) }}</span></div>
            <hr style="border-color:#f1f5f9">
            <div class="d-flex justify-content-between"><strong>Total</strong><strong style="font-size:1.1rem;color:var(--accent)">${{ number_format($order->total, 2) }}</strong></div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Customer -->
        <div class="admin-card mb-4">
            <div class="admin-card-header"><div class="admin-card-title">Customer</div></div>
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="topbar-user-avatar">{{ strtoupper(substr($order->full_name, 0, 1)) }}</div>
                <div>
                    <strong>{{ $order->full_name }}</strong>
                    @if($order->user)<br><small style="color:var(--text-secondary)">{{ $order->user->email }}</small>@endif
                </div>
            </div>
        </div>

        <!-- Shipping -->
        <div class="admin-card mb-4">
            <div class="admin-card-header"><div class="admin-card-title">Shipping Address</div></div>
            <p style="color:var(--text-secondary);font-size:0.85rem;margin:0">
                {{ $order->address }}<br>{{ $order->city }}, {{ $order->zip_code }}
            </p>
        </div>

        <!-- Status Update -->
        <div class="admin-card">
            <div class="admin-card-header"><div class="admin-card-title">Update Status</div></div>
            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                @csrf @method('PATCH')
                <select name="status" class="admin-input admin-select mb-3">
                    @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                    <option value="{{ $s }}" {{ $order->status == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn-admin btn-admin-primary w-100"><i class="fas fa-check"></i> Update Status</button>
            </form>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('admin.orders.index') }}" class="btn-admin btn-admin-outline"><i class="fas fa-arrow-left"></i> Back to Orders</a>
</div>
@endsection
