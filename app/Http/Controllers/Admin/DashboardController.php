<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use App\Models\OrderItem;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Statistics
        $totalRevenue = Order::sum('total_amount');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalUsers = User::count();

        // Active Statistics
        $activeProducts = Product::where('is_active', true)->count();
        $pendingOrders = Order::where('status', 'pending')->count();

        // User Breakdown
        $sellers = User::where('role_id', 2)->count();
        $customers = User::where('role_id', 3)->count();

        // Revenue Growth Calculation (Month over Month)
        $currentMonthRevenue = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');

        $lastMonthRevenue = Order::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('total_amount');

        $revenueGrowth = $lastMonthRevenue > 0
            ? (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100
            : 100;

        // Recent Orders (Last 5)
        $recentOrders = Order::with('customer')
            ->latest()
            ->take(5)
            ->get();

        // Top Selling Products (Based on quantity sold)
        $topProducts = Product::with(['category', 'orderItems'])
            ->withCount(['orderItems as total_sold' => function ($query) {
                $query->select(DB::raw('SUM(quantity)'));
            }])
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();

        // Revenue Chart Data (Last 6 months)
        $revenueData = [];
        $revenueLabels = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $revenueLabels[] = $month->format('M');

            $monthRevenue = Order::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->sum('total_amount');
            $revenueData[] = $monthRevenue;
        }

        // Order Status Distribution
        $orderStatusData = [];
        $orderStatusLabels = ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'];

        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        foreach ($statuses as $status) {
            $orderStatusData[] = Order::where('status', $status)->count();
        }

        // Additional Metrics
        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        $conversionRate = 4.2; // This would come from your analytics system
        $customerSatisfaction = 4.5; // This would come from reviews/ratings

        return view('admin.dashboard.index', compact(
            'totalRevenue',
            'totalOrders',
            'totalProducts',
            'totalUsers',
            'activeProducts',
            'pendingOrders',
            'sellers',
            'customers',
            'revenueGrowth',
            'recentOrders',
            'topProducts',
            'revenueData',
            'revenueLabels',
            'orderStatusData',
            'orderStatusLabels',
            'avgOrderValue',
            'conversionRate',
            'customerSatisfaction'
        ));
    }
}
