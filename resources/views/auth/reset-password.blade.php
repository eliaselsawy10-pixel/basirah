@extends('layouts.app')

@section('title', 'Reset Password — Basirah')

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

    .reset-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #1D3557 0%, #457B9D 50%, #A8DADC 100%);
        padding: 40px 20px;
    }

    .reset-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        max-width: 460px;
        width: 100%;
        padding: 50px 40px;
        text-align: center;
    }

    .reset-card h2 {
        font-size: 1.6rem;
        font-weight: 700;
        color: #1D3557;
        margin-bottom: 10px;
    }

    .reset-card p {
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
</style>
@endpush

@section('content')
<div class="reset-wrapper">
    <div class="reset-card">
        <h2><i class="fas fa-key me-2"></i>Reset Password</h2>
        <p>Enter your new password below.</p>

        @if ($errors->any())
            <div class="alert alert-danger" style="border-radius: 12px; font-size: 0.88rem;">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-floating">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ $email ?? old('email') }}" required>
                <label for="email">Email Address</label>
            </div>

            <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="New Password" required>
                <label for="password">New Password</label>
            </div>

            <div class="form-floating">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
                <label for="password_confirmation">Confirm Password</label>
            </div>

            <button type="submit" class="btn btn-reset">
                <i class="fas fa-check me-2"></i>Reset Password
            </button>
        </form>
    </div>
</div>
@endsection
