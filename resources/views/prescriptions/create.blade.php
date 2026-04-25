@extends('layouts.app')
@section('title', 'Submit Prescription — Basirah Optical')
@section('description_content', 'Submit your eye prescription — Upload a digital copy or enter your refraction data manually for precision lens manufacturing at Basirah Optical.')
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
            --body-bg: #F8FAFC;
            --card-bg: #ffffff;
            --text-primary: #1a1a2e;
            --text-secondary: #555;
            --text-muted: #888;
            --border-light: #e8ecf0;
            --section-bg: #F8FAFC;
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
                           BREADCRUMB
                        ======================================== */
        .breadcrumb-section {
            padding: 20px 0 0;
            background: #fff;
        }

        .breadcrumb-custom {
            display: flex;
            align-items: center;
            gap: 8px;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .breadcrumb-custom li {
            font-size: 0.82rem;
            color: var(--text-muted);
        }

        .breadcrumb-custom li a {
            color: var(--text-muted);
        }

        .breadcrumb-custom li a:hover {
            color: var(--accent);
        }

        .breadcrumb-custom li.active {
            color: var(--text-primary);
            font-weight: 600;
        }

        .breadcrumb-custom li+li::before {
            content: '/';
            margin-right: 8px;
            color: #ccc;
        }

        /* ========================================
                           PAGE HEADER
                        ======================================== */
        .page-header {
            padding: 24px 0 28px;
            background: #fff;
            border-bottom: 1px solid #f0f0f0;
        }

        .page-header h1 {
            font-size: 1.85rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 6px;
            letter-spacing: -0.02em;
        }

        .page-header p {
            color: var(--text-muted);
            font-size: 0.88rem;
            margin: 0;
        }

        /* ========================================
                           TAB SECTION
                        ======================================== */
        .tab-section {
            background: #fff;
            padding: 0 0 2px;
        }

        .tab-nav {
            display: flex;
            gap: 24px;
            padding-top: 20px;
        }

        .tab-link {
            font-size: 0.82rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--accent);
            padding-bottom: 10px;
            border-bottom: 3px solid var(--accent);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: var(--transition);
        }

        .tab-link i {
            font-size: 0.85rem;
        }

        .tab-link:hover {
            color: var(--dark);
        }

        /* ========================================
                           MAIN CONTENT AREA
                        ======================================== */
        .prescription-content {
            padding: 32px 0 20px;
            background: var(--section-bg);
        }

        .prescription-wrapper {
            max-width: 800px;
            margin: 0 auto;
        }

        /* ========================================
                           DRAG & DROP ZONE
                        ======================================== */
        .upload-zone {
            background: #fff;
            border: 2.5px dashed #c8dff0;
            border-radius: var(--radius-lg);
            padding: 48px 32px;
            text-align: center;
            transition: var(--transition);
            cursor: pointer;
            position: relative;
            margin-bottom: 28px;
        }

        .upload-zone:hover,
        .upload-zone.dragover {
            border-color: var(--accent);
            background: #f0f8ff;
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 123, 255, 0.08);
        }

        .upload-zone.dragover {
            border-color: var(--accent);
            background: #e3f0ff;
        }

        .upload-zone.has-file {
            border-color: #28a745;
            border-style: solid;
            background: #f0fff4;
        }

        .upload-icon {
            width: 64px;
            height: 64px;
            background: #e8f4fd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
            font-size: 1.5rem;
            color: var(--accent);
            transition: var(--transition);
        }

        .upload-zone:hover .upload-icon {
            background: var(--primary);
            transform: scale(1.08);
        }

        .upload-zone.has-file .upload-icon {
            background: #d4edda;
            color: #28a745;
        }

        .upload-zone h4 {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .upload-zone .upload-desc {
            font-size: 0.82rem;
            color: var(--text-muted);
            margin-bottom: 18px;
            line-height: 1.5;
        }

        .btn-browse {
            background: var(--dark);
            color: #fff;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 10px 28px;
            border: none;
            border-radius: var(--radius-sm);
            transition: var(--transition);
            cursor: pointer;
        }

        .btn-browse:hover {
            background: #2a4a73;
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(29, 53, 87, 0.3);
        }

        .upload-preview {
            display: none;
            margin-top: 16px;
            padding: 12px 16px;
            background: #e8f5e9;
            border-radius: var(--radius-sm);
            font-size: 0.82rem;
            color: #2e7d32;
            font-weight: 500;
            align-items: center;
            gap: 8px;
        }

        .upload-preview.show {
            display: flex;
        }

        .upload-preview .remove-file {
            margin-left: auto;
            color: #c62828;
            cursor: pointer;
            font-size: 0.85rem;
            transition: var(--transition);
        }

        .upload-preview .remove-file:hover {
            transform: scale(1.15);
        }

        #fileInput {
            display: none;
        }

        /* ========================================
                           REFRACTION DATA CARD
                        ======================================== */
        .refraction-card {
            background: #fff;
            border: 1.5px solid var(--border-light);
            border-radius: var(--radius-lg);
            padding: 28px;
            margin-bottom: 28px;
            transition: var(--transition);
        }

        .refraction-card:hover {
            box-shadow: var(--shadow-sm);
        }

        .refraction-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .refraction-header-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .refraction-header-icon {
            width: 36px;
            height: 36px;
            background: #e8f4fd;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent);
            font-size: 0.95rem;
        }

        .refraction-header h3 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--dark);
            margin: 0;
        }

        .refraction-help {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--accent);
            display: inline-flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
            transition: var(--transition);
        }

        .refraction-help:hover {
            color: var(--dark);
        }

        /* ========================================
                           REFRACTION TABLE
                        ======================================== */
        .refraction-table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .refraction-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .refraction-table thead th {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-muted);
            padding: 0 12px 14px;
            white-space: nowrap;
            border: none;
        }

        .refraction-table thead th .info-tip {
            font-size: 0.65rem;
            color: #bbb;
            margin-left: 3px;
            cursor: help;
        }

        .refraction-table tbody tr {
            transition: var(--transition);
        }

        .refraction-table tbody tr:hover {
            background: #fafcff;
        }

        .refraction-table tbody td {
            padding: 10px 12px;
            vertical-align: middle;
            border: none;
        }

        .eye-label {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--dark);
            white-space: nowrap;
        }

        .eye-badge {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .eye-badge.od {
            background: #e0f2fe;
            color: #0284c7;
        }

        .eye-badge.os {
            background: #dbeafe;
            color: #3b82f6;
        }

        .refraction-input {
            width: 100%;
            min-width: 90px;
            padding: 10px 14px;
            border: 1.5px solid #e0e6ed;
            border-radius: var(--radius-sm);
            font-size: 0.88rem;
            font-weight: 500;
            font-family: var(--font-family);
            color: var(--text-primary);
            text-align: center;
            background: #fff;
            transition: var(--transition);
        }

        .refraction-input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
            background: #fafcff;
        }

        .refraction-input::placeholder {
            color: #ccc;
        }

        /* ========================================
                           PUPILLARY DISTANCE
                        ======================================== */
        .pd-section {
            margin-top: 28px;
            padding-top: 24px;
            border-top: 1px solid #f0f0f0;
        }

        .pd-label {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-muted);
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .pd-label .info-tip {
            font-size: 0.65rem;
            color: #bbb;
            cursor: help;
        }

        .pd-row {
            display: flex;
            align-items: flex-start;
            gap: 20px;
        }

        .pd-input-group {
            flex-shrink: 0;
        }

        .pd-input-wrapper {
            display: flex;
            align-items: center;
            gap: 0;
            margin-bottom: 8px;
        }

        .pd-input {
            width: 80px;
            padding: 10px 14px;
            border: 1.5px solid #e0e6ed;
            border-radius: var(--radius-sm) 0 0 var(--radius-sm);
            font-size: 0.95rem;
            font-weight: 600;
            font-family: var(--font-family);
            color: var(--text-primary);
            text-align: center;
            background: #fff;
            transition: var(--transition);
        }

        .pd-input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
            z-index: 1;
            position: relative;
        }

        .pd-unit {
            padding: 10px 14px;
            background: #f8fafc;
            border: 1.5px solid #e0e6ed;
            border-left: none;
            border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-muted);
        }

        .btn-save-pd {
            background: var(--accent);
            color: #fff;
            font-weight: 600;
            font-size: 0.8rem;
            padding: 10px 20px;
            border: none;
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: var(--transition);
            white-space: nowrap;
        }

        .btn-save-pd:hover {
            background: #0069d9;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        }

        .pd-hint {
            font-size: 0.75rem;
            color: var(--text-muted);
            font-style: italic;
        }

        .pd-info-box {
            flex: 1;
            background: #e8f4fd;
            border: 1.5px solid #c8e3f9;
            border-radius: var(--radius-md);
            padding: 16px 20px;
        }

        .pd-info-title {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--accent);
            margin-bottom: 6px;
        }

        .pd-info-title i {
            font-size: 0.95rem;
        }

        .pd-info-box p {
            font-size: 0.78rem;
            color: var(--text-secondary);
            margin: 0;
            line-height: 1.55;
        }

        /* ========================================
                           ACTION FOOTER
                        ======================================== */
        .action-footer {
            padding: 28px 0;
            background: var(--section-bg);
        }

        .action-footer-inner {
            max-width: 800px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .btn-cancel {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--text-secondary);
            background: none;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            padding: 10px 0;
        }

        .btn-cancel:hover {
            color: var(--dark);
        }

        .btn-cancel i {
            font-size: 0.8rem;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
        }

        .btn-draft {
            background: #fff;
            color: var(--dark);
            font-weight: 600;
            font-size: 0.88rem;
            padding: 12px 28px;
            border: 1.5px solid var(--border-light);
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-draft:hover {
            border-color: var(--dark);
            background: #f8fafc;
            transform: translateY(-1px);
        }

        .btn-save-continue {
            background: var(--accent);
            color: #fff;
            font-weight: 600;
            font-size: 0.88rem;
            padding: 12px 28px;
            border: none;
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-save-continue:hover {
            background: #0069d9;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.35);
        }

        /* ========================================
                           TRUST BADGES
                        ======================================== */
        .trust-badges {
            padding: 32px 0;
            background: #fff;
            border-top: 1px solid #f0f0f0;
        }

        .trust-badge-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 48px;
            flex-wrap: wrap;
        }

        .trust-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--text-muted);
            transition: var(--transition);
        }

        .trust-badge:hover {
            color: var(--dark);
        }

        .trust-badge i {
            font-size: 1rem;
            color: #bbb;
            transition: var(--transition);
        }

        .trust-badge:hover i {
            color: var(--accent);
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

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-6px);
            }

            50% {
                transform: translateX(6px);
            }

            75% {
                transform: translateX(-4px);
            }
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(0, 123, 255, 0.3);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(0, 123, 255, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(0, 123, 255, 0);
            }
        }

        @keyframes checkmark {
            0% {
                transform: scale(0);
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }

        .animate-in {
            animation: fadeInUp 0.5s ease forwards;
        }

        /* ========================================
                           TOAST NOTIFICATION
                        ======================================== */
        .toast-notification {
            position: fixed;
            top: 80px;
            right: 24px;
            padding: 14px 24px;
            border-radius: var(--radius-sm);
            font-size: 0.85rem;
            font-weight: 600;
            color: #fff;
            z-index: 9999;
            display: none;
            align-items: center;
            gap: 8px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            animation: fadeInUp 0.3s ease;
        }

        .toast-notification.success {
            background: #28a745;
        }

        .toast-notification.error {
            background: #dc3545;
        }

        .toast-notification.info {
            background: var(--accent);
        }

        /* ========================================
                           RESPONSIVE
                        ======================================== */
        @media (max-width: 767.98px) {
            .page-header h1 {
                font-size: 1.4rem;
            }

            .page-header {
                padding: 20px 0;
            }

            .prescription-content {
                padding: 20px 0;
            }

            .refraction-card {
                padding: 18px;
            }

            .upload-zone {
                padding: 32px 20px;
            }

            .pd-row {
                flex-direction: column;
                gap: 16px;
            }

            .pd-info-box {
                width: 100%;
            }

            .action-footer-inner {
                flex-direction: column;
                gap: 16px;
                align-items: stretch;
                text-align: center;
            }

            .action-buttons {
                justify-content: center;
            }

            .btn-cancel {
                justify-content: center;
            }

            .trust-badge-row {
                gap: 24px;
            }

            .refraction-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .navbar-basirah .navbar-collapse {
                background: #fff;
                border-radius: var(--radius-md);
                padding: 16px;
                margin-top: 8px;
                box-shadow: var(--shadow-md);
            }
        }

        @media (max-width: 575.98px) {
            .refraction-table thead th {
                font-size: 0.6rem;
                padding: 0 6px 10px;
            }

            .refraction-input {
                min-width: 70px;
                padding: 8px 8px;
                font-size: 0.8rem;
            }

            .eye-label {
                font-size: 0.78rem;
                gap: 6px;
            }

            .eye-badge {
                width: 26px;
                height: 26px;
                font-size: 0.55rem;
            }

            .trust-badge-row {
                flex-direction: column;
                gap: 16px;
            }
        }
    </style>
@endpush

@section('navbar')
    @include('layouts.partials.navbar-default')
@endsection

@section('content')
    <!-- ========================================
                         BREADCRUMB
                    ======================================== -->
    <section class="breadcrumb-section">
        <div class="container">
            <ul class="breadcrumb-custom" id="breadcrumb">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('products.index') }}">Shop</a></li>
                <li class="active">Enter Prescription</li>
            </ul>
        </div>
    </section>

    <!-- ========================================
                         PAGE HEADER
                    ======================================== -->
    <section class="page-header" id="pageHeader">
        <div class="container">
            <h1>Submit Prescription</h1>
            <p>Upload a digital copy or enter your refraction data manually for precision manufacturing.</p>
        </div>
    </section>

    <!-- ========================================
                         TAB SECTION
                    ======================================== -->
    <section class="tab-section">
        <div class="container">
            <div class="tab-nav">
                <span class="tab-link active" id="tabManualEntry">
                    <i class="fas fa-edit"></i>
                    MANUAL ENTRY
                </span>
            </div>
        </div>
    </section>

    <!-- ========================================
                         PRESCRIPTION CONTENT
                    ======================================== -->
    <section class="prescription-content" id="prescriptionContent">
        <div class="container">
            <div class="prescription-wrapper">

                <!-- DRAG & DROP ZONE -->
                <div class="upload-zone" id="uploadZone">
                    <input type="file" id="fileInput" accept=".pdf,.jpg,.jpeg,.png">
                    <div class="upload-icon" id="uploadIcon">
                        <i class="fas fa-cloud-arrow-up"></i>
                    </div>
                    <h4 id="uploadTitle">Drag & Drop Prescription Photo</h4>
                    <p class="upload-desc" id="uploadDesc">Supports PDF, JPG, or PNG files. Please ensure all<br>values
                        (SPH, CYL, Axis) are clearly visible.</p>
                    <button type="button" class="btn-browse" id="btnBrowse">Browse Files</button>
                    <div class="upload-preview" id="uploadPreview">
                        <i class="fas fa-file-check"></i>
                        <span id="fileName"></span>
                        <span class="remove-file" id="removeFile"><i class="fas fa-times-circle"></i></span>
                    </div>
                </div>

                <!-- REFRACTION DATA ENTRY -->
                <form action="{{ route('prescription.storeManual') }}" method="POST" id="prescriptionForm">
                    <!-- Note: Route placeholder, form method is POST for a supposed store action -->
                    @csrf
                    <input type="hidden" name="product_id" value="{{ isset($product) ? $product->id : '' }}">
                    <input type="hidden" name="type" id="prescriptionType"
                        value="{{ (isset($isContact) && $isContact) ? 'contact' : 'eyeglasses' }}">

                    @if(isset($isContact) && $isContact)
                        <div class="alert alert-info d-flex align-items-center mb-4" role="alert"
                            style="border-radius: 8px; font-weight: 500; background-color: #e0f2fe; border-color: #bae6fd; color: #0284c7; padding: 15px;">
                            <i class="fas fa-info-circle" style="font-size: 1.2rem; margin-right: 12px;"></i>
                            <div>
                                You are entering details for <strong>Contact Lenses</strong>.
                            </div>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger"
                            style="margin-bottom: 20px; padding: 15px; border-radius: 8px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;">
                            <ul style="margin: 0; padding-left: 20px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="refraction-card" id="refractionCard">
                        <div class="refraction-header">
                            <div class="refraction-header-left">
                                <div class="refraction-header-icon">
                                    <i class="fas fa-table-cells"></i>
                                </div>
                                <h3>Refraction Data Entry</h3>
                            </div>
                            <a href="#" class="refraction-help">
                                <i class="fas fa-circle-question"></i>
                                How to read prescription?
                            </a>
                        </div>

                        <div class="refraction-table-wrapper">
                            <table class="refraction-table" id="refractionTable">
                                <thead>
                                    <tr>
                                        <th>EYE SELECTION</th>
                                        <th>SPH (SPHERE) <i class="fas fa-circle-info info-tip"
                                                title="Sphere power corrects nearsightedness (-) or farsightedness (+)"></i>
                                        </th>
                                        <th>CYL (CYLINDER) <i class="fas fa-circle-info info-tip"
                                                title="Cylinder corrects astigmatism"></i></th>
                                        <th>AXIS <i class="fas fa-circle-info info-tip"
                                                title="Axis is the angle of astigmatism correction (1-180)"></i></th>
                                        <th class="contact-only" style="display: none;">BC <i
                                                class="fas fa-circle-info info-tip" title="Base Curve"></i></th>
                                        <th class="contact-only" style="display: none;">DIA <i
                                                class="fas fa-circle-info info-tip" title="Diameter"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="rowOD">
                                        <td>
                                            <span class="eye-label">
                                                <span class="eye-badge od">OD</span>
                                                Right Eye
                                            </span>
                                        </td>
                                        <td>
                                            <input type="text" class="refraction-input" id="odSph" name="od_sph"
                                                value="+0.00" placeholder="+0.00" data-eye="od" data-field="sph">
                                        </td>
                                        <td>
                                            <input type="text" class="refraction-input" id="odCyl" name="od_cyl"
                                                value="-0.00" placeholder="-0.00" data-eye="od" data-field="cyl">
                                        </td>
                                        <td>
                                            <input type="text" class="refraction-input" id="odAxis" name="od_axis" value="0"
                                                placeholder="0" data-eye="od" data-field="axis">
                                        </td>
                                        <td class="contact-only" style="display: none;">
                                            <input type="number" step="0.01" class="refraction-input" id="odBc" name="od_bc"
                                                value="" placeholder="8.6" data-eye="od" data-field="bc">
                                        </td>
                                        <td class="contact-only" style="display: none;">
                                            <input type="number" step="0.01" class="refraction-input" id="odDia"
                                                name="od_dia" value="" placeholder="14.2" data-eye="od" data-field="dia">
                                        </td>
                                    </tr>
                                    <tr id="rowOS">
                                        <td>
                                            <span class="eye-label">
                                                <span class="eye-badge os">OS</span>
                                                Left Eye
                                            </span>
                                        </td>
                                        <td>
                                            <input type="text" class="refraction-input" id="osSph" name="os_sph"
                                                value="+0.00" placeholder="+0.00" data-eye="os" data-field="sph">
                                        </td>
                                        <td>
                                            <input type="text" class="refraction-input" id="osCyl" name="os_cyl"
                                                value="-0.00" placeholder="-0.00" data-eye="os" data-field="cyl">
                                        </td>
                                        <td>
                                            <input type="text" class="refraction-input" id="osAxis" name="os_axis" value="0"
                                                placeholder="0" data-eye="os" data-field="axis">
                                        </td>
                                        <td class="contact-only" style="display: none;">
                                            <input type="number" step="0.01" class="refraction-input" id="osBc" name="os_bc"
                                                value="" placeholder="8.6" data-eye="os" data-field="bc">
                                        </td>
                                        <td class="contact-only" style="display: none;">
                                            <input type="number" step="0.01" class="refraction-input" id="osDia"
                                                name="os_dia" value="" placeholder="14.2" data-eye="os" data-field="dia">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- PUPILLARY DISTANCE -->
                        <div class="pd-section" id="pdSection">
                            <div class="pd-label">
                                PUPILLARY DISTANCE (PD)
                                <i class="fas fa-circle-info info-tip"
                                    title="The distance between the centers of your pupils"></i>
                            </div>
                            <div class="pd-row">
                                <div class="pd-input-group">
                                    <div class="pd-input-wrapper">
                                        <input type="number" class="pd-input" id="pdInput" name="pd_value" value="63"
                                            min="40" max="80" step="0.5">
                                        <span class="pd-unit">mm</span>
                                        <button class="btn-save-pd" type="button" id="btnSavePD"
                                            style="margin-left: 10px;">Save P.D</button>
                                    </div>
                                    <p class="pd-hint">Most prescriptions have a single PD ranging from 54mm to 74mm.</p>
                                </div>
                                <div class="pd-info-box">
                                    <div class="pd-info-title">
                                        <i class="fas fa-circle-question"></i>
                                        What is PD?
                                    </div>
                                    <p>Pupillary Distance (PD) is essential for centering your lenses in the frame. If not
                                        on your prescription, we can help you measure it online.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </section>

    <!-- ========================================
                         ACTION FOOTER
                    ======================================== -->
    <section class="action-footer" id="actionFooter">
        <div class="container">
            <div class="action-footer-inner">
                <button class="btn-cancel" id="btnCancel">
                    <i class="fas fa-arrow-left"></i>
                    Cancel & Go Back
                </button>
                <div class="action-buttons">
                    <button class="btn-draft" id="btnSaveDraft">Save Draft</button>
                    <button type="submit" form="prescriptionForm" class="btn-save-continue" id="btnSaveContinue">
                        Save & Continue <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================
                         TRUST BADGES
                    ======================================== -->
    <section class="trust-badges" id="trustBadges">
        <div class="container">
            <div class="trust-badge-row">
                <div class="trust-badge">
                    <i class="fas fa-shield-halved"></i>
                    HIPAA Compliant
                </div>
                <div class="trust-badge">
                    <i class="fas fa-microscope"></i>
                    Precision Verified
                </div>
                <div class="trust-badge">
                    <i class="fas fa-headset"></i>
                    24/7 Optical Support
                </div>
                <div class="trust-badge">
                    <i class="fas fa-certificate"></i>
                    FDA Certified Lab
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================
                         TOAST NOTIFICATION
                    ======================================== -->
    <div class="toast-notification" id="toastNotification">
        <i class="fas fa-check-circle"></i>
        <span id="toastMessage"></span>
    </div>
