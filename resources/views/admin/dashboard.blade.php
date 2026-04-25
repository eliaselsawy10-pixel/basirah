@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- KPI Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-sm-6">
        <div class="kpi-card">
            <div class="kpi-icon blue"><i class="fas fa-dollar-sign"></i></div>
            <div class="kpi-value" data-count="{{ $totalRevenue }}">$0</div>
            <div class="kpi-label">Total Revenue</div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="kpi-card">
            <div class="kpi-icon green"><i class="fas fa-shopping-bag"></i></div>
            <div class="kpi-value" data-count="{{ $totalOrders }}">0</div>
            <div class="kpi-label">Total Orders</div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="kpi-card">
            <div class="kpi-icon amber"><i class="fas fa-users"></i></div>
            <div class="kpi-value" data-count="{{ $totalUsers }}">0</div>
            <div class="kpi-label">Total Users</div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="kpi-card">
            <div class="kpi-icon purple"><i class="fas fa-box-open"></i></div>
            <div class="kpi-value" data-count="{{ $totalProducts }}">0</div>
            <div class="kpi-label">Total Products</div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="admin-card-header">
                <div class="admin-card-title">Revenue Overview</div>
                <span style="font-size:0.75rem;color:var(--text-secondary)">Last 12 months</span>
            </div>
            <canvas id="revenueChart" height="100"></canvas>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="admin-card">
            <div class="admin-card-header">
                <div class="admin-card-title">Order Status</div>
            </div>
            <div style="max-width:260px;margin:0 auto;">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-sm-6">
        <div class="quick-stat">
            <div class="quick-stat-icon" style="background:rgba(245,158,11,0.1);color:var(--warning)"><i class="fas fa-clock"></i></div>
            <div>
                <div class="quick-stat-value">{{ $pendingOrders }}</div>
                <div class="quick-stat-label">Pending Orders</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="quick-stat">
            <div class="quick-stat-icon" style="background:rgba(6,182,212,0.1);color:var(--info)"><i class="fas fa-calendar-day"></i></div>
            <div>
                <div class="quick-stat-value">{{ $todayAppointments }}</div>
                <div class="quick-stat-label">Today's Appointments</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="quick-stat">
            <div class="quick-stat-icon" style="background:rgba(16,185,129,0.1);color:var(--success)"><i class="fas fa-star"></i></div>
            <div>
                <div class="quick-stat-value">{{ $activeReviews }}</div>
                <div class="quick-stat-label">Active Reviews</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="quick-stat">
            <div class="quick-stat-icon" style="background:rgba(239,68,68,0.1);color:var(--danger)"><i class="fas fa-exclamation-triangle"></i></div>
            <div>
                <div class="quick-stat-value">{{ $lowStockProducts }}</div>
                <div class="quick-stat-label">Low Stock Products</div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="admin-card">
    <div class="admin-card-header">
        <div class="admin-card-title">Recent Orders</div>
        <a href="{{ route('admin.orders.index') }}" class="btn-admin btn-admin-outline btn-admin-sm">View All</a>
    </div>
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders as $order)
                <tr>
                    <td><strong>#{{ $order->id }}</strong></td>
                    <td>{{ $order->full_name }}</td>
                    <td>${{ number_format($order->total, 2) }}</td>
                    <td><span class="badge-status {{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center;color:var(--text-secondary);padding:40px;">No orders yet</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('script')
<script>
// Animated counters
document.querySelectorAll('[data-count]').forEach(el => {
    const target = parseFloat(el.dataset.count);
    const isCurrency = el.closest('.kpi-card').querySelector('.kpi-label').textContent.includes('Revenue');
    const duration = 1200;
    const start = performance.now();
    function animate(now) {
        const progress = Math.min((now - start) / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        const current = target * eased;
        el.textContent = isCurrency ? '$' + current.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',') : Math.floor(current).toLocaleString();
        if (progress < 1) requestAnimationFrame(animate);
    }
    requestAnimationFrame(animate);
});

// Revenue Chart
new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
        labels: @json($revenueLabels),
        datasets: [{
            label: 'Revenue',
            data: @json($revenueData),
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59,130,246,0.08)',
            fill: true,
            tension: 0.4,
            borderWidth: 2.5,
            pointBackgroundColor: '#3b82f6',
            pointRadius: 4,
            pointHoverRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { callback: v => '$' + v } },
            x: { grid: { display: false } }
        }
    }
});

// Status Doughnut
const statusData = @json($orderStatuses);
const statusColors = { pending: '#f59e0b', processing: '#3b82f6', shipped: '#6366f1', delivered: '#10b981', cancelled: '#ef4444' };
new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: Object.keys(statusData).map(s => s.charAt(0).toUpperCase() + s.slice(1)),
        datasets: [{
            data: Object.values(statusData),
            backgroundColor: Object.keys(statusData).map(s => statusColors[s] || '#94a3b8'),
            borderWidth: 0,
            hoverOffset: 6
        }]
    },
    options: {
        responsive: true,
        cutout: '68%',
        plugins: { legend: { position: 'bottom', labels: { padding: 16, usePointStyle: true, pointStyle: 'circle', font: { size: 11 } } } }
    }
});
</script>
@endpush
