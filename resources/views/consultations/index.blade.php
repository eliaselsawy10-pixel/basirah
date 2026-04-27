@extends('layouts.app')
@section('title', 'Consult an Eye Doctor — Basirah Optical')
@section('description', 'Consult an Eye Doctor — Book a virtual consultation with certified optometrists and ophthalmologists at Basirah. Get professional advice on lens prescriptions, eye health, and surgical options.')
@push('style')
    <style>
    /* ========================================
           CSS CUSTOM PROPERTIES
        ======================================== */
    :root {
        --primary: #BDE3F9;
        --primary-hover: #9AD4F5;
        --primary-dark: #68B8E8;
        --accent: #007BFF;
        --dark: #1D3557;
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
        background: #BDE3F9;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        color: #1D3557;
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

    .nav-link-consult {
        color: var(--accent) !important;
        font-weight: 600 !important;
    }

    .nav-link-consult::after {
        content: '' !important;
        position: absolute !important;
        bottom: 2px !important;
        left: 16px !important;
        right: 16px !important;
        height: 2px !important;
        background: var(--accent) !important;
        border-radius: 2px !important;
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

    .cart-icon {
        position: relative;
        color: var(--text-primary);
        font-size: 1.1rem;
        cursor: pointer;
        transition: var(--transition);
    }

    .cart-icon:hover {
        color: var(--accent);
    }

    .cart-badge {
        position: absolute;
        top: -6px;
        right: -8px;
        width: 16px;
        height: 16px;
        background: var(--accent);
        color: #fff;
        font-size: 0.6rem;
        font-weight: 700;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* ========================================
           PAGE HERO
        ======================================== */
    .page-hero {
        padding: 48px 0 16px;
        background: #fff;
    }

    .page-hero h1 {
        font-size: 2rem;
        font-weight: 800;
        color: var(--dark);
        margin-bottom: 12px;
        letter-spacing: -0.02em;
    }

    .page-hero p {
        color: var(--text-secondary);
        font-size: 0.92rem;
        max-width: 520px;
        line-height: 1.7;
    }

    /* ========================================
           MAIN CONTENT
        ======================================== */
    .main-content {
        padding: 32px 0 60px;
        background: var(--section-bg);
    }

    /* ========================================
           AVAILABLE SPECIALISTS
        ======================================== */
    .specialists-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
    }

    .specialists-header h2 {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--dark);
    }

    .filter-dropdown {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23555' viewBox='0 0 16 16'%3E%3Cpath d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E") no-repeat right 14px center;
        border: 1.5px solid #e0e0e0;
        border-radius: var(--radius-sm);
        padding: 8px 36px 8px 14px;
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--text-secondary);
        font-family: var(--font-family);
        cursor: pointer;
        transition: var(--transition);
    }

    .filter-dropdown:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.12);
    }

    /* ========================================
           DOCTOR CARD
        ======================================== */
    .doctor-card {
        background: #fff;
        border: 1.5px solid #e8ecf0;
        border-radius: var(--radius-lg);
        padding: 24px;
        margin-bottom: 20px;
        transition: var(--transition);
        position: relative;
    }

    .doctor-card:hover {
        border-color: var(--primary-dark);
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }

    .doctor-card-inner {
        display: flex;
        gap: 20px;
    }

    .doctor-avatar {
        flex-shrink: 0;
    }

    .doctor-avatar img {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--primary);
    }

    .doctor-info {
        flex: 1;
        min-width: 0;
    }

    .doctor-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 4px;
        gap: 12px;
    }

    .doctor-name {
        font-size: 1.08rem;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
    }

    .doctor-rating {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 0.82rem;
        color: var(--text-secondary);
        white-space: nowrap;
    }

    .doctor-rating .fa-star {
        color: #f5a623;
        font-size: 0.78rem;
    }

    .doctor-title {
        font-size: 0.85rem;
        font-weight: 600;
        color: #0ea5a0;
        margin-bottom: 8px;
    }

    .doctor-bio {
        font-size: 0.82rem;
        color: var(--text-muted);
        line-height: 1.6;
        margin-bottom: 12px;
    }

    .doctor-actions {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 6px;
        flex-shrink: 0;
    }

    .btn-select-slot {
        background: var(--primary);
        color: var(--dark);
        font-weight: 600;
        font-size: 0.82rem;
        padding: 9px 24px;
        border: none;
        border-radius: var(--radius-sm);
        transition: var(--transition);
        cursor: pointer;
        white-space: nowrap;
    }

    .btn-select-slot:hover {
        background: var(--primary-hover);
        color: var(--dark);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(189, 227, 249, 0.5);
    }

    .session-price {
        font-size: 0.78rem;
        color: var(--text-muted);
    }

    .session-price span {
        font-weight: 700;
        color: var(--dark);
    }

    .doctor-meta {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .doctor-next {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.75rem;
        color: #0ea5a0;
        font-weight: 500;
    }

    .doctor-next .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #0ea5a0;
    }

    .doctor-tag {
        display: inline-block;
        background: #f0f4f8;
        color: var(--text-secondary);
        font-size: 0.72rem;
        font-weight: 500;
        padding: 4px 12px;
        border-radius: 20px;
        border: 1px solid #e0e6ed;
    }

    .doctor-card-bottom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 0;
    }

    /* ========================================
           BOOKING SIDEBAR
        ======================================== */
    .booking-sidebar {
        position: sticky;
        top: 90px;
    }

    .sidebar-card {
        background: #fff;
        border: 1.5px solid #e8ecf0;
        border-radius: var(--radius-lg);
        padding: 24px;
        margin-bottom: 20px;
    }

    .sidebar-card h3 {
        font-size: 1.08rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 20px;
    }

    /* ========================================
           CALENDAR
        ======================================== */
    .calendar-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .calendar-header h4 {
        font-size: 0.92rem;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
    }

    .calendar-nav {
        display: flex;
        gap: 4px;
    }

    .calendar-nav button {
        width: 28px;
        height: 28px;
        border: 1px solid #e0e0e0;
        background: #fff;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: var(--text-secondary);
        font-size: 0.7rem;
        transition: var(--transition);
    }

    .calendar-nav button:hover {
        background: var(--primary);
        border-color: var(--primary);
        color: var(--dark);
    }

    .calendar-grid {
        width: 100%;
    }

    .calendar-grid .cal-row {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        text-align: center;
    }

    .calendar-grid .cal-day-label {
        font-size: 0.72rem;
        font-weight: 600;
        color: var(--text-muted);
        padding: 6px 0;
        text-transform: uppercase;
    }

    .calendar-grid .cal-day {
        padding: 0;
        position: relative;
    }

    .calendar-grid .cal-day button {
        width: 34px;
        height: 34px;
        border: none;
        background: none;
        border-radius: 50%;
        font-size: 0.82rem;
        font-weight: 500;
        color: var(--text-primary);
        cursor: pointer;
        transition: var(--transition);
        font-family: var(--font-family);
        margin: 1px auto;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .calendar-grid .cal-day button:hover {
        background: var(--primary);
        color: var(--dark);
    }

    .calendar-grid .cal-day button.selected {
        background: var(--accent);
        color: #fff;
        font-weight: 700;
    }

    .calendar-grid .cal-day button.today {
        border: 2px solid var(--accent);
        color: var(--accent);
        font-weight: 700;
    }

    .calendar-grid .cal-day button.today.selected {
        background: var(--accent);
        color: #fff;
    }

    .calendar-grid .cal-day button.faded {
        color: #ccc;
    }

    .calendar-grid .cal-day button.faded:hover {
        background: none;
        cursor: default;
    }

    /* ========================================
           TIME SLOTS
        ======================================== */
    .time-slots-title {
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--dark);
        margin: 20px 0 12px;
    }

    .time-slots-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .time-slot {
        padding: 10px 8px;
        border: 1.5px solid #e0e6ed;
        border-radius: var(--radius-sm);
        background: #fff;
        text-align: center;
        font-size: 0.82rem;
        font-weight: 500;
        color: var(--text-secondary);
        cursor: pointer;
        transition: var(--transition);
        font-family: var(--font-family);
    }

    .time-slot:hover {
        border-color: var(--primary-dark);
        background: #f0f8ff;
        color: var(--dark);
    }

    .time-slot.selected {
        border-color: var(--accent);
        background: #e8f4fd;
        color: var(--accent);
        font-weight: 700;
    }

    /* ========================================
           PRICE SUMMARY
        ======================================== */
    .price-summary {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: 24px 0 16px;
        padding-top: 16px;
        border-top: 1px solid #eee;
    }

    .price-summary .label {
        font-size: 0.88rem;
        font-weight: 500;
        color: var(--text-secondary);
    }

    .price-summary .amount {
        font-size: 1.2rem;
        font-weight: 800;
        color: var(--dark);
    }

    .btn-book-appointment {
        width: 100%;
        background: var(--primary);
        color: var(--dark);
        font-weight: 700;
        font-size: 0.95rem;
        padding: 14px 24px;
        border: none;
        border-radius: var(--radius-md);
        transition: var(--transition);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-book-appointment:hover {
        background: var(--primary-hover);
        color: var(--dark);
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(189, 227, 249, 0.5);
    }

    .booking-terms {
        text-align: center;
        font-size: 0.7rem;
        color: var(--text-muted);
        margin-top: 12px;
        line-height: 1.5;
    }

    .booking-terms a {
        color: var(--accent);
        text-decoration: underline;
    }

    /* ========================================
           BUNDLE & SAVE
        ======================================== */
    .bundle-save {
        background: #e8f4fd;
        border: 1.5px solid #c8e3f9;
        border-radius: var(--radius-md);
        padding: 18px 20px;
    }

    .bundle-save-title {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--accent);
        margin-bottom: 6px;
    }

    .bundle-save-title .fa-circle-info {
        font-size: 1rem;
    }

    .bundle-save p {
        font-size: 0.8rem;
        color: var(--text-secondary);
        margin: 0;
        line-height: 1.5;
    }

    /* ========================================
           WHAT TO EXPECT
        ======================================== */
    .expect-section {
        padding: 60px 0;
        background: #fff;
    }

    .expect-section h2 {
        font-size: 1.3rem;
        font-weight: 800;
        color: var(--dark);
        margin-bottom: 40px;
    }

    .expect-card {
        text-align: left;
        padding: 24px 20px;
        transition: var(--transition);
        border-radius: var(--radius-md);
    }

    .expect-card:hover {
        background: var(--section-bg);
        transform: translateY(-4px);
    }

    .expect-icon {
        width: 48px;
        height: 48px;
        background: #e8f4fd;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
        font-size: 1.1rem;
        color: var(--accent);
        transition: var(--transition);
    }

    .expect-card:hover .expect-icon {
        background: var(--primary);
        transform: scale(1.05);
    }

    .expect-card h5 {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 8px;
    }

    .expect-card p {
        font-size: 0.82rem;
        color: var(--text-muted);
        line-height: 1.6;
        margin: 0;
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

    /* ========================================
           BOOKING MODAL
        ======================================== */
    .booking-modal-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.5);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }
    .booking-modal-overlay.active {
        display: flex;
    }
    .booking-modal {
        background: #fff;
        border-radius: var(--radius-lg);
        padding: 32px;
        width: 100%;
        max-width: 440px;
        box-shadow: var(--shadow-lg);
        position: relative;
        animation: fadeInUp 0.3s ease;
    }
    .booking-modal h3 {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 6px;
    }
    .booking-modal .modal-subtitle {
        font-size: 0.82rem;
        color: var(--text-muted);
        margin-bottom: 20px;
    }
    .booking-modal .form-group {
        margin-bottom: 16px;
    }
    .booking-modal .form-group label {
        display: block;
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--text-secondary);
        margin-bottom: 6px;
    }
    .booking-modal .form-group input {
        width: 100%;
        padding: 10px 14px;
        border: 1.5px solid #e0e6ed;
        border-radius: var(--radius-sm);
        font-size: 0.88rem;
        font-family: var(--font-family);
        color: var(--text-primary);
        transition: var(--transition);
    }
    .booking-modal .form-group input:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(0,123,255,0.12);
    }
    .booking-modal .btn-close-modal {
        position: absolute;
        top: 16px; right: 16px;
        background: none;
        border: none;
        font-size: 1.2rem;
        color: var(--text-muted);
        cursor: pointer;
        transition: var(--transition);
    }
    .booking-modal .btn-close-modal:hover {
        color: var(--text-primary);
    }
    .booking-modal .btn-confirm-booking {
        width: 100%;
        background: var(--accent);
        color: #fff;
        font-weight: 700;
        font-size: 0.95rem;
        padding: 13px 24px;
        border: none;
        border-radius: var(--radius-md);
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 8px;
    }
    .booking-modal .btn-confirm-booking:hover {
        background: #0056b3;
        transform: translateY(-1px);
    }
    .booking-modal .btn-confirm-booking:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    /* No slots message */
    .no-slots-msg {
        text-align: center;
        padding: 18px 10px;
        color: var(--text-muted);
        font-size: 0.84rem;
    }
    .no-slots-msg i {
        display: block;
        font-size: 1.4rem;
        margin-bottom: 6px;
        color: #ccc;
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
        animation: fadeInUp 0.5s ease forwards;
    }

    .doctor-card {
        animation: fadeInUp 0.5s ease forwards;
    }

    .doctor-card:nth-child(2) {
        animation-delay: 0.1s;
    }

    /* ========================================
           RESPONSIVE
        ======================================== */
    @media (max-width: 991.98px) {
        .page-hero h1 {
            font-size: 1.6rem;
        }

        .booking-sidebar {
            position: relative;
            top: 0;
            margin-top: 20px;
        }

        .doctor-card-inner {
            flex-wrap: wrap;
        }

        .doctor-actions {
            width: 100%;
            flex-direction: row;
            align-items: center;
            justify-content: flex-start;
            gap: 12px;
            margin-top: 8px;
        }

        .navbar-basirah .navbar-collapse {
            background: #fff;
            border-radius: var(--radius-md);
            padding: 16px;
            margin-top: 8px;
            box-shadow: var(--shadow-md);
        }
    }

    @media (max-width: 767.98px) {
        .page-hero h1 {
            font-size: 1.4rem;
        }

        .page-hero {
            padding: 32px 0 12px;
        }

        .main-content {
            padding: 20px 0 40px;
        }

        .doctor-card {
            padding: 18px;
        }

        .doctor-avatar img {
            width: 70px;
            height: 70px;
        }

        .doctor-header {
            flex-direction: column;
            gap: 4px;
        }

        .expect-section {
            padding: 40px 0;
        }

        .footer-bottom-links {
            justify-content: flex-start;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 10px;
        }

        .time-slots-grid {
            grid-template-columns: 1fr 1fr;
        }

        .sidebar-card {
            padding: 18px;
        }

        .booking-modal {
            margin: 16px;
        }
    }

    @media (max-width: 575.98px) {
        .doctor-card-inner {
            flex-direction: column;
            text-align: center;
        }

        .doctor-avatar {
            display: flex;
            justify-content: center;
        }

        .doctor-header {
            justify-content: center;
            align-items: center;
        }

        .doctor-meta {
            justify-content: center;
        }

        .doctor-actions {
            justify-content: center;
        }

        .doctor-card-bottom {
            flex-direction: column;
            gap: 12px;
        }
    }
    </style>