@endsection

@section('footer')

@endsection

@push('script')
    <script>
        $(document).ready(function () {

            // ========================================
            // CONTACT LENS TOGGLE
            // ========================================
            var isContact = {{ (isset($isContact) && $isContact) ? 'true' : 'false' }};
            if (isContact) {
                $('#pdSection').hide();
                // We also unset required on client side to prevent validation block if we use HTML5 validation
                $('#pdInput').removeAttr('required');

                // Show BC and DIA fields and make them required
                $('.contact-only').show();
                $('#odBc, #odDia, #osBc, #osDia').attr('required', 'required');
            } else {
                $('.contact-only').hide();
                $('#odBc, #odDia, #osBc, #osDia').removeAttr('required');
            }

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
            // TOAST HELPER
            // ========================================
            function showToast(message, type) {
                var $toast = $('#toastNotification');
                $toast.removeClass('success error info').addClass(type);
                $('#toastMessage').text(message);

                var icon = type === 'success' ? 'fa-check-circle' :
                    type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
                $toast.find('i').attr('class', 'fas ' + icon);

                $toast.css('display', 'flex').hide().fadeIn(300);
                setTimeout(function () {
                    $toast.fadeOut(300);
                }, 3000);
            }

            // ========================================
            // FILE UPLOAD — DRAG & DROP
            // ========================================
            var $uploadZone = $('#uploadZone');
            var $fileInput = $('#fileInput');

            // Browse button click
            $('#btnBrowse').on('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                $fileInput[0].click();
            });

            // Click on zone
            $uploadZone.on('click', function (e) {
                if ($(e.target).closest('#uploadPreview').length) return;
                $fileInput[0].click();
            });

            // Drag events
            $uploadZone.on('dragenter dragover', function (e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).addClass('dragover');
            });

            $uploadZone.on('dragleave drop', function (e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('dragover');
            });

            $uploadZone.on('drop', function (e) {
                var files = e.originalEvent.dataTransfer.files;
                if (files.length > 0) {
                    handleFile(files[0]);
                }
            });

            // File input change
            $fileInput.on('change', function () {
                if (this.files && this.files[0]) {
                    handleFile(this.files[0]);
                }
            });

            // Handle selected file and trigger OCR
            async function handleFile(file) {
                var validTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
                if (validTypes.indexOf(file.type) === -1) {
                    showToast('Invalid file type. Please use PDF, JPG, or PNG.', 'error');
                    return;
                }

                if (file.size > 5 * 1024 * 1024) { // 5MB max
                    showToast('File too large. Maximum size is 5MB.', 'error');
                    return;
                }

                var nameStr = file.name;
                var sizeKB = (file.size / 1024).toFixed(1);

                // UI - Loading State
                $('#fileName').text(nameStr + ' (' + sizeKB + ' KB)');
                $('#uploadPreview').addClass('show');
                $uploadZone.addClass('has-file');
                $('#uploadTitle').text('Analyzing Document...');
                $('#uploadDesc').html('<i class="fas fa-spinner fa-spin" style="margin-right: 8px;"></i> Smart Extraction in progress. Please wait...');
                $('#uploadIcon').html('<i class="fas fa-robot text-primary"></i>');
                $('#btnBrowse').hide();

                // Build Form Data for Upload
                let formData = new FormData();
                formData.append('prescription_image', file);

                try {
                    // Pull CSRF Token
                    let csrfToken = $('input[name=_token]').val() || $('meta[name="csrf-token"]').attr('content') || '';

                    // The Fetch Request to the new Controller Route
                    const response = await fetch('/prescription/ocr', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    });

                    const result = await response.json();

                    if (response.ok && result.success) {
                        // UI - Success State
                        $('#uploadIcon').html('<i class="fas fa-check-circle text-success" style="color: #28a745;"></i>');
                        $('#uploadTitle').text('Extraction Complete!');
                        $('#uploadDesc').text('We auto-filled everything we could read. Please double check.');
                        showToast(result.message, 'success');

                        // Map Backend Data into Form Fields Automatically
                        const data = result.data;

                        // Right Eye (OD) mapped to Table Inputs
                        if (data.right.sph !== null) $('#odSph').val(data.right.sph);
                        if (data.right.cyl !== null) $('#odCyl').val(data.right.cyl);
                        if (data.right.axis !== null) $('#odAxis').val(data.right.axis);

                        // Left Eye (OS) mapped to Table Inputs
                        if (data.left.sph !== null) $('#osSph').val(data.left.sph);
                        if (data.left.cyl !== null) $('#osCyl').val(data.left.cyl);
                        if (data.left.axis !== null) $('#osAxis').val(data.left.axis);

                        // Pupillary Distance
                        if (data.pd !== null) $('#pdInput').val(data.pd);

                        // Trigger blur event on JS formatted fields (adds + automatically if >= 0)
                        setTimeout(() => { $('.refraction-input').trigger('blur'); }, 100);

                    } else {
                        // Error Block if extraction was inconclusive (422)
                        $('#uploadIcon').html('<i class="fas fa-exclamation-triangle text-warning" style="color: #ffc107;"></i>');
                        $('#uploadTitle').text('Manual Check Required');
                        $('#uploadDesc').text(result.message || 'Couldn\'t confidently read the handwriting. Please type values manually.');
                        showToast(result.message || 'Extraction failed.', 'error');
                    }

                } catch (error) {
                    console.error("OCR Request failed:", error);
                    $('#uploadIcon').html('<i class="fas fa-times-circle text-danger" style="color: #dc3545;"></i>');
                    $('#uploadTitle').text('Upload Failed');
                    $('#uploadDesc').text('Network connectivity error. We could not reach the server.');
                    showToast('Connection error. Please submit data manually.', 'error');
                }
            }

            // Remove file
            $('#removeFile').on('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                $fileInput.val('');
                $('#uploadPreview').removeClass('show');
                $uploadZone.removeClass('has-file');
                $('#uploadTitle').text('Drag & Drop Prescription Photo');
                $('#uploadDesc').html('Supports PDF, JPG, or PNG files. Please ensure all<br>values (SPH, CYL, Axis) are clearly visible.');
                $('#uploadIcon').html('<i class="fas fa-cloud-arrow-up"></i>');
                $('#btnBrowse').show();
            });

            // ========================================
            // REFRACTION INPUT FORMATTING
            // ========================================
            $('.refraction-input').on('focus', function () {
                $(this).select();
                $(this).closest('tr').css('background', '#fafcff');
            });

            $('.refraction-input').on('blur', function () {
                $(this).closest('tr').css('background', '');
                var field = $(this).data('field');
                var val = $(this).val().trim();

                if (field === 'sph' || field === 'cyl') {
                    // Format with sign
                    var num = parseFloat(val);
                    if (!isNaN(num)) {
                        if (num >= 0) {
                            $(this).val('+' + num.toFixed(2));
                        } else {
                            $(this).val(num.toFixed(2));
                        }
                    }
                } else if (field === 'axis') {
                    var axisVal = parseInt(val);
                    if (!isNaN(axisVal)) {
                        // Clamp between 0 and 180
                        axisVal = Math.max(0, Math.min(180, axisVal));
                        $(this).val(axisVal);
                    }
                }
            });

            // ========================================
            // SAVE PD BUTTON
            // ========================================
            $('#btnSavePD').on('click', function (e) {
                e.preventDefault();
                var pdVal = parseFloat($('#pdInput').val());
                var $btn = $(this);

                if (isNaN(pdVal) || pdVal < 40 || pdVal > 80) {
                    showToast('Please enter a valid PD value (40-80mm).', 'error');
                    $('#pdInput').css('border-color', '#dc3545');
                    setTimeout(function () {
                        $('#pdInput').css('border-color', '#e0e6ed');
                    }, 2000);
                    return;
                }

                // Success feedback
                var originalText = $btn.text();
                $btn.text('Saved!').css({
                    'background': '#28a745'
                });

                // Pulse animation on PD input
                $('#pdInput').css('animation', 'pulse 0.6s ease');
                setTimeout(function () {
                    $('#pdInput').css('animation', '');
                }, 600);

                showToast('PD value saved: ' + pdVal + 'mm', 'success');

                setTimeout(function () {
                    $btn.text(originalText).css({
                        'background': ''
                    });
                }, 1500);
            });

            // ========================================
            // SAVE DRAFT
            // ========================================
            $('#btnSaveDraft').on('click', function () {
                var $btn = $(this);
                var originalText = $btn.text();

                $btn.html('<i class="fas fa-spinner fa-spin"></i> Saving...');

                setTimeout(function () {
                    $btn.html('<i class="fas fa-check"></i> Saved!').css({
                        'background': '#e8f5e9',
                        'border-color': '#28a745',
                        'color': '#28a745'
                    });

                    showToast('Draft saved successfully!', 'success');

                    setTimeout(function () {
                        $btn.text(originalText).css({
                            'background': '',
                            'border-color': '',
                            'color': ''
                        });
                    }, 2000);
                }, 800);
            });

            // ========================================
            // SAVE & CONTINUE
            // ========================================
            $('#prescriptionForm').on('submit', function (e) {
                var $btn = $('#btnSaveContinue');
                var isValid = true;

                // Validate only VISIBLE refraction inputs (skip hidden contact-only fields)
                $('.refraction-input:visible').each(function () {
                    var val = $(this).val().trim();
                    if (!val || val === '') {
                        $(this).css('border-color', '#dc3545');
                        isValid = false;
                    } else {
                        $(this).css('border-color', '#e0e6ed');
                    }
                });

                // Validate PD only for eyeglasses (not contacts)
                if (!isContact) {
                    var pdVal = parseFloat($('#pdInput').val());
                    if (isNaN(pdVal) || pdVal < 40 || pdVal > 80) {
                        $('#pdInput').css('border-color', '#dc3545');
                        isValid = false;
                    }
                }

                if (!isValid) {
                    e.preventDefault(); // ONLY prevent submission if validation fails
                    showToast('Please fill in all fields correctly.', 'error');
                    setTimeout(function () {
                        $('.refraction-input, #pdInput').css('border-color', '#e0e6ed');
                    }, 2500);
                    return false;
                }

                // Success - Let the native form submit happen
                $btn.html('<i class="fas fa-spinner fa-spin"></i> Saving...').prop('disabled', true);
            });

            // ========================================
            // CANCEL BUTTON
            // ========================================
            $('#btnCancel').on('click', function () {
                window.history.back();
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

                $('.upload-zone, .refraction-card, .trust-badge').each(function (index) {
                    this.style.opacity = '0';
                    this.style.animationDelay = (index * 0.08) + 's';
                    observer.observe(this);
                });
            }

            // ========================================
            // BOOTSTRAP TOOLTIP INIT
            // ========================================
            $('[title]').each(function () {
                $(this).attr('data-bs-toggle', 'tooltip').attr('data-bs-placement', 'top');
            });
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (el) {
                return new bootstrap.Tooltip(el);
            });

        });
    </script>
@endpush