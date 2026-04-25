@extends('layouts.app')
@section('title', 'Your Cart — Basirah')
@section('description_content', 'Basirah — Your shopping cart. Review your selected eyewear and lenses before checkout.')
@push('style')
    <style>
        /* ========================================
                   DESIGN TOKENS (Basirah Brand)
                ======================================== */
        :root {
            --primary: #BDE3F9;
            --primary-hover: #9AD4F5;
            --primary-dark: #68B8E8;
            --accent-blue: #3AAFDB;
            --dark: #1a1a2e;
            --body-bg: #f5f7fa;
            --card-bg: #ffffff;
            --text-primary: #1a1a2e;
            --text-secondary: #555;
            --text-muted: #888;
            --border-light: #e8eaed;
            --border-input: #dde0e4;
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
            --green-free: #22c55e;
        }

        /* ========================================
                   GLOBAL RESET & BASE
                ======================================== */
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font-family);
            color: var(--text-primary);
            background: var(--body-bg);
            line-height: 1.6;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-weight: 700;
            line-height: 1.2;
        }

        a {
            text-decoration: none;
            transition: var(--transition);
        }

        /* ========== NAVBAR ========== */
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
            background: #1D3557;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            color: #fff;
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

        /* Sign In Button */
        .btn-sign-in {
            background: #1D3557;
            border: 1.5px solid #1D3557;
            color: #fff;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 8px 22px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            white-space: nowrap;
            text-decoration: none;
        }

        .btn-sign-in:hover {
            background: #274b78;
            border-color: #274b78;
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(29, 53, 87, 0.2);
        }

        /* Mobile Toggler */
        .navbar-basirah .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(29,53,87,0.7)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }


        /* ========================================
                   CART PAGE HEADER
                ======================================== */
        .cart-wrapper {
            padding: 20px 0 80px;
            max-width: 640px;
            margin: 0 auto;
        }

        .cart-top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 0 24px;
            border-bottom: 1px solid var(--border-light);
            margin-bottom: 0;
        }

        .cart-back-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: none;
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-primary);
            font-size: 1.1rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .cart-back-btn:hover {
            background: var(--section-bg);
        }

        .cart-top-bar h1 {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }

        .cart-more-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: none;
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            font-size: 1.1rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .cart-more-btn:hover {
            background: var(--section-bg);
        }

        /* ========================================
                   CART ITEM ROW
                ======================================== */
        .cart-item {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            padding: 24px 0;
            border-bottom: 1px solid var(--border-light);
            position: relative;
            transition: var(--transition);
        }

        .cart-item:hover {
            background: #fafbfd;
            margin: 0 -16px;
            padding: 24px 16px;
            border-radius: var(--radius-sm);
        }

        .cart-item-image {
            width: 72px;
            height: 72px;
            border-radius: var(--radius-md);
            background: #f0f2f5;
            overflow: hidden;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
        }

        .cart-item-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .cart-item-info {
            flex: 1;
            min-width: 0;
        }

        .cart-item-name {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 2px;
            line-height: 1.3;
        }

        .cart-item-desc {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .cart-item-price {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        /* Delete Button */
        .cart-item-delete {
            position: absolute;
            top: 24px;
            right: 0;
            background: transparent;
            border: none;
            color: #c4c7cc;
            font-size: 1rem;
            cursor: pointer;
            padding: 4px;
            transition: var(--transition);
        }

        .cart-item:hover .cart-item-delete {
            right: 16px;
        }

        .cart-item-delete:hover {
            color: #e74c3c;
            transform: scale(1.15);
        }

        /* Quantity Controls */
        .qty-controls {
            display: flex;
            align-items: center;
            gap: 0;
            background: #f0f2f5;
            border-radius: var(--radius-xl);
            overflow: hidden;
            height: 36px;
            flex-shrink: 0;
            align-self: flex-end;
        }

        .qty-btn {
            width: 36px;
            height: 36px;
            border: none;
            background: transparent;
            color: var(--text-primary);
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .qty-btn:hover {
            background: #e4e7ec;
        }

        .qty-btn:active {
            background: #d4d7dc;
        }

        .qty-value {
            width: 32px;
            text-align: center;
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--text-primary);
            user-select: none;
        }

        /* Item bottom row: price + qty */
        .cart-item-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 4px;
        }

        /* ========================================
                   COUPON BANNER
                ======================================== */
        .coupon-banner {
            display: flex;
            align-items: center;
            gap: 14px;
            background: #f0f8ff;
            border-radius: var(--radius-md);
            padding: 16px 20px;
            margin: 24px 0;
            transition: var(--transition);
        }

        .coupon-banner:hover {
            background: #e6f3fd;
        }

        .coupon-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(189, 227, 249, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: var(--accent-blue);
            flex-shrink: 0;
        }

        .coupon-info {
            flex: 1;
        }

        .coupon-title {
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1px;
        }

        .coupon-desc {
            font-size: 0.76rem;
            color: var(--text-muted);
        }

        .coupon-add-btn {
            background: transparent;
            border: none;
            color: var(--text-primary);
            font-weight: 600;
            font-size: 0.88rem;
            cursor: pointer;
            padding: 6px 12px;
            border-radius: var(--radius-sm);
            transition: var(--transition);
        }

        .coupon-add-btn:hover {
            background: rgba(189, 227, 249, 0.4);
            color: var(--accent-blue);
        }

        /* ========================================
                   ORDER SUMMARY
                ======================================== */
        .order-summary-section {
            padding-top: 8px;
        }

        .order-summary-section h2 {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 20px;
        }

        .summary-card {
            background: var(--section-bg);
            border-radius: var(--radius-md);
            padding: 20px 22px;
        }

        .summary-line {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            font-size: 0.88rem;
        }

        .summary-line .label {
            color: var(--text-muted);
            font-weight: 400;
        }

        .summary-line .value {
            color: var(--text-primary);
            font-weight: 500;
        }

        .summary-line .value.free {
            color: var(--green-free);
            font-weight: 600;
        }

        .summary-divider {
            border: none;
            border-top: 1px solid var(--border-light);
            margin: 16px 0;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .summary-total .label {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .summary-total .value {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--text-primary);
        }

        /* ========================================
                   PROMO CODE
                ======================================== */
        .promo-section {
            margin-top: 20px;
        }

        .promo-row {
            display: flex;
            gap: 10px;
            align-items: stretch;
        }

        .promo-input {
            flex: 1;
            padding: 12px 16px;
            border: 1.5px solid var(--border-input);
            border-radius: var(--radius-sm);
            font-size: 0.88rem;
            font-family: var(--font-family);
            color: var(--text-primary);
            background: #fff;
            outline: none;
            transition: var(--transition);
        }

        .promo-input::placeholder {
            color: #b0b3b8;
            font-weight: 400;
        }

        .promo-input:focus {
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 3px rgba(58, 175, 219, 0.12);
        }

        .promo-input-icon {
            position: relative;
        }

        .promo-input-icon i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #b0b3b8;
            font-size: 0.85rem;
        }

        .promo-input-icon .promo-input {
            padding-left: 40px;
        }

        .btn-apply-promo {
            padding: 12px 24px;
            background: var(--text-primary);
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            font-size: 0.88rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            white-space: nowrap;
        }

        .btn-apply-promo:hover {
            background: #2d2d4a;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(26, 26, 46, 0.3);
        }

        .btn-apply-promo:active {
            transform: translateY(0);
        }

        /* ========================================
                   CHECKOUT CTA
                ======================================== */
        .checkout-cta-section {
            margin-top: 32px;
        }

        .btn-proceed-checkout {
            width: 100%;
            padding: 18px 32px;
            background: linear-gradient(135deg, #a8d8f0 0%, #87c8e8 50%, #6bbde0 100%);
            color: var(--text-primary);
            border: none;
            border-radius: var(--radius-xl);
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            letter-spacing: 0.01em;
            text-decoration: none;
        }

        .btn-proceed-checkout:hover {
            background: linear-gradient(135deg, #93cfe8 0%, #72bfe0 50%, #58b3d8 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(58, 175, 219, 0.3);
            color: var(--text-primary);
        }

        .btn-proceed-checkout:active {
            transform: translateY(0);
        }

        .legal-text {
            font-size: 0.73rem;
            color: var(--text-muted);
            text-align: center;
            margin-top: 14px;
            line-height: 1.5;
        }

        .legal-text a {
            color: var(--text-secondary);
            text-decoration: underline;
            font-weight: 500;
        }

        .legal-text a:hover {
            color: var(--accent-blue);
        }

        /* ========================================
                   EMPTY CART
                ======================================== */
        .empty-cart {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-cart-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--section-bg);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #c4c7cc;
            margin-bottom: 20px;
        }

        .empty-cart h3 {
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .empty-cart p {
            font-size: 0.88rem;
            color: var(--text-muted);
            margin-bottom: 24px;
        }

        .btn-shop-now {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 12px 28px;
            background: var(--text-primary);
            color: #fff;
            border-radius: var(--radius-sm);
            font-weight: 600;
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .btn-shop-now:hover {
            background: #2d2d4a;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(26, 26, 46, 0.3);
        }

        /* ========================================
                   RESPONSIVE
                ======================================== */
        @media (max-width: 767.98px) {
            .cart-wrapper {
                padding: 12px 4px 60px;
            }

            .cart-item-image {
                width: 60px;
                height: 60px;
            }

            .navbar-basirah .navbar-collapse {
                background: #fff;
                border-radius: var(--radius-md);
                padding: 16px;
                margin-top: 8px;
                box-shadow: var(--shadow-md);
            }
        }

        /* ========================================
                   ANIMATIONS
                ======================================== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-in {
            animation: fadeInUp 0.45s ease forwards;
        }

        .delay-1 {
            animation-delay: 0.08s;
        }

        .delay-2 {
            animation-delay: 0.16s;
        }

        .delay-3 {
            animation-delay: 0.24s;
        }

        .delay-4 {
            animation-delay: 0.32s;
        }

        .delay-5 {
            animation-delay: 0.4s;
        }

        @keyframes slideOut {
            to {
                opacity: 0;
                transform: translateX(60px);
                max-height: 0;
                padding: 0;
                margin: 0;
                overflow: hidden;
            }
        }

        .cart-item.removing {
            animation: slideOut 0.35s ease forwards;
        }

        /* Qty update flash */
        .flash-update {
            animation: flashBg 0.4s ease;
        }

        @keyframes flashBg {
            0% {
                background: rgba(189, 227, 249, 0.4);
            }

            100% {
                background: transparent;
            }
        }
    </style>
@endpush

@section('navbar')
    @include('layouts.partials.navbar-default')
@endsection

@section('content')
    <!-- ============================================
                 CART CONTENT
            ============================================= -->
    <div class="cart-wrapper">
        <div class="container">

            <!-- Cart Top Bar -->
            <div class="cart-top-bar animate-in">
                <button class="cart-back-btn" onclick="window.history.back()" aria-label="Go back" id="cart-back">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <h1>Your Cart</h1>
                <button class="cart-more-btn" aria-label="More options" id="cart-more">
                    <i class="fa-solid fa-ellipsis"></i>
                </button>
            </div>

            <!-- Cart Items -->
            <div id="cartItemsContainer">
                @forelse($cartItems as $id => $item)
                    <div class="cart-item animate-in delay-{{ $loop->iteration }}" id="cartItem-{{ $id }}" data-id="{{ $id }}"
                        data-price="{{ $item['price'] }}">
                        <!-- Product Image -->
                        <div class="cart-item-image">
                            <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}">
                        </div>

                        <!-- Product Info -->
                        <div class="cart-item-info">
                            <div class="cart-item-name">{{ $item['name'] }}</div>
                            <div class="cart-item-desc">{{ $item['description'] }}</div>
                            <div class="cart-item-bottom">
                                <div class="cart-item-price" id="itemPrice-{{ $id }}">
                                    ${{ number_format($item['price'], 2) }}
                                </div>
                                <!-- Quantity Controls -->
                                <div class="qty-controls">
                                    <button type="button" class="qty-btn qty-minus" data-id="{{ $id }}"
                                        aria-label="Decrease quantity" id="qty-minus-{{ $id }}">
                                        <i class="fa-solid fa-minus" style="font-size:0.7rem;"></i>
                                    </button>
                                    <span class="qty-value" id="qtyValue-{{ $id }}">{{ $item['quantity'] }}</span>
                                    <button type="button" class="qty-btn qty-plus" data-id="{{ $id }}"
                                        aria-label="Increase quantity" id="qty-plus-{{ $id }}">
                                        <i class="fa-solid fa-plus" style="font-size:0.7rem;"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Button -->
                        <button type="button" class="cart-item-delete btn-delete-item" data-id="{{ $id }}"
                            aria-label="Remove item" id="delete-{{ $id }}">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </div>
                @empty
                    <div class="empty-cart" id="emptyCartMsg">
                        <div class="empty-cart-icon">
                            <i class="fa-solid fa-bag-shopping"></i>
                        </div>
                        <h3>Your cart is empty</h3>
                        <p>Looks like you haven't added any items yet.</p>
                        <a href="/products" class="btn-shop-now" id="btn-shop-now">
                            Shop Now <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                @endforelse
            </div>

            @if(count($cartItems) > 0)
                <!-- Coupon Banner -->
                <div class="coupon-banner animate-in delay-3" id="couponBanner">
                    <div class="coupon-icon">
                        <i class="fa-solid fa-tag"></i>
                    </div>
                    <div class="coupon-info">
                        <div class="coupon-title">Eye Consultation Coupon</div>
                        <div class="coupon-desc">Add a doctor visit and get $10 off</div>
                    </div>
                    <button class="coupon-add-btn" id="btn-add-coupon">Add</button>
                </div>

                <!-- Order Summary -->
                <div class="order-summary-section animate-in delay-4">
                    <h2>Order Summary</h2>

                    <div class="summary-card">
                        <div class="summary-line">
                            <span class="label">Subtotal</span>
                            <span class="value" id="summarySubtotal">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="summary-line">
                            <span class="label">Shipping</span>
                            <span class="value free">Free</span>
                        </div>
                        <div class="summary-line">
                            <span class="label">Tax</span>
                            <span class="value" id="summaryTax">${{ number_format($tax, 2) }}</span>
                        </div>

                        <hr class="summary-divider">

                        <div class="summary-total">
                            <span class="label">Total Cost</span>
                            <span class="value" id="summaryTotal">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Promo Code -->
                <div class="promo-section animate-in delay-4">
                    <div class="promo-row">
                        <div class="promo-input-icon" style="flex:1;">
                            <i class="fa-solid fa-ticket"></i>
                            <input type="text" class="promo-input" placeholder="Promo code" id="promoCodeInput"
                                aria-label="Promo code">
                        </div>
                        <button class="btn-apply-promo" id="btn-apply-promo">Apply</button>
                    </div>
                </div>

                <!-- Checkout Button -->
                <div class="checkout-cta-section animate-in delay-5">
                    <a href="{{ route('checkout.index') }}" class="btn-proceed-checkout" id="btn-proceed-checkout">
                        Proceed to Checkout <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <p class="legal-text">
                        By proceeding, you agree to Basirah's <a href="#">Terms of Service</a> and <a href="#">Privacy
                            Policy</a>.
                    </p>
                </div>
            @endif

        </div>
    </div>
@endsection

@section('footer')

@endsection

@push('script')
    <script>
        $(document).ready(function () {

            // CSRF token for AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // ===========================
            // Quantity: INCREASE
            // ===========================
            $(document).on('click', '.qty-plus', function () {
                var id = $(this).data('id');
                var $qtyValue = $('#qtyValue-' + id);
                var currentQty = parseInt($qtyValue.text());
                var newQty = currentQty + 1;

                if (newQty > 99) return;

                // Optimistic UI update
                $qtyValue.text(newQty);
                updateItemDisplayPrice(id, newQty);

                // AJAX update
                $.ajax({
                    url: '/cart/' + id,
                    method: 'PATCH',
                    data: { quantity: newQty },
                    success: function (res) {
                        if (res.success) {
                            $('#summarySubtotal').text('$' + res.subtotal);
                            $('#summaryTax').text('$' + res.tax);
                            $('#summaryTotal').text('$' + res.total);
                            updateNavBadge('#navCartBadge', res.cartCount);
                            flashItem(id);
                        }
                    },
                    error: function () {
                        // Revert on error
                        $qtyValue.text(currentQty);
                        updateItemDisplayPrice(id, currentQty);
                    }
                });
            });

            // ===========================
            // Quantity: DECREASE
            // ===========================
            $(document).on('click', '.qty-minus', function () {
                var id = $(this).data('id');
                var $qtyValue = $('#qtyValue-' + id);
                var currentQty = parseInt($qtyValue.text());
                var newQty = currentQty - 1;

                if (newQty < 1) return;

                // Optimistic UI update
                $qtyValue.text(newQty);
                updateItemDisplayPrice(id, newQty);

                // AJAX update
                $.ajax({
                    url: '/cart/' + id,
                    method: 'PATCH',
                    data: { quantity: newQty },
                    success: function (res) {
                        if (res.success) {
                            $('#summarySubtotal').text('$' + res.subtotal);
                            $('#summaryTax').text('$' + res.tax);
                            $('#summaryTotal').text('$' + res.total);
                            updateNavBadge('#navCartBadge', res.cartCount);
                            flashItem(id);
                        }
                    },
                    error: function () {
                        // Revert on error
                        $qtyValue.text(currentQty);
                        updateItemDisplayPrice(id, currentQty);
                    }
                });
            });

            // ===========================
            // DELETE ITEM
            // ===========================
            $(document).on('click', '.btn-delete-item', function () {
                var id = $(this).data('id');
                var $item = $('#cartItem-' + id);

                // Animate out
                $item.addClass('removing');

                $.ajax({
                    url: '/cart/' + id,
                    method: 'DELETE',
                    success: function (res) {
                        if (res.success) {
                            setTimeout(function () {
                                $item.remove();

                                $('#summarySubtotal').text('$' + res.subtotal);
                                $('#summaryTax').text('$' + res.tax);
                                $('#summaryTotal').text('$' + res.total);
                                updateNavBadge('#navCartBadge', res.cartCount);

                                // Show empty cart if no items left
                                if (res.isEmpty) {
                                    $('#cartItemsContainer').html(
                                        '<div class="empty-cart animate-in" id="emptyCartMsg">' +
                                        '<div class="empty-cart-icon">' +
                                        '<i class="fa-solid fa-bag-shopping"></i>' +
                                        '</div>' +
                                        '<h3>Your cart is empty</h3>' +
                                        '<p>Looks like you haven\'t added any items yet.</p>' +
                                        '<a href="/products" class="btn-shop-now" id="btn-shop-now">' +
                                        'Shop Now <i class="fa-solid fa-arrow-right"></i>' +
                                        '</a>' +
                                        '</div>'
                                    );
                                    $('#couponBanner').fadeOut();
                                    $('.order-summary-section').fadeOut();
                                    $('.promo-section').fadeOut();
                                    $('.checkout-cta-section').fadeOut();
                                }
                            }, 350);
                        }
                    },
                    error: function () {
                        $item.removeClass('removing');
                    }
                });
            });

            // ===========================
            // Helper: update item price display (client-side)
            // ===========================
            function updateItemDisplayPrice(id, qty) {
                var price = parseFloat($('#cartItem-' + id).data('price'));
                // Optionally show per-unit or total — keeping per-unit as in the design
                // The server recalculates the summary
            }

            // ===========================
            // Helper: flash animation
            // ===========================
            function flashItem(id) {
                var $item = $('#cartItem-' + id);
                $item.addClass('flash-update');
                setTimeout(function () {
                    $item.removeClass('flash-update');
                }, 400);
            }

            // ===========================
            // Navbar scroll effect
            // ===========================
            $(window).on('scroll', function () {
                if ($(this).scrollTop() > 10) {
                    $('#mainNavbar').addClass('scrolled');
                } else {
                    $('#mainNavbar').removeClass('scrolled');
                }
            });

            // ===========================
            // Checkout: Ask about lenses
            // ===========================
            $(document).on('click', '#btn-proceed-checkout', function (e) {
                e.preventDefault();
                var checkoutUrl = $(this).attr('href');

                // Get the first cart item's product ID for the prescription flow
                var $firstItem = $('.cart-item').first();
                var firstProductId = $firstItem.length ? $firstItem.data('id') : null;

                Swal.fire({
                    icon: 'question',
                    title: 'Add Eyeglasses Lenses?',
                    html: 'Would you like to add <strong>prescription lenses</strong> to your frame?<br><small class="text-muted">You\'ll enter your prescription and choose lens options.</small>',
                    showCancelButton: true,
                    confirmButtonText: '<i class="fa-solid fa-eye"></i> Yes, customize lenses',
                    cancelButtonText: 'No, just the frame',
                    confirmButtonColor: '#1D3557',
                    cancelButtonColor: '#6c757d',
                    reverseButtons: true
                }).then(function (result) {
                    if (result.isConfirmed) {
                        // Go to prescription flow with from_cart flag and product_id
                        window.location.href = '{{ route("prescription.create") }}?from_cart=1&product_id=' + firstProductId;
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        // Proceed to checkout normally
                        window.location.href = checkoutUrl;
                    }
                });
            });
        });
    </script>
@endpush