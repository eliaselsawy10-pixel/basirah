@extends('layouts.app')
@section('title', 'Shop Eyewear — Basirah')
@section('description', 'Basirah — Find frames that fit your face shape. Premium prescription eyewear for men, women, and kids.')
@push('style')
    <style>
        :root {
            --primary: #1D3557;
            --primary-hover: #274b78;
            --accent: #BDE3F9;
            --accent-dark: #8DCFF0;
            --dark: #1a1a2e;
            --body-bg: #f4f6f9;
            --card-bg: #ffffff;
            --text-primary: #1a1a2e;
            --text-secondary: #555;
            --text-muted: #888;
            --border-light: #e4e8ec;
            --font-family: 'Inter', sans-serif;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 20px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 8px 30px rgba(0, 0, 0, 0.12);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

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
        }

        img {
            max-width: 100%;
            height: auto;
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
        .btn-nav-icon, .cart-icon {
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

        .btn-nav-icon:hover, .cart-icon:hover {
            color: #1D3557;
            background: #f0f4f8;
        }

        /* Badges */
        .btn-nav-icon .nav-badge, .cart-badge {
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

        /* ========== FACE SHAPE SELECTOR ========== */
        .face-shape-section {
            background: #fff;
            padding: 40px 0 36px;
            border-bottom: 1px solid var(--border-light);
        }

        .face-shape-section .section-title {
            padding: 10px;
            line-height: 1.5;
            text-align: center;
            font-size: 1.15rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--primary);
            margin-bottom: 6px;
        }

        .face-shape-section .section-title span {
            font-weight: 400;
        }

        .face-shape-section .section-sub {
            text-align: center;
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 28px;
        }

        .face-shape-section .section-sub b {
            color: var(--text-primary);
            font-weight: 600;
        }

        .face-shape-section .sort-area {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
            margin-bottom: 20px;
        }

        .face-shape-section .sort-area label {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .sort-select {
            border: 1px solid var(--border-light);
            border-radius: var(--radius-sm);
            padding: 7px 30px 7px 12px;
            font-size: 0.82rem;
            font-family: var(--font-family);
            font-weight: 500;
            color: var(--text-primary);
            background: #fff;
            cursor: pointer;
            appearance: auto;
        }

        .face-cards-row {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .face-card {
            text-align: center;
            cursor: pointer;
            padding: 18px 16px 14px;
            border-radius: var(--radius-lg);
            border: 2px solid transparent;
            transition: var(--transition);
            position: relative;
            width: 160px;
            background-color: #f5f5f5;

        }

        .face-card:hover {
            background: #f5faff;
            border-color: #d0e8f7;
        }

        .face-card.active {
            background: #eef6fd;
            border-color: var(--accent-dark);
            box-shadow: 0 4px 20px rgba(141, 207, 240, 0.35);
        }

        .face-card.active::after {
            content: '\f058';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            top: 8px;
            right: 8px;
            color: var(--primary);
            font-size: 1rem;
        }

        .face-img-wrapper {
            width: 82px;
            height: 82px;
            border-radius: 50%;
            margin: 0 auto 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            /* color:#94A3B8; */
            /* background-color: #94A3B8; */
        }

        .face-img-wrapper::before {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 50%;
            border: 2px dashed #c5d3de;
            transition: var(--transition);
        }

        .face-card.active .face-img-wrapper::before {
            border-color: var(--accent-dark);
            border-style: solid;
        }

        .face-img {
            width: 82px;
            height: 82px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
        }

        .face-title {
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 2px;
            color: var(--text-primary);
        }

        .face-card.active .face-title {
            color: var(--primary);
        }

        .face-desc {
            font-size: 0.66rem;
            color: var(--text-muted);
            line-height: 1.3;
            font-style: italic;
        }

        /* ========== SIDEBAR FILTERS ========== */
        .col-lg-3 {
            margin-top: 15px;
        }

        .filters-sidebar {
            border-radius: 0;
            padding: 0;
            position: sticky;
            top: 72px;
        }

        .filter-group {
            padding: 20px 0;
            border-bottom: 1px solid var(--border-light);
        }

        .filter-group:first-child {
            padding-top: 0;
        }

        .filter-group:last-child {
            border-bottom: none;
        }

        .filter-group h6 {
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-primary);
            margin-bottom: 14px;
        }

        /* Dual Range Slider */
        .price-range-display {
            display: flex;
            justify-content: space-between;
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-bottom: 4px;
        }

        .dual-range-wrapper {
            position: relative;
            height: 32px;
        }

        .dual-range-wrapper input[type="range"] {
            position: absolute;
            width: 100%;
            top: 8px;
            height: 4px;
            -webkit-appearance: none;
            appearance: none;
            background: transparent;
            pointer-events: none;
            z-index: 2;
        }

        .dual-range-wrapper input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 16px;
            height: 16px;
            background: var(--accent);
            border-radius: 50%;
            cursor: pointer;
            pointer-events: all;
            position: relative;
            top: 5px;
            z-index: 3;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
        }

        .range-track {
            position: absolute;
            top: 14px;
            left: 0;
            right: 0;
            height: 4px;
            background: #e0e0e0;
            border-radius: 4px;
            z-index: 1;
        }

        .range-track-fill {
            position: absolute;
            top: 14px;
            height: 4px;
            background: var(--accent);
            border-radius: 4px;
            z-index: 1;
        }

        /* Checkboxes */
        .filter-check {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
            cursor: pointer;
            font-size: 0.84rem;
            color: var(--text-secondary);
        }

        .filter-check input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--primary);
            cursor: pointer;
            flex-shrink: 0;
        }

        .filter-check:hover {
            color: var(--primary);
        }

        .brand-select {
            width: 100%;
            border: 1px solid var(--border-light);
            border-radius: var(--radius-sm);
            padding: 9px 12px;
            font-size: 0.84rem;
            font-family: var(--font-family);
            color: var(--text-secondary);
            background: #fff;
        }

        /* ========== PRODUCT CARDS ========== */
        .product-card {
            background: var(--card-bg);
            border-radius: var(--radius-md);
            overflow: hidden;
            border: 1px solid var(--border-light);
            transition: var(--transition);
            position: relative;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            box-shadow: 0 12px 36px rgba(29, 53, 87, 0.13);
            transform: translateY(-4px);
            border-color: #c5dced;
        }

        .product-card .heart-icon {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 32px;
            height: 32px;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid var(--border-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            z-index: 5;
            color: #bbb;
            font-size: 0.82rem;
        }

        .product-card .heart-icon:hover {
            background: #ffe0e6;
            color: #e74c3c;
            border-color: #ffb3c1;
        }

        .product-card .heart-icon.active {
            background: #ffe0e6;
            color: #e74c3c;
            border-color: #ffb3c1;
        }

        .product-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            padding: 3px 10px;
            border-radius: 4px;
            font-size: 0.62rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            z-index: 5;
        }

        .badge-bestseller {
            background: var(--primary);
            color: #fff;
        }

        .badge-new {
            background: #198754;
            color: #fff;
        }

        .product-img-wrapper {
            height: 190px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 18px;
            background: #f6f8fa;
        }

        .product-img-wrapper img {
            max-height: 140px;
            max-width: 100%;
            object-fit: contain;
            transition: var(--transition);
        }

        .product-card:hover .product-img-wrapper img {
            transform: scale(1.06);
        }

        .product-info {
            padding: 16px 18px 18px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .product-title-row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 4px;
            gap: 8px;
        }

        .product-info h5 {
            font-size: 0.9rem;
            font-weight: 700;
            margin: 0;
            color: var(--text-primary);
        }

        .product-info .price {
            font-size: 0.95rem;
            font-weight: 800;
            color: var(--text-primary);
            white-space: nowrap;
        }

        .product-info .product-desc {
            font-size: 0.72rem;
            color: var(--text-muted);
            margin-bottom: 12px;
            line-height: 1.4;
        }

        .color-swatches {
            display: flex;
            gap: 6px;
            margin-bottom: 14px;
        }

        .color-swatch {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 2px solid #ddd;
            cursor: pointer;
            transition: var(--transition);
        }

        .color-swatch:hover,
        .color-swatch.active {
            border-color: var(--primary);
            transform: scale(1.15);
        }

        .btn-action-group {
            display: flex;
            gap: 8px;
            margin-top: auto;
            width: 100%;
        }

        .btn-view-details {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            background: #fff;
            color: var(--primary);
            border: 1px solid var(--primary);
            border-radius: var(--radius-sm);
            transition: var(--transition);
            flex-shrink: 0;
        }

        .btn-view-details:hover {
            background: var(--primary);
            color: #fff;
            transform: translateY(-1px);
        }

        .btn-add-cart {
            background: var(--primary);
            color: #fff;
            font-weight: 600;
            font-size: 0.78rem;
            padding: 10px 0;
            border: none;
            border-radius: var(--radius-sm);
            transition: var(--transition);
            cursor: pointer;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .btn-add-cart:hover {
            background: var(--primary-hover);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(29, 53, 87, 0.3);
        }

        /* ========== PAGINATION ========== */
        .pagination-wrapper {
            padding: 32px 0;
            display: flex;
            justify-content: center;
        }

        .pagination .page-link {
            border: 1px solid var(--border-light);
            color: var(--text-secondary);
            font-size: 0.82rem;
            font-weight: 500;
            padding: 8px 14px;
            margin: 0 2px;
            border-radius: var(--radius-sm) !important;
            transition: var(--transition);
        }

        .pagination .page-link:hover {
            background: #eef5fb;
            color: var(--primary);
            border-color: var(--accent);
        }

        .pagination .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }

        /* ========== FOOTER ========== */
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
            background: #BDE3F9;
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
            background: #BDE3F9;
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
            color: var(--text-muted);
            font-size: 0.82rem;
            transition: var(--transition);
        }

        .footer-links a:hover {
            color: var(--primary-hover);
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
            font-size: 0.78rem;
            color: var(--text-muted);
        }

        .footer-bottom-links a:hover {
            color: var(--primary-dark);
        }

        /* ========== MOBILE FILTER TOGGLE ========== */
        .filter-toggle-btn {
            display: none;
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: var(--radius-sm);
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            margin-bottom: 16px;
            width: 100%;
        }

        .filter-toggle-btn i {
            margin-right: 6px;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 991.98px) {
            .filter-toggle-btn {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .filters-sidebar {
                display: none;
                position: relative;
                top: 0;
                margin-bottom: 20px;
                padding: 0 16px;
            }

            .filters-sidebar.show {
                display: block;
            }

            .face-card {
                width: 110px;
                padding: 14px 10px 10px;
            }

            .face-img-wrapper {
                width: 66px;
                height: 66px;
            }

            .face-img {
                width: 66px;
                height: 66px;
            }

            .face-img-wrapper::before {
                inset: -3px;
            }
        }

        @media (max-width: 767.98px) {
            .face-shape-section .section-title {
                font-size: 0.9rem;
                letter-spacing: 1px;
            }

            .face-cards-row {
                gap: 10px;
            }

            .face-card {
                width: 90px;
                padding: 10px 6px 8px;
            }

            .face-img-wrapper {
                width: 54px;
                height: 54px;
            }

            .face-img {
                width: 54px;
                height: 54px;
            }

            .face-title {
                font-size: 0.68rem;
            }

            .face-desc {
                font-size: 0.58rem;
            }

            .footer-bottom-links {
                justify-content: flex-start;
                flex-wrap: wrap;
                gap: 12px;
                margin-top: 10px;
            }
        }

        /* ========== ANIMATIONS ========== */
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
            animation: fadeInUp 0.5s ease forwards;
        }
    </style>
