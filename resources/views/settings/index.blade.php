@extends('layouts.app')
@section('title', 'Account Settings — Basirah')
@section('description_content', 'Manage your Basirah account settings — update your name, email, and password.')

@push('style')
    <style>
        /* ========================================
                       CSS CUSTOM PROPERTIES (BRAND TOKENS)
                    ======================================== */
        :root {
            --primary: #BDE3F9;
            --primary-hover: #9AD4F5;
            --primary-dark: #68B8E8;
            --brand-dark: #1D3557;
            --brand-dark-hover: #152A45;
            --dark: #1a1a2e;
            --body-bg: #f0f4f8;
            --card-bg: #ffffff;
            --text-primary: #1a1a2e;
            --text-secondary: #555;
            --text-muted: #888;
            --border-light: #e8ecf1;
            --font-family: 'Inter', sans-serif;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 20px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 8px 40px rgba(0, 0, 0, 0.12);
            --shadow-xl: 0 20px 60px rgba(0, 0, 0, 0.15);
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
            min-height: 100vh;
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
                       SETTINGS PAGE
                    ======================================== */
        .settings-section {
            padding: 50px 0 80px;
            min-height: calc(100vh - 60px);
        }

        .settings-breadcrumb {
            margin-bottom: 32px;
        }

        .settings-breadcrumb a {
            color: var(--text-muted);
            font-size: 0.85rem;
            font-weight: 500;
        }

        .settings-breadcrumb a:hover {
            color: var(--brand-dark);
        }

        .settings-breadcrumb span {
            color: var(--text-muted);
            font-size: 0.85rem;
            margin: 0 6px;
        }

        .settings-breadcrumb .current {
            color: var(--brand-dark);
            font-weight: 600;
        }

        .settings-header {
            margin-bottom: 36px;
            animation: settingsFadeIn 0.5s ease;
        }

        .settings-header h1 {
            font-size: 1.85rem;
            font-weight: 800;
            color: var(--brand-dark);
            margin-bottom: 6px;
            letter-spacing: -0.02em;
        }

        .settings-header p {
            color: var(--text-muted);
            font-size: 0.92rem;
        }

        @keyframes settingsFadeIn {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Settings Cards */
        .settings-card {
            background: var(--card-bg);
            border-radius: var(--radius-xl);
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-light);
            padding: 36px 40px;
            margin-bottom: 28px;
            animation: cardSlideUp 0.5s ease both;
        }

        .settings-card:nth-child(2) {
            animation-delay: 0.1s;
        }

        @keyframes cardSlideUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .settings-card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 28px;
            padding-bottom: 18px;
            border-bottom: 1px solid var(--border-light);
        }

        .settings-card-header .icon-circle {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, #e8f4fd 0%, #d4ecfa 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--brand-dark);
            font-size: 1.05rem;
            flex-shrink: 0;
        }

        .settings-card-header h3 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }

        .settings-card-header p {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin: 2px 0 0;
        }

        /* Form Fields */
        .form-group-settings {
            margin-bottom: 22px;
        }

        .form-group-settings label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 6px;
            letter-spacing: 0.02em;
        }

        .form-control-settings {
            width: 100%;
            padding: 13px 16px;
            font-size: 0.88rem;
            font-family: var(--font-family);
            color: var(--text-primary);
            background: #f8fafc;
            border: 1.5px solid var(--border-light);
            border-radius: var(--radius-md);
            transition: var(--transition);
            outline: none;
        }

        .form-control-settings::placeholder {
            color: #b8c0cc;
            font-weight: 400;
        }

        .form-control-settings:focus {
            border-color: var(--primary-dark);
            box-shadow: 0 0 0 4px rgba(104, 184, 232, 0.12);
            background: #fff;
        }

        .form-control-settings.is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.08);
        }

        .invalid-feedback-settings {
            display: block;
            font-size: 0.78rem;
            color: #dc3545;
            margin-top: 5px;
            font-weight: 500;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-4px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Password Toggle */
        .input-wrapper-settings {
            position: relative;
        }

        .input-wrapper-settings .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.95rem;
            cursor: pointer;
            transition: var(--transition);
            z-index: 2;
            background: none;
            border: none;
            padding: 0;
        }

        .input-wrapper-settings .toggle-password:hover {
            color: var(--brand-dark);
        }

        /* Save Button */
        .btn-save-settings {
            padding: 13px 36px;
            font-size: 0.92rem;
            font-weight: 700;
            font-family: var(--font-family);
            color: #fff;
            background: linear-gradient(135deg, var(--brand-dark) 0%, #274b78 100%);
            border: none;
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            letter-spacing: 0.02em;
        }

        .btn-save-settings::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg,
                    transparent,
                    rgba(255, 255, 255, 0.15),
                    transparent);
            transition: left 0.5s ease;
        }

        .btn-save-settings:hover::before {
            left: 100%;
        }

        .btn-save-settings:hover {
            background: linear-gradient(135deg, #152A45 0%, #1D3557 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(29, 53, 87, 0.35);
        }

        .btn-save-settings:active {
            transform: translateY(0);
        }

        .btn-save-settings .spinner-border {
            width: 18px;
            height: 18px;
            border-width: 2px;
            margin-right: 8px;
            display: none;
        }

        .btn-save-settings.loading .spinner-border {
            display: inline-block;
        }

        .btn-save-settings.loading {
            pointer-events: none;
            opacity: 0.85;
        }

        /* User Avatar Section */
        .settings-avatar-section {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 28px;
            padding-bottom: 24px;
            border-bottom: 1px solid var(--border-light);
        }

        .settings-avatar {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--brand-dark) 0%, #274b78 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.8rem;
            font-weight: 700;
            flex-shrink: 0;
            box-shadow: 0 4px 16px rgba(29, 53, 87, 0.25);
        }

        .settings-avatar-info h4 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 2px;
        }

        .settings-avatar-info p {
            font-size: 0.82rem;
            color: var(--text-muted);
            margin: 0;
        }

        .settings-avatar-info .badge-role {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 6px;
        }

        .badge-role.badge-patient {
            background: #e8f4fd;
            color: var(--brand-dark);
        }

        .badge-role.badge-doctor {
            background: #e8fdf0;
            color: #198754;
        }

        /* Password hint */
        .password-hint {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 4px;
            font-style: italic;
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
                       RESPONSIVE
                    ======================================== */
        @media (max-width: 767.98px) {
            .settings-section {
                padding: 30px 0 60px;
            }

            .settings-card {
                padding: 28px 22px;
                border-radius: var(--radius-lg);
            }

            .settings-header h1 {
                font-size: 1.5rem;
            }

            .settings-avatar-section {
                flex-direction: column;
                text-align: center;
            }

            .btn-save-settings {
                width: 100%;
            }
        }

        @media (max-width: 575.98px) {
            .navbar-basirah .navbar-collapse {
                background: #fff;
                border-radius: var(--radius-md);
                padding: 16px;
                margin-top: 8px;
                box-shadow: var(--shadow-md);
            }

            .settings-card {
                padding: 22px 18px;
            }
        }
    </style>
@endpush


@section('content')
    <section class="settings-section" id="settingsSection">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">

                    {{-- Breadcrumb --}}
                    <div class="settings-breadcrumb">
                        <a href="{{ route('home') }}">Home</a>
                        <span>/</span>
                        <span class="current">Account Settings</span>
                    </div>

                    {{-- Header --}}
                    <div class="settings-header">
                        <h1><i class="fa-solid fa-gear me-2" style="color: var(--primary-dark);"></i>Account Settings</h1>
                        <p>Manage your personal information and security preferences</p>
                    </div>

                    <form action="{{ route('settings.update') }}" method="POST" id="settingsForm" novalidate>
                        @csrf
                        @method('PUT')

                        {{-- Profile Information Card --}}
                        <div class="settings-card">

                            {{-- Avatar --}}
                            <div class="settings-avatar-section">
                                <div class="settings-avatar" id="userAvatar">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div class="settings-avatar-info">
                                    <h4>{{ $user->name }}</h4>
                                    <p>{{ $user->email }}</p>
                                    <span class="badge-role {{ $user->role === 'doctor' ? 'badge-doctor' : 'badge-patient' }}">
                                        <i class="fa-solid {{ $user->role === 'doctor' ? 'fa-stethoscope' : 'fa-user' }} me-1"></i>
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </div>
                            </div>

                            <div class="settings-card-header">
                                <div class="icon-circle">
                                    <i class="fa-solid fa-user-pen"></i>
                                </div>
                                <div>
                                    <h3>Personal Information</h3>
                                    <p>Update your name and email address</p>
                                </div>
                            </div>

                            {{-- Name --}}
                            <div class="form-group-settings">
                                <label for="settings-name">Full Name</label>
                                <input type="text" id="settings-name" name="name"
                                       class="form-control-settings @error('name') is-invalid @enderror"
                                       value="{{ old('name', $user->name) }}"
                                       placeholder="Enter your full name" required>
                                @error('name')
                                    <span class="invalid-feedback-settings" role="alert">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </span>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="form-group-settings">
                                <label for="settings-email">Email Address</label>
                                <input type="email" id="settings-email" name="email"
                                       class="form-control-settings @error('email') is-invalid @enderror"
                                       value="{{ old('email', $user->email) }}"
                                       placeholder="your@email.com" required>
                                @error('email')
                                    <span class="invalid-feedback-settings" role="alert">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Security Card --}}
                        <div class="settings-card">
                            <div class="settings-card-header">
                                <div class="icon-circle">
                                    <i class="fa-solid fa-shield-halved"></i>
                                </div>
                                <div>
                                    <h3>Security</h3>
                                    <p>Change your password to keep your account secure</p>
                                </div>
                            </div>

                            {{-- Current Password --}}
                            <div class="form-group-settings">
                                <label for="settings-current-password">Current Password</label>
                                <div class="input-wrapper-settings">
                                    <input type="password" id="settings-current-password" name="current_password"
                                           class="form-control-settings @error('current_password') is-invalid @enderror"
                                           placeholder="Enter current password" autocomplete="current-password">
                                    <button type="button" class="toggle-password" data-target="#settings-current-password" aria-label="Toggle password visibility">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>
                                </div>
                                @error('current_password')
                                    <span class="invalid-feedback-settings" role="alert">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </span>
                                @enderror
                            </div>

                            {{-- New Password --}}
                            <div class="form-group-settings">
                                <label for="settings-new-password">New Password</label>
                                <div class="input-wrapper-settings">
                                    <input type="password" id="settings-new-password" name="new_password"
                                           class="form-control-settings @error('new_password') is-invalid @enderror"
                                           placeholder="Enter new password" autocomplete="new-password">
                                    <button type="button" class="toggle-password" data-target="#settings-new-password" aria-label="Toggle password visibility">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>
                                </div>
                                <p class="password-hint">Leave blank if you don't want to change your password</p>
                                @error('new_password')
                                    <span class="invalid-feedback-settings" role="alert">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </span>
                                @enderror
                            </div>

                            {{-- Confirm New Password --}}
                            <div class="form-group-settings">
                                <label for="settings-confirm-password">Confirm New Password</label>
                                <div class="input-wrapper-settings">
                                    <input type="password" id="settings-confirm-password" name="new_password_confirmation"
                                           class="form-control-settings"
                                           placeholder="Re-enter new password" autocomplete="new-password">
                                    <button type="button" class="toggle-password" data-target="#settings-confirm-password" aria-label="Toggle password visibility">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Save Button --}}
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn-save-settings" id="btnSaveSettings">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                <i class="fa-solid fa-check me-2"></i> Save Changes
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
@endsection


@push('script')
    <script>
        $(document).ready(function() {

            // ── Toggle password visibility ──
            $(document).on('click', '.toggle-password', function() {
                var target = $($(this).data('target'));
                var icon = $(this).find('i');
                if (target.attr('type') === 'password') {
                    target.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    target.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            // ── SweetAlert on success ──
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Updated!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#1D3557',
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif

            // ── Form submit loading state ──
            $('#settingsForm').on('submit', function() {
                var btn = $('#btnSaveSettings');
                btn.addClass('loading');
            });

            // ── Live avatar initial update ──
            $('#settings-name').on('input', function() {
                var name = $(this).val().trim();
                if (name.length > 0) {
                    $('#userAvatar').text(name.charAt(0).toUpperCase());
                }
            });
        });
    </script>
@endpush
