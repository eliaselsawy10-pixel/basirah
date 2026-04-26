@extends('layouts.app')
@section('title', 'About Us | Basirah')
@section('description', 'Basirah — About Us')
@push('style')
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            color: #4a4a4a;
            /* Soft grey/black for body */
            line-height: 1.8;
            padding: 80px 20px;
            display: flex;
            justify-content: center;
        }

        .about-container {
            max-width: 800px;
            width: 100%;
            text-align: center;
        }

        h1,
        h2 {
            color: #1D3557;
            /* Dark Blue */
            font-weight: 700;
            margin-bottom: 24px;
        }

        h1 {
            font-size: 3rem;
            margin-bottom: 60px;
            letter-spacing: -0.02em;
        }

        h2 {
            font-size: 2rem;
            margin-top: 60px;
            letter-spacing: -0.01em;
        }

        p {
            font-weight: 300;
            /* Light weight for body */
            font-size: 1.15rem;
            margin-bottom: 24px;
        }

        .divider {
            width: 60px;
            height: 3px;
            background-color: #1D3557;
            margin: 40px auto;
            border-radius: 2px;
        }

        a.back-link {
            display: inline-block;
            margin-top: 80px;
            color: #1D3557;
            text-decoration: none;
            font-weight: 700;
            border-bottom: 2px solid transparent;
            padding-bottom: 4px;
            transition: border-color 0.3s ease;
        }

        a.back-link:hover {
            border-color: #1D3557;
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
        .btn-nav-icon, .cart-icon {
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

        .btn-nav-icon:hover, .cart-icon:hover {
            color: #1D3557;
            background: #f0f4f8;
        }

        /* Badges */
        .btn-nav-icon .nav-badge, .cart-badge {
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
    </style>
@endpush


@section('content')
    <div class="about-container">

        <h1>About Basirah</h1>

        <h2>Philosophy</h2>
        <p>At Basirah, we believe that clear vision is the foundation of a life well-lived. Our philosophy is rooted in the
            intersection of premium quality and modern elegance. We design and curate eyewear that not only enhances how you
            see the world, but ultimately transforms how the world sees you. True luxury should be effortless, functional,
            and deeply personal.</p>

        <div class="divider"></div>

        <h2>Storyyyyyyyyyyyyyyyyyy Behind the Name</h2>
        <p>The name "Basirah" originates from the Arabic word for "insight" and "deep perception." It represents clarity
            that goes beyond the physical act of seeing. We chose this name because it captures our ultimate mission: to
            provide you with the visual acuity and aesthetic confidence to navigate your life with profound insight. It is a
            tribute to the power of a clear perspective.</p>

        <div class="divider"></div>

        <h2>Why We Do What We Do</h2>
        <p>We do what we do because eyewear is uniquely personal. It sits at the center of your face, frames your
            expressions, and becomes part of your identity. Over the years, we recognized a gap in the market for eyewear
            that seamlessly balances high-end medical function with sophisticated, timeless aesthetics. We are driven by the
            desire to elevate an everyday necessity into an empowering piece of personal style.</p>

        <div class="divider"></div>

        <h2>Our Promiseeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee</h2>
        <p>Our promise to you is unwavering quality, meticulous craftsmanship, and complete transparency. Every piece of
            eyewear is rigorously tested and beautifully crafted to ensure durability and comfort. From your routine eye
            consultations to the moment you put on your frames, we promise an experience that is nothing short of
            exceptional.</p>

        <a href="{{ route('home') }}" class="back-link">&larr; Return to Home</a>
    </div>
@endsection

@section('footer')

@endsection