@endpush

@section('navbar')
    @include('layouts.partials.navbar-default')
@endsection

@section('content')
    <!-- ========== FACE SHAPE SELECTOR ========== -->
    <section class="face-shape-section" id="face-shapes">
        <div class="container">
            <h1 class="section-title">FIND FRAMES THAT <span>FIT YOUR FACE</span></h1>
            <p class="section-sub">Choose your <b>face shape</b> to see the best matches</p>

            <div class="row align-items-center mb-3">
                <div class="col">
                    <!-- spacer -->
                </div>
                <div class="col-auto">
                    <div class="d-flex align-items-center gap-2">
                        <label style="font-size:0.8rem;color:var(--text-muted);white-space:nowrap;">Sort by:</label>
                        <select class="sort-select" id="sort-select" form="filter-form" name="sort"
                            onchange="document.getElementById('filter-form').submit();">
                            <option value="popular" {{ ($filters['sort'] ?? '') == 'popular' ? 'selected' : '' }}>Most Popular
                            </option>
                            <option value="price_asc" {{ ($filters['sort'] ?? '') == 'price_asc' ? 'selected' : '' }}>Price:
                                Low to High</option>
                            <option value="price_desc" {{ ($filters['sort'] ?? '') == 'price_desc' ? 'selected' : '' }}>Price:
                                High to Low</option>
                            <option value="newest" {{ ($filters['sort'] ?? '') == 'newest' ? 'selected' : '' }}>Newest First
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="face-cards-row">
                @php $activeShape = $filters['face_shape'] ?? 'all'; @endphp
                <div class="face-card {{ $activeShape == 'oval' ? 'active' : '' }}" data-shape="oval" id="face-oval">
                    <div class="face-img-wrapper">
                        <img src="{{ asset('images/shape1.png') }}" alt="Oval face shape" class="face-img">
                    </div>
                    <div class="face-title">Oval</div>
                    <div class="face-desc">Balanced Proportions</div>
                </div>
                <div class="face-card {{ $activeShape == 'round' ? 'active' : '' }}" data-shape="round" id="face-round">
                    <div class="face-img-wrapper">
                        <img src="{{ asset('images/shape2.png') }}" alt="Round face shape" class="face-img">
                    </div>
                    <div class="face-title">Round</div>
                    <div class="face-desc">Soft & Curvy</div>
                </div>
                <div class="face-card {{ $activeShape == 'square' ? 'active' : '' }}" data-shape="square" id="face-square">
                    <div class="face-img-wrapper">
                        <img src="{{ asset('images/shape3.png') }}" alt="Square face shape" class="face-img">
                    </div>
                    <div class="face-title">Square</div>
                    <div class="face-desc">Strong Jawline</div>
                </div>
                <div class="face-card {{ $activeShape == 'triangle' ? 'active' : '' }}" data-shape="triangle"
                    id="face-triangle">
                    <div class="face-img-wrapper">
                        <img src="{{ asset('images/shape4.png') }}" alt="Triangle face shape" class="face-img">
                    </div>
                    <div class="face-title">Triangle</div>
                    <div class="face-desc">Wide Forehead</div>
                </div>
                <div class="face-card {{ $activeShape == 'heart' ? 'active' : '' }}" data-shape="heart" id="face-heart">
                    <div class="face-img-wrapper">
                        <img src="{{ asset('images/shape5.png') }}" alt="Heart face shape" class="face-img">
                    </div>
                    <div class="face-title">Heart</div>
                    <div class="face-desc">Narrow Chin</div>
                </div>
                <!-- Clears the face shape filter -->
                @if($activeShape !== 'all')
                    <div class="face-card mt-2" data-shape="all"
                        style="width: 100%; border:none; background:transparent; padding:0; height:auto; box-shadow:none; cursor:pointer;"
                        title="Clear Face Shape Filter">
                        <span style="font-size:0.8rem; color:var(--text-muted); text-decoration:underline;">Clear shape
                            filter</span>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- ========== MAIN CONTENT ========== -->
    <section class="py-4" id="products-section">
        <div class="container">
            <div class="row g-4">

                <!-- SIDEBAR FILTERS -->
                <div class="col-lg-3">
                    <button class="filter-toggle-btn" id="filter-toggle"><i class="fa-solid fa-sliders"></i> Show
                        Filters</button>
                    <form class="filters-sidebar" id="filter-form" action="{{ url()->current() }}" method="GET">
                        @if(isset($selectedCategory))
                            <input type="hidden" name="category" value="{{ $selectedCategory }}">
                        @endif
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        <input type="hidden" name="face_shape" id="face-shape-input"
                            value="{{ $filters['face_shape'] ?? 'all' }}">

                        <!-- Price Range -->
                        <div class="filter-group">
                            <h6>Price Range</h6>
                            <div class="price-range-display">
                                <span id="price-min-label">${{ $filters['min_price'] ?? 0 }}</span>
                                <span
                                    id="price-max-label">{{ isset($filters['max_price']) && $filters['max_price'] < 500 ? '$' . $filters['max_price'] : '$500+' }}</span>
                            </div>
                            <div class="dual-range-wrapper">
                                <div class="range-track"></div>
                                <div class="range-track-fill" id="range-fill"></div>
                                <input type="range" name="min_price" min="0" max="500"
                                    value="{{ $filters['min_price'] ?? 0 }}" id="price-range-min"
                                    onchange="this.form.submit()">
                                <input type="range" name="max_price" min="0" max="500"
                                    value="{{ $filters['max_price'] ?? 500 }}" id="price-range-max"
                                    onchange="this.form.submit()">
                            </div>
                        </div>
                        <!-- Quick Filters -->
                        <div class="filter-group">
                            <h6>Quick Filters</h6>
                            <label class="filter-check">
                                <input type="checkbox" name="best_sellers" value="1" id="chk-bestsellers"
                                    onchange="this.form.submit()" {{ isset($filters['best_sellers']) ? 'checked' : '' }}>
                                Best Sellers
                            </label>
                            <label class="filter-check">
                                <input type="checkbox" name="new_arrivals" value="1" id="chk-newarrivals"
                                    onchange="this.form.submit()" {{ isset($filters['new_arrivals']) ? 'checked' : '' }}>
                                New Arrivals
                            </label>
                        </div>
                        <!-- Frame Material -->
                        <div class="filter-group">
                            <h6>Frame Material</h6>
                            @php $selMaterials = $filters['material'] ?? []; @endphp
                            <label class="filter-check">
                                <input type="checkbox" name="material[]" value="Pure Titanium" onchange="this.form.submit()"
                                    {{ in_array('Pure Titanium', $selMaterials) ? 'checked' : '' }}> Pure Titanium
                            </label>
                            <label class="filter-check">
                                <input type="checkbox" name="material[]" value="Eco-Acetate" onchange="this.form.submit()"
                                    {{ in_array('Eco-Acetate', $selMaterials) ? 'checked' : '' }}> Eco-Acetate
                            </label>
                            <label class="filter-check">
                                <input type="checkbox" name="material[]" value="Lightweight Metal"
                                    onchange="this.form.submit()" {{ in_array('Lightweight Metal', $selMaterials) ? 'checked' : '' }}> Lightweight Metal
                            </label>
                        </div>
                        <!-- Brand -->
                        <div class="filter-group">
                            <h6>Brand</h6>
                            <select class="brand-select" id="brand-select" name="brand" onchange="this.form.submit()">
                                <option value="all">All Brands</option>
                                <option value="Ray-Ban" {{ ($filters['brand'] ?? '') == 'Ray-Ban' ? 'selected' : '' }}>Ray-Ban
                                </option>
                                <option value="Oakley" {{ ($filters['brand'] ?? '') == 'Oakley' ? 'selected' : '' }}>Oakley
                                </option>
                                <option value="Tom Ford" {{ ($filters['brand'] ?? '') == 'Tom Ford' ? 'selected' : '' }}>Tom
                                    Ford</option>
                                <option value="Gucci" {{ ($filters['brand'] ?? '') == 'Gucci' ? 'selected' : '' }}>Gucci
                                </option>
                            </select>
                        </div>
                    </form>
                </div>

                <!-- PRODUCT GRID -->
                <div class="col-lg-9">
                    @if(isset($selectedCategory))
                        <h4 class="mb-4" style="color: var(--primary); font-weight: 800;">Showing results for:
                            {{ $selectedCategory }}</h4>
                    @endif
                    @if(request('search'))
                        <h4 class="mb-4" style="color: var(--primary); font-weight: 800;">
                            <i class="fa-solid fa-magnifying-glass"></i> Search results for: "{{ request('search') }}"
                            <a href="{{ route('products.index') }}" style="font-size:0.8rem; color:var(--text-muted); margin-left:8px;" title="Clear search"><i class="fa-solid fa-xmark"></i> Clear</a>
                        </h4>
                    @endif
                    <div class="row g-3" id="product-grid">
                        @if($products->isEmpty())
                            <div class="col-12 text-center py-5">
                                <h5 class="text-muted">No products found</h5>
                            </div>
                        @else
                            @foreach($products as $product)
                                <div class="col-sm-6 col-xl-4">
                                    <div class="product-card" id="product-{{ $product->id }}">
                                        @php $isFav = isset(session('favorites', [])[$product->id]); @endphp
                                        <div class="heart-icon {{ $isFav ? 'active' : '' }}" id="heart-{{ $product->id }}"
                                            data-id="{{ $product->id }}">
                                            <i class="{{ $isFav ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                                        </div>
                                        <div class="product-img-wrapper">
                                            <!-- Fallback to a default image if none exists -->
                                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                                        </div>
                                        <div class="product-info">
                                            <div class="product-title-row">
                                                <h5>{{ $product->name }}</h5>
                                                <span class="price">${{ number_format($product->price, 2) }}</span>
                                            </div>
                                            <p class="product-desc">{{ $product->description }}</p>
                                            <div class="color-swatches">
                                                <span class="color-swatch active" style="background:#8B8B8B;"
                                                    title="Default Color"></span>
                                            </div>
                                            <div class="btn-action-group">
                                                <a href="{{ $product->is_contact_lens ? route('prescription.create', ['product_id' => $product->id]) : route('products.show', $product->id) }}" class="btn-view-details"
                                                    title="View Details">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                                <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form" style="width:100%;">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <button type="submit" class="btn-add-cart btn-primary" data-product="{{ $product->name }}"
                                                        data-price="{{ $product->price }}">
                                                        <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <!-- PAGINATION -->
                    <div class="pagination-wrapper">
                        {{ $products->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@push('script')
    <script>
        $(document).ready(function () {

            // ---- Navbar scroll effect ----
            $(window).on('scroll', function () {
                $('#mainNavbar').toggleClass('scrolled', $(this).scrollTop() > 50);
            });

            // ---- Face shape card click ----
            $('.face-card').on('click', function () {
                var shape = $(this).data('shape');
                $('#face-shape-input').val(shape);
                $('#filter-form').submit();
            });

            // ---- Heart / wishlist toggle ----
            $(document).on('click', '.heart-icon', function (e) {
                e.preventDefault();
                e.stopPropagation();
                var $btn = $(this);
                var $icon = $btn.find('i');
                var productId = $btn.data('id');

                if (!productId) return;

                if ($btn.hasClass('active')) {
                    // Remove from favorites
                    $.ajax({
                        url: '/favorites/' + productId,
                        type: 'DELETE',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function (res) {
                            if (res.success) {
                                $btn.removeClass('active');
                                $icon.removeClass('fa-solid').addClass('fa-regular');
                                updateNavBadge('#navFavBadge', res.count);
                            }
                        },
                        error: function (xhr) {
                            if (xhr.status === 401) {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Sign In Required',
                                    text: 'You must sign in to save your favorite products.',
                                    showCancelButton: true,
                                    confirmButtonText: 'Sign In',
                                    cancelButtonText: 'Cancel',
                                    confirmButtonColor: '#1D3557',
                                    footer: 'Don\'t have an account? <a href="{{ route('register') }}">Create an account</a>'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "{{ route('login') }}";
                                    }
                                });
                            }
                        }
                    });
                } else {
                    // Add to favorites
                    $.ajax({
                        url: '{{ route('favorites.store') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            product_id: productId
                        },
                        success: function (res) {
                            if (res.success) {
                                $btn.addClass('active');
                                $icon.removeClass('fa-regular').addClass('fa-solid');
                                updateNavBadge('#navFavBadge', res.count);
                            }
                        },
                        error: function (xhr) {
                            if (xhr.status === 401) {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Sign In Required',
                                    text: 'You must sign in to save your favorite products.',
                                    showCancelButton: true,
                                    confirmButtonText: 'Sign In',
                                    cancelButtonText: 'Cancel',
                                    confirmButtonColor: '#1D3557',
                                    footer: 'Don\'t have an account? <a href="{{ route('register') }}">Create an account</a>'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "{{ route('login') }}";
                                    }
                                });
                            }
                        }
                    });
                }
            });

            // ---- Product card hover effects ----
            $('.product-card').on('mouseenter', function () {
                $(this).css('box-shadow', '0 12px 40px rgba(29,53,87,0.15)');
                $(this).find('.btn-add-cart').css({ 'background': '#274b78', 'transform': 'scale(1.02)' });
            }).on('mouseleave', function () {
                $(this).css('box-shadow', '');
                $(this).find('.btn-add-cart').css({ 'background': '', 'transform': '' });
            });

            // ---- Add to cart AJAX submit ----
            $(document).on('submit', '.add-to-cart-form', function (e) {
                e.preventDefault(); // The "Refresh Killer"
                
                var $form = $(this);
                var $btn = $(this).find('button');
                var origHtml = $btn.html();

                // Show loading state
                $btn.prop('disabled', true)
                    .html('<i class="fas fa-spinner fa-spin"></i> Processing...')
                    .removeClass('btn-primary btn-success')
                    .css({ 'background': '#274b78', 'color': '#fff' });

                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: $form.serialize(),
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').length ? $('meta[name="csrf-token"]').attr('content') : '{{ csrf_token() }}' },
                    success: function (response) {
                        // Handle duplicate item in cart
                        if (response.already_in_cart) {
                            $btn.prop('disabled', false).html(origHtml).css({ 'background': '', 'color': '' });
                            Swal.fire({
                                icon: 'question',
                                title: 'Already in Cart',
                                text: 'This item is already in your cart (' + response.current_qty + ' piece). Would you like to add another piece?',
                                showCancelButton: true,
                                confirmButtonText: 'Yes, add another',
                                cancelButtonText: 'No, thanks',
                                confirmButtonColor: '#1D3557',
                                cancelButtonColor: '#6c757d'
                            }).then(function(result) {
                                if (result.isConfirmed) {
                                    $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Adding...').css({ 'background': '#274b78', 'color': '#fff' });
                                    $.ajax({
                                        url: $form.attr('action'),
                                        type: 'POST',
                                        data: $form.serialize() + '&force=1',
                                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').length ? $('meta[name="csrf-token"]').attr('content') : '{{ csrf_token() }}' },
                                        success: function(res) {
                                            if (res.success) {
                                                $btn.html('<i class="fa-solid fa-check"></i> Added!').css({ 'background': '#198754', 'color': '#fff' });
                                                updateNavBadge('#navCartBadge', res.cart_count || res.cartCount);
                                                Swal.fire({ toast: true, position: 'bottom-end', icon: 'success', title: res.message || 'Added to Cart!', showConfirmButton: false, timer: 3000, timerProgressBar: true });
                                            }
                                        },
                                        complete: function() {
                                            setTimeout(function() { $btn.prop('disabled', false).html(origHtml).removeClass('btn-success').addClass('btn-primary').css({ 'background': '', 'color': '' }); }, 2500);
                                        }
                                    });
                                }
                            });
                            return;
                        }

                        if (response.success) {
                            $btn.removeClass('btn-primary').addClass('btn-success')
                                .html('<i class="fa-solid fa-check"></i> Added!')
                                .css({ 'background': '#198754', 'color': '#fff' });
                            
                            // Update cart badge dynamically
                            updateNavBadge('#navCartBadge', response.cart_count || response.cartCount);

                            // SweetAlert2 Toast
                            Swal.fire({
                                toast: true,
                                position: 'bottom-end',
                                icon: 'success',
                                title: response.message || 'Added to Cart!',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });
                        }
                    },
                    error: function (xhr) {
                        $btn.html('<i class="fa-solid fa-xmark"></i> Error').css({ 'background': '#dc3545', 'color': '#fff' });
                        var errMsg = 'Failed to add to cart';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errMsg = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            toast: true,
                            position: 'bottom-end',
                            icon: 'error',
                            title: errMsg,
                            showConfirmButton: false,
                            timer: 3500,
                            timerProgressBar: true
                        });
                    },
                    complete: function () {
                        setTimeout(function () {
                            $btn.prop('disabled', false)
                                .html(origHtml)
                                .removeClass('btn-success')
                                .addClass('btn-primary')
                                .css({ 'background': '', 'color': '' });
                        }, 2500);
                    }
                });
            });

            // ---- Color swatch click ----
            $(document).on('click', '.color-swatch', function () {
                $(this).closest('.color-swatches').find('.color-swatch').removeClass('active');
                $(this).addClass('active');
            });

            // ---- Mobile filter toggle ----
            $('#filter-toggle').on('click', function () {
                var $sidebar = $('#filters-sidebar');
                $sidebar.toggleClass('show');
                $(this).html(
                    $sidebar.hasClass('show')
                        ? '<i class="fa-solid fa-xmark"></i> Hide Filters'
                        : '<i class="fa-solid fa-sliders"></i> Show Filters'
                );
            });

            // ---- Dual Price Range Slider ----
            var $minSlider = $('#price-range-min');
            var $maxSlider = $('#price-range-max');
            var $fill = $('#range-fill');
            var sliderMax = 500;

            function updateRangeFill() {
                var minVal = parseInt($minSlider.val());
                var maxVal = parseInt($maxSlider.val());
                // Prevent overlap
                if (minVal > maxVal) {
                    $minSlider.val(maxVal);
                    minVal = maxVal;
                }
                var leftPct = (minVal / sliderMax) * 100;
                var rightPct = (maxVal / sliderMax) * 100;
                $fill.css({ 'left': leftPct + '%', 'width': (rightPct - leftPct) + '%' });
                $('#price-min-label').text('$' + minVal);
                $('#price-max-label').text(maxVal >= 500 ? '$500+' : '$' + maxVal);
            }

            $minSlider.on('input', function () {
                if (parseInt($(this).val()) > parseInt($maxSlider.val())) {
                    $(this).val($maxSlider.val());
                }
                updateRangeFill();
            });
            $maxSlider.on('input', function () {
                if (parseInt($(this).val()) < parseInt($minSlider.val())) {
                    $(this).val($minSlider.val());
                }
                updateRangeFill();
            });
            updateRangeFill();



            // ---- Scroll reveal animation ----
            if ('IntersectionObserver' in window) {
                var observer = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            $(entry.target).addClass('animate-in');
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.1 });

                $('.product-card, .face-card').each(function () {
                    this.style.opacity = '0';
                    observer.observe(this);
                });
            }

        });
    </script>
@endpush