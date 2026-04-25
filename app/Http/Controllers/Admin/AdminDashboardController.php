<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Review;
use App\Models\Prescription;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * Main admin dashboard with KPIs and charts.
     */
    public function index()
    {
        // ── KPI Cards ──
        $totalRevenue  = Order::sum('total');
        $totalOrders   = Order::count();
        $totalUsers    = User::where('role', '!=', 'admin')->count();
        $totalProducts = Product::count();

        // ── Quick Stats ──
        $pendingOrders      = Order::where('status', 'pending')->count();
        $todayAppointments  = Appointment::whereDate('appointment_date', today())->count();
        $activeReviews      = Review::count();
        $lowStockProducts   = Product::where('stock', '<=', 5)->count();

        // ── Monthly Revenue (last 12 months) for Chart.js ──
        $monthlyRevenue = Order::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('SUM(total) as revenue')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('revenue', 'month')
            ->toArray();

        // Fill in missing months with 0
        $revenueLabels = [];
        $revenueData   = [];
        for ($i = 11; $i >= 0; $i--) {
            $monthKey = now()->subMonths($i)->format('Y-m');
            $revenueLabels[] = now()->subMonths($i)->format('M Y');
            $revenueData[]   = (float) ($monthlyRevenue[$monthKey] ?? 0);
        }

        // ── Order Status Distribution for Doughnut ──
        $orderStatuses = Order::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // ── Recent Orders (last 10) ──
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalRevenue', 'totalOrders', 'totalUsers', 'totalProducts',
            'pendingOrders', 'todayAppointments', 'activeReviews', 'lowStockProducts',
            'revenueLabels', 'revenueData', 'orderStatuses', 'recentOrders'
        ));
    }
}
