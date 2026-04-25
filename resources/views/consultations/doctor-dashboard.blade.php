@extends('layouts.app')
@section('title', 'Doctor Dashboard — Basirah Optical')
@section('description', 'Manage your consultations and join video meetings with patients.')
@push('style')
    <style>
        :root {
            --primary: #BDE3F9;
            --primary-hover: #9AD4F5;
            --primary-dark: #68B8E8;
            --accent: #007BFF;
            --dark: #1D3557;
            --body-bg: #ffffff;
            --text-primary: #1a1a2e;
            --text-secondary: #555;
            --text-muted: #888;
            --border-light: #eee;
            --section-bg: #f8fafc;
            --font-family: 'Inter', sans-serif;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 20px rgba(0, 0, 0, 0.08);
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

        /* ── PAGE HERO ── */
        .page-hero {
            padding: 48px 0 16px;
            background: #fff;
        }

        .page-hero h1 {
            font-size: 2rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 8px;
            letter-spacing: -0.02em;
        }

        .page-hero p {
            color: var(--text-secondary);
            font-size: 0.92rem;
            max-width: 520px;
            line-height: 1.7;
        }

        .doctor-welcome {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-top: 16px;
        }

        .doctor-welcome img {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            border: 3px solid var(--primary);
            object-fit: cover;
        }

        .doctor-welcome-info h3 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--dark);
            margin: 0;
        }

        .doctor-welcome-info span {
            font-size: 0.82rem;
            color: #0ea5a0;
            font-weight: 600;
        }

        /* ── MAIN CONTENT ── */
        .main-content {
            padding: 32px 0 60px;
            background: var(--section-bg);
            min-height: 50vh;
        }

        /* ── SECTION HEADERS ── */
        .section-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid #e8ecf0;
        }

        .section-header i {
            font-size: 1.1rem;
            color: var(--accent);
        }

        .section-header h2 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--dark);
            margin: 0;
        }

        .section-header .badge-count {
            background: var(--accent);
            color: #fff;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            margin-left: 6px;
        }

        /* ── APPOINTMENT CARD (reuse patient page style) ── */
        .appt-card {
            background: #fff;
            border: 1.5px solid #e8ecf0;
            border-radius: var(--radius-lg);
            padding: 22px;
            margin-bottom: 16px;
            transition: var(--transition);
            position: relative;
        }

        .appt-card:hover {
            border-color: var(--primary-dark);
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .appt-card.live-now {
            border-color: #28a745;
            box-shadow: 0 0 0 2px rgba(40, 167, 69, 0.15);
        }

        .appt-card-inner {
            display: flex;
            gap: 16px;
            align-items: center;
        }

        .appt-card-left {
            flex: 1;
            min-width: 0;
        }

        .appt-card-right {
            flex-shrink: 0;
            text-align: right;
        }

        .patient-name {
            font-size: 1rem;
            font-weight: 700;
            color: var(--dark);
            margin: 0 0 2px;
        }

        .patient-contact {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 8px;
        }

        .patient-contact a {
            color: var(--accent);
        }

        .appt-detail-row {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .appt-detail-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.82rem;
            color: var(--text-secondary);
        }

        .appt-detail-item i {
            color: var(--accent);
            font-size: 0.85rem;
            width: 14px;
            text-align: center;
        }

        .appt-detail-item strong {
            font-weight: 600;
            color: var(--dark);
        }

        .appt-notes {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 8px;
            font-style: italic;
        }

        /* Status badges */
        .appt-status {
            display: inline-block;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 3px 12px;
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

        /* Join / Price */
        .btn-join-meeting {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #28a745;
            color: #fff;
            font-weight: 700;
            font-size: 0.85rem;
            padding: 10px 24px;
            border: none;
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            animation: pulse-glow 2s ease-in-out infinite;
            margin-top: 8px;
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
            gap: 6px;
            font-size: 0.82rem;
            color: var(--text-secondary);
            margin-top: 8px;
        }

        .meeting-countdown i {
            color: var(--accent);
        }

        .meeting-countdown .countdown-timer {
            font-weight: 700;
            color: var(--dark);
        }

        .appt-price {
            font-size: 0.82rem;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .appt-price span {
            font-weight: 700;
            color: var(--dark);
            font-size: 0.95rem;
        }

        /* Live indicator */
        .live-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #28a745;
            color: #fff;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 3px 12px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            animation: pulse-glow 2s ease-in-out infinite;
        }

        .live-badge .dot {
            width: 6px;
            height: 6px;
            background: #fff;
            border-radius: 50%;
            animation: blink 1s infinite;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.3;
            }
        }

        /* Empty section */
        .empty-section {
            text-align: center;
            padding: 30px 20px;
            color: var(--text-muted);
            font-size: 0.88rem;
        }

        .empty-section i {
            font-size: 1.6rem;
            color: #ddd;
            margin-bottom: 10px;
            display: block;
        }

        /* Stats Row */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 16px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: #fff;
            border: 1.5px solid #e8ecf0;
            border-radius: var(--radius-md);
            padding: 20px;
            text-align: center;
            transition: var(--transition);
        }

        .stat-card:hover {
            border-color: var(--primary-dark);
            box-shadow: var(--shadow-sm);
        }

        .stat-card .stat-number {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--dark);
            line-height: 1;
        }

        .stat-card .stat-label {
            font-size: 0.78rem;
            color: var(--text-muted);
            font-weight: 500;
            margin-top: 4px;
        }

        .stat-card .stat-icon {
            font-size: 1.3rem;
            color: var(--accent);
            margin-bottom: 8px;
        }

        /* Alert */
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

        .appt-card {
            animation: fadeInUp 0.4s ease forwards;
        }

        /* Responsive */
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
                padding: 16px;
            }

            .appt-card-inner {
                flex-direction: column;
                align-items: stretch;
            }

            .appt-card-right {
                text-align: left;
                margin-top: 10px;
            }

            .stats-row {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
@endpush

@section('content')
    <!-- PAGE HERO -->
    <section class="page-hero" id="pageHero">
        <div class="container">
            <h1>Doctor Dashboard</h1>
            <p>View your scheduled consultations. Join video meetings with your patients when the appointment time arrives.
            </p>
            <div class="doctor-welcome">
                <img src="{{ asset($doctor->image ?? 'images/doctor-sarah.png') }}" alt="{{ $doctor->name }}">
                <div class="doctor-welcome-info">
                    <h3>{{ $doctor->name }}</h3>
                    <span>{{ $doctor->title }}</span>
                </div>
            </div>
        </div>
    </section>

    <!-- MAIN CONTENT -->
    <section class="main-content" id="mainContent">
        <div class="container">

            @if(session('error'))
                <div class="alert-banner error">
                    <i class="fas fa-circle-exclamation"></i> {{ session('error') }}
                </div>
            @endif
            @if(session('success'))
                <div class="alert-banner success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <!-- STATS ROW -->
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-calendar-day"></i></div>
                    <div class="stat-number">{{ $todayAppointments->count() }}</div>
                    <div class="stat-label">Today's Appointments</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
                    <div class="stat-number">{{ $upcomingAppointments->count() }}</div>
                    <div class="stat-label">Upcoming</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-video"></i></div>
                    <div class="stat-number">{{ $todayAppointments->filter(fn($a) => $a->canJoinMeeting())->count() }}</div>
                    <div class="stat-label">Live Now</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-check-double"></i></div>
                    <div class="stat-number">{{ $pastAppointments->count() }}</div>
                    <div class="stat-label">Completed</div>
                </div>
            </div>

            <!-- TODAY'S APPOINTMENTS -->
            <div class="section-header">
                <i class="fas fa-calendar-day"></i>
                <h2>Today's Appointments</h2>
                @if($todayAppointments->count() > 0)
                    <span class="badge-count">{{ $todayAppointments->count() }}</span>
                @endif
            </div>

            @if($todayAppointments->isEmpty())
                <div class="empty-section">
                    <i class="fas fa-sun"></i>
                    No appointments scheduled for today.
                </div>
            @else
                @foreach($todayAppointments as $appointment)
                    <div class="appt-card {{ $appointment->canJoinMeeting() ? 'live-now' : '' }}">
                        <div class="appt-card-inner">
                            <div class="appt-card-left">
                                <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px">
                                    <h4 class="patient-name">{{ $appointment->patient_name }}</h4>
                                    @if($appointment->canJoinMeeting())
                                        <span class="live-badge"><span class="dot"></span> LIVE</span>
                                    @else
                                        <span class="appt-status {{ $appointment->status }}">{{ ucfirst($appointment->status) }}</span>
                                    @endif
                                </div>
                                <div class="patient-contact">
                                    <a href="mailto:{{ $appointment->patient_email }}">{{ $appointment->patient_email }}</a>
                                    @if($appointment->patient_phone)
                                        · {{ $appointment->patient_phone }}
                                    @endif
                                </div>
                                <div class="appt-detail-row">
                                    <div class="appt-detail-item">
                                        <i class="fas fa-clock"></i>
                                        <strong>{{ $appointment->time_slot }}</strong>
                                    </div>
                                    @if($appointment->consultation_type)
                                        <div class="appt-detail-item">
                                            <i class="fas fa-tag"></i>
                                            {{ $appointment->consultation_type }}
                                        </div>
                                    @endif
                                    <div class="appt-detail-item">
                                        <i class="fas fa-dollar-sign"></i>
                                        <strong>${{ number_format($appointment->price_paid, 2) }}</strong>
                                    </div>
                                </div>
                                @if($appointment->notes)
                                    <div class="appt-notes">
                                        <i class="fas fa-sticky-note"></i> {{ $appointment->notes }}
                                    </div>
                                @endif
                            </div>
                            <div class="appt-card-right">
                                @if($appointment->canJoinMeeting())
                                    <a href="{{ route('consultation.join', $appointment->meeting_token) }}" class="btn-join-meeting"
                                        target="_blank">
                                        <i class="fas fa-video"></i> Join Meeting
                                    </a>
                                @elseif(!$appointment->isPast() && $appointment->meeting_url)
                                    <div class="meeting-countdown">
                                        <i class="fas fa-hourglass-half"></i>
                                        <span class="countdown-timer"
                                            data-target="{{ $appointment->appointment_date->format('Y-m-d') }}T{{ $appointment->appointment_time }}">...</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

            <!-- UPCOMING APPOINTMENTS -->
            <div class="section-header" style="margin-top: 40px">
                <i class="fas fa-calendar-alt"></i>
                <h2>Upcoming Appointments</h2>
                @if($upcomingAppointments->count() > 0)
                    <span class="badge-count">{{ $upcomingAppointments->count() }}</span>
                @endif
            </div>

            @if($upcomingAppointments->isEmpty())
                <div class="empty-section">
                    <i class="fas fa-calendar-plus"></i>
                    No upcoming appointments scheduled.
                </div>
            @else
                @foreach($upcomingAppointments as $appointment)
                    <div class="appt-card">
                        <div class="appt-card-inner">
                            <div class="appt-card-left">
                                <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px">
                                    <h4 class="patient-name">{{ $appointment->patient_name }}</h4>
                                    <span class="appt-status {{ $appointment->status }}">{{ ucfirst($appointment->status) }}</span>
                                </div>
                                <div class="patient-contact">
                                    <a href="mailto:{{ $appointment->patient_email }}">{{ $appointment->patient_email }}</a>
                                    @if($appointment->patient_phone)
                                        · {{ $appointment->patient_phone }}
                                    @endif
                                </div>
                                <div class="appt-detail-row">
                                    <div class="appt-detail-item">
                                        <i class="fas fa-calendar"></i>
                                        <strong>{{ $appointment->appointment_date->format('M d, Y') }}</strong>
                                    </div>
                                    <div class="appt-detail-item">
                                        <i class="fas fa-clock"></i>
                                        <strong>{{ $appointment->time_slot }}</strong>
                                    </div>
                                    @if($appointment->consultation_type)
                                        <div class="appt-detail-item">
                                            <i class="fas fa-tag"></i>
                                            {{ $appointment->consultation_type }}
                                        </div>
                                    @endif
                                    <div class="appt-detail-item">
                                        <i class="fas fa-dollar-sign"></i>
                                        <strong>${{ number_format($appointment->price_paid, 2) }}</strong>
                                    </div>
                                </div>
                                @if($appointment->notes)
                                    <div class="appt-notes">
                                        <i class="fas fa-sticky-note"></i> {{ $appointment->notes }}
                                    </div>
                                @endif
                            </div>
                            <div class="appt-card-right">
                                <div class="meeting-countdown">
                                    <i class="fas fa-hourglass-half"></i>
                                    <span class="countdown-timer"
                                        data-target="{{ $appointment->appointment_date->format('Y-m-d') }}T{{ $appointment->appointment_time }}">...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

            <!-- RECENT / PAST APPOINTMENTS -->
            @if($pastAppointments->count() > 0)
                <div class="section-header" style="margin-top: 40px">
                    <i class="fas fa-history"></i>
                    <h2>Recent Consultations</h2>
                </div>

                @foreach($pastAppointments as $appointment)
                    <div class="appt-card" style="opacity:0.75">
                        <div class="appt-card-inner">
                            <div class="appt-card-left">
                                <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px">
                                    <h4 class="patient-name">{{ $appointment->patient_name }}</h4>
                                    <span class="appt-status {{ $appointment->status }}">{{ ucfirst($appointment->status) }}</span>
                                </div>
                                <div class="appt-detail-row">
                                    <div class="appt-detail-item">
                                        <i class="fas fa-calendar"></i>
                                        <strong>{{ $appointment->appointment_date->format('M d, Y') }}</strong>
                                    </div>
                                    <div class="appt-detail-item">
                                        <i class="fas fa-clock"></i>
                                        <strong>{{ $appointment->time_slot }}</strong>
                                    </div>
                                    <div class="appt-detail-item">
                                        <i class="fas fa-dollar-sign"></i>
                                        <strong>${{ number_format($appointment->price_paid, 2) }}</strong>
                                    </div>
                                </div>
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

            // Prevent infinite reload loops
            var reloadKey = 'appt_reload_' + window.location.pathname;
            var reloadCount = parseInt(sessionStorage.getItem(reloadKey) || '0', 10);

            setTimeout(function () {
                sessionStorage.setItem(reloadKey, '0');
            }, 10000);

            function safeReload() {
                if (reloadCount < 3) {
                    sessionStorage.setItem(reloadKey, String(reloadCount + 1));
                    location.reload();
                } else {
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
                    var windowStart = new Date(target.getTime() - 15 * 60 * 1000);
                    var now = new Date();
                    var diff = windowStart - now;

                    if (diff <= 0) {
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

            updateCountdowns();
            setInterval(updateCountdowns, 1000);

            // Auto-refresh every 5 minutes to catch status changes
            setTimeout(function () { location.reload(); }, 5 * 60 * 1000);
        });
    </script>
@endpush