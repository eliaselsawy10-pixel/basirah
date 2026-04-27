@extends('layouts.app')
@section('title', 'My Favorites — Basirah')
@section('description', 'Basirah — Your favorites and wishlist. Save and revisit the eyewear you love.')
@push('style')
    <style>
        /* ========================================
                       DESIGN TOKENS  (Basirah Brand)
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
            --green-stock: #22c55e;
            --red-oos: #ef4444;
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
                       FAVORITES PAGE HEADER
                    ======================================== */
        .fav-wrapper {
            padding: 20px 0 80px;
            max-width: 720px;
            margin: 0 auto;
        }

        .fav-top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 0 24px;
            border-bottom: 1px solid var(--border-light);
            margin-bottom: 0;
        }

        .fav-back-btn {
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

        .fav-back-btn:hover {
            background: var(--section-bg);
        }

        .fav-top-bar h1 {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }

        .fav-count-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 28px;
            height: 24px;
            background: var(--section-bg);
            border-radius: var(--radius-xl);
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-muted);
            padding: 0 8px;
        }

        /* ========================================
                       FAVORITES ITEM ROW
                    ======================================== */
        .fav-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 24px 0;
            border-bottom: 1px solid var(--border-light);
            position: relative;
            transition: var(--transition);
        }

        .fav-item:hover {
            background: #fafbfd;
            margin: 0 -16px;
            padding: 24px 16px;
            border-radius: var(--radius-sm);
        }

        .fav-item-image {
            width: 80px;
            height: 80px;
            border-radius: var(--radius-md);
            background: #f0f2f5;
            overflow: hidden;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
        }

        .fav-item-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .fav-item-info {
            flex: 1;
            min-width: 0;
        }

        .fav-item-name {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 2px;
            line-height: 1.3;
        }

        .fav-item-category {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .fav-item-meta {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .fav-item-price {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        /* Stock Badge */
        .stock-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: var(--radius-xl);
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.02em;
        }

        .stock-badge.in-stock {
            background: rgba(34, 197, 94, 0.1);
            color: var(--green-stock);
        }

        .stock-badge.in-stock .stock-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--green-stock);
            animation: dotPulse 2s ease infinite;
        }

        .stock-badge.out-of-stock {
            background: rgba(239, 68, 68, 0.1);
            color: var(--red-oos);
        }

        .stock-badge.out-of-stock .stock-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--red-oos);
        }

        @keyframes dotPulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.4;
            }
        }

        /* ========================================
                       ACTION BUTTONS (right side)
                    ======================================== */
        .fav-item-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .btn-add-to-cart {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 18px;
            background: linear-gradient(135deg, #a8d8f0 0%, #87c8e8 50%, #6bbde0 100%);
            color: var(--text-primary);
            border: none;
            border-radius: var(--radius-sm);
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            white-space: nowrap;
            font-family: var(--font-family);
        }

        .btn-add-to-cart:hover {
            background: linear-gradient(135deg, #93cfe8 0%, #72bfe0 50%, #58b3d8 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(58, 175, 219, 0.3);
            color: var(--text-primary);
        }

        .btn-add-to-cart:active {
            transform: translateY(0);
        }

        .btn-add-to-cart.disabled {
            opacity: 0.45;
            pointer-events: none;
            cursor: not-allowed;
        }

        .btn-remove-fav {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 1.5px solid var(--border-light);
            background: transparent;
            color: #c4c7cc;
            font-size: 0.85rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            flex-shrink: 0;
        }

        .btn-remove-fav:hover {
            border-color: #e74c3c;
            color: #e74c3c;
            background: rgba(231, 76, 60, 0.05);
            transform: scale(1.08);
        }

        /* ========================================
                       EMPTY STATE
                    ======================================== */
        .empty-favorites {
            text-align: center;
            padding: 80px 20px;
        }

        .empty-fav-icon {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f0f2f5 0%, #e8eaed 100%);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            color: #c4c7cc;
            margin-bottom: 24px;
            position: relative;
        }

        .empty-fav-icon::after {
            content: '';
            position: absolute;
            inset: -6px;
            border-radius: 50%;
            border: 2px dashed var(--border-light);
            animation: spinDashed 20s linear infinite;
        }

        @keyframes spinDashed {
            to {
                transform: rotate(360deg);
            }
        }

        .empty-favorites h3 {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--text-primary);
        }

        .empty-favorites p {
            font-size: 0.88rem;
            color: var(--text-muted);
            margin-bottom: 28px;
            max-width: 320px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }

        .btn-start-shopping {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 32px;
            background: var(--text-primary);
            color: #fff;
            border-radius: var(--radius-sm);
            font-weight: 600;
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .btn-start-shopping:hover {
            background: #2d2d4a;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(26, 26, 46, 0.3);
        }

        /* ========================================
                       SUMMARY FOOTER BAR
                    ======================================== */
        .fav-summary-bar {
            background: var(--section-bg);
            border-radius: var(--radius-md);
            padding: 20px 24px;
            margin-top: 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }

        .fav-summary-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .fav-summary-icon {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: rgba(189, 227, 249, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: var(--accent-blue);
            flex-shrink: 0;
        }

        .fav-summary-text .fav-summary-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1px;
        }

        .fav-summary-text .fav-summary-desc {
            font-size: 0.76rem;
            color: var(--text-muted);
        }

        .btn-add-all-to-cart {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 11px 24px;
            background: var(--text-primary);
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            white-space: nowrap;
            font-family: var(--font-family);
        }

        .btn-add-all-to-cart:hover {
            background: #2d2d4a;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(26, 26, 46, 0.3);
        }

        /* ========================================
                       TOAST NOTIFICATION
                    ======================================== */
        .fav-toast {
            position: fixed;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%) translateY(80px);
            background: var(--text-primary);
            color: #fff;
            padding: 14px 28px;
            border-radius: var(--radius-xl);
            font-size: 0.85rem;
            font-weight: 500;
            box-shadow: var(--shadow-lg);
            pointer-events: none;
            opacity: 0;
            z-index: 9999;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            white-space: nowrap;
        }

        .fav-toast.show {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

        .fav-toast i {
            margin-right: 6px;
        }

        /* ========================================
                       RESPONSIVE
                    ======================================== */
        @media (max-width: 767.98px) {
            .fav-wrapper {
                padding: 12px 4px 60px;
            }

            .fav-item {
                flex-wrap: wrap;
                gap: 12px;
            }

            .fav-item-image {
                width: 64px;
                height: 64px;
            }

            .fav-item-info {
                flex: 1 1 calc(100% - 88px);
                min-width: 0;
            }

            .fav-item-actions {
                width: 100%;
                justify-content: flex-end;
                padding-top: 4px;
                border-top: 1px solid #f0f2f5;
                margin-top: 4px;
                padding-left: 76px;
            }

            .btn-add-to-cart {
                flex: 1;
                justify-content: center;
            }

            .navbar-basirah .navbar-collapse {
                background: #fff;
                border-radius: var(--radius-md);
                padding: 16px;
                margin-top: 8px;
                box-shadow: var(--shadow-md);
            }

            .fav-summary-bar {
                flex-direction: column;
                text-align: center;
            }

            .fav-summary-left {
                flex-direction: column;
            }
        }

        @media (max-width: 575.98px) {
            .fav-item-actions {
                padding-left: 0;
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
            animation-delay: 0.40s;
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

        .fav-item.removing {
            animation: slideOut 0.35s ease forwards;
        }

        /* Cart-added flash */
        .flash-added {
            animation: flashGreen 0.5s ease;
        }

        @keyframes flashGreen {
            0% {
                background: rgba(34, 197, 94, 0.12);
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
                     FAVORITES CONTENT
                ============================================= -->
    <div class="fav-wrapper">
        <div class="container">

            <!-- Favorites Top Bar -->
            <div class="fav-top-bar animate-in">
                <button class="fav-back-btn" onclick="window.history.back()" aria-label="Go back" id="fav-back">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <h1>My Favorites <span class="fav-count-badge" id="favCountBadge">{{ count($favorites) }}</span></h1>
                <div style="width:36px;"></div> {{-- spacer for centering --}}
            </div>

            <!-- Favorites Items -->
            <div id="favItemsContainer">
                @forelse($favorites as $id => $item)
                    <div class="fav-item animate-in delay-{{ $loop->iteration }}" id="favItem-{{ $id }}" data-id="{{ $id }}">
                        <!-- Product Image -->
                        <div class="fav-item-image">
                            <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}">
                        </div>

                        <!-- Product Info -->
                        <div class="fav-item-info">
                            <div class="fav-item-name">{{ $item['name'] }}</div>
                            <div class="fav-item-category">{{ $item['category'] }}</div>
                            <div class="fav-item-meta">
                                <span class="fav-item-price">${{ number_format($item['price'], 2) }}</span>
                                @if($item['inStock'])
                                    <span class="stock-badge in-stock">
                                        <span class="stock-dot"></span> In Stock
                                    </span>
                                @else
                                    <span class="stock-badge out-of-stock">
                                        <span class="stock-dot"></span> Out of Stock
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="fav-item-actions">
                            <button type="button" class="btn-add-to-cart {{ !$item['inStock'] ? 'disabled' : '' }}"
                                data-id="{{ $id }}" id="addToCart-{{ $id }}" {{ !$item['inStock'] ? 'disabled' : '' }}
                                aria-label="Add to Cart">
                                <i class="fa-solid fa-cart-plus"></i>
                                <span>{{ $item['inStock'] ? 'Add to Cart' : 'Unavailable' }}</span>
                            </button>
                            <button type="button" class="btn-remove-fav" data-id="{{ $id }}" id="removeFav-{{ $id }}"
                                aria-label="Remove from favorites">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="empty-favorites animate-in" id="emptyFavMsg">
                        <div class="empty-fav-icon">
                            <i class="fa-regular fa-heart"></i>
                        </div>
                        <h3>Your wishlist is empty</h3>
                        <p>Tap the heart icon on any product to save it here for later.</p>
                        <a href="/products" class="btn-start-shopping" id="btn-start-shopping">
                            Start Shopping <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                @endforelse
            </div>

            @if(count($favorites) > 0)
                <!-- Summary / Add All Banner -->
                <div class="fav-summary-bar animate-in delay-4" id="favSummaryBar">
                    <div class="fav-summary-left">
                        <div class="fav-summary-icon">
                            <i class="fa-solid fa-heart"></i>
                        </div>
                        <div class="fav-summary-text">
                            <div class="fav-summary-title" id="favSummaryTitle">{{ count($favorites) }}
                                {{ count($favorites) === 1 ? 'item' : 'items' }} saved
                            </div>
                            <div class="fav-summary-desc">Ready when you are — add them all at once</div>
                        </div>
                    </div>
                    <button class="btn-add-all-to-cart" id="btn-add-all-to-cart">
                        <i class="fa-solid fa-cart-plus"></i>
                        Add All to Cart
                    </button>
                </div>
            @endif

        </div>
    </div>

    <!-- Toast -->
    <div class="fav-toast" id="favToast"></div>
@endsection

@section('footer')

@endsection

@push('script')
    <script>
        $(document).ready(function () {

            // CSRF for AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // ===========================
            // REMOVE from Favorites
            // ===========================
            $(document).on('click', '.btn-remove-fav', function () {
                var id = $(this).data('id');
                var $item = $('#favItem-' + id);

                $item.addClass('removing');

                $.ajax({
                    url: '/favorites/' + id,
                    method: 'DELETE',
                    success: function (res) {
                        if (res.success) {
                            setTimeout(function () {
                                $item.remove();
                                updateCount(res.count);

                                if (res.isEmpty) {
                                    showEmptyState();
                                }

                                showToast('<i class="fa-solid fa-check"></i> Removed from favorites');
                            }, 350);
                        }
                    },
                    error: function () {
                        $item.removeClass('removing');
                    }
                });
            });

            // ===========================
            // ADD TO CART (single item)
            // ===========================
            $(document).on('click', '.btn-add-to-cart:not(.disabled)', function () {
                var $btn = $(this);
                var id = $btn.data('id');
                var originalHtml = $btn.html();

                // Visual feedback
                $btn.html('<i class="fa-solid fa-spinner fa-spin"></i> Adding…');
                $btn.prop('disabled', true);

                // Simulate adding to cart (replace with real AJAX in production)
                setTimeout(function () {
                    $btn.html('<i class="fa-solid fa-check"></i> Added!');
                    $btn.css('background', 'linear-gradient(135deg, #86efac 0%, #4ade80 100%)');

                    $('#favItem-' + id).addClass('flash-added');
                    setTimeout(function () {
                        $('#favItem-' + id).removeClass('flash-added');
                    }, 500);

                    showToast('<i class="fa-solid fa-cart-plus"></i> Added to cart');

                    setTimeout(function () {
                        $btn.html(originalHtml);
                        $btn.css('background', '');
                        $btn.prop('disabled', false);
                    }, 1800);

                }, 600);
            });

            // ===========================
            // ADD ALL TO CART
            // ===========================
            $('#btn-add-all-to-cart').on('click', function () {
                var $btn = $(this);
                var originalHtml = $btn.html();

                $btn.html('<i class="fa-solid fa-spinner fa-spin"></i> Adding…');
                $btn.prop('disabled', true);

                // Simulate batch add
                setTimeout(function () {
                    $btn.html('<i class="fa-solid fa-check"></i> All Added!');

                    // Flash all items
                    $('.fav-item').addClass('flash-added');
                    setTimeout(function () {
                        $('.fav-item').removeClass('flash-added');
                    }, 500);

                    showToast('<i class="fa-solid fa-cart-plus"></i> All items added to cart');

                    setTimeout(function () {
                        $btn.html(originalHtml);
                        $btn.prop('disabled', false);
                    }, 2000);
                }, 800);
            });

            // ===========================
            // Helpers
            // ===========================
            function updateCount(count) {
                $('#favCountBadge').text(count);
                updateNavBadge('#navFavBadge', count);
                var itemWord = count === 1 ? 'item' : 'items';
                $('#favSummaryTitle').text(count + ' ' + itemWord + ' saved');
            }

            function showEmptyState() {
                $('#favItemsContainer').html(
                    '<div class="empty-favorites animate-in" id="emptyFavMsg">' +
                    '<div class="empty-fav-icon">' +
                    '<i class="fa-regular fa-heart"></i>' +
                    '</div>' +
                    '<h3>Your wishlist is empty</h3>' +
                    '<p>Tap the heart icon on any product to save it here for later.</p>' +
                    '<a href="/products" class="btn-start-shopping" id="btn-start-shopping">' +
                    'Start Shopping <i class="fa-solid fa-arrow-right"></i>' +
                    '</a>' +
                    '</div>'
                );
                $('#favSummaryBar').fadeOut(300);
            }

            var toastTimer;
            function showToast(html) {
                var $toast = $('#favToast');
                clearTimeout(toastTimer);
                $toast.html(html).addClass('show');
                toastTimer = setTimeout(function () {
                    $toast.removeClass('show');
                }, 2500);
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
        });
    </script>
@endpush