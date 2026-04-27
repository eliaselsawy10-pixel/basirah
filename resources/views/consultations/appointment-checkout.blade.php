@extends('layouts.app')
@section('title', 'Appointment Checkout — Basirah Optical')
@section('description_content', 'Complete your consultation payment to confirm your appointment with a Basirah eye doctor.')

@push('style')
    <style>
        /* ========================================
               DESIGN TOKENS
            ======================================== */
        :root {
            --primary: #BDE3F9;
            --primary-hover: #9AD4F5;
            --primary-dark: #68B8E8;
            --accent-blue: #3AAFDB;
            --dark: #1a1a2e;
            --body-bg: #f5f7fa;
            --card-bg: #ffffff;
            --text-primary: #1a1a2e;
            --text-secondary: #555;
            --text-muted: #888;
            --border-light: #e8eaed;
            --border-input: #dde0e4;
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
            --green-success: #22c55e;
        }

        /* ========================================
               GLOBAL RESET & BASE
            ======================================== */
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: var(--font-family);
            color: var(--text-primary);
            background: var(--body-bg);
            line-height: 1.6;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }
        img { max-width: 100%; height: auto; }
        h1,h2,h3,h4,h5,h6 { font-weight: 700; line-height: 1.2; }
        a { text-decoration: none; transition: var(--transition); }

        /* ========================================
               CHECKOUT PAGE LAYOUT
            ======================================== */
        .checkout-wrapper { padding: 40px 0 80px; }

        .checkout-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 32px;
        }
        .checkout-header h1 {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-primary);
        }
        .secure-badge {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 500;
        }
        .secure-badge i { font-size: 0.9rem; }

        /* ========================================
               APPOINTMENT SUMMARY CARD
            ======================================== */
        .appt-summary-card {
            background: var(--card-bg);
            border: 1px solid var(--border-light);
            border-radius: var(--radius-md);
            padding: 28px;
            margin-bottom: 28px;
            box-shadow: var(--shadow-sm);
        }
        .appt-summary-card h2 {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .appt-summary-card h2 i { color: var(--accent-blue); font-size: 1rem; }

        .doctor-summary {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px;
            background: var(--section-bg);
            border-radius: var(--radius-sm);
            margin-bottom: 20px;
        }
        .doctor-summary img {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary);
        }
        .doctor-summary-info h3 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 2px;
        }
        .doctor-summary-info p {
            font-size: 0.82rem;
            color: var(--text-muted);
            margin: 0;
        }

        .appt-detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #f0f2f5;
        }
        .appt-detail-row:last-child { border-bottom: none; }
        .appt-detail-row .label {
            font-size: 0.88rem;
            color: var(--text-muted);
            font-weight: 400;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .appt-detail-row .label i {
            font-size: 0.85rem;
            color: var(--accent-blue);
            width: 18px;
            text-align: center;
        }
        .appt-detail-row .value {
            font-size: 0.88rem;
            color: var(--text-primary);
            font-weight: 600;
        }

        .appt-total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 16px;
            margin-top: 8px;
            border-top: 2px solid var(--border-light);
        }
        .appt-total-row .label {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-primary);
        }
        .appt-total-row .value {
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--dark);
        }

        /* ========================================
               FORM SECTIONS
            ======================================== */
        .checkout-section-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 20px;
        }

        .form-label-checkout {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 6px;
            display: block;
        }
        .form-control-checkout {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid var(--border-input);
            border-radius: var(--radius-sm);
            font-size: 0.88rem;
            font-family: var(--font-family);
            color: var(--text-primary);
            background: #fff;
            transition: var(--transition);
            outline: none;
        }
        .form-control-checkout::placeholder { color: #b0b3b8; font-weight: 400; }
        .form-control-checkout:focus {
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 3px rgba(58, 175, 219, 0.12);
        }
        .form-group-checkout { margin-bottom: 20px; }

        /* ========================================
               PAYMENT METHOD SELECTOR
            ======================================== */
        .payment-methods {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
        }
        .payment-option {
            flex: 1;
            position: relative;
        }
        .payment-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }
        .payment-option-label {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 18px;
            border: 1.5px solid var(--border-input);
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.88rem;
            font-weight: 500;
            color: var(--text-primary);
            background: #fff;
        }
        .payment-option-label:hover { border-color: var(--primary-dark); }
        .payment-option input[type="radio"]:checked + .payment-option-label {
            border-color: var(--accent-blue);
            background: linear-gradient(135deg, #f0f9ff 0%, #e8f6fd 100%);
            box-shadow: 0 0 0 3px rgba(58, 175, 219, 0.10);
        }
        .radio-circle {
            width: 18px;
            height: 18px;
            border: 2px solid var(--border-input);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: var(--transition);
        }
        .payment-option input[type="radio"]:checked + .payment-option-label .radio-circle {
            border-color: var(--accent-blue);
            background: var(--accent-blue);
        }
        .radio-circle::after {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #fff;
            opacity: 0;
            transition: var(--transition);
        }
        .payment-option input[type="radio"]:checked + .payment-option-label .radio-circle::after {
            opacity: 1;
        }

        /* Card Fields */
        .card-fields {
            padding-left: 0;
            margin-top: 4px;
            transition: all 0.35s ease;
        }
        .card-fields.hidden { display: none; }

        /* ========================================
               CTA BUTTON
            ======================================== */
        .btn-complete-payment {
            width: 100%;
            padding: 16px 32px;
            background: linear-gradient(135deg, #3AAFDB 0%, #2a95bf 100%);
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 24px;
            letter-spacing: 0.01em;
        }
        .btn-complete-payment:hover {
            background: linear-gradient(135deg, #2a95bf 0%, #1e7fa6 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(58, 175, 219, 0.35);
        }
        .btn-complete-payment:active { transform: translateY(0); }

        .legal-text {
            font-size: 0.75rem;
            color: var(--text-muted);
            text-align: center;
            margin-top: 16px;
            line-height: 1.5;
        }
        .legal-text a {
            color: var(--text-secondary);
            text-decoration: underline;
            font-weight: 500;
        }
        .legal-text a:hover { color: var(--accent-blue); }

        /* ========================================
               GUARANTEE BADGE
            ======================================== */
        .guarantee-banner {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 20px;
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
            border: 1px solid #bbf7d0;
            border-radius: var(--radius-sm);
            margin-top: 20px;
        }
        .guarantee-banner i {
            font-size: 1.3rem;
            color: var(--green-success);
        }
        .guarantee-banner div {
            font-size: 0.82rem;
            color: #166534;
            line-height: 1.5;
        }
        .guarantee-banner strong {
            display: block;
            font-size: 0.85rem;
            margin-bottom: 2px;
        }

        /* ========================================
               BACK LINK
            ======================================== */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.88rem;
            font-weight: 500;
            color: var(--text-muted);
            margin-bottom: 20px;
            transition: var(--transition);
        }
        .back-link:hover {
            color: var(--accent-blue);
        }
        .back-link i { font-size: 0.78rem; }

        /* ========================================
               ANIMATIONS
            ======================================== */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-in { animation: fadeInUp 0.5s ease forwards; }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }

        /* ========================================
               RESPONSIVE
            ======================================== */
        @media (max-width: 991.98px) {
            .checkout-wrapper { padding: 24px 0 60px; }
            .checkout-header h1 { font-size: 1.5rem; }
            .appt-summary-card { position: static; margin-top: 32px; }
        }
        @media (max-width: 575.98px) {
            .payment-methods { flex-direction: column; }
            .checkout-header { flex-direction: column; align-items: flex-start; gap: 8px; }
            .doctor-summary { flex-direction: column; text-align: center; }
        }
    </style>
@endpush

@section('content')
    <div class="checkout-wrapper">
        <div class="container">

            <a href="{{ route('appointments.index') }}" class="back-link animate-in">
                <i class="fas fa-arrow-left"></i> Back to Consultations
            </a>

            <form action="{{ route('appointments.processCheckout') }}" method="POST" id="appointment-checkout-form">
                @csrf

                <div class="row g-lg-5">
                    <!-- ========================
                         LEFT COLUMN — Payment
                    ========================= -->
                    <div class="col-lg-7">
                        <!-- Checkout Header -->
                        <div class="checkout-header animate-in">
                            <h1>Complete Payment</h1>
                            <span class="secure-badge">
                                <i class="fa-solid fa-lock"></i>
                                Secure Checkout
                            </span>
                        </div>

                        <!-- Payment Method -->
                        <div class="animate-in delay-1">
                            <h2 class="checkout-section-title">Payment Method</h2>

                            <div class="payment-methods">
                                <div class="payment-option">
                                    <input type="radio" name="payment_method" id="pay-credit" value="credit_card" checked>
                                    <label for="pay-credit" class="payment-option-label">
                                        <span class="radio-circle"></span>
                                        <i class="fa-solid fa-credit-card" style="color:var(--accent-blue)"></i>
                                        Credit Card
                                    </label>
                                </div>

                                <div class="payment-option">
                                    <input type="radio" name="payment_method" id="pay-digital" value="digital_wallets">
                                    <label for="pay-digital" class="payment-option-label">
                                        <span class="radio-circle"></span>
                                        <i class="fa-solid fa-wallet" style="color:var(--accent-blue)"></i>
                                        Digital Wallets
                                    </label>
                                </div>
                            </div>

                            <!-- Credit Card Fields -->
                            <div class="card-fields" id="cardFields">
                                <div class="form-group-checkout">
                                    <label for="card_number" class="form-label-checkout">Card Number</label>
                                    <input type="text" name="card_number" id="card_number" class="form-control-checkout"
                                        placeholder="•••• •••• •••• ••••" maxlength="19">
                                </div>

                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="form-group-checkout">
                                            <label for="expiration" class="form-label-checkout">Expiration</label>
                                            <input type="text" name="expiration" id="expiration"
                                                class="form-control-checkout" placeholder="MM / YY" maxlength="7">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group-checkout">
                                            <label for="cvc" class="form-label-checkout">CVC</label>
                                            <input type="text" name="cvc" id="cvc" class="form-control-checkout"
                                                placeholder="123" maxlength="4">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Guarantee -->
                        <div class="guarantee-banner animate-in delay-2">
                            <i class="fa-solid fa-shield-check"></i>
                            <div>
                                <strong>100% Satisfaction Guarantee</strong>
                                Full refund if the consultation doesn't meet your expectations. Cancel up to 1 hour before your appointment.
                            </div>
                        </div>
                    </div>

                    <!-- ========================
                         RIGHT COLUMN — Summary
                    ========================= -->
                    <div class="col-lg-5">
                        <div class="appt-summary-card animate-in delay-2" style="position:sticky; top:90px;">
                            <h2>
                                <i class="fa-solid fa-calendar-check"></i>
                                <span>Appointment Summary</span>
                            </h2>

                            <!-- Doctor Info -->
                            <div class="doctor-summary">
                                <img src="{{ asset($booking['doctor_image'] ?? 'images/doctor-sarah.png') }}" alt="{{ $booking['doctor_name'] }}">
                                <div class="doctor-summary-info">
                                    <h3>{{ $booking['doctor_name'] }}</h3>
                                    <p>{{ $booking['doctor_title'] ?? 'Eye Care Specialist' }}</p>
                                </div>
                            </div>

                            <!-- Appointment Details -->
                            <div class="appt-detail-row">
                                <span class="label"><i class="fa-regular fa-calendar"></i> Date</span>
                                <span class="value">{{ \Carbon\Carbon::parse($booking['appointment_date'])->format('M d, Y') }}</span>
                            </div>
                            <div class="appt-detail-row">
                                <span class="label"><i class="fa-regular fa-clock"></i> Time</span>
                                <span class="value">{{ $booking['time_slot'] }}</span>
                            </div>
                            <div class="appt-detail-row">
                                <span class="label"><i class="fa-solid fa-user"></i> Patient</span>
                                <span class="value">{{ $booking['patient_name'] }}</span>
                            </div>
                            <div class="appt-detail-row">
                                <span class="label"><i class="fa-solid fa-video"></i> Type</span>
                                <span class="value">Virtual Consultation</span>
                            </div>

                            <!-- Total -->
                            <div class="appt-total-row">
                                <span class="label">Total Due</span>
                                <span class="value">${{ number_format($booking['price'], 2) }}</span>
                            </div>

                            <!-- CTA Button -->
                            <button type="submit" class="btn-complete-payment" id="btn-complete-payment">
                                <i class="fa-solid fa-lock"></i>
                                Pay ${{ number_format($booking['price'], 2) }} & Confirm
                            </button>

                            <!-- Legal Text -->
                            <p class="legal-text">
                                By completing payment, you agree to our <a href="#">Terms of Service</a>
                                and <a href="#">Cancellation Policy</a>.
                            </p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer')

@endsection

@push('script')
    <script>
        // ========================================
        // Payment Method Toggle
        // ========================================
        const creditRadio = document.getElementById('pay-credit');
        const digitalRadio = document.getElementById('pay-digital');
        const cardFields = document.getElementById('cardFields');

        function toggleCardFields() {
            if (creditRadio.checked) {
                cardFields.classList.remove('hidden');
            } else {
                cardFields.classList.add('hidden');
            }
        }

        creditRadio.addEventListener('change', toggleCardFields);
        digitalRadio.addEventListener('change', toggleCardFields);
        toggleCardFields();

        // ========================================
        // Card Number Formatting (auto-space)
        // ========================================
        const cardInput = document.getElementById('card_number');
        cardInput.addEventListener('input', function (e) {
            let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
            let formatted = value.match(/.{1,4}/g);
            e.target.value = formatted ? formatted.join(' ') : '';
        });

        // ========================================
        // Expiration Date Formatting (MM / YY)
        // ========================================
        const expInput = document.getElementById('expiration');
        expInput.addEventListener('input', function (e) {
            let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '').replace('/', '');
            if (value.length >= 2) {
                value = value.substring(0, 2) + ' / ' + value.substring(2, 4);
            }
            e.target.value = value;
        });

        // ========================================
        // Navbar Scroll Effect
        // ========================================
        window.addEventListener('scroll', function () {
            const navbar = document.getElementById('mainNavbar');
            if (navbar) {
                if (window.scrollY > 10) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            }
        });
    </script>
@endpush