@endpush

@section('content')
    <!-- ========================================
         PAGE HERO
    ======================================== -->
    <section class="page-hero" id="pageHero">
        <div class="container">
            <h1>Consult an Eye Doctor</h1>
            <p>Book a virtual consultation with our certified optometrists and ophthalmologists. Get professional advice
                on lens prescriptions, eye health, and surgical options from the comfort of your home.</p>
        </div>
    </section>

    <!-- ========================================
         MAIN CONTENT
    ======================================== -->
    <section class="main-content" id="mainContent">
        <div class="container">
            <div class="row">
                <!-- LEFT COLUMN — Available Specialists -->
                <div class="col-lg-8">
                    <div class="specialists-header">
                        <h2>Available Specialists</h2>
                        <select class="filter-dropdown" id="specialtyFilter">
                            <option value="all">All Specialties</option>
                            <option value="optometrist">Optometrist</option>
                            <option value="ophthalmologist">Ophthalmologist</option>
                            <option value="lasik">LASIK Specialist</option>
                        </select>
                    </div>

                    <!-- Dynamic Doctor Cards -->
                    @foreach($doctors as $doctor)
                    <div class="doctor-card" id="doctorCard{{ $doctor->id }}">
                        <div class="doctor-card-inner">
                            <div class="doctor-avatar">
                                <img src="{{ asset($doctor->image ?? 'images/doctor-sarah.png') }}" alt="{{ $doctor->name }} — {{ $doctor->title }}">
                            </div>
                            <div class="doctor-info">
                                <div class="doctor-header">
                                    <div>
                                        <h3 class="doctor-name">{{ $doctor->name }}</h3>
                                        <div class="doctor-title">{{ $doctor->title }}</div>
                                    </div>
                                    <div class="doctor-rating">
                                        <i class="fas fa-star"></i>
                                        {{ number_format($doctor->rating, 1) }} ({{ $doctor->review_count }} reviews)
                                    </div>
                                </div>
                                <p class="doctor-bio">{{ $doctor->bio }}</p>
                                <div class="doctor-card-bottom">
                                    <div class="doctor-meta">
                                        <span class="doctor-next"><span class="dot"></span> Available Today</span>
                                        @if($doctor->specializations)
                                            @foreach($doctor->specializations as $spec)
                                                <span class="doctor-tag">{{ $spec }}</span>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="doctor-actions">
                                        <button class="btn-select-slot"
                                            data-doctor-id="{{ $doctor->id }}"
                                            data-doctor="{{ $doctor->name }}"
                                            data-price="{{ $doctor->price }}">Select Slot</button>
                                        <span class="session-price"><span>${{ number_format($doctor->price, 2) }}</span> / Session</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @if($doctors->isEmpty())
                    <div class="sidebar-card text-center py-5">
                        <i class="fas fa-user-doctor" style="font-size:2rem;color:#ccc;margin-bottom:12px;display:block"></i>
                        <p style="color:var(--text-muted);font-size:0.9rem">No specialists available at the moment. Please check back later.</p>
                    </div>
                    @endif

                </div>

                <!-- RIGHT COLUMN — Booking Sidebar -->
                <div class="col-lg-4">
                    <div class="booking-sidebar">

                        <!-- Select Appointment Card -->
                        <div class="sidebar-card" id="appointmentCard">
                            <h3>Select Appointment</h3>

                            <!-- Calendar -->
                            <div class="calendar-header">
                                <h4 id="calendarMonthLabel"></h4>
                                <div class="calendar-nav">
                                    <button id="calPrev" aria-label="Previous month"><i
                                            class="fas fa-chevron-left"></i></button>
                                    <button id="calNext" aria-label="Next month"><i
                                            class="fas fa-chevron-right"></i></button>
                                </div>
                            </div>

                            <div class="calendar-grid" id="calendarGrid">
                                <!-- Day labels -->
                                <div class="cal-row">
                                    <div class="cal-day-label">S</div>
                                    <div class="cal-day-label">M</div>
                                    <div class="cal-day-label">T</div>
                                    <div class="cal-day-label">W</div>
                                    <div class="cal-day-label">T</div>
                                    <div class="cal-day-label">F</div>
                                    <div class="cal-day-label">S</div>
                                </div>
                                <!-- Calendar days populated by jQuery -->
                            </div>

                            <!-- Available Times -->
                            <h5 class="time-slots-title" id="timeSlotsTitle">Select a date to see times</h5>
                            <div class="time-slots-grid" id="timeSlotsGrid">
                                <div class="no-slots-msg" style="grid-column:1/-1">
                                    <i class="fas fa-calendar-day"></i>
                                    Please select a doctor and date
                                </div>
                            </div>

                            <!-- Price Summary -->
                            <div class="price-summary">
                                <span class="label">Consultation Fee</span>
                                <span class="amount" id="consultFee">$0.00</span>
                            </div>

                            <!-- Book Button -->
                            <button class="btn-book-appointment" id="bookAppointmentBtn">
                                Book Appointment <i class="fas fa-arrow-right"></i>
                            </button>
                            <p class="booking-terms">By booking, you agree to our <a href="#">Terms of Service</a> and
                                <a href="#">Cancellation Policy</a>.</p>
                        </div>

                        <!-- Bundle & Save -->
                        <div class="bundle-save" id="bundleSave">
                            <div class="bundle-save-title">
                                <i class="fas fa-circle-info"></i>
                                Bundle & Save
                            </div>
                            <p>Book a doctor visit and get $10 off your next pair of eyeglasses or contact lenses.</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================
         WHAT TO EXPECT
    ======================================== -->
    <section class="expect-section" id="whatToExpect">
        <div class="container">
            <h2>What to expect during your visit</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="expect-card">
                        <div class="expect-icon">
                            <i class="fas fa-laptop-medical"></i>
                        </div>
                        <h5>Simple Connection</h5>
                        <p>Join via a secure video link from your smartphone or computer. No software download required.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="expect-card">
                        <div class="expect-icon">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <h5>Personalized Care</h5>
                        <p>Discuss your vision history, current symptoms, and receive a tailored management plan.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="expect-card">
                        <div class="expect-icon">
                            <i class="fas fa-file-prescription"></i>
                        </div>
                        <h5>Digital Prescription</h5>
                        <p>Receive your digital prescription and medical notes instantly in your Basirah account.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================
         BOOKING FORM MODAL
    ======================================== -->
    <div class="booking-modal-overlay" id="bookingModalOverlay">
        <div class="booking-modal">
            <button class="btn-close-modal" id="closeBookingModal"><i class="fas fa-times"></i></button>
            <h3>Complete Your Booking</h3>
            <p class="modal-subtitle" id="bookingSummaryText">Doctor · Date · Time</p>

            <form id="bookingForm">
                <div class="form-group">
                    <label for="patientName">Full Name *</label>
                    <input type="text" id="patientName" name="patient_name" required placeholder="Enter your full name">
                </div>
                <div class="form-group">
                    <label for="patientEmail">Email Address *</label>
                    <input type="email" id="patientEmail" name="patient_email" required placeholder="Enter your email">
                </div>
                <div class="form-group">
                    <label for="patientPhone">Phone Number</label>
                    <input type="tel" id="patientPhone" name="patient_phone" placeholder="Enter your phone (optional)">
                </div>

                <button type="submit" class="btn-confirm-booking" id="confirmBookingBtn">
                    <i class="fas fa-check-circle"></i> Confirm Booking
                </button>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function () {

            // ========================================
            // AUTH STATE (injected by Blade)
            // ========================================
            var isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};
            var loginUrl = '{{ route("login") }}';
            var registerUrl = '{{ route("register") }}';

            function requireAuth(actionLabel) {
                if (isAuthenticated) return true;
                Swal.fire({
                    icon: 'info',
                    title: 'Sign In Required',
                    text: 'You need to sign in to ' + actionLabel + '.',
                    showCancelButton: true,
                    confirmButtonText: 'Sign In',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#1D3557',
                    footer: 'Don\'t have an account? <a href="' + registerUrl + '">Create an account</a>'
                }).then(function (result) {
                    if (result.isConfirmed) {
                        window.location.href = loginUrl + '?redirect=' + encodeURIComponent(window.location.href);
                    }
                });
                return false;
            }

            // ========================================
            // STATE
            // ========================================
            var selectedDoctorId = null;
            var selectedDoctorName = '';
            var selectedDoctorPrice = 0;
            var selectedTimeSlot = null;

            var now = new Date();
            var currentMonth = now.getMonth();
            var currentYear = now.getFullYear();
            var todayDate = now.getDate();
            var todayMonth = now.getMonth();
            var todayYear = now.getFullYear();
            var selectedDay = todayDate;

            // ========================================
            // NAVBAR SCROLL EFFECT
            // ========================================
            $(window).on('scroll', function () {
                if ($(this).scrollTop() > 10) {
                    $('#mainNavbar').addClass('scrolled');
                } else {
                    $('#mainNavbar').removeClass('scrolled');
                }
            });

            // ========================================
            // CALENDAR LOGIC
            // ========================================
            var monthNames = [
                'January', 'February', 'March', 'April',
                'May', 'June', 'July', 'August',
                'September', 'October', 'November', 'December'
            ];

            var monthAbbr = [
                'Jan', 'Feb', 'Mar', 'Apr',
                'May', 'Jun', 'Jul', 'Aug',
                'Sep', 'Oct', 'Nov', 'Dec'
            ];

            function renderCalendar(month, year) {
                // Update header label
                $('#calendarMonthLabel').text(monthNames[month] + ' ' + year);

                // Remove existing day rows (keep the label row)
                $('#calendarGrid .cal-row:not(:first)').remove();

                var firstDay = new Date(year, month, 1).getDay(); // 0 = Sunday
                var daysInMonth = new Date(year, month + 1, 0).getDate();
                var daysInPrev = new Date(year, month, 0).getDate();

                var dayCount = 1;
                var totalCells = Math.ceil((firstDay + daysInMonth) / 7) * 7;
                var rows = totalCells / 7;

                for (var r = 0; r < rows; r++) {
                    var $row = $('<div class="cal-row"></div>');
                    for (var c = 0; c < 7; c++) {
                        var cellIndex = r * 7 + c;
                        var $cell = $('<div class="cal-day"></div>');
                        var $btn = $('<button></button>');

                        if (cellIndex < firstDay) {
                            // Previous month's trailing days
                            var prevDay = daysInPrev - firstDay + cellIndex + 1;
                            $btn.text(prevDay).addClass('faded');
                        } else if (dayCount > daysInMonth) {
                            // Next month's leading days
                            var nextDay = dayCount - daysInMonth;
                            $btn.text(nextDay).addClass('faded');
                            dayCount++;
                        } else {
                            $btn.text(dayCount);
                            $btn.attr('data-day', dayCount);

                            // Mark today
                            if (month === todayMonth && year === todayYear && dayCount === todayDate) {
                                $btn.addClass('today');
                            }

                            // Disable past dates
                            if (year < todayYear || (year === todayYear && month < todayMonth) || (year === todayYear && month === todayMonth && dayCount < todayDate)) {
                                $btn.addClass('faded');
                            }

                            // Mark selected day
                            if (dayCount === selectedDay && month === currentMonth && year === currentYear) {
                                $btn.addClass('selected');
                            }

                            dayCount++;
                        }

                        $cell.append($btn);
                        $row.append($cell);
                    }
                    $('#calendarGrid').append($row);
                }

                // Update time slots title
                updateTimeSlotsTitle();
            }

            function updateTimeSlotsTitle() {
                $('#timeSlotsTitle').text('Available Times (' + monthAbbr[currentMonth] + ' ' + selectedDay + ')');
            }

            function getSelectedDateStr() {
                var m = (currentMonth + 1).toString().padStart(2, '0');
                var d = selectedDay.toString().padStart(2, '0');
                return currentYear + '-' + m + '-' + d;
            }

            // Navigate calendar
            $('#calPrev').on('click', function () {
                // Don't go before current month
                if (currentMonth === todayMonth && currentYear === todayYear) return;
                currentMonth--;
                if (currentMonth < 0) {
                    currentMonth = 11;
                    currentYear--;
                }
                selectedDay = 1;
                selectedTimeSlot = null;
                renderCalendar(currentMonth, currentYear);
                fetchSlots();
            });

            $('#calNext').on('click', function () {
                currentMonth++;
                if (currentMonth > 11) {
                    currentMonth = 0;
                    currentYear++;
                }
                selectedDay = 1;
                selectedTimeSlot = null;
                renderCalendar(currentMonth, currentYear);
                fetchSlots();
            });

            // Calendar day selection
            $(document).on('click', '.cal-day button:not(.faded)', function () {
                var day = $(this).data('day');
                if (day) {
                    selectedDay = day;
                    selectedTimeSlot = null;
                    // Remove previous selection & re-add
                    $('.cal-day button').removeClass('selected');
                    $(this).addClass('selected');
                    updateTimeSlotsTitle();

                    // Subtle pulse animation
                    $(this).css('transform', 'scale(1.2)');
                    setTimeout(function () {
                        $('.cal-day button.selected').css('transform', 'scale(1)');
                    }, 150);

                    // Fetch available slots
                    fetchSlots();
                }
            });

            // Initial render
            renderCalendar(currentMonth, currentYear);


            // ========================================
            // FETCH AVAILABLE SLOTS FROM API
            // ========================================
            function fetchSlots() {
                if (!selectedDoctorId) {
                    $('#timeSlotsGrid').html('<div class="no-slots-msg" style="grid-column:1/-1"><i class="fas fa-user-doctor"></i>Please select a doctor first</div>');
                    return;
                }

                var dateStr = getSelectedDateStr();

                $('#timeSlotsGrid').html('<div class="no-slots-msg" style="grid-column:1/-1"><i class="fas fa-spinner fa-spin"></i>Loading slots...</div>');

                $.ajax({
                    url: '{{ route("appointments.slots") }}',
                    method: 'GET',
                    data: {
                        doctor_id: selectedDoctorId,
                        date: dateStr
                    },
                    success: function (response) {
                        var slots = response.slots;
                        if (slots.length === 0) {
                            $('#timeSlotsGrid').html('<div class="no-slots-msg" style="grid-column:1/-1"><i class="fas fa-calendar-xmark"></i>No available slots for this date</div>');
                            return;
                        }

                        var html = '';
                        $.each(slots, function (i, slot) {
                            html += '<div class="time-slot" data-time="' + slot + '">' + slot + '</div>';
                        });
                        $('#timeSlotsGrid').html(html);
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            $('#timeSlotsGrid').html('<div class="no-slots-msg" style="grid-column:1/-1"><i class="fas fa-circle-exclamation"></i>Please select a valid future date</div>');
                        } else {
                            $('#timeSlotsGrid').html('<div class="no-slots-msg" style="grid-column:1/-1"><i class="fas fa-circle-exclamation"></i>Error loading slots</div>');
                        }
                    }
                });
            }


            // ========================================
            // TIME SLOT SELECTION
            // ========================================
            $(document).on('click', '.time-slot', function () {
                $('.time-slot').removeClass('selected');
                $(this).addClass('selected');
                selectedTimeSlot = $(this).data('time');

                // Micro-animation
                $(this).css('transform', 'scale(0.95)');
                var $el = $(this);
                setTimeout(function () {
                    $el.css('transform', 'scale(1)');
                }, 120);
            });


            // ========================================
            // SELECT SLOT BUTTON (Doctor Cards)
            // ========================================
            $('.btn-select-slot').on('click', function () {
                // ── Auth gate ──
                if (!requireAuth('book a consultation')) return;

                selectedDoctorId = $(this).data('doctor-id');
                selectedDoctorName = $(this).data('doctor');
                selectedDoctorPrice = parseFloat($(this).data('price'));

                // Update consultation fee
                $('#consultFee').text('$' + selectedDoctorPrice.toFixed(2));

                // Highlight the selected doctor card
                $('.doctor-card').css('border-color', '#e8ecf0');
                $(this).closest('.doctor-card').css('border-color', '#007BFF');

                // Smooth scroll to appointment card on mobile
                if ($(window).width() < 992) {
                    $('html, body').animate({
                        scrollTop: $('#appointmentCard').offset().top - 80
                    }, 400);
                }

                // Flash animation on the sidebar card
                $('#appointmentCard').css('box-shadow', '0 0 0 3px rgba(0,123,255,0.2)');
                setTimeout(function () {
                    $('#appointmentCard').css('box-shadow', 'none');
                }, 600);

                // Fetch available slots for the selected doctor + date
                fetchSlots();
            });


            // ========================================
            // BOOK APPOINTMENT BUTTON → OPEN MODAL
            // ========================================
            $('#bookAppointmentBtn').on('click', function () {
                // ── Auth gate ──
                if (!requireAuth('book a consultation')) return;

                // Validate selections
                if (!selectedDoctorId) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Select a Doctor',
                        text: 'Please select a doctor by clicking "Select Slot" on a doctor card.',
                        confirmButtonColor: '#007BFF'
                    });
                    return;
                }

                if (!selectedTimeSlot) {
                    // Shake animation if no time selected
                    var $grid = $('#timeSlotsGrid');
                    $grid.css('animation', 'none');
                    setTimeout(function () {
                        $grid.css({
                            'animation': 'shake 0.4s ease',
                            'border': '2px solid #ff6b6b',
                            'border-radius': '12px',
                            'padding': '8px'
                        });
                        setTimeout(function () {
                            $grid.css({
                                'border': 'none',
                                'padding': '0'
                            });
                        }, 1500);
                    }, 10);

                    Swal.fire({
                        icon: 'warning',
                        title: 'Select a Time',
                        text: 'Please select an available time slot.',
                        confirmButtonColor: '#007BFF'
                    });
                    return;
                }

                // Update modal summary text
                var dateLabel = monthAbbr[currentMonth] + ' ' + selectedDay + ', ' + currentYear;
                $('#bookingSummaryText').text(selectedDoctorName + ' · ' + dateLabel + ' · ' + selectedTimeSlot + ' · $' + selectedDoctorPrice.toFixed(2));

                // Show modal
                $('#bookingModalOverlay').addClass('active');
            });


            // ========================================
            // CLOSE BOOKING MODAL
            // ========================================
            $('#closeBookingModal').on('click', function () {
                $('#bookingModalOverlay').removeClass('active');
            });

            $('#bookingModalOverlay').on('click', function (e) {
                if ($(e.target).is('#bookingModalOverlay')) {
                    $(this).removeClass('active');
                }
            });


            // ========================================
            // SUBMIT BOOKING FORM (AJAX)
            // ========================================
            $('#bookingForm').on('submit', function (e) {
                e.preventDefault();

                var $btn = $('#confirmBookingBtn');
                $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Booking...');

                $.ajax({
                    url: '{{ route("appointments.store") }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        doctor_id: selectedDoctorId,
                        appointment_date: getSelectedDateStr(),
                        time_slot: selectedTimeSlot,
                        patient_name: $('#patientName').val(),
                        patient_email: $('#patientEmail').val(),
                        patient_phone: $('#patientPhone').val()
                    },
                    success: function (response) {
                        // Close modal
                        $('#bookingModalOverlay').removeClass('active');
                        $btn.prop('disabled', false).html('<i class="fas fa-check-circle"></i> Confirm Booking');
                        $('#bookingForm')[0].reset();

                        // Redirect to the appointment checkout page for payment
                        if (response.redirect) {
                            window.location.href = response.redirect;
                        }
                    },
                    error: function (xhr) {
                        $btn.prop('disabled', false).html('<i class="fas fa-check-circle"></i> Confirm Booking');

                        var msg = 'Something went wrong. Please try again.';
                        if (xhr.status === 409 && xhr.responseJSON) {
                            msg = xhr.responseJSON.message;
                        } else if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                            var errors = xhr.responseJSON.errors;
                            msg = Object.values(errors).flat().join('<br>');
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Booking Failed',
                            html: msg,
                            confirmButtonColor: '#007BFF'
                        });
                    }
                });
            });


            // ========================================
            // INTERSECTION OBSERVER ANIMATIONS
            // ========================================
            if ('IntersectionObserver' in window) {
                var observer = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            $(entry.target).addClass('animate-in');
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.1 });

                $('.expect-card, .bundle-save').each(function () {
                    this.style.opacity = '0';
                    observer.observe(this);
                });
            }

        });

        // Shake keyframes injected via JS
        var shakeStyle = document.createElement('style');
        shakeStyle.textContent = '@keyframes shake { 0%, 100% { transform: translateX(0); } 25% { transform: translateX(-6px); } 50% { transform: translateX(6px); } 75% { transform: translateX(-4px); } }';
        document.head.appendChild(shakeStyle);
    </script>
@endpush