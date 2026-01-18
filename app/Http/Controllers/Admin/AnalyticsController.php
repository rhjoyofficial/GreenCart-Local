<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\SalesSummaryDaily;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function overview()
    {
        // Today's stats
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        $todayStats = [
            'orders' => Order::whereDate('created_at', $today)->count(),
            'revenue' => Order::whereDate('created_at', $today)->sum('total_amount'),
            'new_customers' => User::whereDate('created_at', $today)
                ->whereHas('role', fn($q) => $q->where('slug', 'customer'))
                ->count(),
            'new_sellers' => User::whereDate('created_at', $today)
                ->whereHas('role', fn($q) => $q->where('slug', 'seller'))
                ->count(),
        ];

        $yesterdayStats = [
            'orders' => Order::whereDate('created_at', $yesterday)->count(),
            'revenue' => Order::whereDate('created_at', $yesterday)->sum('total_amount'),
        ];

        // Calculate growth
        $orderGrowth = $yesterdayStats['orders'] > 0
            ? (($todayStats['orders'] - $yesterdayStats['orders']) / $yesterdayStats['orders']) * 100
            : ($todayStats['orders'] > 0 ? 100 : 0);

        $revenueGrowth = $yesterdayStats['revenue'] > 0
            ? (($todayStats['revenue'] - $yesterdayStats['revenue']) / $yesterdayStats['revenue']) * 100
            : ($todayStats['revenue'] > 0 ? 100 : 0);

        // Weekly stats
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();

        $weeklyStats = [
            'orders' => Order::whereBetween('created_at', [$weekStart, $weekEnd])->count(),
            'revenue' => Order::whereBetween('created_at', [$weekStart, $weekEnd])->sum('total_amount'),
            'customers' => User::whereBetween('created_at', [$weekStart, $weekEnd])
                ->whereHas('role', fn($q) => $q->where('slug', 'customer'))
                ->count(),
        ];

        // Monthly stats
        $monthStart = Carbon::now()->startOfMonth();
        $monthEnd = Carbon::now()->endOfMonth();

        $monthlyStats = [
            'orders' => Order::whereBetween('created_at', [$monthStart, $monthEnd])->count(),
            'revenue' => Order::whereBetween('created_at', [$monthStart, $monthEnd])->sum('total_amount'),
            'top_products' => $this->getTopProducts($monthStart, $monthEnd, 5),
        ];

        // Yearly stats
        $yearStart = Carbon::now()->startOfYear();
        $yearEnd = Carbon::now()->endOfYear();

        $yearlyStats = [
            'orders' => Order::whereBetween('created_at', [$yearStart, $yearEnd])->count(),
            'revenue' => Order::whereBetween('created_at', [$yearStart, $yearEnd])->sum('total_amount'),
            'growth' => $this->calculateYearlyGrowth(),
        ];

        // Sales chart data (last 7 days)
        $salesChartData = $this->getSalesChartData(7);

        return view('admin.analytics.overview', compact(
            'todayStats',
            'orderGrowth',
            'revenueGrowth',
            'weeklyStats',
            'monthlyStats',
            'yearlyStats',
            'salesChartData'
        ));
    }

    public function salesTrends(Request $request)
    {
        $period = $request->get('period', '7d'); // 7d, 30d, 90d, 1y

        switch ($period) {
            case '30d':
                $days = 30;
                break;
            case '90d':
                $days = 90;
                break;
            case '1y':
                $days = 365;
                break;
            default:
                $days = 7;
        }

        $salesData = $this->getSalesChartData($days);
        $revenueData = $this->getRevenueChartData($days);
        $orderData = $this->getOrderChartData($days);

        return view('admin.analytics.sales-trends', compact(
            'salesData',
            'revenueData',
            'orderData',
            'period',
            'days'
        ));
    }

    public function customerAnalytics()
    {
        // Customer demographics
        $totalCustomers = User::whereHas('role', fn($q) => $q->where('slug', 'customer'))->count();
        $activeCustomers = User::whereHas('role', fn($q) => $q->where('slug', 'customer'))
            ->where('is_active', true)
            ->count();

        // Customer locations
        $customerLocations = User::whereHas('role', fn($q) => $q->where('slug', 'customer'))
            ->select('city', DB::raw('count(*) as total'))
            ->whereNotNull('city')
            ->groupBy('city')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        // Repeat customers
        $repeatCustomers = User::whereHas('role', fn($q) => $q->where('slug', 'customer'))
            ->has('orders', '>', 1)
            ->count();

        // Customer lifetime value
        $clv = User::whereHas('role', fn($q) => $q->where('slug', 'customer'))
            ->withSum('orders', 'total_amount')
            ->get()
            ->avg('orders_sum_total_amount');

        // New vs returning customers
        $newCustomers = User::whereHas('role', fn($q) => $q->where('slug', 'customer'))
            ->whereDate('created_at', '>=', Carbon::now()->subDays(30))
            ->count();

        $returningCustomers = $totalCustomers - $newCustomers;

        return view('admin.analytics.customers', compact(
            'totalCustomers',
            'activeCustomers',
            'customerLocations',
            'repeatCustomers',
            'clv',
            'newCustomers',
            'returningCustomers'
        ));
    }

    public function productAnalytics()
    {
        // Top performing products
        $topProducts = Product::with(['category', 'seller'])
            ->withCount(['orderItems as total_sold' => function ($query) {
                $query->select(DB::raw('SUM(quantity)'));
            }])
            ->withSum(['orderItems as total_revenue'], 'total_price')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();

        // Low stock products
        $lowStockProducts = Product::where('stock_quantity', '<', 10)
            ->orderBy('stock_quantity')
            ->limit(10)
            ->get();

        // Product approval stats
        $approvalStats = [
            'approved' => Product::where('approval_status', 'approved')->count(),
            'pending' => Product::where('approval_status', 'pending')->count(),
            'rejected' => Product::where('approval_status', 'rejected')->count(),
        ];

        // Category performance
        $categoryPerformance = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'categories.name',
                DB::raw('COUNT(products.id) as product_count'),
                DB::raw('SUM(order_items.quantity) as total_sold')
            )
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total_sold', 'desc')
            ->get();

        return view('admin.analytics.products', compact(
            'topProducts',
            'lowStockProducts',
            'approvalStats',
            'categoryPerformance'
        ));
    }

    private function getSalesChartData($days)
    {
        $data = [];
        $labels = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('M d');

            $revenue = Order::whereDate('created_at', $date)->sum('total_amount');
            $orders = Order::whereDate('created_at', $date)->count();

            $data['revenue'][] = $revenue;
            $data['orders'][] = $orders;
        }

        return [
            'labels' => $labels,
            'datasets' => $data,
        ];
    }

    private function getRevenueChartData($days)
    {
        $data = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $data[] = Order::whereDate('created_at', $date)->sum('total_amount');
        }

        return $data;
    }

    private function getOrderChartData($days)
    {
        $data = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $data[] = Order::whereDate('created_at', $date)->count();
        }

        return $data;
    }

    private function getTopProducts($startDate, $endDate, $limit = 5)
    {
        return Product::with(['category'])
            ->withCount(['orderItems as total_sold' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate])
                    ->select(DB::raw('SUM(quantity)'));
            }])
            ->withSum(['orderItems as total_revenue' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }], 'total_price')
            ->orderBy('total_sold', 'desc')
            ->limit($limit)
            ->get();
    }

    private function calculateYearlyGrowth()
    {
        $currentYear = Carbon::now()->year;
        $lastYear = $currentYear - 1;

        $currentYearRevenue = Order::whereYear('created_at', $currentYear)->sum('total_amount');
        $lastYearRevenue = Order::whereYear('created_at', $lastYear)->sum('total_amount');

        if ($lastYearRevenue > 0) {
            return (($currentYearRevenue - $lastYearRevenue) / $lastYearRevenue) * 100;
        }

        return $currentYearRevenue > 0 ? 100 : 0;
    }
}
