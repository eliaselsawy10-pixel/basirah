@extends('layouts.app')
@section('title', 'My Appointments — Basirah Optical')
@section('description', 'View and manage your booked consultations with Basirah eye care specialists.')
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
            -webkit-font-smoothing: antialiased;
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
            min-height: 50vh;
        }

        /* ========================================
               APPOINTMENT CARD
            ======================================== */
        .appt-card {
            background: #fff;
            border: 1.5px solid #e8ecf0;
            border-radius: var(--radius-lg);
            padding: 24px;
            margin-bottom: 20px;
            transition: var(--transition);
            position: relative;
            animation: fadeInUp 0.5s ease forwards;
        }

        .appt-card:hover {
            border-color: var(--primary-dark);
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .appt-card-inner {
            display: flex;
            gap: 20px;
        }

        .appt-avatar {
            flex-shrink: 0;
        }

        .appt-avatar img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary);
        }

        .appt-body {
            flex: 1;
            min-width: 0;
        }

        .appt-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 4px;
            gap: 12px;
        }

        .appt-doctor-name {
            font-size: 1.08rem;
            font-weight: 700;
            color: var(--dark);
            margin: 0;
        }

        .appt-doctor-title {
            font-size: 0.85rem;
            font-weight: 600;
            color: #0ea5a0;
            margin-bottom: 10px;
        }

        /* Status badges */
        .appt-status {
            display: inline-block;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 4px 14px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .appt-status.pending {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffc107;
        }

        .appt-status.confirmed {
            background: #d4edda;
            color: #155724;
            border: 1px solid #28a745;
        }

        .appt-status.completed {
            background: #e8f4fd;
            color: #0c5460;
            border: 1px solid #17a2b8;
        }

        .appt-status.cancelled {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #dc3545;
        }

        /* Date / time info */
        .appt-details {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 14px;
        }

        .appt-detail-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.84rem;
            color: var(--text-secondary);
        }

        .appt-detail-item i {
            color: var(--accent);
            font-size: 0.9rem;
            width: 16px;
            text-align: center;
        }

        .appt-detail-item strong {
            font-weight: 600;
            color: var(--dark);
        }

        /* Meeting link area */
        .appt-meeting {
            margin-top: 12px;
            padding-top: 14px;
            border-top: 1px solid #eee;
        }

        .btn-join-meeting {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #28a745;
            color: #fff;
            font-weight: 700;
            font-size: 0.88rem;
            padding: 11px 28px;
            border: none;
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            animation: pulse-glow 2s ease-in-out infinite;
        }

        .btn-join-meeting:hover {
            background: #218838;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
        }

        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.4);
            }

            50% {
                box-shadow: 0 0 0 10px rgba(40, 167, 69, 0);
            }
        }

        .meeting-countdown {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.84rem;
            color: var(--text-secondary);
        }

        .meeting-countdown i {
            color: var(--accent);
        }

        .meeting-countdown .countdown-timer {
            font-weight: 700;
            color: var(--dark);
        }

        .meeting-past-label {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.82rem;
            color: var(--text-muted);
        }

        .meeting-past-label i {
            font-size: 0.9rem;
        }

        /* Price */
        .appt-price {
            font-size: 0.82rem;
            color: var(--text-muted);
            margin-top: 6px;
        }

        .appt-price span {
            font-weight: 700;
            color: var(--dark);
            font-size: 1rem;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: #fff;
            border-radius: var(--radius-lg);
            border: 1.5px solid #e8ecf0;
        }

        .empty-state i {
            font-size: 3rem;
            color: #ddd;
            margin-bottom: 16px;
        }

        .empty-state h3 {
            font-size: 1.1rem;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .empty-state p {
            font-size: 0.88rem;
            color: var(--text-muted);
            margin-bottom: 20px;
        }

        .btn-book-now {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--primary);
            color: var(--dark);
            font-weight: 700;
            font-size: 0.9rem;
            padding: 12px 28px;
            border: none;
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-book-now:hover {
            background: var(--primary-hover);
            color: var(--dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(189, 227, 249, 0.5);
        }

        /* Alert message */
        .alert-banner {
            padding: 12px 20px;
            border-radius: var(--radius-sm);
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-banner.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-banner.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
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

        /* ========================================
               RESPONSIVE
            ======================================== */
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

            .appt-card {
                padding: 18px;
            }

            .appt-avatar img {
                width: 60px;
                height: 60px;
            }

            .appt-header {
                flex-direction: column;
                gap: 8px;
            }

            .appt-details {
                gap: 12px;
            }
        }

        @media (max-width: 575.98px) {
            .appt-card-inner {
                flex-direction: column;
                text-align: center;
            }

            .appt-avatar {
                display: flex;
                justify-content: center;
            }

            .appt-header {
                align-items: center;
            }

            .appt-details {
                justify-content: center;
            }

            .appt-meeting {
                text-align: center;
            }
        }
    </style>
@endpush
@section('navbar')
    @include('layouts.partials.navbar-default')
@endsection
@section('content')
    <!-- ========================================
             PAGE HERO
        ======================================== -->
    <section class="page-hero" id="pageHero">
        <div class="container">
            <h1>My Appointments</h1>
            <p>View your scheduled consultations. When it's time for your appointment, a "Join Consultation" button will
                appear to connect you with your doctor via video call.</p>
        </div>
    </section>

    <!-- ========================================
             MAIN CONTENT
        ======================================== -->
    <section class="main-content" id="mainContent">
        <div class="container">

            {{-- Flash messages --}}
            @if(session('error'))
                <div class="alert-banner error">
                    <i class="fas fa-circle-exclamation"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert-banner success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if($appointments->isEmpty())
                {{-- Empty State --}}
                <div class="empty-state">
                    <i class="fas fa-calendar-plus"></i>
                    <h3>No Appointments Yet</h3>
                    <p>You haven't booked any consultations yet. Schedule one with our certified eye care specialists.</p>
                    <a href="{{ route('appointments.index') }}" class="btn-book-now">
                        <i class="fas fa-plus"></i> Book a Consultation
                    </a>
                </div>
            @else
                @foreach($appointments as $appointment)
                    <div class="appt-card" id="appointmentItem{{ $appointment->id }}" data-appointment-id="{{ $appointment->id }}"
                        @if(!$appointment->isPast() && $appointment->meeting_url && !$appointment->canJoinMeeting() && in_array($appointment->status, ['pending', 'confirmed']))
                            data-meeting-datetime="{{ $appointment->appointment_date->format('Y-m-d') }} {{ $appointment->appointment_time }}"
                        @endif>
                        <div class="appt-card-inner">
                            <div class="appt-avatar">
                                @if($appointment->doctor)
                                    <img src="{{ asset($appointment->doctor->image ?? 'images/doctor-sarah.png') }}"
                                        alt="{{ $appointment->doctor->name }}">
                                @else
                                    <img src="{{ asset('images/doctor-sarah.png') }}" alt="Doctor">
                                @endif
                            </div>
                            <div class="appt-body">
                                <div class="appt-header">
                                    <div>
                                        <h3 class="appt-doctor-name">{{ $appointment->doctor->name ?? 'Doctor' }}</h3>
                                        <div class="appt-doctor-title">{{ $appointment->doctor->title ?? 'Specialist' }}</div>
                                    </div>
                                    <span class="appt-status {{ $appointment->status }}">{{ ucfirst($appointment->status) }}</span>
                                </div>

                                <div class="appt-details">
                                    <div class="appt-detail-item">
                                        <i class="fas fa-calendar"></i>
                                        <strong>{{ $appointment->appointment_date->format('M d, Y') }}</strong>
                                    </div>
                                    <div class="appt-detail-item">
                                        <i class="fas fa-clock"></i>
                                        <strong>{{ $appointment->time_slot }}</strong>
                                    </div>
                                    <div class="appt-detail-item">
                                        <i class="fas fa-user"></i>
                                        {{ $appointment->patient_name }}
                                    </div>
                                </div>

                                <div class="appt-price">
                                    Consultation Fee: <span>${{ number_format($appointment->price_paid, 2) }}</span>
                                </div>

                                {{-- Meeting link section --}}
                                @if(in_array($appointment->status, ['pending', 'confirmed']))
                                    <div class="appt-meeting">
                                        @if($appointment->canJoinMeeting())
                                            {{-- Meeting is LIVE --}}
                                            <a href="{{ route('consultation.join', $appointment->meeting_token) }}" class="btn-join-meeting"
                                                target="_blank" id="joinBtn{{ $appointment->id }}">
                                                <i class="fas fa-video"></i> Join Consultation
                                            </a>
                                        @elseif(!$appointment->isPast() && $appointment->meeting_url)
                                            {{-- Meeting is upcoming — show countdown --}}
                                            <div class="meeting-countdown" id="countdown{{ $appointment->id }}">
                                                <i class="fas fa-hourglass-half"></i>
                                                <span>Meeting link activates in: </span>
                                                <span class="countdown-timer"
                                                    data-target="{{ $appointment->appointment_date->format('Y-m-d') }}T{{ $appointment->appointment_time }}">calculating...</span>
                                            </div>
                                        @else
                                            {{-- Meeting time has passed --}}
                                            <div class="meeting-past-label">
                                                <i class="fas fa-clock-rotate-left"></i>
                                                Consultation time has passed
                                            </div>
                                        @endif
                                    </div>
                                @elseif($appointment->status === 'completed')
                                    <div class="appt-meeting">
                                        <div class="meeting-past-label">
                                            <i class="fas fa-check-circle" style="color:#28a745"></i>
                                            Consultation completed
                                        </div>
                                    </div>
                                @elseif($appointment->status === 'cancelled')
                                    <div class="appt-meeting">
                                        <div class="meeting-past-label">
                                            <i class="fas fa-ban" style="color:#dc3545"></i>
                                            Appointment was cancelled
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
    </section>
@endsection

@section('footer')

@endsection

@push('script')
    <script>
        $(document).ready(function () {

            // ========================================
            // COUNTDOWN TIMERS
            // ========================================

            // Prevent infinite reload loops: track reload attempts
            var reloadKey = 'appt_reload_' + window.location.pathname;
            var reloadCount = parseInt(sessionStorage.getItem(reloadKey) || '0', 10);

            // Reset reload counter after 10 seconds on a successful page load
            setTimeout(function () {
                sessionStorage.setItem(reloadKey, '0');
            }, 10000);

            function safeReload() {
                if (reloadCount < 3) {
                    sessionStorage.setItem(reloadKey, String(reloadCount + 1));
                    location.reload();
                } else {
                    // Max reloads reached — show a manual refresh message
                    $('.countdown-timer').each(function () {
                        $(this).text('Ready — please refresh the page');
                    });
                }
            }

            function updateCountdowns() {
                $('.countdown-timer').each(function () {
                    var $el = $(this);
                    var targetStr = $el.data('target');
                    if (!targetStr) return;

                    var target = new Date(targetStr);
                    // Open window 15 minutes early
                    var windowStart = new Date(target.getTime() - 15 * 60 * 1000);
                    var now = new Date();
                    var diff = windowStart - now;

                    if (diff <= 0) {
                        // Time to reload — the meeting link should now be active
                        $el.text('Meeting is ready!');
                        safeReload();
                        return;
                    }

                    var days = Math.floor(diff / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((diff % (1000 * 60)) / 1000);

                    var parts = [];
                    if (days > 0) parts.push(days + 'd');
                    if (hours > 0) parts.push(hours + 'h');
                    parts.push(minutes + 'm');
                    parts.push(seconds + 's');

                    $el.text(parts.join(' '));
                });
            }

            // Run immediately, then every second
            updateCountdowns();
            setInterval(updateCountdowns, 1000);

        });
    </script>
@endpush