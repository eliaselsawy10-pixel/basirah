@extends('layouts.app')
@section('title', 'Contact Lenses — Basirah Wholesale')
@section('description_content', 'Basirah — Wholesale Premium Contact Lenses. Shop Bella, Desio, Anesthesia and more at exclusive wholesale rates.')
@push('style')
    <style>
        :root {
            --primary: #1D3557;
            --primary-hover: #274b78;
            --blue: #007BFF;
            --blue-hover: #0069d9;
            --accent: #BDE3F9;
            --accent-dark: #8DCFF0;
            --dark: #1a1a2e;
            --body-bg: #f4f6f9;
            --card-bg: #fff;
            --text-primary: #1a1a2e;
            --text-secondary: #555;
            --text-muted: #888;
            --border-light: #e4e8ec;
            --star-color: #f5a623;
            --font: 'Inter', sans-serif;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, .06);
            --shadow-md: 0 4px 20px rgba(0, 0, 0, .08);
            --shadow-lg: 0 8px 30px rgba(0, 0, 0, .12);
            --r-sm: 8px;
            --r-md: 12px;
            --r-lg: 16px;
            --tr: all .3s cubic-bezier(.4, 0, .2, 1)
        }

        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box
        }

        html {
            scroll-behavior: smooth
        }

        body {
            font-family: var(--font);
            color: var(--text-primary);
            background: var(--body-bg);
            line-height: 1.6;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased
        }

        img {
            max-width: 100%;
            height: auto
        }

        a {
            text-decoration: none;
            transition: var(--tr)
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

        /* HERO */
        .hero {
            background: #0d1117;
            position: relative;
            overflow: hidden;
            min-height: 280px;
            display: flex;
            align-items: center
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            background: url('https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=1400&h=500&fit=crop') center/cover no-repeat;
            opacity: .45
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(10, 15, 20, .88) 0%, rgba(10, 15, 20, .55) 60%, transparent 100%)
        }

        .hero-content {
            position: relative;
            z-index: 2;
            padding: 50px 0;
            max-width: 520px
        }

        .hero-badge {
            display: inline-block;
            background: rgba(0, 123, 255, .18);
            color: var(--blue);
            font-size: .68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 5px 14px;
            border-radius: 20px;
            margin-bottom: 16px
        }

        .hero h1 {
            font-size: 2.1rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.15;
            margin-bottom: 14px;
            letter-spacing: -.5px
        }

        .hero p {
            font-size: .88rem;
            color: rgba(255, 255, 255, .65);
            line-height: 1.7;
            max-width: 420px
        }

        /* FILTERS SIDEBAR */
        .filters-col {
            position: sticky;
            top: 72px
        }

        .filter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px
        }

        .filter-header h5 {
            font-size: 1rem;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px
        }

        .filter-header a {
            font-size: .78rem;
            color: var(--blue);
            font-weight: 500
        }

        .filter-header a:hover {
            text-decoration: underline
        }

        .f-group {
            margin-bottom: 24px
        }

        .f-group h6 {
            font-size: .72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-primary);
            margin-bottom: 12px
        }

        .f-check {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 9px;
            cursor: pointer;
            font-size: .84rem;
            color: var(--text-secondary)
        }

        .f-check input[type="checkbox"],
        .f-check input[type="radio"] {
            width: 16px;
            height: 16px;
            accent-color: var(--blue);
            cursor: pointer;
            flex-shrink: 0
        }

        .f-check:hover {
            color: var(--primary)
        }

        .color-circles {
            display: flex;
            gap: 10px;
            flex-wrap: wrap
        }

        .color-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 2.5px solid #ddd;
            cursor: pointer;
            transition: var(--tr)
        }

        .color-circle:hover {
            transform: scale(1.12)
        }

        .color-circle.active {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(0, 123, 255, .2)
        }

        .price-inputs {
            display: flex;
            align-items: center;
            gap: 8px
        }

        .price-inputs input {
            width: 100%;
            border: 1px solid var(--border-light);
            border-radius: var(--r-sm);
            padding: 8px 10px;
            font-size: .82rem;
            font-family: var(--font);
            color: var(--text-primary)
        }

        .price-inputs input:focus {
            outline: none;
            border-color: var(--accent-dark)
        }

        .price-inputs span {
            color: var(--text-muted);
            font-size: .8rem
        }

        .tier-box {
            background: #eef7fd;
            border-radius: var(--r-md);
            padding: 16px 18px;
            margin-top: 6px
        }

        .tier-box h6 {
            font-size: .72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--blue);
            margin-bottom: 6px
        }

        .tier-box p {
            font-size: .78rem;
            color: var(--text-secondary);
            margin: 0;
            line-height: 1.5
        }

        .tier-box b {
            font-weight: 700;
            color: var(--primary)
        }

        /* PRODUCT LISTING HEADER */
        .listing-header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 6px;
            flex-wrap: wrap;
            gap: 10px
        }

        .listing-header h4 {
            font-size: 1.25rem;
            font-weight: 800;
            margin: 0
        }

        .listing-header h4 span {
            font-weight: 400;
            color: var(--text-muted);
            font-size: .95rem
        }

        .listing-sub {
            font-size: .8rem;
            color: var(--text-muted);
            margin-bottom: 20px
        }

        .sort-wrap {
            display: flex;
            align-items: center;
            gap: 8px
        }

        .sort-wrap label {
            font-size: .8rem;
            color: var(--text-muted);
            white-space: nowrap
        }

        .sort-sel {
            border: 1px solid var(--border-light);
            border-radius: var(--r-sm);
            padding: 7px 28px 7px 12px;
            font-size: .82rem;
            font-family: var(--font);
            font-weight: 500;
            color: var(--text-primary);
            background: #fff;
            cursor: pointer;
            appearance: auto
        }

        /* PRODUCT CARD */
        .p-card {
            background: var(--card-bg);
            border-radius: var(--r-md);
            overflow: hidden;
            border: 1px solid var(--border-light);
            transition: var(--tr);
            position: relative;
            height: 100%;
            display: flex;
            flex-direction: column
        }

        .p-card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-4px);
            border-color: #c5dced
        }

        .p-card-img {
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: #f6f8fa;
            position: relative
        }

        .p-card-img img {
            max-height: 155px;
            object-fit: contain;
            transition: var(--tr)
        }

        .p-card:hover .p-card-img img {
            transform: scale(1.05)
        }

        .eye-preview {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 2px solid #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .15);
            object-fit: cover
        }

        .p-badge {
            position: absolute;
            bottom: 12px;
            left: 12px;
            padding: 3px 10px;
            border-radius: 4px;
            font-size: .6rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            z-index: 2
        }

        .p-badge-type {
            background: #e8f4fd;
            color: var(--blue)
        }

        .p-badge-new {
            background: #198754;
            color: #fff;
            bottom: 12px;
            left: auto;
            right: 12px
        }

        .p-top-new {
            position: absolute;
            top: 12px;
            left: 12px;
            background: #198754;
            color: #fff;
            padding: 3px 10px;
            border-radius: 4px;
            font-size: .6rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            z-index: 2
        }

        .p-info {
            padding: 14px 16px 16px;
            flex: 1;
            display: flex;
            flex-direction: column
        }

        .p-brand {
            font-size: .62rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: var(--blue);
            margin-bottom: 2px
        }

        .p-name-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 4px
        }

        .p-info h5 {
            font-size: .9rem;
            font-weight: 700;
            margin: 0;
            color: var(--text-primary)
        }

        .p-heart {
            background: none;
            border: none;
            color: #ccc;
            font-size: .9rem;
            cursor: pointer;
            transition: var(--tr);
            padding: 0
        }

        .p-heart:hover,
        .p-heart.active {
            color: #e74c3c
        }

        .p-stars {
            display: flex;
            align-items: center;
            gap: 2px;
            margin-bottom: 8px
        }

        .p-stars i {
            color: var(--star-color);
            font-size: .68rem
        }

        .p-stars span {
            font-size: .68rem;
            color: var(--text-muted);
            margin-left: 4px
        }

        .p-wholesale {
            font-size: .68rem;
            color: var(--text-muted);
            margin-bottom: 2px
        }

        .p-price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto
        }

        .p-price {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--text-primary)
        }

        .p-price small {
            font-weight: 400;
            font-size: .72rem;
            color: var(--text-muted)
        }

        .btn-quick {
            width: 36px;
            height: 36px;
            border-radius: var(--r-sm);
            background: var(--blue);
            color: #fff;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .85rem;
            cursor: pointer;
            transition: var(--tr);
            flex-shrink: 0
        }

        .btn-quick:hover {
            background: var(--blue-hover);
            transform: scale(1.08)
        }

        /* PAGINATION */
        .pag-wrap {
            padding: 32px 0;
            display: flex;
            justify-content: center
        }

        .pagination .page-link {
            border: 1px solid var(--border-light);
            color: var(--text-secondary);
            font-size: .82rem;
            font-weight: 500;
            padding: 8px 14px;
            margin: 0 2px;
            border-radius: var(--r-sm) !important;
            transition: var(--tr)
        }

        .pagination .page-link:hover {
            background: #eef5fb;
            color: var(--primary);
            border-color: var(--accent)
        }

        .pagination .page-item.active .page-link {
            background: var(--blue);
            border-color: var(--blue);
            color: #fff
        }

        /* FOOTER */
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
            transition: 0.3s;
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
            transition: 0.3s;
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

        /* MOBILE FILTER */
        .mob-filter-btn {
            display: none;
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: var(--r-sm);
            font-size: .85rem;
            font-weight: 600;
            cursor: pointer;
            margin-bottom: 16px;
            width: 100%
        }

        .mob-filter-btn i {
            margin-right: 6px
        }

        @media(max-width:991.98px) {
            .mob-filter-btn {
                display: flex;
                align-items: center;
                justify-content: center
            }

            .filters-col .filter-inner {
                display: none
            }

            .filters-col .filter-inner.show {
                display: block
            }

            .hero h1 {
                font-size: 1.6rem
            }
        }

        @media(max-width:767.98px) {
            .hero h1 {
                font-size: 1.3rem
            }

            .hero-content {
                padding: 30px 0
            }

            .f-bottom-links {
                justify-content: flex-start;
                flex-wrap: wrap;
                gap: 12px;
                margin-top: 10px
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        .animate-in {
            animation: fadeInUp .5s ease forwards
        }
    </style>
@endpush


@section('content')
    <!-- HERO BANNER -->
    <section class="hero" id="hero-banner">
        <div class="hero-bg"></div>
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content">
                <span class="hero-badge">NEW SEASON COLLECTION</span>
                <h1>Discover the Spectrum: Premium Contact Lenses</h1>
                <p>Exclusive wholesale rates on the world's most sought-after brands including Bella, Desio, and Anesthesia.
                </p>
            </div>
        </div>
    </section>

    <!-- MAIN CONTENT -->
    <section class="py-4" id="products-section">
        <div class="container">
            <div class="row g-4">
                <!-- SIDEBAR FILTERS -->
                <div class="col-lg-3">
                    <div class="filters-col">
                        <button class="mob-filter-btn" id="filter-toggle"><i class="fa-solid fa-sliders"></i>Show
                            Filters</button>
                        <form class="filter-inner show" id="filter-form" action="{{ route('products.color-lenses') }}"
                            method="GET">
                            <div class="filter-header">
                                <h5><i class="fa-solid fa-sliders" style="font-size:.85rem"></i> Filters</h5><a
                                    href="{{ route('products.color-lenses') }}" id="clear-all">Clear All</a>
                            </div>

                            <input type="hidden" name="color_family" id="color-family-input"
                                value="{{ $filters['color_family'] ?? '' }}">

                            <!-- Brands -->
                            <div class="f-group">
                                <h6>Brands</h6>
                                @php $selBrands = $filters['brand'] ?? []; @endphp
                                <label class="f-check"><input type="checkbox" name="brand[]" value="Bella"
                                        onchange="this.form.submit()" {{ in_array('Bella', $selBrands) ? 'checked' : '' }}>
                                    Bella</label>
                                <label class="f-check"><input type="checkbox" name="brand[]" value="Anesthesia"
                                        onchange="this.form.submit()" {{ in_array('Anesthesia', $selBrands) ? 'checked' : '' }}> Anesthesia</label>
                                <label class="f-check"><input type="checkbox" name="brand[]" value="Desio"
                                        onchange="this.form.submit()" {{ in_array('Desio', $selBrands) ? 'checked' : '' }}>
                                    Desio</label>
                                <label class="f-check"><input type="checkbox" name="brand[]" value="Solotica"
                                        onchange="this.form.submit()" {{ in_array('Solotica', $selBrands) ? 'checked' : '' }}> Solotica</label>
                                <label class="f-check"><input type="checkbox" name="brand[]" value="FreshLook"
                                        onchange="this.form.submit()" {{ in_array('FreshLook', $selBrands) ? 'checked' : '' }}> FreshLook</label>
                            </div>
                            <!-- Color Family -->
                            <div class="f-group">
                                <h6>Color Family</h6>
                                <div class="color-circles" id="color-family">
                                    @php $activeColor = $filters['color_family'] ?? ''; @endphp
                                    <span class="color-circle {{ $activeColor == 'Light Blue' ? 'active' : '' }}"
                                        style="background:#7ec8e3" data-color="Light Blue" title="Light Blue"></span>
                                    <span class="color-circle {{ $activeColor == 'Grey' ? 'active' : '' }}"
                                        style="background:#8a9bae" data-color="Grey" title="Grey"></span>
                                    <span class="color-circle {{ $activeColor == 'Brown' ? 'active' : '' }}"
                                        style="background:#8B6914" data-color="Brown" title="Brown"></span>
                                    <span class="color-circle {{ $activeColor == 'Amber' ? 'active' : '' }}"
                                        style="background:#d4a030" data-color="Amber" title="Amber"></span>
                                    <span class="color-circle {{ $activeColor == 'Violet' ? 'active' : '' }}"
                                        style="background:#9b59b6" data-color="Violet" title="Violet"></span>
                                </div>
                            </div>
                            <!-- Replacement -->
                            <div class="f-group">
                                <h6>Replacement</h6>
                                @php $repl = $filters['replacement'] ?? ''; @endphp
                                <label class="f-check"><input type="radio" name="replacement" value="Daily"
                                        onchange="this.form.submit()" {{ $repl == 'Daily' ? 'checked' : '' }}> Daily
                                    Disposable</label>
                                <label class="f-check"><input type="radio" name="replacement" value="Monthly"
                                        onchange="this.form.submit()" {{ $repl == 'Monthly' ? 'checked' : '' }}>
                                    Monthly</label>
                                <label class="f-check"><input type="radio" name="replacement" value="Yearly"
                                        onchange="this.form.submit()" {{ $repl == 'Yearly' ? 'checked' : '' }}> Yearly</label>
                            </div>
                            <!-- Wholesale Price -->
                            <div class="f-group">
                                <h6>Wholesale Price</h6>
                                <div class="price-inputs">
                                    <input type="number" name="min_price" placeholder="0"
                                        value="{{ $filters['min_price'] ?? '' }}" id="price-min"
                                        onchange="this.form.submit()">
                                    <span>-</span>
                                    <input type="number" name="max_price" placeholder="500"
                                        value="{{ $filters['max_price'] ?? '' }}" id="price-max"
                                        onchange="this.form.submit()">
                                </div>
                            </div>
                            <!-- Wholesale Tier -->
                            <div class="f-group">
                                <div class="tier-box" id="tier-box">
                                    <h6>Wholesale Tier</h6>
                                    <p>Order <b>50+ boxes</b> to unlock <b>15% extra discount.</b></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- PRODUCT GRID -->
                <div class="col-lg-9">
                    <div class="listing-header">
                        <h4>Contact Lenses <span>({{ $products->total() }} items)</span></h4>
                        <div class="sort-wrap">
                            <label>Sort By</label>
                            <select class="sort-sel" id="sort-select" form="filter-form" name="sort"
                                onchange="document.getElementById('filter-form').submit();">
                                <option value="popular" {{ ($filters['sort'] ?? '') == 'popular' ? 'selected' : '' }}>Most
                                    Popular</option>
                                <option value="price_asc" {{ ($filters['sort'] ?? '') == 'price_asc' ? 'selected' : '' }}>
                                    Price: Low to High</option>
                                <option value="price_desc" {{ ($filters['sort'] ?? '') == 'price_desc' ? 'selected' : '' }}>
                                    Price: High to Low</option>
                                <option value="newest" {{ ($filters['sort'] ?? '') == 'newest' ? 'selected' : '' }}>Newest
                                </option>
                            </select>
                        </div>
                    </div>
                    <p class="listing-sub">Showing top wholesale picks for Optical Retailers</p>

                    <div class="row g-3" id="product-grid">
                        @if($products->isEmpty())
                            <div class="col-12 text-center py-5">
                                <h5 class="text-muted">No contact lenses found</h5>
                            </div>
                        @else
                            @foreach($products as $product)
                                <div class="col-sm-6 col-xl-4">
                                    <div class="p-card" id="product-{{ $product->id }}">
                                        <div class="p-card-img">
                                            @if($product->is_new_arrival)
                                                <span class="p-top-new">NEW</span>
                                            @endif
                                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                                            @if($product->replacement)
                                                <span class="p-badge p-badge-type">{{ $product->replacement }}</span>
                                            @endif
                                        </div>
                                        <div class="p-info">
                                            <div class="p-brand">{{ $product->brand ?? 'BASIRAH' }}</div>
                                            <div class="p-name-row">
                                                <h5><a href="{{ $product->is_contact_lens ? route('prescription.create', ['product_id' => $product->id]) : route('products.show', $product->id) }}"
                                                        style="color:var(--text-primary);">{{ $product->name }}</a></h5>
                                                @php $isFav = isset(session('favorites', [])[$product->id]); @endphp
                                                <button class="p-heart {{ $isFav ? 'active' : '' }}" data-id="{{ $product->id }}"
                                                    aria-label="Favorite">
                                                    <i class="{{ $isFav ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                                                </button>
                                            </div>
                                            <div class="p-stars">
                                                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                    class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                    class="fa-solid fa-star-half-stroke"></i>
                                                <span>(0)</span>
                                            </div>
                                            <div class="p-wholesale">Wholesale Price</div>
                                            <div class="p-price-row">
                                                <div class="p-price">${{ number_format($product->price, 2) }} <small>/ box</small></div>
                                                <a href="{{ route('prescription.create', ['product_id' => $product->id]) }}" class="btn-quick" title="Enter Prescription" style="text-decoration:none;">
                                                    <i class="fa-solid fa-file-medical"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <!-- PAGINATION -->
                    <div class="pag-wrap">
                        {{ $products->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $(document).ready(function () {
            // Navbar scroll
            $(window).on('scroll', function () { $('#mainNavbar').toggleClass('scrolled', $(this).scrollTop() > 50) });

            // Color Family circle toggle
            $('#color-family').on('click', '.color-circle', function () {
                // Get the color
                var color = $(this).data('color');
                // If already active, deselect
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                    $('#color-family-input').val('');
                } else {
                    $('.color-circle').removeClass('active');
                    $(this).addClass('active');
                    $('#color-family-input').val(color);
                }
                $('#filter-form').submit();
            });

            // Heart toggle
            $(document).on('click', '.p-heart', function (e) {
                e.preventDefault();
                var $btn = $(this);
                var $i = $btn.find('i');
                var productId = $btn.data('id');

                if (!productId) return;

                if ($btn.hasClass('active')) {
                    $.ajax({
                        url: '/favorites/' + productId,
                        type: 'DELETE',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function (res) {
                            if (res.success) {
                                $btn.removeClass('active');
                                $i.removeClass('fa-solid').addClass('fa-regular');
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
                    $.ajax({
                        url: '{{ route('favorites.store') }}',
                        type: 'POST',
                        data: { _token: '{{ csrf_token() }}', product_id: productId },
                        success: function (res) {
                            if (res.success) {
                                $btn.addClass('active');
                                $i.removeClass('fa-regular').addClass('fa-solid');
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

            // Quick Add to Cart
            $(document).on('click', '.btn-quick', function (e) {
                e.preventDefault();
                var name = $(this).data('product');
                var $btn = $(this);
                $btn.html('<i class="fa-solid fa-check"></i>').css('background', '#198754');
                var $bdg = $('#cart-badge');
                var c = parseInt($bdg.text()) || 0;
                $bdg.text(c + 1);
                setTimeout(function () { $btn.html('<i class="fa-solid fa-cart-shopping"></i>').css('background', '') }, 1200);
            });

            // Clear All filters
            $('#clear-all').on('click', function (e) {
                e.preventDefault();
                $('input[type="checkbox"]').prop('checked', false);
                $('input[type="radio"]').prop('checked', false);
                $('.color-circle').removeClass('active');
                $('#price-min').val('');
                $('#price-max').val('');
            });

            // Mobile filter toggle
            $('#filter-toggle').on('click', function () {
                var $inner = $('#filter-inner');
                $inner.toggleClass('show');
                $(this).html($inner.hasClass('show') ? '<i class="fa-solid fa-xmark"></i> Hide Filters' : '<i class="fa-solid fa-sliders"></i> Show Filters');
            });

            // Pagination
            $(document).on('click', '.pagination .page-link', function (e) {
                e.preventDefault();
                if (!$(this).parent().hasClass('disabled')) {
                    $('.pagination .page-item').removeClass('active');
                    $(this).parent().addClass('active');
                }
            });

            // Scroll reveal
            if ('IntersectionObserver' in window) {
                var obs = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) { $(entry.target).addClass('animate-in'); obs.unobserve(entry.target) }
                    });
                }, { threshold: .1 });
                $('.p-card').each(function () { this.style.opacity = '0'; obs.observe(this) });
            }
        });
    </script>
@endpush