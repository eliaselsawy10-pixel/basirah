@extends('layouts.app')
@section('title', 'David Beckham Classic Aviators — Basirah')
@section('description', 'David Beckham Classic Aviators — Premium titanium eyewear. Shop the best prescription glasses at Basirah.')
@push('style')
    <style>
        :root {
            --primary: #1D3557;
            --primary-hover: #274b78;
            --accent: #BDE3F9;
            --accent-hover: #a4d6f4;
            --accent-dark: #8DCFF0;
            --dark: #1a1a2e;
            --body-bg: #f4f6f9;
            --card-bg: #ffffff;
            --text-primary: #1a1a2e;
            --text-secondary: #555;
            --text-muted: #888;
            --border-light: #e4e8ec;
            --star-color: #f5a623;
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
            background: #fff;
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

        /* ========== BREADCRUMBS ========== */
        .breadcrumb-section {
            padding: 20px 0 0;
        }

        .breadcrumb-custom {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.82rem;
            color: var(--text-muted);
            flex-wrap: wrap;
        }

        .breadcrumb-custom a {
            color: var(--text-muted);
        }

        .breadcrumb-custom a:hover {
            color: var(--primary);
            text-decoration: underline;
        }

        .breadcrumb-custom .separator {
            color: #ccc;
            font-size: 0.7rem;
        }

        .breadcrumb-custom .current {
            color: var(--text-primary);
            font-weight: 600;
        }

        /* ========== PRODUCT DETAIL SECTION ========== */
        .product-detail-section {
            padding: 24px 0 60px;
        }

        /* --- Gallery --- */
        .product-gallery {
            position: relative;
        }

        .main-image-wrapper {
            position: relative;
            background: #f6f8fa;
            border-radius: var(--radius-md);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 380px;
            padding: 30px;
            border: 1px solid var(--border-light);
        }

        .main-image-wrapper img {
            max-height: 320px;
            object-fit: contain;
            transition: var(--transition);
        }

        .gallery-heart {
            position: absolute;
            top: 16px;
            right: 16px;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid var(--border-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            z-index: 5;
            color: #ccc;
            font-size: 1rem;
        }

        .gallery-heart:hover,
        .gallery-heart.active {
            background: #ffe0e6;
            color: #e74c3c;
            border-color: #ffb3c1;
        }

        .ar-badge {
            position: absolute;
            bottom: 16px;
            left: 16px;
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid var(--border-light);
            border-radius: 20px;
            padding: 5px 14px;
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 6px;
            z-index: 5;
            letter-spacing: 0.5px;
        }

        .ar-badge i {
            color: #198754;
            font-size: 0.65rem;
        }

        .thumbnail-row {
            display: flex;
            gap: 10px;
            justify-content: space-evenly;
            margin-top: 14px;
        }

        .thumbnail-item {
            width: 250px;
            height: 100px;
            border-radius: var(--radius-sm);
            border: 2px solid var(--border-light);
            overflow: hidden;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 6px;
            background: #f9fafb;
        }

        .thumbnail-item:hover {
            border-color: var(--accent-dark);
        }

        .thumbnail-item.active {
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(29, 53, 87, 0.15);
        }

        .thumbnail-item img {
            max-height: 54px;
            max-width: 100%;
            object-fit: contain;
        }

        /* --- Product Info --- */
        .product-info-col {
            padding-left: 20px;
        }

        .collection-tag {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--primary);
            margin-bottom: 6px;
            opacity: 0.7;
        }

        .product-title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 10px;
            line-height: 1.15;
            letter-spacing: -0.5px;
        }

        .price-rating-row {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 18px;
            flex-wrap: wrap;
        }

        .product-price {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--text-primary);
        }

        .rating-stars {
            display: flex;
            align-items: center;
            gap: 2px;
        }

        .rating-stars i {
            color: var(--star-color);
            font-size: 0.8rem;
        }

        .rating-stars i.half {
            position: relative;
        }

        .review-count {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-left: 4px;
        }

        .product-description {
            font-size: 0.88rem;
            color: var(--text-secondary);
            line-height: 1.7;
            margin-bottom: 28px;
            max-width: 480px;
        }

        /* Frame Material */
        .option-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-primary);
            margin-bottom: 10px;
        }

        .material-pills {
            display: flex;
            gap: 10px;
            margin-bottom: 26px;
            flex-wrap: wrap;
        }

        .material-pill {
            padding: 8px 20px;
            border-radius: 24px;
            border: 1.5px solid var(--border-light);
            background: #fff;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-secondary);
            cursor: pointer;
            transition: var(--transition);
            font-family: var(--font-family);
        }

        .material-pill:hover {
            border-color: var(--accent-dark);
            color: var(--primary);
        }

        .material-pill.active {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }

        /* Color Swatches */
        .color-option-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-primary);
            margin-bottom: 10px;
        }

        .color-option-label span {
            font-weight: 500;
            text-transform: none;
            letter-spacing: 0;
            margin-left: 4px;
        }

        .color-swatches-detail {
            display: flex;
            gap: 10px;
            margin-bottom: 26px;
        }

        .swatch-circle {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 2.5px solid #ddd;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
        }

        .swatch-circle:hover {
            transform: scale(1.12);
        }

        .swatch-circle.active {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(29, 53, 87, 0.15);
        }

        /* Size Selector */
        .size-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .size-guide-link {
            font-size: 0.78rem;
            color: var(--primary);
            font-weight: 600;
            text-decoration: underline;
            text-underline-offset: 3px;
            cursor: pointer;
        }

        .size-guide-link:hover {
            color: var(--primary-hover);
        }

        .size-select {
            width: 100%;
            max-width: 320px;
            border: 1.5px solid var(--border-light);
            border-radius: var(--radius-sm);
            padding: 11px 16px;
            font-size: 0.88rem;
            font-family: var(--font-family);
            color: var(--text-primary);
            font-weight: 500;
            background: #fff;
            cursor: pointer;
            appearance: auto;
            margin-bottom: 28px;
            transition: var(--transition);
        }

        .size-select:focus {
            outline: none;
            border-color: var(--accent-dark);
            box-shadow: 0 0 0 3px rgba(189, 227, 249, 0.4);
        }

        /* Purchase Option Cards */
        .purchase-options {
            margin-bottom: 24px;
        }

        .purchase-options .option-label {
            margin-bottom: 12px;
        }

        .purchase-option {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 16px 18px;
            border: 2px solid var(--border-light);
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: var(--transition);
            margin-bottom: 10px;
            position: relative;
            background: #fff;
        }

        .purchase-option:hover {
            border-color: var(--accent-dark);
            background: #f8fbfe;
        }

        .purchase-option.selected {
            border-color: var(--primary);
            background: #f0f6fc;
            box-shadow: 0 0 0 1px var(--primary);
        }

        .purchase-option.selected .po-check {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }

        .purchase-option input[type="radio"] {
            display: none;
        }

        .po-check {
            width: 22px;
            height: 22px;
            min-width: 22px;
            border-radius: 50%;
            border: 2px solid #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.65rem;
            color: transparent;
            transition: var(--transition);
            margin-top: 2px;
        }

        .po-icon {
            width: 40px;
            height: 40px;
            min-width: 40px;
            border-radius: var(--radius-sm);
            background: var(--body-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.05rem;
            color: var(--primary);
            transition: var(--transition);
        }

        .purchase-option.selected .po-icon {
            background: var(--accent);
        }

        .po-text {
            flex: 1;
        }

        .po-text h6 {
            font-size: 0.88rem;
            font-weight: 700;
            margin: 0 0 2px;
            color: var(--text-primary);
        }

        .po-text p {
            font-size: 0.76rem;
            color: var(--text-muted);
            margin: 0;
            line-height: 1.4;
        }

        .po-price-hint {
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--primary);
            margin-top: 4px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .po-price-hint i {
            font-size: 0.62rem;
        }

        /* Add to Cart / CTA Button */
        .btn-add-to-cart {
            background: var(--accent);
            color: var(--primary);
            font-weight: 700;
            font-size: 0.95rem;
            padding: 14px 40px;
            border: none;
            border-radius: var(--radius-sm);
            transition: var(--transition);
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            letter-spacing: 0.3px;
            width: 100%;
            max-width: 420px;
            justify-content: center;
        }

        .btn-add-to-cart:hover {
            background: var(--accent-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 22px rgba(189, 227, 249, 0.55);
        }

        .btn-add-to-cart:active {
            transform: translateY(0);
        }

        /* Trust Badges */
        .trust-badges {
            display: flex;
            gap: 20px;
            margin-top: 22px;
            flex-wrap: wrap;
        }

        .trust-badge {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.74rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .trust-badge i {
            color: var(--primary);
            font-size: 0.8rem;
        }

        /* ========== REVIEWS SECTION ========== */
        .reviews-section {
            background: #FFFAF7;
            padding: 60px 0;
        }

        .reviews-title {
            text-align: center;
            font-size: 1rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--text-primary);
            margin-bottom: 36px;
        }

        .review-card {
            background: #fff;
            border-radius: var(--radius-md);
            padding: 28px 24px;
            border: 1px solid var(--border-light);
            height: 100%;
            transition: var(--transition);
            display: flex;
            flex-direction: column;
        }

        .review-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-3px);
            border-color: #d0e8f7;
        }

        .reviewer-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
        }

        .reviewer-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--border-light);
        }

        .reviewer-info h6 {
            font-size: 0.88rem;
            font-weight: 700;
            margin: 0;
            color: var(--text-primary);
        }

        .reviewer-info .reviewer-class {
            font-size: 0.7rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .review-stars {
            display: flex;
            gap: 2px;
            margin-bottom: 12px;
        }

        .review-stars i {
            color: var(--star-color);
            font-size: 0.75rem;
        }

        .review-text {
            font-size: 0.84rem;
            color: var(--text-secondary);
            line-height: 1.65;
            flex: 1;
            font-style: italic;
        }

        /* ========== RELATED PRODUCTS ========== */
        .related-section {
            padding: 60px 0;
            background: #fff;
        }

        .related-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 8px;
        }

        .related-title {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--text-primary);
        }

        .related-subtitle {
            font-size: 0.84rem;
            color: var(--text-muted);
            margin-bottom: 28px;
        }

        .view-all-link {
            font-size: 0.84rem;
            font-weight: 600;
            color: var(--primary);
        }

        .view-all-link:hover {
            color: var(--primary-hover);
            text-decoration: underline;
        }

        .related-card {
            border-radius: var(--radius-md);
            overflow: hidden;
            border: 1px solid var(--border-light);
            transition: var(--transition);
            cursor: pointer;
            background: #f9fafb;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .related-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-4px);
            border-color: #c5dced;
        }

        .related-card-img {
            width: 100%;
            height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            background: #f6f8fa;
        }

        .related-card-img img {
            width: 100%;
            max-height: 110px;
            object-fit: contain;
            transition: var(--transition);
        }

        .related-card:hover .related-card-img img {
            transform: scale(1.06);
        }

        .related-card-body {
            padding: 14px 16px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .related-card-body h6 {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 4px;
            line-height: 1.3;
        }

        .related-card-body .related-desc {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin: 0 0 10px;
            line-height: 1.4;
            flex: 1;
        }

        .related-card-body .related-price {
            font-size: 0.95rem;
            font-weight: 800;
            color: var(--text-primary);
            margin: 0;
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

        /* ========== RESPONSIVE ========== */
        @media (max-width: 991.98px) {
            .product-info-col {
                padding-left: 0;
                margin-top: 28px;
            }

            .product-title {
                font-size: 1.6rem;
            }

            .main-image-wrapper {
                min-height: 300px;
            }
        }

        @media (max-width: 767.98px) {
            .product-title {
                font-size: 1.35rem;
            }

            .product-price {
                font-size: 1.3rem;
            }

            .btn-add-to-cart {
                max-width: 100%;
            }

            .size-select {
                max-width: 100%;
            }

            .trust-badges {
                gap: 14px;
            }

            .thumbnail-item {
                width: 72px;
                height: 58px;
            }

            .related-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 4px;
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

        @keyframes pulseOnce {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.25);
            }

            100% {
                transform: scale(1);
            }
        }

        .pulse-once {
            animation: pulseOnce 0.4s ease;
        }

        /* Image zoom on hover */
        .main-image-wrapper:hover img {
            transform: scale(1.03);
        }

        /* ========== REVIEW FORM ========== */
        .review-form-wrapper {
            margin-top: 40px;
            background: #fff;
            border-radius: var(--radius-md);
            padding: 32px;
            border: 1px solid var(--border-light);
        }

        .review-form-wrapper h4 {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 20px;
        }

        .star-selector {
            display: flex;
            gap: 6px;
            margin-bottom: 16px;
        }

        .star-selector i {
            font-size: 1.4rem;
            color: #ddd;
            cursor: pointer;
            transition: color 0.2s ease, transform 0.15s ease;
        }

        .star-selector i:hover {
            transform: scale(1.2);
        }

        .star-selector i.active {
            color: var(--star-color);
        }

        .review-textarea {
            width: 100%;
            min-height: 100px;
            border: 1.5px solid var(--border-light);
            border-radius: var(--radius-sm);
            padding: 14px 16px;
            font-size: 0.88rem;
            font-family: var(--font-family);
            color: var(--text-primary);
            resize: vertical;
            transition: var(--transition);
            margin-bottom: 16px;
        }

        .review-textarea:focus {
            outline: none;
            border-color: var(--accent-dark);
            box-shadow: 0 0 0 3px rgba(189, 227, 249, 0.4);
        }

        .review-textarea::placeholder {
            color: var(--text-muted);
        }

        .btn-submit-review {
            background: var(--primary);
            color: #fff;
            font-weight: 700;
            font-size: 0.88rem;
            padding: 12px 32px;
            border: none;
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-submit-review:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(29, 53, 87, 0.2);
        }

        .btn-submit-review:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
    </style>
@endpush

@section('navbar')
    @include('layouts.partials.navbar-default')
@endsection

@section('content')
    <!-- ========== BREADCRUMBS ========== -->
    <section class="breadcrumb-section">
        <div class="container">
            <div class="breadcrumb-custom" id="breadcrumb-nav">
                <a href="{{ route('home') }}">Home</a>
                <span class="separator">/</span>
                <a href="{{ route('products.index') }}">Eyeglasses</a>
                <span class="separator">/</span>
                <span class="current">{{ $product->name }}</span>
            </div>
        </div>
    </section>

    <!-- ========== PRODUCT DETAIL ========== -->
    <section class="product-detail-section" id="product-detail">
        <div class="container">
            <div class="row">
                <!-- Gallery Column -->
                <div class="col-lg-6">
                    <div class="product-gallery">
                        <div class="main-image-wrapper" id="main-image-wrapper">
                            @php $isFav = isset(session('favorites', [])[$product->id]); @endphp
                            <div class="gallery-heart {{ $isFav ? 'active' : '' }}" id="gallery-heart"
                                data-id="{{ $product->id }}">
                                <i class="{{ $isFav ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                            </div>
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }} — Front View"
                                id="main-product-image">
                            <div class="ar-badge" id="ar-badge">
                                <i class="fa-solid fa-circle"></i>
                                AR READY
                            </div>
                        </div>
                        <div class="thumbnail-row" id="thumbnail-row">
                            @if(isset($product->images) && $product->images->count() > 0)
                                @foreach($product->images as $index => $image)
                                    <div class="thumbnail-item {{ $index === 0 ? 'active' : '' }}"
                                        data-image="{{ asset($image->image_path) }}" data-alt="Thumbnail {{ $index + 1 }}">
                                        <img src="{{ asset($image->image_path) }}" alt="Thumbnail {{ $index + 1 }}">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Product Info Column -->
                <div class="col-lg-6 product-info-col">
                    <div class="collection-tag" id="collection-tag">PREMIUM COLLECTION</div>
                    <h1 class="product-title" id="product-title">{{ $product->name }}</h1>
                    <div class="price-rating-row">
                        <span class="product-price" id="product-price">${{ number_format($product->price, 2) }}</span>
                        <div class="rating-stars" id="product-rating">
                            @php $fullStars = floor($avgRating); $halfStar = ($avgRating - $fullStars) >= 0.25; @endphp
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $fullStars)
                                    <i class="fa-solid fa-star"></i>
                                @elseif($halfStar && $i == $fullStars + 1)
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                @else
                                    <i class="fa-regular fa-star"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="review-count">({{ $reviewCount }} {{ Str::plural('review', $reviewCount) }})</span>
                    </div>
                    <p class="product-description" id="product-description">
                        {{ $product->description }}
                    </p>

                    <form action="{{ route('cart.add') }}" method="POST" id="add-to-cart-form">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <!-- Hidden inputs for frame selections -->
                        <input type="hidden" name="frame_material" id="input-frame-material" value="">
                        <input type="hidden" name="frame_color" id="input-frame-color" value="">
                        <input type="hidden" name="frame_size" id="input-frame-size" value="">

                        <!-- Frame Material -->
                        @php $materials = $product->frame_materials ?? []; @endphp
                        @if(count($materials) > 0)
                        <div class="option-label">Frame Material</div>
                        <div class="material-pills" id="material-pills">
                            @foreach($materials as $index => $mat)
                                <button type="button" class="material-pill {{ $index === 0 ? 'active' : '' }}" data-material="{{ $mat }}">{{ $mat }}</button>
                            @endforeach
                        </div>
                        @endif

                        <!-- Color Selection -->
                        @php $colors = $product->frame_colors ?? []; @endphp
                        @if(count($colors) > 0)
                        <div class="color-option-label">COLOR: <span id="color-name">{{ strtoupper($colors[0]['name'] ?? '') }}</span></div>
                        <div class="color-swatches-detail" id="color-swatches">
                            @foreach($colors as $index => $color)
                                <span class="swatch-circle {{ $index === 0 ? 'active' : '' }}" style="background:{{ $color['hex'] }};" data-color="{{ $color['name'] }}" title="{{ $color['name'] }}"></span>
                            @endforeach
                        </div>
                        @endif

                        <!-- Size Selector -->
                        @php $sizes = $product->frame_sizes ?? []; @endphp
                        @if(count($sizes) > 0)
                        <div class="size-header">
                            <div class="option-label mb-0">Size</div>
                            <a href="#" class="size-guide-link" id="size-guide-link">Size Guide</a>
                        </div>
                        <select class="size-select" id="size-select" name="size">
                            <option value="" disabled>Select a size</option>
                            @foreach($sizes as $index => $size)
                                <option value="{{ $size['value'] }}" {{ $index === 1 ? 'selected' : '' }}>{{ $size['label'] }}</option>
                            @endforeach
                        </select>
                        @endif

                        <!-- Purchase Options -->
                        <div class="purchase-options" id="purchase-options">
                            <div class="option-label">Purchase Option</div>
                            <label class="purchase-option selected" id="opt-frame-only">
                                <input type="radio" name="purchase-type" value="frame-only" checked>
                                <span class="po-check"><i class="fa-solid fa-check"></i></span>
                                <span class="po-icon"><i class="fa-solid fa-glasses"></i></span>
                                <div class="po-text">
                                    <h6>Frame Only</h6>
                                    <p>Buy the frame without prescription lenses.</p>
                                </div>
                            </label>
                            <label class="purchase-option" id="opt-frame-lens">
                                <input type="radio" name="purchase-type" value="frame-lens">
                                <span class="po-check"><i class="fa-solid fa-check"></i></span>
                                <span class="po-icon"><i class="fa-solid fa-eye"></i></span>
                                <div class="po-text">
                                    <h6>Frame + Prescription Lenses</h6>
                                    <p>Add custom lenses based on your vision needs.</p>
                                    <span class="po-price-hint"><i class="fa-solid fa-tag"></i> Starting from
                                        +$49.00</span>
                                </div>
                            </label>
                        </div>

                        <!-- Dynamic CTA Button -->
                        {{-- Frame Only: adds to cart then goes to checkout --}}
                        <button type="button" class="btn-add-to-cart" id="btn-frame-only"
                            data-product-id="{{ $product->id }}" style="display:inline-flex;">
                            <i class="fa-solid fa-arrow-right"></i>
                            Go to Checkout
                        </button>

                        {{-- Frame + Prescription Lenses: goes to prescription create --}}
                        <a href="{{ route('prescription.create', ['product_id' => $product->id]) }}" class="btn-add-to-cart"
                            id="btn-frame-lens" style="display:none; background:#1D3557; color:#fff; margin-top:8px;">
                            <i class="fa-solid fa-eye"></i>
                            Customize Your Lenses
                        </a>
                    </form>

                    <!-- Trust Badges -->
                    <div class="trust-badges" id="trust-badges">
                        <div class="trust-badge">
                            <i class="fa-solid fa-truck-fast"></i>
                            Free Shipping
                        </div>
                        <div class="trust-badge">
                            <i class="fa-solid fa-shield-halved"></i>
                            1 Year Warranty
                        </div>
                        <div class="trust-badge">
                            <i class="fa-solid fa-rotate-left"></i>
                            30-Day Returns
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== REVIEWS SECTION ========== -->
    <section class="reviews-section" id="reviews-section">
        <div class="container">
            <h2 class="reviews-title" id="reviews-title">Reviews ({{ $reviewCount }})</h2>
            <div class="row g-4">
                @forelse($productReviews as $review)
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
                            <p class="review-text">
                                {{ $review->comment }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted">
                        <p>No reviews yet for this product.</p>
                    </div>
                @endforelse
            </div>

            <!-- Review Form -->
            <div class="review-form-wrapper" id="review-form-wrapper">
                @auth
                    <h4><i class="fa-solid fa-pen-to-square"></i> Write a Review</h4>
                    <form id="review-submit-form">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="option-label" style="margin-bottom: 8px;">Your Rating</div>
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
                    <p style="color: var(--text-muted); font-size: 0.88rem; margin-bottom: 16px;">You must be signed in to leave a review.</p>
                    <a href="{{ route('login') }}" class="btn-submit-review">
                        <i class="fa-solid fa-right-to-bracket"></i> Sign In to Review
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- ========== RELATED PRODUCTS ========== -->
    <section class="related-section" id="related-section">
        <div class="container">
            <div class="related-header">
                <div>
                    <h2 class="related-title">You Might Also Like</h2>
                </div>
                <a href="{{ route('products.index') }}" class="view-all-link" id="view-all-link">View All <i
                        class="fa-solid fa-arrow-right" style="font-size:0.7rem;"></i></a>
            </div>
            <p class="related-subtitle">Curated selections based on your style preference.</p>

            <div class="row g-3" id="related-grid">
                @if(isset($relatedProducts))
                    @foreach($relatedProducts as $related)
                        <div class="col-6 col-md-3">
                            <a href="{{ $related->is_contact_lens ? route('prescription.create', ['product_id' => $related->id]) : route('products.show', $related->id) }}" style="text-decoration:none; color:inherit;">
                                <div class="related-card" id="related-{{ $related->id }}">
                                    <div class="related-card-img">
                                        <img src="{{ asset($related->image) }}" alt="{{ $related->name }}">
                                    </div>
                                    <div class="related-card-body">
                                        <h6>{{ $related->name }}</h6>
                                        <p class="related-desc">{{ Str::limit($related->description, 40) }}</p>
                                        <p class="related-price">${{ number_format($related->price, 2) }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
@endsection

@push('script')
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{!! session('success') !!}',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            });
        </script>
    @endif

    <script>
        $(document).ready(function () {

            // ---- Navbar scroll effect ----
            $(window).on('scroll', function () {
                $('#mainNavbar').toggleClass('scrolled', $(this).scrollTop() > 50);
            });

            // ---- Thumbnail click → swap main image ----
            $('#thumbnail-row').on('click', '.thumbnail-item', function () {
                var $this = $(this);
                var newSrc = $this.data('image');
                var newAlt = $this.data('alt') || 'Product image';

                // Remove active from all thumbnails
                $('.thumbnail-item').removeClass('active');
                $this.addClass('active');

                // Fade out → swap → fade in
                var $mainImg = $('#main-product-image');
                $mainImg.css('opacity', 0);
                setTimeout(function () {
                    $mainImg.attr('src', newSrc).attr('alt', newAlt);
                    $mainImg.css('opacity', 1);
                }, 250);
            });

            // ---- Gallery heart handler is below (AJAX-based) ----

            // ---- Frame Material pill toggle ----
            // Set initial hidden input values
            var $activeMat = $('.material-pill.active');
            if ($activeMat.length) $('#input-frame-material').val($activeMat.data('material'));
            var $activeColor = $('.swatch-circle.active');
            if ($activeColor.length) $('#input-frame-color').val($activeColor.data('color'));
            var $sizeSelect = $('#size-select');
            if ($sizeSelect.length) $('#input-frame-size').val($sizeSelect.val());

            $('#material-pills').on('click', '.material-pill', function () {
                $('.material-pill').removeClass('active');
                $(this).addClass('active');
                $('#input-frame-material').val($(this).data('material'));
            });

            // ---- Color swatch toggle ----
            $('#color-swatches').on('click', '.swatch-circle', function () {
                $('.swatch-circle').removeClass('active');
                $(this).addClass('active');
                // Update color name label + hidden input
                var colorName = $(this).data('color') || '';
                $('#color-name').text(colorName.toUpperCase());
                $('#input-frame-color').val(colorName);
            });

            // ---- Size select → update hidden input ----
            $('#size-select').on('change', function () {
                $('#input-frame-size').val($(this).val());
            });

            // ---- Purchase Option Toggle ----
            // Show/hide the correct CTA button based on selected purchase option
            var prescribeUrl = "{{ route('prescription.create') }}";
            var checkoutUrl = "{{ route('checkout.index') }}";
            var productId = {{ $product->id }};

            function syncPurchaseButtons() {
                var val = $('input[name="purchase-type"]:checked').val();
                if (val === 'frame-lens') {
                    $('#btn-frame-only').hide();
                    $('#btn-frame-lens').show();
                    // Update the href to include product_id
                    $('#btn-frame-lens').attr('href', prescribeUrl + '?product_id=' + productId);
                } else {
                    $('#btn-frame-only').show();
                    $('#btn-frame-lens').hide();
                }
            }

            $('.purchase-option').on('click', function () {
                $('.purchase-option').removeClass('selected');
                $(this).addClass('selected');
                syncPurchaseButtons();
            });

            // Initialise on page load
            syncPurchaseButtons();

            // ---- Frame Only: Go directly to checkout (skip cart) ----
            $('#btn-frame-only').on('click', function () {
                var $btn = $(this);
                var pid  = $btn.data('product-id');
                $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');
                var params = 'frame_only=' + pid;
                params += '&frame_material=' + encodeURIComponent($('#input-frame-material').val() || '');
                params += '&frame_color=' + encodeURIComponent($('#input-frame-color').val() || '');
                params += '&frame_size=' + encodeURIComponent($('#input-frame-size').val() || '');
                window.location.href = '{{ route("checkout.index") }}?' + params;
            });

            // ---- Review card hover micro-interaction (jQuery) ----
            $('.review-card').on('mouseenter', function () {
                $(this).find('.reviewer-avatar').css('transform', 'scale(1.08)');
            }).on('mouseleave', function () {
                $(this).find('.reviewer-avatar').css('transform', 'scale(1)');
            });
            // Smooth avatar transitions
            $('.reviewer-avatar').css('transition', 'transform 0.3s ease');

            // ---- Related product card click ----
            $('.related-card').on('click', function () {
                // Placeholder — would navigate to product detail
            });

            // ---- Gallery heart / wishlist toggle ----
            $('.gallery-heart').on('click', function (e) {
                e.preventDefault();
                var $btn = $(this);
                var $icon = $btn.find('i');
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
                    $.ajax({
                        url: '{{ route('favorites.store') }}',
                        type: 'POST',
                        data: { _token: '{{ csrf_token() }}', product_id: productId },
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

                $('.review-card, .related-card, .product-gallery, .product-info-col').each(function () {
                    this.style.opacity = '0';
                    observer.observe(this);
                });
            }

            // ---- Star Selector (Review Form) ----
            $('#star-selector i').on('click', function () {
                var val = $(this).data('value');
                $('#rating-input').val(val);
                // Highlight stars up to selected
                $('#star-selector i').each(function () {
                    if ($(this).data('value') <= val) {
                        $(this).removeClass('fa-regular').addClass('fa-solid active');
                    } else {
                        $(this).removeClass('fa-solid active').addClass('fa-regular');
                    }
                });
            });

            // Hover preview for stars
            $('#star-selector i').on('mouseenter', function () {
                var val = $(this).data('value');
                $('#star-selector i').each(function () {
                    if ($(this).data('value') <= val) {
                        $(this).addClass('active');
                    } else {
                        $(this).removeClass('active');
                    }
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

                if (rating < 1) {
                    Swal.fire({ icon: 'warning', title: 'Please select a rating', text: 'Click on the stars above to rate this product.', confirmButtonColor: '#1D3557' });
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
                            // Build star HTML
                            var starsHtml = '';
                            for (var i = 1; i <= 5; i++) {
                                starsHtml += i <= response.review.rating
                                    ? '<i class="fa-solid fa-star"></i>'
                                    : '<i class="fa-regular fa-star"></i>';
                            }

                            // Build new review card
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

                            // Prepend to reviews grid
                            var $grid = $('#reviews-section .row.g-4');
                            $grid.find('.text-center.text-muted').parent().remove(); // remove "no reviews" message if present
                            $grid.prepend(cardHtml);

                            // Update review count in title
                            var $title = $('#reviews-title');
                            var currentCount = parseInt($title.text().match(/\d+/) || 0) + 1;
                            $title.text('Reviews (' + currentCount + ')');

                            // Reset form
                            $('#review-comment').val('');
                            $('#rating-input').val('0');
                            $('#star-selector i').removeClass('fa-solid active').addClass('fa-regular');

                            // Toast
                            Swal.fire({
                                toast: true,
                                position: 'bottom-end',
                                icon: 'success',
                                title: response.message || 'Review submitted!',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });
                        }
                    },
                    error: function (xhr) {
                        var errMsg = 'Failed to submit review.';
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
                        $btn.prop('disabled', false).html(origHtml);
                    }
                });
            });
        });
    </script>
@endpush