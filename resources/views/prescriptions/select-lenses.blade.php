@extends('layouts.app')
@section('title', 'Choose Your Lenses — Basirah')
@section('description_content', 'Choose your eyeglass lenses — Basirah. Customize your visual experience with high-quality lens options.')
@push('style')
    <style>
        :root {
            --primary: #1D3557;
            --primary-hover: #274b78;
            --blue: #007BFF;
            --blue-hover: #0069d9;
            --accent: #BDE3F9;
            --accent-hover: #a4d6f4;
            --accent-dark: #8DCFF0;
            --dark: #1a1a2e;
            --body-bg: #f4f6f9;
            --card-bg: #fff;
            --text-primary: #1a1a2e;
            --text-secondary: #555;
            --text-muted: #888;
            --border-light: #e4e8ec;
            --green: #198754;
            --font: 'Inter', sans-serif;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, .06);
            --shadow-md: 0 4px 20px rgba(0, 0, 0, .08);
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
            background: #fff;
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

        /* STEPPER */
        .stepper-section {
            padding: 36px 0 10px;
            background: #fff
        }

        .stepper {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0
        }

        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .85rem;
            font-weight: 700;
            transition: var(--tr);
            position: relative;
            z-index: 2
        }

        .step-circle.completed {
            background: var(--primary);
            color: #fff;
            border: 2px solid var(--primary)
        }

        .step-circle.active {
            background: var(--blue);
            color: #fff;
            border: 2px solid var(--blue);
            box-shadow: 0 0 0 4px rgba(0, 123, 255, .18)
        }

        .step-circle.inactive {
            background: #fff;
            color: var(--text-muted);
            border: 2px solid var(--border-light)
        }

        .step-line {
            width: 60px;
            height: 2px;
            background: var(--border-light);
            position: relative;
            z-index: 1
        }

        .step-line.done {
            background: var(--primary)
        }

        /* PAGE HEADER */
        .page-title-section {
            text-align: center;
            padding: 28px 0 36px
        }

        .page-title-section h1 {
            font-size: 1.65rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 10px;
            letter-spacing: -.3px
        }

        .page-title-section p {
            font-size: .88rem;
            color: var(--text-muted);
            max-width: 440px;
            margin: 0 auto;
            line-height: 1.6
        }

        /* LENS CARDS */
        .lens-grid {
            margin-bottom: 48px
        }

        .lens-card {
            background: var(--card-bg);
            border: 2px solid var(--border-light);
            border-radius: var(--r-md);
            padding: 24px;
            cursor: pointer;
            transition: var(--tr);
            position: relative;
            height: 100%;
            display: flex;
            flex-direction: column
        }

        .lens-card:hover {
            border-color: var(--accent-dark);
            background: #fbfdff;
            box-shadow: var(--shadow-sm)
        }

        .lens-card.selected {
            border-color: var(--blue);
            background: #f0f8ff;
            box-shadow: 0 0 0 1px var(--blue)
        }

        .lens-card.selected::after {
            content: '\f058';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            top: 16px;
            right: 16px;
            color: var(--blue);
            font-size: 1.1rem
        }

        .lens-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 14px
        }

        .lens-icon {
            width: 38px;
            height: 38px;
            border-radius: var(--r-sm);
            background: #eef7fd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: var(--blue)
        }

        .lens-card.selected .lens-icon {
            background: var(--accent)
        }

        .lens-price-tag {
            font-size: .88rem;
            font-weight: 700;
            color: var(--blue)
        }

        .lens-card h5 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--text-primary)
        }

        .lens-card .lens-desc {
            font-size: .8rem;
            color: var(--text-muted);
            line-height: 1.55;
            margin-bottom: 14px
        }

        .lens-benefits {
            list-style: none;
            padding: 0;
            margin: 0
        }

        .lens-benefits li {
            font-size: .78rem;
            color: var(--text-secondary);
            padding: 3px 0;
            display: flex;
            align-items: center;
            gap: 8px
        }

        .lens-benefits li i {
            color: var(--blue);
            font-size: .65rem;
            flex-shrink: 0
        }

        /* ENHANCEMENTS */
        .enhancements-section {
            margin-bottom: 32px
        }

        .enhancements-section h4 {
            font-size: 1.15rem;
            font-weight: 800;
            margin-bottom: 18px;
            color: var(--text-primary)
        }

        .enhancement-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 20px;
            border: 1px solid var(--border-light);
            border-radius: var(--r-md);
            margin-bottom: 10px;
            background: #fff;
            transition: var(--tr);
            flex-wrap: wrap;
            gap: 12px
        }

        .enhancement-row:hover {
            border-color: #d0e0ee;
            background: #fafcfe
        }

        .enhancement-row.added {
            border-color: var(--blue);
            background: #f5faff
        }

        .enh-left {
            display: flex;
            align-items: center;
            gap: 14px;
            flex: 1;
            min-width: 0
        }

        .enh-icon {
            width: 36px;
            height: 36px;
            min-width: 36px;
            border-radius: var(--r-sm);
            background: #f0f4f8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .9rem;
            color: var(--primary)
        }

        .enh-info h6 {
            font-size: .88rem;
            font-weight: 700;
            margin: 0;
            color: var(--text-primary)
        }

        .enh-info p {
            font-size: .74rem;
            color: var(--text-muted);
            margin: 0
        }

        .enh-right {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0
        }

        .enh-price {
            font-size: .85rem;
            font-weight: 700;
            color: var(--text-primary)
        }

        .btn-enh-add {
            background: #fff;
            border: 1.5px solid var(--border-light);
            color: var(--text-primary);
            font-weight: 600;
            font-size: .78rem;
            padding: 5px 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: var(--tr);
            font-family: var(--font)
        }

        .btn-enh-add:hover {
            border-color: var(--blue);
            color: var(--blue)
        }

        .btn-enh-add.added {
            background: var(--blue);
            border-color: var(--blue);
            color: #fff
        }

        .enh-included {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: .82rem;
            font-weight: 600;
            color: var(--text-muted)
        }

        .enh-included i {
            color: var(--green);
            font-size: .9rem
        }

        /* SUMMARY BAR */
        .summary-bar {
            background: var(--primary);
            border-radius: var(--r-md);
            padding: 22px 30px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px
        }

        .summary-left .summary-label {
            font-size: .72rem;
            color: rgba(255, 255, 255, .55);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 2px
        }

        .summary-left .summary-total {
            font-size: 1.55rem;
            font-weight: 800;
            color: #fff
        }

        .summary-right {
            display: flex;
            align-items: center;
            gap: 10px
        }

        .btn-back {
            background: rgba(255, 255, 255, .12);
            border: 1.5px solid rgba(255, 255, 255, .25);
            color: #fff;
            font-weight: 600;
            font-size: .85rem;
            padding: 10px 24px;
            border-radius: var(--r-sm);
            cursor: pointer;
            transition: var(--tr);
            font-family: var(--font)
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, .2);
            border-color: rgba(255, 255, 255, .5)
        }

        .btn-continue {
            background: var(--accent);
            color: var(--primary);
            font-weight: 700;
            font-size: .88rem;
            padding: 11px 28px;
            border: none;
            border-radius: var(--r-sm);
            cursor: pointer;
            transition: var(--tr);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: var(--font)
        }

        .btn-continue:hover {
            background: var(--accent-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(189, 227, 249, .5)
        }

        .price-note {
            text-align: center;
            font-size: .74rem;
            color: var(--text-muted);
            margin-bottom: 50px;
            font-style: italic
        }

        /* FOOTER */
        .footer-s {
            background: #f8fafc;
            padding: 60px 0 0;
            border-top: 1px solid var(--border-light)
        }

        .f-logo {
            display: flex;
            align-items: center;
            gap: 9px;
            font-weight: 800;
            font-size: 1.2rem;
            color: var(--text-primary);
            margin-bottom: 14px
        }

        .f-logo .ico {
            width: 28px;
            height: 28px;
            background: var(--accent);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .75rem;
            color: var(--primary)
        }

        .f-desc {
            font-size: .8rem;
            color: var(--text-muted);
            line-height: 1.7;
            margin-bottom: 20px;
            max-width: 280px
        }

        .f-social {
            display: flex;
            gap: 10px
        }

        .f-social a {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            font-size: .85rem;
            transition: var(--tr)
        }

        .f-social a:hover {
            background: var(--primary);
            color: #fff;
            transform: translateY(-2px)
        }

        .f-heading {
            font-size: .85rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: .5px
        }

        .f-links {
            list-style: none;
            padding: 0;
            margin: 0
        }

        .f-links li {
            margin-bottom: 10px
        }

        .f-links a {
            color: var(--text-muted);
            font-size: .82rem
        }

        .f-links a:hover {
            color: var(--primary);
            padding-left: 4px
        }

        .f-bottom {
            background: #f0f2f5;
            padding: 20px 0;
            margin-top: 40px
        }

        .f-bottom p {
            font-size: .78rem;
            color: var(--text-muted);
            margin: 0
        }

        .f-bottom-links {
            display: flex;
            gap: 20px;
            justify-content: flex-end
        }

        .f-bottom-links a {
            font-size: .78rem;
            color: var(--text-muted)
        }

        .f-bottom-links a:hover {
            color: var(--primary)
        }

        @media(max-width:767.98px) {
            .page-title-section h1 {
                font-size: 1.3rem
            }

            .summary-bar {
                padding: 18px 20px
            }

            .summary-left .summary-total {
                font-size: 1.25rem
            }

            .btn-continue {
                padding: 10px 20px;
                font-size: .82rem
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

        /* SECTION HEADER */
        .section-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px
        }

        .section-header .section-number {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: var(--blue);
            color: #fff;
            font-size: .75rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0
        }

        .section-header h4 {
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--text-primary);
            margin: 0
        }

        /* MATERIAL CARDS */
        .material-grid {
            margin-bottom: 40px
        }

        .material-card {
            background: var(--card-bg);
            border: 2px solid var(--border-light);
            border-radius: var(--r-md);
            padding: 22px 24px;
            cursor: pointer;
            transition: var(--tr);
            position: relative;
            height: 100%;
            display: flex;
            flex-direction: column
        }

        .material-card:hover {
            border-color: var(--accent-dark);
            background: #fbfdff;
            box-shadow: var(--shadow-sm)
        }

        .material-card.selected {
            border-color: var(--blue);
            background: #f0f8ff;
            box-shadow: 0 0 0 1px var(--blue)
        }

        .material-card.selected::after {
            content: '\f058';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            top: 14px;
            right: 14px;
            color: var(--blue);
            font-size: 1.1rem
        }

        .material-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px
        }

        .material-icon {
            width: 42px;
            height: 42px;
            border-radius: var(--r-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem
        }

        .material-icon.plastic-icon {
            background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
            color: #388e3c
        }

        .material-icon.glass-icon {
            background: linear-gradient(135deg, #e3f2fd, #bbdefb);
            color: #1565c0
        }

        .material-card.selected .material-icon {
            box-shadow: 0 2px 8px rgba(0, 0, 0, .08)
        }

        .material-price-tag {
            font-size: .92rem;
            font-weight: 700;
            color: var(--blue)
        }

        .material-card h5 {
            font-size: 1.02rem;
            font-weight: 700;
            margin-bottom: 6px;
            color: var(--text-primary)
        }

        .material-card .material-desc {
            font-size: .8rem;
            color: var(--text-muted);
            line-height: 1.55;
            margin-bottom: 12px
        }

        .material-benefits {
            list-style: none;
            padding: 0;
            margin: 0
        }

        .material-benefits li {
            font-size: .78rem;
            color: var(--text-secondary);
            padding: 2px 0;
            display: flex;
            align-items: center;
            gap: 8px
        }

        .material-benefits li i {
            color: var(--green);
            font-size: .65rem;
            flex-shrink: 0
        }

        /* PRICE BREAKDOWN IN SUMMARY */
        .price-breakdown {
            margin-bottom: 18px;
            padding-bottom: 14px;
            border-bottom: 1px solid rgba(255, 255, 255, .12)
        }

        .price-breakdown-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 3px 0;
            font-size: .8rem
        }

        .price-breakdown-row .bd-label {
            color: rgba(255, 255, 255, .6)
        }

        .price-breakdown-row .bd-value {
            color: rgba(255, 255, 255, .85);
            font-weight: 600
        }

        .price-breakdown-row.bd-frame .bd-label {
            color: rgba(255, 255, 255, .8);
            font-weight: 600
        }

        .price-breakdown-row.bd-frame .bd-value {
            color: #fff;
            font-weight: 700
        }
    </style>
@endpush

@section('navbar')
    @include('layouts.partials.navbar-default')
@endsection

@section('content')
    <!-- STEPPER -->
    <section class="stepper-section">
        <div class="container">
            <div class="stepper" id="stepper">
                <div class="step-circle completed" id="step-1"><i class="fa-solid fa-check"></i></div>
                <div class="step-line done"></div>
                <div class="step-circle active" id="step-2">2</div>
                <div class="step-line"></div>
                <div class="step-circle inactive" id="step-3">3</div>
            </div>
        </div>
    </section>

    <!-- PAGE TITLE -->
    <section class="page-title-section">
        <div class="container">
            <h1>Choose Your Eyeglass Lenses</h1>
            <p>Customize your visual experience with our high-quality lens options. Select the type that best fits your
                daily needs and lifestyle.</p>
        </div>
    </section>

    <!-- MAIN CONTENT -->
    <section class="pb-2">
        <div class="container" style="max-width:820px">

            <!-- ① LENS MATERIAL SELECTION -->
            <div class="material-grid">
                <div class="section-header">
                    <span class="section-number">1</span>
                    <h4>Choose Lens Material</h4>
                </div>
                <div class="row g-3" id="material-grid">
                    <!-- Plastic Lenses -->
                    <div class="col-md-6">
                        <div class="material-card selected" data-price="30" data-name="Plastic" id="material-plastic">
                            <div class="material-card-header">
                                <div class="material-icon plastic-icon"><i class="fa-solid fa-feather-pointed"></i></div>
                                <span class="material-price-tag">$30.00</span>
                            </div>
                            <h5>Plastic Lenses</h5>
                            <p class="material-desc">Lightweight CR-39 plastic lenses. The most popular choice for everyday
                                eyewear — comfortable, durable, and affordable.</p>
                            <ul class="material-benefits">
                                <li><i class="fa-solid fa-check"></i> Ultra-lightweight for all-day comfort</li>
                                <li><i class="fa-solid fa-check"></i> Excellent optical clarity</li>
                                <li><i class="fa-solid fa-check"></i> Impact resistant</li>
                            </ul>
                        </div>
                    </div>
                    <!-- Glass Lenses -->
                    <div class="col-md-6">
                        <div class="material-card" data-price="50" data-name="Glass" id="material-glass">
                            <div class="material-card-header">
                                <div class="material-icon glass-icon"><i class="fa-solid fa-gem"></i></div>
                                <span class="material-price-tag">$50.00</span>
                            </div>
                            <h5>Glass Lenses</h5>
                            <p class="material-desc">Premium optical glass lenses with superior scratch resistance and the
                                crispest possible vision. A classic choice for discerning wearers.</p>
                            <ul class="material-benefits">
                                <li><i class="fa-solid fa-check"></i> Superior scratch resistance</li>
                                <li><i class="fa-solid fa-check"></i> Highest optical quality</li>
                                <li><i class="fa-solid fa-check"></i> Thinner profile at higher Rx</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ② LENS TYPE GRID -->
            <div class="lens-grid">
                <div class="section-header">
                    <span class="section-number">2</span>
                    <h4>Choose Lens Type</h4>
                </div>
                <div class="row g-3" id="lens-grid">
                    <!-- Single Vision -->
                    <div class="col-md-6">
                        <div class="lens-card selected" data-price="0" data-name="Single Vision" id="lens-single">
                            <div class="lens-card-header">
                                <div class="lens-icon"><i class="fa-regular fa-circle"></i></div>
                                <span class="lens-price-tag">+$0.00</span>
                            </div>
                            <h5>Single Vision</h5>
                            <p class="lens-desc">Optimized for one focal distance, whether it's for distance, reading, or
                                intermediate use. The most common lens type.</p>
                            <ul class="lens-benefits">
                                <li><i class="fa-solid fa-check"></i> Wide field of view</li>
                                <li><i class="fa-solid fa-check"></i> Thinner lens profile available</li>
                            </ul>
                        </div>
                    </div>
                    <!-- Progressive -->
                    <div class="col-md-6">
                        <div class="lens-card" data-price="120" data-name="Progressive" id="lens-progressive">
                            <div class="lens-card-header">
                                <div class="lens-icon"><i class="fa-solid fa-table-cells"></i></div>
                                <span class="lens-price-tag">+$120.00</span>
                            </div>
                            <h5>Progressive</h5>
                            <p class="lens-desc">No-line multifocal lenses that provide a seamless transition between
                                distance, intermediate, and near vision.</p>
                            <ul class="lens-benefits">
                                <li><i class="fa-solid fa-check"></i> All-in-one vision solution</li>
                                <li><i class="fa-solid fa-check"></i> No visible lines in lens</li>
                            </ul>
                        </div>
                    </div>
                    <!-- Bifocal -->
                    <div class="col-md-6">
                        <div class="lens-card" data-price="80" data-name="Bifocal" id="lens-bifocal">
                            <div class="lens-card-header">
                                <div class="lens-icon"><i class="fa-regular fa-copy"></i></div>
                                <span class="lens-price-tag">+$80.00</span>
                            </div>
                            <h5>Bifocal</h5>
                            <p class="lens-desc">Traditional lenses with two distinct optical powers, separated by a visible
                                line. Ideal for distance and reading.</p>
                            <ul class="lens-benefits">
                                <li><i class="fa-solid fa-check"></i> Clear near &amp; far zones</li>
                                <li><i class="fa-solid fa-check"></i> Traditional optical design</li>
                            </ul>
                        </div>
                    </div>
                    <!-- Blue Light Blocking -->
                    <div class="col-md-6">
                        <div class="lens-card" data-price="45" data-name="Blue Light Blocking" id="lens-bluelight">
                            <div class="lens-card-header">
                                <div class="lens-icon"><i class="fa-solid fa-display"></i></div>
                                <span class="lens-price-tag">+$45.00</span>
                            </div>
                            <h5>Blue Light Blocking</h5>
                            <p class="lens-desc">Advanced coating that filters harmful blue light from digital screens to
                                reduce eye strain and improve sleep quality.</p>
                            <ul class="lens-benefits">
                                <li><i class="fa-solid fa-check"></i> Reduces digital eye fatigue</li>
                                <li><i class="fa-solid fa-check"></i> UV protection included</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ③ RECOMMENDED ENHANCEMENTS -->
            <div class="enhancements-section" id="enhancements-section">
                <div class="section-header">
                    <span class="section-number">3</span>
                    <h4>Recommended Enhancements</h4>
                </div>
                <div class="enhancement-row" id="enh-antireflective">
                    <div class="enh-left">
                        <div class="enh-icon"><i class="fa-solid fa-wand-magic-sparkles"></i></div>
                        <div class="enh-info">
                            <h6>Anti-Reflective Coating</h6>
                            <p>Eliminate glare from lights and night driving</p>
                        </div>
                    </div>
                    <div class="enh-right">
                        <span class="enh-price">+$25.00</span>
                        <button type="button" class="btn-enh-add" data-price="25" data-name="Anti-Reflective Coating"
                            id="btn-add-ar">Add</button>
                    </div>
                </div>
                <div class="enhancement-row" id="enh-scratch">
                    <div class="enh-left">
                        <div class="enh-icon"><i class="fa-solid fa-shield-halved"></i></div>
                        <div class="enh-info">
                            <h6>Scratch Resistant Coating</h6>
                            <p>Durable protection for your daily lens wear</p>
                        </div>
                    </div>
                    <div class="enh-right">
                        <span class="enh-included">Included <i class="fa-solid fa-circle-check"></i></span>
                    </div>
                </div>
            </div>

            <!-- SUMMARY BAR WITH BREAKDOWN -->
            <div class="summary-bar" id="summary-bar">
                <div class="summary-left" style="flex:1">
                    <div class="price-breakdown" id="price-breakdown">
                        <div class="price-breakdown-row bd-frame">
                            <span class="bd-label"><i class="fa-solid fa-glasses" style="margin-right:5px"></i> Frame:
                                {{ $product->name }}</span>
                            <span class="bd-value" id="bd-frame">${{ number_format($product->price, 2) }}</span>
                        </div>
                        <div class="price-breakdown-row">
                            <span class="bd-label" id="bd-material-label">Plastic Lenses</span>
                            <span class="bd-value" id="bd-material">$30.00</span>
                        </div>
                        <div class="price-breakdown-row">
                            <span class="bd-label" id="bd-lens-label">Single Vision</span>
                            <span class="bd-value" id="bd-lens">+$0.00</span>
                        </div>
                        <div class="price-breakdown-row" id="bd-enh-row" style="display:none">
                            <span class="bd-label">Enhancements</span>
                            <span class="bd-value" id="bd-enh">+$0.00</span>
                        </div>
                    </div>
                    <div class="summary-label">Estimated Total</div>
                    <div class="summary-total" id="summary-total">${{ number_format($product->price + 30, 2) }}</div>
                </div>
                <div class="summary-right">
                    <button type="button" class="btn-back" id="btn-back" onclick="history.back()">Back</button>
                    <button type="button" class="btn-continue" id="btn-continue">
                        Continue to Checkout <i class="fa-solid fa-arrow-right" style="font-size:.75rem"></i>
                    </button>
                </div>
            </div>
            <p class="price-note">Prices are for a pair of lenses. Final price may vary based on your specific prescription
                parameters.</p>

            <!-- HIDDEN FORM (submitted via JS) -->
            <form id="proceed-form" action="{{ route('lenses.proceed') }}" method="POST" style="display:none">
                @csrf
                <input type="hidden" name="prescription_id" value="{{ $prescription->id }}">
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="frame_price" value="{{ $product->price }}">
                <input type="hidden" name="lens_type" id="form-lens-type" value="Single Vision">
                <input type="hidden" name="lens_type_price" id="form-lens-type-price" value="0">
                <input type="hidden" name="lens_material" id="form-lens-material" value="Plastic">
                <input type="hidden" name="lens_material_price" id="form-lens-material-price" value="30">
                <!-- Enhancement fields are added dynamically -->
            </form>

        </div>
    </section>
@endsection

@section('footer')

@endsection

@push('script')
    <script>
        $(document).ready(function () {
            // ── Price state ──
            var framePrice = parseFloat({{ $product->price }});
            var materialPrice = 30;    // default: Plastic
            var lensPrice = 0;     // default: Single Vision
            var enhancements = {};    // name → price

            // ── Selected names ──
            var materialName = 'Plastic';
            var lensName = 'Single Vision';

            function updateTotal() {
                var enhTotal = 0;
                $.each(enhancements, function (k, v) { enhTotal += v; });
                var total = framePrice + materialPrice + lensPrice + enhTotal;

                // Update summary total
                $('#summary-total').text('$' + total.toFixed(2));

                // Update breakdown rows
                $('#bd-material-label').text(materialName + ' Lenses');
                $('#bd-material').text('$' + materialPrice.toFixed(2));
                $('#bd-lens-label').text(lensName);
                $('#bd-lens').text('+$' + lensPrice.toFixed(2));

                if (enhTotal > 0) {
                    $('#bd-enh-row').show();
                    $('#bd-enh').text('+$' + enhTotal.toFixed(2));
                } else {
                    $('#bd-enh-row').hide();
                }

                // Update hidden form fields
                $('#form-lens-type').val(lensName);
                $('#form-lens-type-price').val(lensPrice);
                $('#form-lens-material').val(materialName);
                $('#form-lens-material-price').val(materialPrice);
            }

            // Navbar scroll
            $(window).on('scroll', function () {
                $('#mainNavbar').toggleClass('scrolled', $(this).scrollTop() > 50);
            });

            // ── Material card selection ──
            $('#material-grid').on('click', '.material-card', function () {
                $('.material-card').removeClass('selected');
                $(this).addClass('selected');
                materialPrice = parseFloat($(this).data('price')) || 0;
                materialName = $(this).data('name');
                updateTotal();
            });

            // ── Lens card selection ──
            $('#lens-grid').on('click', '.lens-card', function () {
                $('.lens-card').removeClass('selected');
                $(this).addClass('selected');
                lensPrice = parseFloat($(this).data('price')) || 0;
                lensName = $(this).data('name');
                updateTotal();
            });

            // ── Enhancement add/remove ──
            $(document).on('click', '.btn-enh-add', function () {
                var $btn = $(this);
                var name = $btn.data('name');
                var price = parseFloat($btn.data('price')) || 0;
                var $row = $btn.closest('.enhancement-row');

                if ($btn.hasClass('added')) {
                    $btn.removeClass('added').text('Add');
                    $row.removeClass('added');
                    delete enhancements[name];
                } else {
                    $btn.addClass('added').text('Added');
                    $row.addClass('added');
                    enhancements[name] = price;
                }
                updateTotal();
            });

            // ── Continue to checkout ──
            $('#btn-continue').on('click', function () {
                // Remove old enhancement inputs
                $('#proceed-form input[name^="enhancements"]').remove();

                // Append enhancement fields
                var idx = 0;
                $.each(enhancements, function (name, price) {
                    $('#proceed-form').append(
                        '<input type="hidden" name="enhancements[' + idx + '][name]" value="' + name + '">' +
                        '<input type="hidden" name="enhancements[' + idx + '][price]" value="' + price + '">'
                    );
                    idx++;
                });

                // Submit the form
                $('#proceed-form').submit();
            });

            // ── Scroll reveal ──
            if ('IntersectionObserver' in window) {
                var obs = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            $(entry.target).addClass('animate-in');
                            obs.unobserve(entry.target);
                        }
                    });
                }, { threshold: .1 });
                $('.material-card,.lens-card,.enhancement-row').each(function () {
                    this.style.opacity = '0';
                    obs.observe(this);
                });
            }
        });
    </script>
@endpush