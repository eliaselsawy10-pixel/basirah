<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Basirah Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
            --sidebar-active: #3b82f6;
            --topbar-height: 64px;
            --content-bg: #f1f5f9;
            --card-bg: #ffffff;
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --accent: #3b82f6;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #06b6d4;
            --radius: 12px;
            --radius-sm: 8px;
            --shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            --shadow-md: 0 4px 6px rgba(0,0,0,0.06), 0 2px 4px rgba(0,0,0,0.04);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--content-bg);
            color: var(--text-primary);
            font-size: 14px;
            overflow-x: hidden;
        }

        /* ── Sidebar ── */
        .admin-sidebar {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            z-index: 1040;
            display: flex; flex-direction: column;
            transition: transform 0.3s cubic-bezier(0.4,0,0.2,1);
        }
        .sidebar-brand {
            height: var(--topbar-height);
            display: flex; align-items: center; gap: 10px;
            padding: 0 24px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .sidebar-brand i { color: var(--accent); font-size: 1.4rem; }
        .sidebar-brand span {
            color: #fff; font-size: 1.25rem; font-weight: 700;
            letter-spacing: -0.5px;
        }
        .sidebar-brand small { color: var(--text-secondary); font-size: 0.65rem; font-weight: 500; text-transform: uppercase; letter-spacing: 1px; }

        .sidebar-nav { flex: 1; overflow-y: auto; padding: 16px 12px; }
        .sidebar-label {
            color: rgba(255,255,255,0.35); font-size: 0.65rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: 1.2px;
            padding: 16px 12px 8px; margin-top: 4px;
        }
        .sidebar-link {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 16px; border-radius: var(--radius-sm);
            color: rgba(255,255,255,0.6); text-decoration: none;
            font-size: 0.85rem; font-weight: 500;
            transition: all 0.2s ease; margin-bottom: 2px;
        }
        .sidebar-link i { width: 20px; text-align: center; font-size: 0.95rem; }
        .sidebar-link:hover { background: var(--sidebar-hover); color: rgba(255,255,255,0.9); }
        .sidebar-link.active {
            background: linear-gradient(135deg, var(--accent), #2563eb);
            color: #fff; font-weight: 600;
            box-shadow: 0 4px 12px rgba(59,130,246,0.3);
        }
        .sidebar-link .badge-count {
            margin-left: auto; background: var(--danger);
            color: #fff; font-size: 0.65rem; padding: 2px 7px;
            border-radius: 50px; font-weight: 600;
        }

        /* ── Topbar ── */
        .admin-topbar {
            position: fixed; top: 0; right: 0;
            left: var(--sidebar-width); height: var(--topbar-height);
            background: var(--card-bg); z-index: 1030;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 28px;
            border-bottom: 1px solid #e2e8f0;
            box-shadow: var(--shadow);
        }
        .topbar-title { font-size: 1.1rem; font-weight: 700; color: var(--text-primary); }
        .topbar-actions { display: flex; align-items: center; gap: 16px; }
        .topbar-actions .btn-store {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: #fff; border: none; padding: 7px 16px;
            border-radius: var(--radius-sm); font-size: 0.8rem;
            font-weight: 600; text-decoration: none;
            transition: all 0.2s ease;
        }
        .topbar-actions .btn-store:hover { transform: translateY(-1px); box-shadow: var(--shadow-md); }
        .topbar-user { display: flex; align-items: center; gap: 10px; }
        .topbar-user-avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), #8b5cf6);
            color: #fff; display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 0.85rem;
        }
        .topbar-user-name { font-weight: 600; font-size: 0.85rem; }
        .topbar-user-role { font-size: 0.7rem; color: var(--text-secondary); }

        .btn-sidebar-toggle {
            display: none; background: none; border: none;
            font-size: 1.3rem; color: var(--text-primary); cursor: pointer;
        }

        /* ── Main Content ── */
        .admin-main {
            margin-left: var(--sidebar-width);
            padding-top: var(--topbar-height);
            min-height: 100vh;
        }
        .admin-content { padding: 28px; }

        /* ── Cards ── */
        .admin-card {
            background: var(--card-bg); border-radius: var(--radius);
            box-shadow: var(--shadow); border: 1px solid #e2e8f0;
            padding: 24px; transition: all 0.2s ease;
        }
        .admin-card:hover { box-shadow: var(--shadow-md); }
        .admin-card-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid #f1f5f9;
        }
        .admin-card-title { font-size: 0.95rem; font-weight: 700; color: var(--text-primary); }

        /* ── KPI Cards ── */
        .kpi-card {
            background: var(--card-bg); border-radius: var(--radius);
            box-shadow: var(--shadow); border: 1px solid #e2e8f0;
            padding: 24px; position: relative; overflow: hidden;
            transition: all 0.3s ease;
        }
        .kpi-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }
        .kpi-card .kpi-icon {
            width: 48px; height: 48px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; margin-bottom: 16px;
        }
        .kpi-card .kpi-icon.blue { background: rgba(59,130,246,0.1); color: var(--accent); }
        .kpi-card .kpi-icon.green { background: rgba(16,185,129,0.1); color: var(--success); }
        .kpi-card .kpi-icon.amber { background: rgba(245,158,11,0.1); color: var(--warning); }
        .kpi-card .kpi-icon.purple { background: rgba(139,92,246,0.1); color: #8b5cf6; }
        .kpi-card .kpi-value { font-size: 1.75rem; font-weight: 800; margin-bottom: 4px; }
        .kpi-card .kpi-label { font-size: 0.8rem; color: var(--text-secondary); font-weight: 500; }
        .kpi-card::after {
            content: ''; position: absolute; top: 0; right: 0;
            width: 120px; height: 120px; border-radius: 50%;
            background: radial-gradient(circle, rgba(59,130,246,0.04), transparent);
            transform: translate(30px, -30px);
        }

        /* ── Tables ── */
        .admin-table { width: 100%; border-collapse: separate; border-spacing: 0; }
        .admin-table thead th {
            background: #f8fafc; color: var(--text-secondary);
            font-size: 0.75rem; font-weight: 600; text-transform: uppercase;
            letter-spacing: 0.5px; padding: 12px 16px;
            border-bottom: 1px solid #e2e8f0;
        }
        .admin-table tbody td {
            padding: 14px 16px; border-bottom: 1px solid #f1f5f9;
            vertical-align: middle; font-size: 0.85rem;
        }
        .admin-table tbody tr { transition: background 0.15s ease; }
        .admin-table tbody tr:hover { background: #f8fafc; }

        /* ── Badges ── */
        .badge-status {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 12px; border-radius: 50px;
            font-size: 0.72rem; font-weight: 600;
        }
        .badge-status.pending { background: #fef3c7; color: #92400e; }
        .badge-status.processing { background: #dbeafe; color: #1e40af; }
        .badge-status.shipped { background: #e0e7ff; color: #3730a3; }
        .badge-status.delivered { background: #d1fae5; color: #065f46; }
        .badge-status.cancelled { background: #fee2e2; color: #991b1b; }
        .badge-status.confirmed { background: #d1fae5; color: #065f46; }
        .badge-status.completed { background: #cffafe; color: #155e75; }
        .badge-status.submitted { background: #dbeafe; color: #1e40af; }
        .badge-status.ordered { background: #d1fae5; color: #065f46; }

        .badge-role {
            padding: 4px 12px; border-radius: 50px;
            font-size: 0.72rem; font-weight: 600;
        }
        .badge-role.patient { background: #dbeafe; color: #1e40af; }
        .badge-role.doctor { background: #d1fae5; color: #065f46; }
        .badge-role.admin { background: #fae8ff; color: #86198f; }

        /* ── Buttons ── */
        .btn-admin {
            padding: 8px 18px; border-radius: var(--radius-sm);
            font-size: 0.8rem; font-weight: 600; border: none;
            cursor: pointer; transition: all 0.2s ease;
            text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-admin-primary { background: var(--accent); color: #fff; }
        .btn-admin-primary:hover { background: #2563eb; color: #fff; transform: translateY(-1px); }
        .btn-admin-success { background: var(--success); color: #fff; }
        .btn-admin-success:hover { background: #059669; color: #fff; }
        .btn-admin-danger { background: var(--danger); color: #fff; }
        .btn-admin-danger:hover { background: #dc2626; color: #fff; }
        .btn-admin-outline {
            background: transparent; color: var(--text-secondary);
            border: 1px solid #e2e8f0;
        }
        .btn-admin-outline:hover { border-color: var(--accent); color: var(--accent); }
        .btn-admin-sm { padding: 5px 12px; font-size: 0.75rem; }

        /* ── Forms ── */
        .admin-input {
            width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0;
            border-radius: var(--radius-sm); font-size: 0.85rem;
            font-family: 'Inter', sans-serif; transition: all 0.2s ease;
            background: #fff;
        }
        .admin-input:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
        .admin-label { font-size: 0.8rem; font-weight: 600; color: var(--text-primary); margin-bottom: 6px; display: block; }
        .admin-select {
            padding: 10px 14px; border: 1px solid #e2e8f0;
            border-radius: var(--radius-sm); font-size: 0.85rem;
            font-family: 'Inter', sans-serif; background: #fff;
            cursor: pointer;
        }
        .admin-select:focus { outline: none; border-color: var(--accent); }

        /* ── Filter Bar ── */
        .filter-bar {
            display: flex; align-items: center; gap: 12px;
            flex-wrap: wrap; margin-bottom: 20px;
        }
        .filter-tabs {
            display: flex; gap: 4px; background: #f1f5f9;
            border-radius: var(--radius-sm); padding: 4px;
        }
        .filter-tab {
            padding: 6px 16px; border-radius: 6px; font-size: 0.78rem;
            font-weight: 500; color: var(--text-secondary); text-decoration: none;
            transition: all 0.2s ease; border: none; background: none; cursor: pointer;
        }
        .filter-tab:hover { color: var(--text-primary); }
        .filter-tab.active { background: #fff; color: var(--accent); font-weight: 600; box-shadow: var(--shadow); }

        /* ── Search Box ── */
        .admin-search {
            position: relative; flex: 1; max-width: 320px;
        }
        .admin-search i {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            color: var(--text-secondary); font-size: 0.85rem;
        }
        .admin-search input {
            width: 100%; padding: 9px 14px 9px 38px; border: 1px solid #e2e8f0;
            border-radius: var(--radius-sm); font-size: 0.85rem;
            font-family: 'Inter', sans-serif;
        }
        .admin-search input:focus { outline: none; border-color: var(--accent); }

        /* ── Product Thumbnail ── */
        .product-thumb {
            width: 44px; height: 44px; border-radius: 8px;
            object-fit: cover; border: 1px solid #e2e8f0;
        }

        /* ── Alert ── */
        .admin-alert {
            padding: 14px 20px; border-radius: var(--radius-sm);
            font-size: 0.85rem; font-weight: 500; margin-bottom: 20px;
            display: flex; align-items: center; gap: 10px;
            animation: slideDown 0.3s ease;
        }
        .admin-alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .admin-alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ── Pagination ── */
        .admin-pagination .page-link {
            border: 1px solid #e2e8f0; color: var(--text-secondary);
            font-size: 0.8rem; padding: 6px 12px; border-radius: 6px;
            margin: 0 2px;
        }
        .admin-pagination .page-item.active .page-link {
            background: var(--accent); border-color: var(--accent); color: #fff;
        }

        /* ── Stars ── */
        .star-rating { color: #f59e0b; font-size: 0.85rem; }
        .star-rating .empty { color: #d1d5db; }

        /* ── Quick Stat ── */
        .quick-stat {
            display: flex; align-items: center; gap: 14px;
            background: var(--card-bg); border-radius: var(--radius);
            box-shadow: var(--shadow); border: 1px solid #e2e8f0;
            padding: 18px 20px; transition: all 0.2s ease;
        }
        .quick-stat:hover { box-shadow: var(--shadow-md); }
        .quick-stat-icon {
            width: 40px; height: 40px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
        }
        .quick-stat-value { font-size: 1.15rem; font-weight: 700; }
        .quick-stat-label { font-size: 0.72rem; color: var(--text-secondary); font-weight: 500; }

        /* ── Responsive ── */
        @media (max-width: 991px) {
            .admin-sidebar { transform: translateX(-100%); }
            .admin-sidebar.open { transform: translateX(0); box-shadow: 4px 0 24px rgba(0,0,0,0.2); }
            .admin-topbar { left: 0; }
            .admin-main { margin-left: 0; }
            .btn-sidebar-toggle { display: block; }
            .sidebar-overlay {
                position: fixed; inset: 0; background: rgba(0,0,0,0.4);
                z-index: 1035; display: none;
            }
            .sidebar-overlay.active { display: block; }
        }
    </style>
    @stack('style')
</head>
<body>

<!-- Sidebar Overlay (mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Sidebar -->
<aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-brand">
        <i class="fa-solid fa-glasses"></i>
        <div>
            <span>Basirah</span><br>
            <small>Admin Panel</small>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="sidebar-label">Main</div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-th-large"></i> Dashboard
        </a>

        <div class="sidebar-label">Management</div>
        <a href="{{ route('admin.products.index') }}" class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="fas fa-box-open"></i> Products
        </a>
        <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="fas fa-shopping-bag"></i> Orders
            @php $pendingCount = \App\Models\Order::where('status','pending')->count(); @endphp
            @if($pendingCount > 0)
            <span class="badge-count">{{ $pendingCount }}</span>
            @endif
        </a>
        <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Users
        </a>
        <a href="{{ route('admin.appointments.index') }}" class="sidebar-link {{ request()->routeIs('admin.appointments.*') ? 'active' : '' }}">
            <i class="fas fa-calendar-check"></i> Appointments
        </a>

        <div class="sidebar-label">Content</div>
        <a href="{{ route('admin.reviews.index') }}" class="sidebar-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
            <i class="fas fa-star"></i> Reviews
        </a>
        <a href="{{ route('admin.prescriptions.index') }}" class="sidebar-link {{ request()->routeIs('admin.prescriptions.*') ? 'active' : '' }}">
            <i class="fas fa-file-medical"></i> Prescriptions
        </a>
    </nav>
</aside>

<!-- Topbar -->
<header class="admin-topbar">
    <div class="d-flex align-items-center gap-3">
        <button class="btn-sidebar-toggle" id="btnSidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <h1 class="topbar-title">@yield('page-title', 'Dashboard')</h1>
    </div>
    <div class="topbar-actions">
        <a href="{{ route('home') }}" class="btn-store" target="_blank">
            <i class="fas fa-external-link-alt me-1"></i> View Store
        </a>
        <div class="topbar-user">
            <div class="topbar-user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div>
                <div class="topbar-user-name">{{ auth()->user()->name }}</div>
                <div class="topbar-user-role">Administrator</div>
            </div>
        </div>
    </div>
</header>

<!-- Main Content -->
<main class="admin-main">
    <div class="admin-content">
        @if(session('success'))
        <div class="admin-alert admin-alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="admin-alert admin-alert-danger">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
        @endif

        @yield('content')
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
    // Sidebar toggle (mobile)
    $('#btnSidebarToggle').on('click', function() {
        $('#adminSidebar').toggleClass('open');
        $('#sidebarOverlay').toggleClass('active');
    });
    $('#sidebarOverlay').on('click', function() {
        $('#adminSidebar').removeClass('open');
        $(this).removeClass('active');
    });

    // Auto-hide alerts
    setTimeout(function() {
        $('.admin-alert').fadeOut(300);
    }, 5000);
</script>
@stack('script')
</body>
</html>
