@extends('layouts.app')

@section('title', 'Forgot Password — Basirah')

@section('navbar')
@endsection

@section('footer')
@endsection

@push('style')
<style>
    body {
        margin: 0;
        font-family: 'Inter', sans-serif;
    }

    .forgot-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #1D3557 0%, #457B9D 50%, #A8DADC 100%);
        padding: 40px 20px;
    }

    .forgot-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        max-width: 460px;
        width: 100%;
        padding: 50px 40px;
        text-align: center;
    }

    .forgot-card h2 {
        font-size: 1.6rem;
        font-weight: 700;
        color: #1D3557;
        margin-bottom: 10px;
    }

    .forgot-card p {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 30px;
    }

    .form-floating {
        margin-bottom: 20px;
        text-align: left;
    }

    .form-floating .form-control {
        border-radius: 12px;
        border: 1.5px solid #dce3ea;
        padding: 18px 16px 8px;
        font-size: 0.92rem;
        transition: all 0.3s ease;
    }

    .form-floating .form-control:focus {
        border-color: #1D3557;
        box-shadow: 0 0 0 3px rgba(29, 53, 87, 0.1);
    }

    .btn-reset {
        width: 100%;
        background: #1D3557;
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 14px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        margin-top: 10px;
    }

    .btn-reset:hover {
        background: #2a4a7f;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(29, 53, 87, 0.3);
    }

    .back-link {
        display: block;
        margin-top: 20px;
        color: #1D3557;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.9rem;
        transition: color 0.3s ease;
    }

    .back-link:hover {
        color: #457B9D;
    }

    .alert-success {
        border-radius: 12px;
        font-size: 0.88rem;
    }
</style>
@endpush

@section('content')
<div class="forgot-wrapper">
    <div class="forgot-card">
        <h2><i class="fas fa-lock me-2"></i>Forgot Password?</h2>
        <p>Enter your email address and we'll send you a link to reset your password.</p>

        @if (session('status'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger" style="border-radius: 12px; font-size: 0.88rem;">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-floating">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                <label for="email">Email Address</label>
            </div>

            <button type="submit" class="btn btn-reset">
                <i class="fas fa-paper-plane me-2"></i>Send Reset Link
            </button>
        </form>

        <a href="{{ route('login') }}" class="back-link">
            <i class="fas fa-arrow-left me-1"></i>Back to Login
        </a>
    </div>
</div>
@endsection
