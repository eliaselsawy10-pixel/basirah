<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('description_content')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @stack('style')

    <style>
        /* ========== Profile Dropdown (Global) ========== */
        .profile-dropdown {
            min-width: 210px;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
            border: 1px solid #e4e8ec;
            padding: 8px 0;
            animation: dropdownFadeIn 0.2s ease;
        }
        @keyframes dropdownFadeIn {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .profile-dropdown-header {
            font-weight: 600;
            color: #1D3557 !important;
            font-size: 0.88rem;
            padding: 10px 20px;
        }
        .profile-dropdown .dropdown-item {
            font-size: 0.85rem;
            padding: 9px 20px;
            transition: all 0.2s ease;
            font-weight: 500;
        }
        .profile-dropdown .dropdown-item:hover {
            background: #f0f4f8;
        }
        .profile-dropdown .dropdown-item.text-danger:hover {
            background: #fff1f1;
        }
        .profile-dropdown .dropdown-divider {
            margin: 4px 0;
            border-color: #e8ecf1;
        }
        #navUserDropdown.dropdown-toggle::after {
            display: none;
        }
    </style>

</head>

<body>

    @section('navbar')
    @include('layouts.partials.navbar-default')
    @show

    @yield('content')

    @section('footer')
    @include('layouts.partials.footer')
    @show

    <!-- Chatbot Component -->
    @include('components.chatbot')


    <!-- ============================================
         SCRIPTS
    ============================================= -->
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery 3.7 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('script')
    
    <script>
        function showAuthAlert() {
            Swal.fire({
                icon: 'info',
                title: 'Sign In Required',
                text: 'You must sign in to view your favorite products.',
                showCancelButton: true,
                confirmButtonText: 'Sign In',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#1D3557',
                footer: 'Don\'t have an account? <a href="{{ route('register') }}">Create an account</a>'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('login') }}";
                }
            });
        }

        // Logout confirmation via SweetAlert
        $(document).on('click', '#btn-logout-link', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Log Out?',
                text: 'Are you sure you want to log out?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1D3557',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, log out',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        });

        /**
         * Global helper: update a navbar badge count.
         * Shows/hides the badge and adds a pulse animation.
         * @param {string} selector  - e.g. '#navCartBadge' or '#navFavBadge'
         * @param {number} count     - the new count
         */
        function updateNavBadge(selector, count) {
            var $badge = $(selector);
            if ($badge.length) {
                $badge.text(count);
                if (count > 0) {
                    $badge.show().css('transform', 'scale(1.35)');
                    setTimeout(function() { $badge.css('transform', 'scale(1)'); }, 250);
                } else {
                    $badge.hide();
                }
            }
        }

        // Sync badges when user navigates back/forward (bfcache)
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>

</body>

</html>