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

        /* CUSTOMIZE YOUR LENSES BUTTON */
        .btn-customize-lenses {
            width: 100%;
            margin-top: 10px;
            padding: 9px 16px;
            border-radius: var(--r-sm);
            background: var(--primary);
            color: #fff;
            border: none;
            font-size: .78rem;
            font-weight: 700;
            font-family: var(--font);
            cursor: pointer;
            transition: var(--tr);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            letter-spacing: .3px
        }

        .btn-customize-lenses:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 14px rgba(29,53,87,.25)
        }

        /* REVIEWS SECTION */
        .reviews-section {
            background: #FFFAF7;
            padding: 60px 0
        }

        .reviews-title {
            text-align: center;
            font-size: 1rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--text-primary);
            margin-bottom: 36px
        }

        .review-card {
            background: #fff;
            border-radius: var(--r-md);
            padding: 28px 24px;
            border: 1px solid var(--border-light);
            height: 100%;
            transition: var(--tr);
            display: flex;
            flex-direction: column
        }

        .review-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-3px);
            border-color: #d0e8f7
        }

        .reviewer-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px
        }

        .reviewer-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--border-light)
        }

        .reviewer-info h6 {
            font-size: .88rem;
            font-weight: 700;
            margin: 0;
            color: var(--text-primary)
        }

        .reviewer-info .reviewer-class {
            font-size: .7rem;
            color: var(--text-muted);
            font-weight: 500
        }

        .review-stars {
            display: flex;
            gap: 2px;
            margin-bottom: 12px
        }

        .review-stars i {
            color: var(--star-color);
            font-size: .75rem
        }

        .review-text {
            font-size: .84rem;
            color: var(--text-secondary);
            line-height: 1.65;
            flex: 1;
            font-style: italic
        }

        /* REVIEW FORM */
        .review-form-wrapper {
            margin-top: 40px;
            background: #fff;
            border-radius: var(--r-md);
            padding: 32px;
            border: 1px solid var(--border-light)
        }

        .review-form-wrapper h4 {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 20px
        }

        .star-selector {
            display: flex;
            gap: 6px;
            margin-bottom: 16px
        }

        .star-selector i {
            font-size: 1.4rem;
            color: #ddd;
            cursor: pointer;
            transition: color .2s ease, transform .15s ease
        }

        .star-selector i:hover { transform: scale(1.2) }
        .star-selector i.active { color: var(--star-color) }

        .review-textarea {
            width: 100%;
            min-height: 100px;
            border: 1.5px solid var(--border-light);
            border-radius: var(--r-sm);
            padding: 14px 16px;
            font-size: .88rem;
            font-family: var(--font);
            color: var(--text-primary);
            resize: vertical;
            transition: var(--tr);
            margin-bottom: 16px
        }

        .review-textarea:focus {
            outline: none;
            border-color: var(--accent-dark);
            box-shadow: 0 0 0 3px rgba(189,227,249,.4)
        }

        .review-textarea::placeholder { color: var(--text-muted) }

        .btn-submit-review {
            background: var(--primary);
            color: #fff;
            font-weight: 700;
            font-size: .88rem;
            padding: 12px 32px;
            border: none;
            border-radius: var(--r-sm);
            cursor: pointer;
            transition: var(--tr);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none
        }

        .btn-submit-review:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(29,53,87,.2);
            color: #fff
        }

        .btn-submit-review:disabled {
            opacity: .6;
            cursor: not-allowed;
            transform: none
        }

        .review-product-select {
            width: 100%;
            max-width: 400px;
            border: 1.5px solid var(--border-light);
            border-radius: var(--r-sm);
            padding: 10px 14px;
            font-size: .85rem;
            font-family: var(--font);
            color: var(--text-primary);
            margin-bottom: 16px;
            background: #fff
        }

        .review-product-select:focus {
            outline: none;
            border-color: var(--accent-dark)
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
                                                <h5>{{ $product->name }}</h5>
                                                @php $isFav = isset(session('favorites', [])[$product->id]); @endphp
                                                <button class="p-heart {{ $isFav ? 'active' : '' }}" data-id="{{ $product->id }}"
                                                    aria-label="Favorite">
                                                    <i class="{{ $isFav ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                                                </button>
                                            </div>
                                            @php
                                                $avgRat = round($product->reviews_avg_rating ?? 0, 1);
                                                $fullS  = floor($avgRat);
                                                $halfS  = ($avgRat - $fullS) >= 0.25;
                                            @endphp
                                            <div class="p-stars">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $fullS)
                                                        <i class="fa-solid fa-star"></i>
                                                    @elseif($halfS && $i == $fullS + 1)
                                                        <i class="fa-solid fa-star-half-stroke"></i>
                                                    @else
                                                        <i class="fa-regular fa-star"></i>
                                                    @endif
                                                @endfor
                                                <span>({{ $product->reviews_count }})</span>
                                            </div>
                                            <div class="p-wholesale">Wholesale Price</div>
                                            <div class="p-price-row">
                                                <div class="p-price">${{ number_format($product->price, 2) }} <small>/ box</small></div>
                                            </div>
                                            <button type="button" class="btn-customize-lenses" data-product-id="{{ $product->id }}" title="Customize Your Lenses">
                                                <i class="fa-solid fa-eye"></i> Customize Your Lenses
                                            </button>
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

    <!-- ========== REVIEWS SECTION ========== -->
    @php
        $allProductIds = $products->pluck('id')->toArray();
        $lensReviews   = \App\Models\Review::whereIn('product_id', $allProductIds)->latest()->take(6)->get();
        $lensReviewCnt = \App\Models\Review::whereIn('product_id', $allProductIds)->count();
    @endphp
    <section class="reviews-section" id="reviews-section">
        <div class="container">
            <h2 class="reviews-title" id="reviews-title">Customer Reviews ({{ $lensReviewCnt }})</h2>
            <div class="row g-4">
                @forelse($lensReviews as $review)
                    <div class="col-md-4">
                        <div class="review-card" id="review-{{ $review->id }}">
                            <div class="reviewer-header">
                                <img src="{{ asset('images/Avatar.png') }}" alt="{{ $review->reviewer_name }} avatar" class="reviewer-avatar">
                                <div class="reviewer-info">
                                    <h6>{{ $review->reviewer_name }}</h6>
                                    <div class="reviewer-class">{{ $review->created_at->format('M d, Y') }}</div>
                                </div>
                            </div>
                            <div class="review-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="fa-solid fa-star"></i>
                                    @else
                                        <i class="fa-regular fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <p class="review-text">{{ $review->comment }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted">
                        <p>No reviews yet for contact lens products.</p>
                    </div>
                @endforelse
            </div>

            <!-- Review Form -->
            <div class="review-form-wrapper" id="review-form-wrapper">
                @auth
                    <h4><i class="fa-solid fa-pen-to-square"></i> Write a Review</h4>
                    <form id="review-submit-form">
                        @csrf
                        <div style="margin-bottom:14px;">
                            <label class="option-label" style="display:block; margin-bottom:8px;">Select Product</label>
                            <select name="product_id" class="review-product-select" id="review-product-select" required>
                                <option value="" disabled selected>Choose a product to review…</option>
                                @foreach($products as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="option-label" style="margin-bottom:8px;">Your Rating</div>
                        <div class="star-selector" id="star-selector">
                            <i class="fa-regular fa-star" data-value="1"></i>
                            <i class="fa-regular fa-star" data-value="2"></i>
                            <i class="fa-regular fa-star" data-value="3"></i>
                            <i class="fa-regular fa-star" data-value="4"></i>
                            <i class="fa-regular fa-star" data-value="5"></i>
                        </div>
                        <input type="hidden" name="rating" id="rating-input" value="0">
                        <textarea name="comment" class="review-textarea" id="review-comment" placeholder="Share your experience with this product..."></textarea>
                        <button type="submit" class="btn-submit-review" id="btn-submit-review">
                            <i class="fa-solid fa-paper-plane"></i> Submit Review
                        </button>
                    </form>
                @else
                    <h4><i class="fa-solid fa-pen-to-square"></i> Write a Review</h4>
                    <p style="color:var(--text-muted); font-size:.88rem; margin-bottom:16px;">You must be signed in to leave a review.</p>
                    <a href="{{ route('login') }}" class="btn-submit-review">
                        <i class="fa-solid fa-right-to-bracket"></i> Sign In to Review
                    </a>
                @endauth
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $(document).ready(function () {
            // Navbar scroll
            $(window).on('scroll', function () { $('#mainNavbar').toggleClass('scrolled', $(this).scrollTop() > 50) });

            // ---- Auth gate helper ----
            var isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};

            function showAuthAlert() {
                Swal.fire({
                    icon: 'info',
                    title: 'Sign In Required',
                    text: 'You need to sign in before proceeding.',
                    showCancelButton: true,
                    confirmButtonText: 'Sign In',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#1D3557',
                    footer: 'Don\'t have an account? <a href="{{ route('register') }}">Register now</a>'
                }).then(function (result) {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('login') }}";
                    }
                });
            }

            // ---- Navbar badge helper ----
            function updateNavBadge(selector, count) {
                var $badge = $(selector);
                if (count > 0) {
                    $badge.text(count).show();
                } else {
                    $badge.text('0').hide();
                }
            }

            // Color Family circle toggle
            $('#color-family').on('click', '.color-circle', function () {
                var color = $(this).data('color');
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

            // ---- Heart toggle (with navbar badge update) ----
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
                                updateNavBadge('#navFavBadge', res.count);
                            }
                        },
                        error: function (xhr) {
                            if (xhr.status === 401) { showAuthAlert(); }
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
                                updateNavBadge('#navFavBadge', res.count);
                            }
                        },
                        error: function (xhr) {
                            if (xhr.status === 401) { showAuthAlert(); }
                        }
                    });
                }
            });

            // ---- Customize Your Lenses (auth-gated) ----
            $(document).on('click', '.btn-customize-lenses', function (e) {
                e.preventDefault();
                if (!isAuthenticated) {
                    showAuthAlert();
                    return;
                }
                var pid = $(this).data('product-id');
                window.location.href = "{{ route('prescription.create') }}?product_id=" + pid;
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

            // Scroll reveal
            if ('IntersectionObserver' in window) {
                var obs = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) { $(entry.target).addClass('animate-in'); obs.unobserve(entry.target) }
                    });
                }, { threshold: .1 });
                $('.p-card, .review-card').each(function () { this.style.opacity = '0'; obs.observe(this) });
            }

            // ---- Star Selector (Review Form) ----
            $('#star-selector i').on('click', function () {
                var val = $(this).data('value');
                $('#rating-input').val(val);
                $('#star-selector i').each(function () {
                    if ($(this).data('value') <= val) {
                        $(this).removeClass('fa-regular').addClass('fa-solid active');
                    } else {
                        $(this).removeClass('fa-solid active').addClass('fa-regular');
                    }
                });
            });

            $('#star-selector i').on('mouseenter', function () {
                var val = $(this).data('value');
                $('#star-selector i').each(function () {
                    $(this).toggleClass('active', $(this).data('value') <= val);
                });
            });

            $('#star-selector').on('mouseleave', function () {
                var selected = parseInt($('#rating-input').val());
                $('#star-selector i').each(function () {
                    if ($(this).data('value') <= selected) {
                        $(this).removeClass('fa-regular').addClass('fa-solid active');
                    } else {
                        $(this).removeClass('fa-solid active').addClass('fa-regular');
                    }
                });
            });

            // ---- Review Form Submission (AJAX) ----
            $('#review-submit-form').on('submit', function (e) {
                e.preventDefault();

                var rating = parseInt($('#rating-input').val());
                var comment = $('#review-comment').val().trim();
                var productId = $('#review-product-select').val();

                if (!productId) {
                    Swal.fire({ icon: 'warning', title: 'Select a Product', text: 'Please choose which product you want to review.', confirmButtonColor: '#1D3557' });
                    return;
                }
                if (rating < 1) {
                    Swal.fire({ icon: 'warning', title: 'Please select a rating', text: 'Click on the stars to rate this product.', confirmButtonColor: '#1D3557' });
                    return;
                }
                if (comment.length < 5) {
                    Swal.fire({ icon: 'warning', title: 'Review too short', text: 'Please write at least 5 characters.', confirmButtonColor: '#1D3557' });
                    return;
                }

                var $btn = $('#btn-submit-review');
                var origHtml = $btn.html();
                $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Submitting...');

                $.ajax({
                    url: '{{ route("reviews.store") }}',
                    type: 'POST',
                    data: $(this).serialize(),
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function (response) {
                        if (response.success) {
                            var starsHtml = '';
                            for (var i = 1; i <= 5; i++) {
                                starsHtml += i <= response.review.rating
                                    ? '<i class="fa-solid fa-star"></i>'
                                    : '<i class="fa-regular fa-star"></i>';
                            }

                            var cardHtml = '<div class="col-md-4">' +
                                '<div class="review-card animate-in" id="review-' + response.review.id + '">' +
                                    '<div class="reviewer-header">' +
                                        '<img src="{{ asset("images/Avatar.png") }}" alt="' + response.review.reviewer_name + ' avatar" class="reviewer-avatar">' +
                                        '<div class="reviewer-info">' +
                                            '<h6>' + response.review.reviewer_name + '</h6>' +
                                            '<div class="reviewer-class">' + response.review.date + '</div>' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="review-stars">' + starsHtml + '</div>' +
                                    '<p class="review-text">' + response.review.comment + '</p>' +
                                '</div>' +
                            '</div>';

                            var $grid = $('#reviews-section .row.g-4');
                            $grid.find('.text-center.text-muted').parent().remove();
                            $grid.prepend(cardHtml);

                            var $title = $('#reviews-title');
                            var currentCount = parseInt($title.text().match(/\d+/) || 0) + 1;
                            $title.text('Customer Reviews (' + currentCount + ')');

                            // Reset form
                            $('#review-comment').val('');
                            $('#rating-input').val('0');
                            $('#review-product-select').val('');
                            $('#star-selector i').removeClass('fa-solid active').addClass('fa-regular');

                            Swal.fire({
                                toast: true, position: 'bottom-end', icon: 'success',
                                title: response.message || 'Review submitted!',
                                showConfirmButton: false, timer: 3000, timerProgressBar: true
                            });
                        }
                    },
                    error: function (xhr) {
                        var errMsg = 'Failed to submit review.';
                        if (xhr.responseJSON && xhr.responseJSON.message) errMsg = xhr.responseJSON.message;
                        Swal.fire({
                            toast: true, position: 'bottom-end', icon: 'error',
                            title: errMsg, showConfirmButton: false, timer: 3500, timerProgressBar: true
                        });
                    },
                    complete: function () {
                        $btn.prop('disabled', false).html(origHtml);
                    }
                });
            });
        });
    </script>
@endpush