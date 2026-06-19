@extends('layouts.app')

@section('title', 'My Orders — Basirah')

@push('style')
<style>
    :root {
            --primary: #BDE3F9;
            --primary-hover: #9AD4F5;
            --primary-dark: #68B8E8;
            --dark: #1a1a2e;
            --body-bg: #ffffff;
            --card-bg: #ffffff;
            --text-primary: #1a1a2e;
            --text-secondary: #555;
            --text-muted: #888;
            --border-light: #eee;
            --section-bg: #f8fafc;
            --font-family: 'Inter', sans-serif;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 20px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 8px 30px rgba(0, 0, 0, 0.12);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 24px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

    .navbar-basirah {
            background: #ffffff;
            padding: 12px 0;
            position: sticky;
            top: 0;
            z-index: 1050;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 1px 0 rgba(0, 0, 0, 0.08);
        }

        .navbar-basirah.scrolled {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            font-size: 1.3rem;
            color: #1D3557;
            letter-spacing: -0.3px;
            text-decoration: none;
        }

        .navbar-brand-logo:hover {
            color: #1D3557;
        }

        .navbar-brand-logo .logo-icon {
            width: 36px;
            height: 36px;
            background: #BDE3F9;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            color: #1D3557;
        }

        .navbar-basirah .nav-link {
            color: #4a5568;
            font-weight: 500;
            font-size: 0.9rem;
            padding: 8px 16px !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            white-space: nowrap;
        }

        .navbar-basirah .nav-link:hover,
        .navbar-basirah .nav-link.active {
            color: #1D3557;
            font-weight: 600;
        }

        /* Search Box */
        .navbar-search-form {
            display: flex;
            align-items: center;
        }

        .navbar-search-box {
            position: relative;
            display: flex;
            align-items: center;
        }

        .navbar-search-input {
            background: transparent;
            border: none;
            color: #1D3557;
            padding: 7px 12px;
            font-size: 0.85rem;
            width: 0;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .navbar-search-box:focus-within .navbar-search-input {
            width: 180px;
            opacity: 1;
            background: #f5f7fa;
            border: 1.5px solid #e8eaed;
            border-radius: 24px;
            padding: 7px 16px;
        }

        .navbar-search-input:focus {
            outline: none;
            border-color: #1D3557;
            box-shadow: 0 0 0 3px rgba(29, 53, 87, 0.06);
        }

        .navbar-search-input::placeholder {
            color: rgba(29, 53, 87, 0.35);
        }

        /* Icon Buttons (Search, Fav, Cart) */
        .btn-nav-icon,
        .cart-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: transparent;
            border: none;
            color: #4a5568;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            transition: all 0.25s ease;
            position: relative;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-nav-icon:hover,
        .cart-icon:hover {
            color: #1D3557;
            background: #f0f4f8;
        }

        /* Badges */
        .btn-nav-icon .nav-badge,
        .cart-badge {
            position: absolute;
            top: 0px;
            right: -2px;
            min-width: 18px;
            height: 18px;
            background: #1D3557;
            color: #fff;
            font-size: 0.6rem;
            font-weight: 700;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #fff;
        }
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
    .footer-section {
            background: #f8fafc;
            padding: 60px 0 0;
            border-top: 1px solid var(--border-light);
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 800;
            font-size: 1.2rem;
            color: var(--text-primary);
            margin-bottom: 14px;
        }

        .footer-logo .logo-icon {
            width: 28px;
            height: 28px;
            background: var(--primary);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
        }

        .footer-desc {
            font-size: 0.8rem;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 20px;
            max-width: 280px;
        }

        .footer-social {
            display: flex;
            gap: 12px;
        }

        .footer-social a {
            text-decoration: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .footer-social a:hover {
            background: var(--primary);
            color: var(--text-primary);
            transform: translateY(-2px);
        }

        .footer-heading {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .use_case {
            list-style-type: none;
            margin: 0;
            padding: 0;
            font-size: 0.82rem;
        }

        .use_case li {
            margin-bottom: 15px;
            color: var(--text-muted);
        }


        .footer-links a {
            text-decoration: none;
            color: var(--text-muted);
            font-size: 0.82rem;
            transition: var(--transition);
        }

        .footer-links a:hover {
            color: var(--primary-dark);
            padding-left: 4px;
        }

        .footer-bottom {
            background: #f0f2f5;
            padding: 20px 0;
            margin-top: 40px;
        }

        .footer-bottom p {
            font-size: 0.78rem;
            color: var(--text-muted);
            margin: 0;
        }

        .footer-bottom-links {
            display: flex;
            gap: 20px;
            justify-content: flex-end;
        }

        .footer-bottom-links a {
            text-decoration: none;
            font-size: 0.78rem;
            color: var(--text-muted);
        }

        .footer-bottom-links a:hover {
            color: var(--primary-dark);
        }
</style>
@endpush
@section('navbar')
    @include('layouts.partials.navbar-default')
@endsection
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


