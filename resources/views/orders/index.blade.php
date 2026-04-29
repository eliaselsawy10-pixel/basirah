@extends('layouts.app')

@section('title', 'My Orders — Basirah')

@push('style')
<style>
    .orders-wrapper {
        min-height: 80vh;
        padding: 50px 20px;
        background: #f8f9fa;
    }

    .orders-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .orders-header {
        margin-bottom: 35px;
    }

    .orders-header h1 {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1D3557;
    }

    .orders-header p {
        color: #6c757d;
        font-size: 0.95rem;
    }

    .order-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        padding: 25px 30px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
        border: 1px solid #eef1f5;
    }

    .order-card:hover {
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .order-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .order-id {
        font-weight: 700;
        color: #1D3557;
        font-size: 1.05rem;
    }

    .order-date {
        color: #6c757d;
        font-size: 0.85rem;
    }

    .order-status {
        display: inline-block;
        padding: 5px 16px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .order-status.pending { background: #fff3cd; color: #856404; }
    .order-status.processing { background: #cce5ff; color: #004085; }
    .order-status.shipped { background: #d4edda; color: #155724; }
    .order-status.delivered { background: #d1ecf1; color: #0c5460; }
    .order-status.cancelled { background: #f8d7da; color: #721c24; }

    .order-items-preview {
        border-top: 1px solid #f0f0f0;
        padding-top: 15px;
    }

    .order-item-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 6px 0;
        font-size: 0.88rem;
    }

    .order-item-row .item-name {
        flex: 1;
        color: #333;
        font-weight: 500;
    }

    .order-item-row .item-qty {
        color: #6c757d;
        margin: 0 15px;
        font-size: 0.82rem;
    }

    .order-item-row .item-price {
        font-weight: 600;
        color: #1D3557;
    }

    .order-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 18px;
        padding-top: 15px;
        border-top: 1px solid #f0f0f0;
    }

    .order-total {
        font-weight: 700;
        font-size: 1.1rem;
        color: #1D3557;
    }

    .order-total span {
        color: #6c757d;
        font-weight: 500;
        font-size: 0.85rem;
    }

    .empty-orders {
        text-align: center;
        padding: 80px 20px;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    }

    .empty-orders i {
        font-size: 60px;
        color: #dee2e6;
        margin-bottom: 20px;
    }

    .empty-orders h4 {
        font-weight: 700;
        color: #1D3557;
        margin-bottom: 10px;
    }

    .empty-orders p {
        color: #6c757d;
        margin-bottom: 25px;
    }

    .btn-shop {
        background: #1D3557;
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 12px 30px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-shop:hover {
        background: #2a4a7f;
        color: #fff;
        transform: translateY(-2px);
    }
</style>
@endpush

@section('content')
<div class="orders-wrapper">
    <div class="orders-container">
        <div class="orders-header">
            <h1><i class="fas fa-receipt me-2"></i>My Orders</h1>
            <p>Track and review your purchase history</p>
        </div>

        @if ($orders->isEmpty())
            <div class="empty-orders">
                <i class="fas fa-shopping-bag"></i>
                <h4>No Orders Yet</h4>
                <p>You haven't placed any orders. Start shopping to see your orders here!</p>
                <a href="{{ route('products.index') }}" class="btn-shop">
                    <i class="fas fa-shopping-bag me-2"></i>Browse Products
                </a>
            </div>
        @else
            @foreach ($orders as $order)
            <div class="order-card">
                <div class="order-card-header">
                    <div>
                        <span class="order-id">Order #{{ $order->id }}</span>
                        <span class="order-date ms-3">
                            <i class="far fa-calendar-alt me-1"></i>{{ $order->created_at->format('M d, Y · h:i A') }}
                        </span>
                    </div>
                    <span class="order-status {{ $order->status }}">{{ ucfirst($order->status) }}</span>
                </div>

                <div class="order-items-preview">
                    @foreach ($order->items->take(3) as $item)
                    <div class="order-item-row">
                        <span class="item-name">{{ $item->product_name }}</span>
                        <span class="item-qty">× {{ $item->quantity }}</span>
                        <span class="item-price">${{ number_format($item->line_total, 2) }}</span>
                    </div>
                    @endforeach

                    @if ($order->items->count() > 3)
                    <div class="order-item-row">
                        <span class="item-name text-muted fst-italic">+ {{ $order->items->count() - 3 }} more item(s)</span>
                    </div>
                    @endif
                </div>

                <div class="order-card-footer">
                    <div class="order-total">
                        <span>Total: </span>${{ number_format($order->total, 2) }}
                    </div>
                    <div>
                        <span class="text-muted" style="font-size: 0.82rem;">
                            {{ $order->items->count() }} item(s) · {{ ucwords(str_replace('_', ' ', $order->payment_method)) }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="d-flex justify-content-center mt-4">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
