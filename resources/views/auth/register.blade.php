@extends('layouts.app')
@section('title', 'Sign Up — Basirah')
@section('description_content', 'Create your Basirah account — access premium wholesale optical supplies, manage orders, and shop the best eyewear frames.')

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
            background: #fff;
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
                   LOGIN HERO SECTION
                   — Full-bleed background image with
                     the form card floating on the left
                ======================================== */
        .login-hero {
            position: relative;
            min-height: calc(100vh - 58px);
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        /* Background image — covers the entire section,
                   positioned to show the person on the right */
        .login-hero__bg {
            position: absolute;
            inset: 0;
            z-index: 0;
        }

        .login-hero__bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: right center;
        }

        /* Soft white-to-transparent gradient overlay so
                   the left-side form card is always readable */
        .login-hero__bg::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to right,
                    rgba(255, 255, 255, 0.97) 0%,
                    rgba(255, 255, 255, 0.92) 25%,
                    rgba(255, 255, 255, 0.65) 48%,
                    rgba(255, 255, 255, 0.10) 70%,
                    transparent 100%);
            z-index: 1;
        }

        /* Content layer sits above the bg */
        .login-hero__content {
            position: relative;
            z-index: 2;
            width: 100%;
            padding: 50px 0;
        }

        /* ========================================
                   FORM CARD — Floating on the left
                ======================================== */
        .login-form-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: var(--radius-xl);
            box-shadow: 0 8px 48px rgba(0, 0, 0, 0.08), 0 2px 12px rgba(0, 0, 0, 0.04);
            padding: 44px 40px;
            max-width: 430px;
            width: 100%;
            animation: cardEnter 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes cardEnter {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ========================================
                   FORM HEADER
                ======================================== */
        .login-header {
            margin-bottom: 28px;
        }

        .login-header h1 {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--brand-dark);
            margin-bottom: 4px;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }

        .login-header h1 .glasses-emoji {
            display: inline-block;
            animation: wiggle 2.5s ease-in-out infinite;
        }

        @keyframes wiggle {

            0%,
            100% {
                transform: rotate(0deg);
            }

            25% {
                transform: rotate(-3deg);
            }

            75% {
                transform: rotate(3deg);
            }
        }

        .login-header p {
            font-size: 0.88rem;
            color: var(--text-muted);
            font-weight: 400;
        }

        /* ========================================
                   FORM INPUTS
                ======================================== */
        .form-group-custom {
            margin-bottom: 18px;
            position: relative;
        }

        .form-group-custom label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 5px;
            letter-spacing: 0.02em;
        }

        .input-wrapper {
            position: relative;
        }

        .form-control-custom {
            width: 100%;
            padding: 13px 16px;
            font-size: 0.88rem;
            font-family: var(--font-family);
            color: var(--text-primary);
            background: #fff;
            border: 1.5px solid var(--border-light);
            border-radius: var(--radius-md);
            transition: var(--transition);
            outline: none;
        }

        .form-control-custom::placeholder {
            color: #b8c0cc;
            font-weight: 400;
        }

        .form-control-custom:focus {
            border-color: var(--primary-dark);
            box-shadow: 0 0 0 4px rgba(104, 184, 232, 0.12);
        }

        .input-wrapper .input-icon-right {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.95rem;
            cursor: pointer;
            transition: var(--transition);
            z-index: 2;
        }

        .input-wrapper .input-icon-right:hover {
            color: var(--brand-dark);
        }

        /* Validation error styling */
        .form-control-custom.is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.08);
        }

        .invalid-feedback-custom {
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

        /* ========================================
                   LOGIN BUTTON
                ======================================== */
        .btn-login {
            width: 100%;
            padding: 14px 24px;
            font-size: 0.95rem;
            font-weight: 700;
            font-family: var(--font-family);
            color: #fff;
            background: linear-gradient(135deg, #5B9BD5 0%, #6BAEE0 100%);
            border: none;
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            letter-spacing: 0.02em;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg,
                    transparent,
                    rgba(255, 255, 255, 0.18),
                    transparent);
            transition: left 0.5s ease;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #4A8CC7 0%, #5A9ED5 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(91, 155, 213, 0.40);
        }

        .btn-login:active {
            transform: translateY(0);
            box-shadow: 0 4px 12px rgba(91, 155, 213, 0.30);
        }

        /* ========================================
                   DIVIDER
                ======================================== */
        .login-divider {
            display: flex;
            align-items: center;
            gap: 16px;
            margin: 22px 0;
        }

        .login-divider::before,
        .login-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border-light);
        }

        .login-divider span {
            font-size: 0.78rem;
            color: var(--text-muted);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        /* ========================================
                   SOCIAL LOGIN BUTTON
                ======================================== */
        .btn-social {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px 20px;
            font-size: 0.88rem;
            font-weight: 600;
            font-family: var(--font-family);
            color: var(--text-primary);
            background: #fff;
            border: 1.5px solid var(--border-light);
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-social:hover {
            border-color: var(--primary-dark);
            background: #f8fafc;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        }

        /* ========================================
                   REGISTER LINK
                ======================================== */
        .register-prompt {
            text-align: center;
            margin-top: 24px;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .register-prompt a {
            color: var(--primary-dark);
            font-weight: 700;
            transition: var(--transition);
        }

        .register-prompt a:hover {
            color: var(--brand-dark);
            text-decoration: underline;
        }

        /* ========================================
                   STAGGER ANIMATIONS
                ======================================== */
        .stagger-1 {
            animation: fadeSlideUp 0.5s 0.15s ease both;
        }

        .stagger-2 {
            animation: fadeSlideUp 0.5s 0.25s ease both;
        }

        .stagger-3 {
            animation: fadeSlideUp 0.5s 0.35s ease both;
        }

        .stagger-4 {
            animation: fadeSlideUp 0.5s 0.45s ease both;
        }

        .stagger-5 {
            animation: fadeSlideUp 0.5s 0.55s ease both;
        }

        .stagger-6 {
            animation: fadeSlideUp 0.5s 0.65s ease both;
        }

        .stagger-7 {
            animation: fadeSlideUp 0.5s 0.75s ease both;
        }

        .stagger-8 {
            animation: fadeSlideUp 0.5s 0.85s ease both;
        }

        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(14px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ========================================
                   LOADING STATE
                ======================================== */
        .btn-login.loading {
            pointer-events: none;
            opacity: 0.85;
        }

        .btn-login .spinner-border {
            width: 18px;
            height: 18px;
            border-width: 2px;
            margin-right: 8px;
            display: none;
        }

        .btn-login.loading .spinner-border {
            display: inline-block;
        }

        /* ========================================
                   RESPONSIVE
                ======================================== */
        @media (max-width: 991.98px) {
            .login-hero__bg::after {
                background: linear-gradient(to right,
                        rgba(255, 255, 255, 0.97) 0%,
                        rgba(255, 255, 255, 0.90) 40%,
                        rgba(255, 255, 255, 0.70) 65%,
                        rgba(255, 255, 255, 0.30) 100%);
            }

            .login-form-card {
                max-width: 400px;
                padding: 36px 30px;
            }
        }

        @media (max-width: 767.98px) {
            .login-hero {
                min-height: auto;
                align-items: flex-start;
            }

            .login-hero__bg::after {
                background: linear-gradient(to bottom,
                        rgba(255, 255, 255, 0.95) 0%,
                        rgba(255, 255, 255, 0.80) 60%,
                        rgba(255, 255, 255, 0.50) 100%);
            }

            .login-hero__content {
                padding: 30px 0 50px;
            }

            .login-form-card {
                max-width: 100%;
                margin: 0 auto;
                padding: 30px 22px;
                background: rgba(255, 255, 255, 0.92);
            }
        }

        @media (max-width: 575.98px) {
            .login-header h1 {
                font-size: 1.45rem;
            }

            .login-form-card {
                padding: 26px 18px;
                border-radius: var(--radius-lg);
            }

            .navbar-basirah .navbar-collapse {
                background: #fff;
                border-radius: var(--radius-md);
                padding: 16px;
                margin-top: 8px;
                box-shadow: var(--shadow-md);
            }
        }
    </style>
@endpush

@section('content')
    <!-- ============================================
                 LOGIN HERO SECTION
                 Background image fills the section.
                 Form card floats on the LEFT, overlapping.
            ============================================= -->
    <section class="login-hero" id="loginHero">

        <!-- Full-bleed background image -->
        <div class="login-hero__bg">
            <!-- Using the same hero image as login for consistency -->
            <img src="{{ asset('images/login-hero.png') }}" alt="Person wearing Basirah eyeglasses working at a desk"
                id="login-hero-img">
        </div>

        <!-- Form card overlay -->
        <div class="login-hero__content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-md-7 col-sm-10">
                        <div class="login-form-card" id="loginCard">

                            <!-- Header -->
                            <div class="login-header stagger-1">
                                <h1>Create an Account <span class="glasses-emoji">👓</span></h1>
                                <p>Join us to shop the best frames</p>
                            </div>

                            <!-- Register Form -->
                            <form method="POST" action="{{ route('register') }}" id="registerForm" novalidate>
                                @csrf

                                <!-- Name -->
                                <div class="form-group-custom stagger-2">
                                    <label for="name">Full Name</label>
                                    <div class="input-wrapper">
                                        <input type="text" id="name" name="name"
                                            class="form-control-custom @error('name') is-invalid @enderror"
                                            placeholder="John Doe" value="{{ old('name') }}" required autocomplete="name"
                                            autofocus>
                                    </div>
                                    @error('name')
                                        <span class="invalid-feedback-custom" role="alert">
                                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="form-group-custom stagger-3">
                                    <label for="email">Email</label>
                                    <div class="input-wrapper">
                                        <input type="email" id="email" name="email"
                                            class="form-control-custom @error('email') is-invalid @enderror"
                                            placeholder="yourname@email.com" value="{{ old('email') }}" required
                                            autocomplete="email">
                                    </div>
                                    @error('email')
                                        <span class="invalid-feedback-custom" role="alert">
                                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="form-group-custom stagger-4">
                                    <label for="password">Password</label>
                                    <div class="input-wrapper">
                                        <input type="password" id="password" name="password"
                                            class="form-control-custom @error('password') is-invalid @enderror"
                                            placeholder="••••••••••••" required autocomplete="new-password">
                                        <i class="bi bi-eye-slash input-icon-right toggle-password" data-target="#password"
                                            title="Show password"></i>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback-custom" role="alert">
                                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div class="form-group-custom stagger-5">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <div class="input-wrapper">
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                            class="form-control-custom" placeholder="••••••••••••" required
                                            autocomplete="new-password">
                                        <i class="bi bi-eye-slash input-icon-right toggle-password"
                                            data-target="#password_confirmation" title="Show password"></i>
                                    </div>
                                </div>


                                <!-- Submit Button -->
                                <button type="submit" class="btn-login stagger-6 mt-3" id="btnRegister">
                                    <span class="spinner-border spinner-border-sm text-light" role="status"
                                        aria-hidden="true"></span>
                                    <span class="btn-text">Sign Up</span>
                                </button>
                            </form>

                            <!-- Divider -->
                            <div class="login-divider stagger-7">
                                <span>OR</span>
                            </div>

                            <!-- Social Login -->
                            <button type="button" class="btn-social stagger-7" id="btnGoogleRegister">
                                <svg width="20" height="20" viewBox="0 0 48 48">
                                    <path fill="#FFC107"
                                        d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z" />
                                    <path fill="#FF3D00"
                                        d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z" />
                                    <path fill="#4CAF50"
                                        d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z" />
                                    <path fill="#1976D2"
                                        d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z" />
                                </svg>
                                Sign Up with Google
                            </button>

                            <!-- Login Prompt -->
                            <div class="register-prompt stagger-8">
                                Already have an account?
                                <a href="{{ route('login') }}" id="loginLink">Sign In</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer')

@endsection

@push('script')
    <script>
        $(document).ready(function () {

            // ── Toggle Password Visibility ──
            $('.toggle-password').on('click', function () {
                const target = $(this).data('target');
                const $input = $(target);
                const type = $input.attr('type') === 'password' ? 'text' : 'password';
                $input.attr('type', type);

                $(this)
                    .toggleClass('bi-eye-slash bi-eye')
                    .attr('title', type === 'password' ? 'Show password' : 'Hide password');
            });

            // ── Enhanced Focus States ──
            $('.form-control-custom').on('focus', function () {
                $(this).closest('.input-wrapper').addClass('focused');
            }).on('blur', function () {
                $(this).closest('.input-wrapper').removeClass('focused');
            });

            // ── Form Submit Loading State ──
            $('#registerForm').on('submit', function () {
                const $btn = $('#btnRegister');
                if ($btn.hasClass('loading')) {
                    return false;
                }
                $btn.addClass('loading');
            });

            // ── Navbar Scroll Shadow ──
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