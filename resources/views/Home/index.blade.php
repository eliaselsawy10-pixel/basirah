@extends('layouts.app')
@section('title', 'Basirah — Premium Wholesale Optical Supplies')
@section('description_content', 'Basirah — Premium wholesale optical supplies for independent practices and retail. Shop eyeglasses, contact lenses, and more.')

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

        /* ========================================
                           NAVBAR
                        ======================================== */
        .navbar-basirah {
            background: #fff;
            padding: 12px 0;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
            position: sticky;
            top: 0;
            z-index: 1050;
            transition: var(--transition);
        }

        .navbar-basirah.scrolled {
            box-shadow: var(--shadow-sm);
        }

        .navbar-brand-logo {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 800;
            font-size: 1.35rem;
            color: var(--text-primary);
        }

        .navbar-brand-logo .logo-icon {
            width: 32px;
            height: 32px;
            background: var(--primary);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            color: var(--dark);
        }

        .navbar-basirah .nav-link {
            color: var(--text-secondary);
            font-weight: 500;
            font-size: 0.9rem;
            padding: 8px 16px !important;
            border-radius: var(--radius-sm);
            transition: var(--transition);
            position: relative;
        }

        .navbar-basirah .nav-link:hover,
        .navbar-basirah .nav-link.active {
            color: var(--text-primary);
        }

        .navbar-basirah .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 2px;
            left: 16px;
            right: 16px;
            height: 2px;
            background: var(--primary-dark);
            border-radius: 2px;
        }

        .btn-sign-in {
            background: transparent;
            border: 1.5px solid var(--border-light);
            color: var(--text-primary);
            font-weight: 500;
            font-size: 0.85rem;
            padding: 7px 20px;
            border-radius: var(--radius-sm);
            transition: var(--transition);
        }

        .btn-sign-in:hover {
            border-color: var(--primary-dark);
            color: var(--primary-dark);
        }

        .btn-register {
            background: var(--text-primary);
            color: #fff;
            font-weight: 500;
            font-size: 0.85rem;
            padding: 7px 20px;
            border: 1.5px solid var(--text-primary);
            border-radius: var(--radius-sm);
            transition: var(--transition);
        }

        .btn-register:hover {
            background: #2d2d4e;
            border-color: #2d2d4e;
            color: #fff;
            transform: translateY(-1px);
        }

        /* Search Box (Authenticated Navbar) */
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
            color: var(--text-primary);
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
            border-color: var(--text-primary);
            box-shadow: 0 0 0 3px rgba(26, 26, 46, 0.06);
        }

        .navbar-search-input::placeholder {
            color: rgba(26, 26, 46, 0.35);
        }

        /* Icon Buttons (Search, Fav, Cart) */
        .btn-nav-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: transparent;
            border: none;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            transition: all 0.25s ease;
            position: relative;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-nav-icon:hover {
            color: var(--text-primary);
            background: #f0f4f8;
        }

        /* Badges */
        .btn-nav-icon .nav-badge {
            position: absolute;
            top: 0px;
            right: -2px;
            min-width: 18px;
            height: 18px;
            background: var(--text-primary);
            color: #fff;
            font-size: 0.6rem;
            font-weight: 700;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #fff;
        }

        /* ========================================
                           HERO SECTION
                        ======================================== */
        .hero-section {
            background: linear-gradient(135deg, #f0f4f8 0%, #e8eef5 50%, #dce6f0 100%);
            padding: 80px 0 0;
            min-height: 520px;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(189, 227, 249, 0.3) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            margin-bottom: 100px;
        }

        .hero-content h1 {
            font-size: 3.2rem;
            font-weight: 800;
            line-height: 1.15;
            color: var(--text-primary);
            margin-bottom: 32px;
            letter-spacing: -0.02em;
        }

        .btn-shop-hero {
            background: var(--primary);
            color: var(--text-primary);
            font-weight: 600;
            font-size: 1rem;
            padding: 14px 36px;
            border: none;
            border-radius: var(--radius-md);
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;

        }

        .btn-shop-hero:hover {
            background: var(--primary-hover);
            color: var(--text-primary);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(189, 227, 249, 0.5);
        }

        .hero-image-wrapper {
            position: relative;
            z-index: 2;
            text-align: right;
        }

        .hero-image-wrapper img {
            max-height: 460px;
            object-fit: cover;
            object-position: top center;
        }

        .section-heading {
            text-align: center;
            margin-bottom: 48px;
        }

        .section-heading h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
            letter-spacing: -0.01em;
        }

        .section-heading p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .section-divider {
            width: 50px;
            height: 3px;
            background: var(--primary);
            margin: 12px auto 0;
            border-radius: 3px;
        }

        /* ========================================
                           WHOLESALE CATEGORIES
                        ======================================== */
        .categories-section {
            padding: 80px 0;
            background: #fff;
        }

        .category-card {
            text-align: center;
            transition: var(--transition);
            cursor: pointer;
        }

        .category-card:hover {
            transform: translateY(-6px);
        }

        .category-img-wrapper {
            width: 250px;
            height: 250px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto 20px;
            border: 4px solid #f0f0f0;
            transition: var(--transition);
            position: relative;

        }

        .category-card:hover .category-img-wrapper {
            border-color: var(--primary);
            box-shadow: 0 8px 30px rgba(189, 227, 249, 0.4);
        }

        .category-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .category-label {
            position: absolute;
            bottom: 12px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(8px);
            padding: 4px 18px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--text-primary);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-shop-category {
            background: var(--primary);
            color: var(--text-primary);
            font-weight: 600;
            font-size: 0.85rem;
            padding: 10px 28px;
            border: none;
            border-radius: var(--radius-sm);
            transition: var(--transition);
        }

        .btn-shop-category:hover {
            background: var(--primary-hover);
            color: var(--text-primary);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(189, 227, 249, 0.4);
        }

        /* ========================================
                           BEST SELLERS
                        ======================================== */
        .bestsellers-section {
            padding: 80px 0;
            background: var(--section-bg);
        }

        .product-card {
            background: var(--card-bg);
            border-radius: var(--radius-lg);
            overflow: hidden;
            border: 1px solid var(--border-light);
            transition: var(--transition);
            position: relative;
        }

        .product-card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-6px);
            border-color: var(--primary);
        }

        .product-card .heart-icon {
            position: absolute;
            top: 16px;
            right: 16px;
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(4px);
            border: 1px solid var(--border-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            z-index: 5;
            color: var(--text-muted);
            font-size: 0.9rem;
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

        .product-img-wrapper {
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: #fafafa;
        }

        .product-img-wrapper img {
            max-height: 140px;
            object-fit: contain;
            transition: var(--transition);
        }

        .product-card:hover .product-img-wrapper img {
            transform: scale(1.05);
        }

        .product-info {
            padding: 20px;
        }

        .product-info h5 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .product-info .product-desc {
            font-size: 0.78rem;
            color: var(--text-muted);
            margin-bottom: 16px;
            line-height: 1.4;
        }

        .product-info .product-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .product-info .price {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-primary);
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
            color: #1D3557;
            border: 1px solid #1D3557;
            border-radius: var(--radius-sm);
            transition: var(--transition);
            flex-shrink: 0;
            text-decoration: none;
        }

        .btn-view-details:hover {
            background: #1D3557;
            color: #fff;
            transform: translateY(-1px);
        }

        .btn-add-cart {
            background: #1D3557;
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
            background: #274b78;
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(29, 53, 87, 0.3);
        }

        /* ========================================
                           FEATURED SECTION
                        ======================================== */
        .featured-section {
            padding: 80px 0;
            background: #fff;
        }

        .featured-card {
            text-align: center;
            transition: var(--transition);
        }

        .featured-card:hover {
            transform: translateY(-6px);
        }

        .featured-img-wrapper {
            height: 220px;
            border-radius: var(--radius-lg);
            overflow: hidden;
            margin-bottom: 24px;
            box-shadow: var(--shadow-sm);
        }

        .featured-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }


        .featured-card:hover .featured-img-wrapper img {
            transform: scale(1.05);
        }

        .featured-card h4 {
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .featured-card p {
            font-size: 0.82rem;
            color: var(--text-muted);
            margin-bottom: 20px;
            line-height: 2;
            padding: 0 10px;
        }

        .btn-featured {
            background: var(--primary);
            color: var(--text-primary);
            font-weight: 600;
            font-size: 0.85rem;
            padding: 12px 28px;
            border: none;
            border-radius: var(--radius-sm);
            transition: var(--transition);
        }

        .btn-featured:hover {
            background: var(--primary-hover);
            color: var(--text-primary);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(189, 227, 249, 0.4);
        }

        /* ========================================
                           QUOTES / TESTIMONIALS
                        ======================================== */
        .quotes-section {
            padding: 80px 0;
            background: var(--section-bg);
        }

        .quotes-section h2 {
            text-align: center;
        }

        .quotes-section .text-start {
            position: relative;
        }

        .quotes-section .text-start::after {
            position: absolute;
            content: "";
            bottom: -1;
            right: 48%;
            background-color: var(--primary-dark);
            height: 2px;
            width: 50px;
        }

        .quote-card {
            background: var(--card-bg);
            border-radius: var(--radius-md);
            padding: 28px 24px;
            border: 1px solid var(--border-light);
            transition: var(--transition);
            min-height: 100%;
        }

        .quote-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-4px);
            border-color: var(--primary);
        }

        .quote-card .quote-text {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 16px;
            font-style: italic;
        }

        .quote-card .quote-text::before {
            content: '\201C';
            font-size: 1.5rem;
            color: var(--primary-dark);
            margin-right: 2px;
        }

        .quote-card .quote-text::after {
            content: '\201D';
            font-size: 1.5rem;
            color: var(--primary-dark);
            margin-left: 2px;
        }

        .quote-author {
            display: flex;
            /* align-items: center; */
            gap: 12px;
        }

        .quote-author-info .stars {
            color: #ffc107;
            font-size: 14px;
        }

        .quote-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            background: var(--primary);
        }

        .quote-author-info .author-title {
            font-size: 0.8rem;
            color: var(--primary-dark);
            font-weight: 600;
            display: block;
        }

        .quote-author-info .author-desc {
            font-size: 0.75rem;
            color: var(--text-muted);
            display: block;
            margin-top: 5px;
        }

        /* ========================================
                           FOOTER
                        ======================================== */
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
            font-size: 0.78rem;
            color: var(--text-muted);
        }

        .footer-bottom-links a:hover {
            color: var(--primary-dark);
        }

        @media (max-width: 991.98px) {
            .hero-content h1 {
                font-size: 2.4rem;
            }

            .hero-section {
                padding: 60px 0 0;
                min-height: auto;
            }

            .hero-image-wrapper {
                text-align: center;
                margin-top: 40px;
            }

            .hero-image-wrapper img {
                max-height: 350px;
            }

            .category-img-wrapper {
                width: 160px;
                height: 160px;
            }
        }

        @media (max-width: 767.98px) {
            .hero-content h1 {
                font-size: 2rem;
            }

            .section-heading h2 {
                font-size: 1.4rem;
            }

            .categories-section,
            .bestsellers-section,
            .featured-section,
            .quotes-section {
                padding: 50px 0;
            }

            .category-img-wrapper {
                width: 140px;
                height: 140px;
            }

            .footer-bottom-links {
                justify-content: flex-start;
                flex-wrap: wrap;
                gap: 12px;
                margin-top: 10px;
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
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-in {
            animation: fadeInUp 0.6s ease forwards;
        }

        .delay-1 {
            animation-delay: 0.1s;
        }

        .delay-2 {
            animation-delay: 0.2s;
        }

        .delay-3 {
            animation-delay: 0.3s;
        }

        /* ========== FEEDBACK FORM ========== */
        .feedback-form-wrapper {
            margin-top: 40px;
            background: var(--card-bg);
            border-radius: var(--radius-md);
            padding: 32px;
            border: 1px solid var(--border-light);
        }

        .feedback-form-wrapper h4 {
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
            color: #ffc107;
        }

        .feedback-textarea {
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

        .feedback-textarea:focus {
            outline: none;
            border-color: var(--primary-dark);
            box-shadow: 0 0 0 3px rgba(189, 227, 249, 0.4);
        }

        .feedback-textarea::placeholder {
            color: var(--text-muted);
        }

        .btn-submit-feedback {
            background: var(--text-primary);
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
            text-decoration: none;
        }

        .btn-submit-feedback:hover {
            background: #2d2d4e;
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(26, 26, 46, 0.2);
        }

        .btn-submit-feedback:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .option-label-sm {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-primary);
            margin-bottom: 8px;
        }
    </style>
@endpush

@section('navbar')
    @include('layouts.partials.navbar-home')
@endsection

@section('content')
    <section class="hero-section" id="hero">
        <div class="container">
            <div class="row align-items-end">
                <div class="col-lg-6 hero-content">
                    <h1>Find out what's<br>best for your face</h1>
                    <a href="{{ route('products.index') }}" class="btn btn-shop-hero" id="btn-hero-shop">
                        Shop Now
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
                <div class="col-lg-6 hero-image-wrapper">
                    <img src="{{ asset('images/Hero__.png') }}" alt="Man wearing stylish eyeglasses" id="hero-image">
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================
                                WHOLESALE CATEGORIES
                            ============================================= -->
    <section class="categories-section" id="categories">
        <div class="container">
            <div class="section-heading">
                <h2>Wholesale Optical Supplies to Choose From</h2>
                <div class="section-divider"></div>
            </div>

            <div class="row g-4 justify-content-center">
                <!-- Men -->
                <div class="col-md-4 col-sm-6">
                    <div class="category-card" id="category-men">
                        <div class="category-img-wrapper">
                            <img src="{{ asset('images/men.png') }}" alt="Men's eyewear collection">
                            <span class="category-label">Men</span>
                        </div>
                        <a href="{{ route('products.category', 'Men') }}" class="btn btn-shop-category">Shop Now</a>
                    </div>
                </div>
                <!-- Kids -->
                <div class="col-md-4 col-sm-6">
                    <div class="category-card" id="category-kids">
                        <div class="category-img-wrapper">
                            <img src="{{ asset('images/kids.png') }}" alt="Kids eyewear collection">
                            <span class="category-label">Kids</span>
                        </div>
                        <a href="{{ route('products.category', 'Kids') }}" class="btn btn-shop-category">Shop Now</a>
                    </div>
                </div>
                <!-- Woman -->
                <div class="col-md-4 col-sm-6">
                    <div class="category-card" id="category-woman">
                        <div class="category-img-wrapper">
                            <img src="{{ asset('images/women.png') }}" alt="Women's eyewear collection">
                            <span class="category-label">Women</span>
                        </div>
                        <a href="{{ route('products.category', 'Women') }}" class="btn btn-shop-category">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================
                                BEST SELLERS
                            ============================================= -->
    <section class="bestsellers-section" id="bestsellers">
        <div class="container">
            <div class="section-heading">
                <h2>BEST SELLERS</h2>
                <div class="section-divider"></div>
            </div>

            <div class="row g-4">
                @if(isset($bestSellers) && $bestSellers->count() > 0)
                    @foreach($bestSellers as $product)
                        <div class="col-lg-4 col-md-6">
                            <div class="product-card" id="product-{{ $product->id }}">
                                @php $isFav = isset(session('favorites', [])[$product->id]); @endphp
                                <span class="heart-icon {{ $isFav ? 'active' : '' }}" data-id="{{ $product->id }}"><i
                                        class="{{ $isFav ? 'fa-solid' : 'fa-regular' }} fa-heart"></i></span>
                                <div class="product-img-wrapper">
                                    <a href="{{ $product->is_contact_lens ? route('prescription.create', ['product_id' => $product->id]) : route('products.show', $product->id) }}">
                                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }} eyeglasses">
                                    </a>
                                </div>
                                <div class="product-info">
                                    <div class="product-bottom">
                                        <h5>{{ $product->name }}</h5>
                                        <span class="price">${{ number_format($product->price, 2) }}</span>
                                    </div>
                                    <p class="product-desc">{{ Str::limit($product->description, 30) }}</p>
                                    <div class="btn-action-group">
                                        <a href="{{ $product->is_contact_lens ? route('prescription.create', ['product_id' => $product->id]) : route('products.show', $product->id) }}" class="btn-view-details"
                                            title="View Details">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form" style="width:100%;">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <button type="submit" class="btn-add-cart btn-primary" data-product="{{ $product->name }}">
                                                <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center text-muted">
                        <p>No best sellers found right now. Check back later!</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- ============================================
                                FEATURED ON BASIRAH
                            ============================================= -->
    <section class="featured-section" id="featured">
        <div class="container">
            <div class="section-heading">
                <h2>Featured On Basirah</h2>
                <div class="section-divider"></div>
            </div>

            <div class="row g-4">
                <!-- Eyeglasses Lenses -->
                <div class="col-md-4">
                    <div class="featured-card" id="featured-eyeglasses">
                        <div class="featured-img-wrapper">
                            <img src="{{ asset('images/feature1.png') }}" alt="Eyeglasses Lenses collection">
                        </div>
                        <h4>Eyeglasses Lenses</h4>
                        <p>Shop from a Perfect Collection of Eyeglasses Lenses from Premium, Economy and Standard Brands
                        </p>
                        <a href="javascript:void(0)" class="btn btn-featured" id="lens-shop-link">Shop Now</a>
                    </div>
                </div>
                <!-- Contact Lenses -->
                <div class="col-md-4">
                    <div class="featured-card" id="featured-contact">
                        <div class="featured-img-wrapper">
                            <img src="{{ asset('images/feature2.png') }}" alt="Contact Lenses">
                        </div>
                        <h4>Contact Lenses</h4>
                        <p>Pick your Lenses from a Variety of Clear & Colored Contact Lenses</p>
                        <a href="{{ route('products.color-lenses') }}" class="btn btn-featured" id="contact-lens-link">Shop
                            Now</a>
                    </div>
                </div>
                <!-- Consult a Doctor -->
                <div class="col-md-4">
                    <div class="featured-card" id="featured-doctor">
                        <div class="featured-img-wrapper">
                            <img class="doctor" src="{{ asset('images/feature3.png') }}" alt="Consult a Doctor">
                        </div>
                        <h4>Consult a Doctor</h4>
                        <p>Inquire about certain eye dimensions and any other consultations</p>
                        <a href="{{ route('appointments.index') }}" class="btn btn-featured">Consult Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================
                                QUOTES / TESTIMONIALS
                            ============================================= -->
    <section class="quotes-section" id="quotes">
        <div class="container">
            <div class="section-heading text-start">
                <h2>Feedbacks</h2>
            </div>

            <div class="row g-3">
                @forelse($siteReviews as $review)
                    <div class="col-lg-3 col-md-6">
                        <div class="quote-card" id="quote-{{ $review->id }}">
                            <div class="quote-author">
                                <img src="{{ asset('images/Avatar.png') }}" alt="{{ $review->reviewer_name }} avatar" class="quote-avatar">
                                <div class="quote-author-info">
                                    <span class="author-title">{{ $review->reviewer_name }}</span>
                                    <div class="stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <span><i class="bi bi-star-fill"></i></span>
                                            @elseif($i - 0.5 <= $review->rating)
                                                <span><i class="bi bi-star-half"></i></span>
                                            @else
                                                <span><i class="bi bi-star"></i></span>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="author-desc">{{ $review->comment }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted">
                        <p>No reviews yet. Be the first to leave feedback!</p>
                    </div>
                @endforelse
            </div>

            <!-- Feedback Form -->
            <div class="feedback-form-wrapper" id="feedback-form-wrapper">
                @auth
                    <h4><i class="fa-solid fa-comment-dots"></i> Share Your Feedback</h4>
                    <form id="feedback-submit-form">
                        @csrf
                        <div class="option-label-sm">Your Rating</div>
                        <div class="star-selector" id="site-star-selector">
                            <i class="fa-regular fa-star" data-value="1"></i>
                            <i class="fa-regular fa-star" data-value="2"></i>
                            <i class="fa-regular fa-star" data-value="3"></i>
                            <i class="fa-regular fa-star" data-value="4"></i>
                            <i class="fa-regular fa-star" data-value="5"></i>
                        </div>
                        <input type="hidden" name="rating" id="site-rating-input" value="0">
                        <textarea name="comment" class="feedback-textarea" id="site-feedback-comment" placeholder="Tell us about your experience with Basirah..."></textarea>
                        <button type="submit" class="btn-submit-feedback" id="btn-submit-feedback">
                            <i class="fa-solid fa-paper-plane"></i> Submit Feedback
                        </button>
                    </form>
                @else
                    <h4><i class="fa-solid fa-comment-dots"></i> Share Your Feedback</h4>
                    <p style="color: var(--text-muted); font-size: 0.88rem; margin-bottom: 16px;">Sign in to share your experience with Basirah.</p>
                    <a href="{{ route('login') }}" class="btn-submit-feedback">
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

            // ========================================
            // NAVBAR SCROLL EFFECT
            // ========================================
            $(window).on('scroll', function () {
                if ($(this).scrollTop() > 50) {
                    $('#mainNavbar').addClass('scrolled');
                } else {
                    $('#mainNavbar').removeClass('scrolled');
                }
            });

            // ========================================
            // PRODUCT CARD HOVER EFFECTS
            // ========================================
            $('.product-card').on('mouseenter', function () {
                $(this).css({
                    'box-shadow': '0 12px 40px rgba(29,53,87,0.15)',
                    'border-color': '#c5dced'
                });
                $(this).find('.btn-add-cart').css({
                    'background': '#274b78',
                    'transform': 'scale(1.02)'
                });
            }).on('mouseleave', function () {
                $(this).css({
                    'box-shadow': '',
                    'border-color': ''
                });
                $(this).find('.btn-add-cart').css({
                    'background': '',
                    'transform': ''
                });
            });

            // ========================================
            // ADD TO CART AJAX HANDLER
            // ========================================
            $(document).on('submit', '.add-to-cart-form', function (e) {
                e.preventDefault(); // Prevent page refresh
                
                var $form = $(this);
                var $btn = $(this).find('button');
                var origHtml = $btn.html();

                // Show loading state & disable button
                $btn.prop('disabled', true)
                    .html('<i class="fas fa-spinner fa-spin"></i> Processing...')
                    .removeClass('btn-primary btn-success')
                    .css({ 'background': '#274b78', 'color': '#fff' });

                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: $form.serialize(),
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
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
                                    // Re-submit with force flag
                                    $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Adding...').css({ 'background': '#274b78', 'color': '#fff' });
                                    $.ajax({
                                        url: $form.attr('action'),
                                        type: 'POST',
                                        data: $form.serialize() + '&force=1',
                                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
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

            // ========================================
            // HEART / WISHLIST TOGGLE (AJAX)
            // ========================================
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

            // ========================================
            // SCROLL REVEAL ANIMATION (Intersection Observer)
            // ========================================
            var observerOptions = {
                threshold: 0.15,
                rootMargin: '0px 0px -40px 0px'
            };

            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        $(entry.target).addClass('animate-in');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            // Observe cards and sections
            $('.product-card, .category-card, .featured-card, .quote-card').each(function () {
                this.style.opacity = '0';
                observer.observe(this);
            });

            // ========================================
            // SMOOTH SCROLL FOR NAV LINKS
            // ========================================
            $('a[href^="#"]').on('click', function (e) {
                var target = $(this.getAttribute('href'));
                if (target.length) {
                    e.preventDefault();
                    $('html, body').animate({
                        scrollTop: target.offset().top - 80
                    }, 600);
                }
            });

            // ========================================
            // EYEGLASSES LENSES - SWEET ALERT
            // ========================================
            $('#lens-shop-link').on('click', function (e) {
                e.preventDefault();
                Swal.fire({
                    icon: 'info',
                    title: 'Frame Required First',
                    text: 'You must get a frame first before ordering eyeglasses lenses.',
                    confirmButtonText: 'Get a frame <i class="fa-solid fa-arrow-right"></i>',
                    confirmButtonColor: '#68B8E8',
                    showCancelButton: true,
                    cancelButtonText: 'Cancel',
                    cancelButtonColor: '#d1d5db'
                }).then(function (result) {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route("products.index") }}';
                    }
                });
            });

            // ========================================
            // SITE FEEDBACK - STAR SELECTOR
            // ========================================
            $('#site-star-selector i').on('click', function () {
                var val = $(this).data('value');
                $('#site-rating-input').val(val);
                $('#site-star-selector i').each(function () {
                    if ($(this).data('value') <= val) {
                        $(this).removeClass('fa-regular').addClass('fa-solid active');
                    } else {
                        $(this).removeClass('fa-solid active').addClass('fa-regular');
                    }
                });
            });

            $('#site-star-selector i').on('mouseenter', function () {
                var val = $(this).data('value');
                $('#site-star-selector i').each(function () {
                    if ($(this).data('value') <= val) {
                        $(this).addClass('active');
                    } else {
                        $(this).removeClass('active');
                    }
                });
            });

            $('#site-star-selector').on('mouseleave', function () {
                var selected = parseInt($('#site-rating-input').val());
                $('#site-star-selector i').each(function () {
                    if ($(this).data('value') <= selected) {
                        $(this).removeClass('fa-regular').addClass('fa-solid active');
                    } else {
                        $(this).removeClass('fa-solid active').addClass('fa-regular');
                    }
                });
            });

            // ========================================
            // SITE FEEDBACK - FORM SUBMISSION (AJAX)
            // ========================================
            $('#feedback-submit-form').on('submit', function (e) {
                e.preventDefault();

                var rating = parseInt($('#site-rating-input').val());
                var comment = $('#site-feedback-comment').val().trim();

                if (rating < 1) {
                    Swal.fire({ icon: 'warning', title: 'Please select a rating', text: 'Click on the stars to rate your experience.', confirmButtonColor: '#1a1a2e' });
                    return;
                }
                if (comment.length < 5) {
                    Swal.fire({ icon: 'warning', title: 'Feedback too short', text: 'Please write at least 5 characters.', confirmButtonColor: '#1a1a2e' });
                    return;
                }

                var $btn = $('#btn-submit-feedback');
                var origHtml = $btn.html();
                $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Submitting...');

                $.ajax({
                    url: '{{ route("reviews.store") }}',
                    type: 'POST',
                    data: $(this).serialize(),
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function (response) {
                        if (response.success) {
                            // Build star icons
                            var starsHtml = '';
                            for (var i = 1; i <= 5; i++) {
                                starsHtml += i <= response.review.rating
                                    ? '<span><i class="bi bi-star-fill"></i></span>'
                                    : '<span><i class="bi bi-star"></i></span>';
                            }

                            // Build new card
                            var cardHtml = '<div class="col-lg-3 col-md-6">' +
                                '<div class="quote-card animate-in" id="quote-' + response.review.id + '">' +
                                    '<div class="quote-author">' +
                                        '<img src="{{ asset("images/Avatar.png") }}" alt="' + response.review.reviewer_name + ' avatar" class="quote-avatar">' +
                                        '<div class="quote-author-info">' +
                                            '<span class="author-title">' + response.review.reviewer_name + '</span>' +
                                            '<div class="stars">' + starsHtml + '</div>' +
                                            '<span class="author-desc">' + response.review.comment + '</span>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>';

                            // Prepend to grid
                            var $grid = $('#quotes .row.g-3');
                            $grid.find('.text-center.text-muted').parent().remove();
                            $grid.prepend(cardHtml);

                            // Reset form
                            $('#site-feedback-comment').val('');
                            $('#site-rating-input').val('0');
                            $('#site-star-selector i').removeClass('fa-solid active').addClass('fa-regular');

                            Swal.fire({
                                toast: true,
                                position: 'bottom-end',
                                icon: 'success',
                                title: response.message || 'Feedback submitted!',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });
                        }
                    },
                    error: function (xhr) {
                        var errMsg = 'Failed to submit feedback.';
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