<!-- ============================================
         NAVBAR (Home Page — Auth Aware)
    ============================================= -->
<nav class="navbar navbar-expand-lg navbar-basirah" id="mainNavbar">
    <div class="container">
        <a class="navbar-brand navbar-brand-logo" href="{{ route('home') }}">
            <span class="logo-icon"><i class="fa-solid fa-glasses"></i></span>
            Basirah
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav gap-1">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('home') }}" id="nav-home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('products.index') }}" id="nav-shop">Shop now</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('favorites.index') }}" id="nav-size" @guest onclick="event.preventDefault(); showAuthAlert();" @endguest>Favourites</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('about') }}" id="nav-about">About</a>
                </li>
            </ul>
        </div>

        {{-- Right Side: Search, Fav, Cart + Auth-specific --}}
        <div class="d-none d-lg-flex align-items-center gap-2 ms-3">
            {{-- Search Icon --}}
            <form action="{{ route('products.index') }}" method="GET" class="navbar-search-form" id="navSearchForm">
                <div class="navbar-search-box">
                    <button type="submit" class="btn-nav-icon" aria-label="Search" id="navSearchBtn">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                    <input type="text" name="search" class="navbar-search-input" placeholder="Search eyewear..." id="navSearchInput" autocomplete="off" value="{{ request('search') }}">
                </div>
            </form>

            @guest
                {{-- Sign In --}}
                <a href="{{ route('login') }}" class="btn btn-sign-in" id="btn-signin">Sign In</a>
                <a href="{{ route('register') }}" class="btn btn-register" id="btn-register">Register</a>
            @endguest

            {{-- Favourites Icon --}}
            <a href="{{ route('favorites.index') }}" class="btn-nav-icon" id="navFavBtn" aria-label="Favorites" @guest onclick="event.preventDefault(); showAuthAlert();" @endguest>
                <i class="fa-regular fa-heart"></i>
                @php $favCount = count(session('favorites', [])); @endphp
                <span class="nav-badge" id="navFavBadge" @if($favCount < 1) style="display:none" @endif>{{ $favCount }}</span>
            </a>

            {{-- Cart Icon --}}
            <a href="{{ route('cart.index') }}" class="btn-nav-icon" id="navCartBtn" aria-label="Cart">
                <i class="fa-solid fa-bag-shopping"></i>
                @php $cartCount = count(session('cart', [])); @endphp
                <span class="nav-badge" id="navCartBadge" @if($cartCount < 1) style="display:none" @endif>{{ $cartCount }}</span>
            </a>

            @auth
            {{-- Profile Dropdown --}}
            <div class="dropdown">
                <a href="#" class="btn-nav-icon dropdown-toggle" id="navUserDropdown" role="button"
                   data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="true">
                    <i class="fa-solid fa-user"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end profile-dropdown" aria-labelledby="navUserDropdown">
                    <li class="dropdown-header profile-dropdown-header">
                        <i class="fa-solid fa-user-circle me-1"></i> {{ auth()->user()->name }}
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('settings.index') }}" id="dropdown-settings">
                            <i class="fa-solid fa-gear me-2"></i> User Settings
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger" href="#" id="btn-logout-link">
                            <i class="fa-solid fa-right-from-bracket me-2"></i> Log Out
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
            @endauth
        </div>
    </div>
</nav>