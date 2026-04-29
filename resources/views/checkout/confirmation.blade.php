@extends('layouts.app')

@section('title', 'Order Confirmed — Basirah')

@push('style')
<style>
    .confirmation-wrapper {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px 20px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .confirmation-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        max-width: 700px;
        width: 100%;
        padding: 50px 40px;
        text-align: center;
        animation: slideUp 0.6s ease;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .confirmation-icon {
        width: 90px;
        height: 90px;
        background: linear-gradient(135deg, #28a745, #20c997);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        animation: popIn 0.5s ease 0.3s both;
    }

    @keyframes popIn {
        from { transform: scale(0); }
        to { transform: scale(1); }
    }

    .confirmation-icon i {
        font-size: 40px;
        color: #fff;
    }

    .confirmation-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1D3557;
        margin-bottom: 8px;
    }

    .confirmation-subtitle {
        color: #6c757d;
        font-size: 1rem;
        margin-bottom: 35px;
    }

    .order-details {
        text-align: left;
        background: #f8f9fa;
        border-radius: 14px;
        padding: 25px;
        margin-bottom: 30px;
    }

    .order-details h6 {
        font-weight: 700;
        color: #1D3557;
        margin-bottom: 15px;
        font-size: 0.95rem;
    }

    .order-detail-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid #e9ecef;
        font-size: 0.9rem;
    }

    .order-detail-row:last-child {
        border-bottom: none;
    }

    .order-detail-row .label {
        color: #6c757d;
        font-weight: 500;
    }

    .order-detail-row .value {
        color: #1D3557;
        font-weight: 600;
    }

    .order-items-list {
        text-align: left;
        margin-bottom: 30px;
    }

    .order-items-list h6 {
        font-weight: 700;
        color: #1D3557;
        margin-bottom: 15px;
        font-size: 0.95rem;
    }

    .order-item-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
        font-size: 0.88rem;
    }

    .order-item-row:last-child {
        border-bottom: none;
    }

    .order-item-name {
        flex: 1;
        color: #333;
        font-weight: 500;
    }

    .order-item-qty {
        color: #6c757d;
        margin: 0 15px;
        font-size: 0.82rem;
    }

    .order-item-price {
        font-weight: 600;
        color: #1D3557;
    }

    .order-total-section {
        background: #1D3557;
        color: #fff;
        border-radius: 12px;
        padding: 18px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        font-size: 1.1rem;
    }

    .order-total-section .total-label {
        font-weight: 600;
    }

    .order-total-section .total-value {
        font-weight: 700;
        font-size: 1.3rem;
    }

    .confirmation-actions {
        display: flex;
        gap: 15px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-continue {
        background: #1D3557;
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 14px 35px;
        font-weight: 600;
        font-size: 0.95rem;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-continue:hover {
        background: #2a4a7f;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(29, 53, 87, 0.3);
    }

    .btn-orders {
        background: transparent;
        color: #1D3557;
        border: 2px solid #1D3557;
        border-radius: 12px;
        padding: 14px 35px;
        font-weight: 600;
        font-size: 0.95rem;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-orders:hover {
        background: #1D3557;
        color: #fff;
        transform: translateY(-2px);
    }

    .status-badge {
        display: inline-block;
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 600;
        text-transform: uppercase;
        background: #fff3cd;
        color: #856404;
    }
</style>
@endpush

@section('content')
<div class="confirmation-wrapper">
    <div class="confirmation-card">
        <div class="confirmation-icon">
            <i class="fas fa-check"></i>
        </div>

        <h1 class="confirmation-title">Order Confirmed!</h1>
        <p class="confirmation-subtitle">
            Thank you for your purchase. Your order <strong>#{{ $order->id }}</strong> has been placed successfully.
        </p>

        {{-- Order Details --}}
        <div class="order-details">
            <h6><i class="fas fa-shipping-fast me-2"></i>Shipping Details</h6>
            <div class="order-detail-row">
                <span class="label">Name</span>
                <span class="value">{{ $order->full_name }}</span>
            </div>
            <div class="order-detail-row">
                <span class="label">Address</span>
                <span class="value">{{ $order->address }}</span>
            </div>
            <div class="order-detail-row">
                <span class="label">City</span>
                <span class="value">{{ $order->city }}</span>
            </div>
            <div class="order-detail-row">
                <span class="label">Payment</span>
                <span class="value">{{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</span>
            </div>
            <div class="order-detail-row">
                <span class="label">Status</span>
                <span class="value"><span class="status-badge">{{ ucfirst($order->status) }}</span></span>
            </div>
        </div>

        {{-- Items --}}
        <div class="order-items-list">
            <h6><i class="fas fa-box me-2"></i>Order Items</h6>
            @foreach ($order->items as $item)
            <div class="order-item-row">
                <span class="order-item-name">{{ $item->product_name }}</span>
                <span class="order-item-qty">× {{ $item->quantity }}</span>
                <span class="order-item-price">${{ number_format($item->line_total, 2) }}</span>
            </div>
            @endforeach
        </div>

        {{-- Total --}}
        <div class="order-total-section">
            <span class="total-label">Total Paid</span>
            <span class="total-value">${{ number_format($order->total, 2) }}</span>
        </div>

        {{-- Actions --}}
        <div class="confirmation-actions">
            <a href="{{ route('orders.index') }}" class="btn-orders">
                <i class="fas fa-receipt me-2"></i>My Orders
            </a>
            <a href="{{ route('products.index') }}" class="btn-continue">
                <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
            </a>
        </div>
    </div>
</div>
@endsection
