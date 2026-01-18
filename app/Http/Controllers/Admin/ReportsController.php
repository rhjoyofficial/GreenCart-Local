<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\SalesSummaryDaily;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        // Default date range: Last 30 days
        $startDate = $request->get('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        // Sales Overview
        $salesData = $this->getSalesData($startDate, $endDate);
        $topProducts = $this->getTopProducts($startDate, $endDate);
        $topSellers = $this->getTopSellers($startDate, $endDate);
        $salesByDay = $this->getSalesByDay($startDate, $endDate);

        return view('admin.reports.index', compact(
            'salesData',
            'topProducts',
            'topSellers',
            'salesByDay',
            'startDate',
            'endDate'
        ));
    }

    public function sales(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->subMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        $orders = Order::whereBetween('created_at', [$startDate, $endDate])
            ->with('customer')
            ->latest()
            ->paginate(20);

        $totalRevenue = $orders->sum('total_amount');
        $totalOrders = $orders->total();
        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        return view('admin.reports.sales', compact(
            'orders',
            'totalRevenue',
            'totalOrders',
            'avgOrderValue',
            'startDate',
            'endDate'
        ));
    }

    public function products(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->subMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        $products = Product::with(['seller', 'category', 'orderItems' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }])
            ->withCount(['orderItems as total_sold' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate])
                    ->select(DB::raw('SUM(quantity)'));
            }])
            ->withSum(['orderItems as total_revenue' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }], 'total_price')
            ->orderBy('total_sold', 'desc')
            ->paginate(20);

        return view('admin.reports.products', compact('products', 'startDate', 'endDate'));
    }

    public function sellers(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->subMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        $sellers = User::whereHas('role', fn($q) => $q->where('slug', 'seller'))
            ->with(['products', 'sellerOrders' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->withCount(['sellerOrders as total_orders' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->withSum(['sellerOrders as total_revenue' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }], 'total_price')
            ->orderBy('total_revenue', 'desc')
            ->paginate(20);

        return view('admin.reports.sellers', compact('sellers', 'startDate', 'endDate'));
    }

    private function getSalesData($startDate, $endDate)
    {
        $orders = Order::whereBetween('created_at', [$startDate, $endDate]);

        return [
            'total_revenue' => $orders->sum('total_amount'),
            'total_orders' => $orders->count(),
            'average_order_value' => $orders->count() > 0 ? $orders->sum('total_amount') / $orders->count() : 0,
            'pending_orders' => Order::whereBetween('created_at', [$startDate, $endDate])
                ->where('status', 'pending')
                ->count(),
        ];
    }

    private function getTopProducts($startDate, $endDate, $limit = 10)
    {
        return Product::with(['category', 'seller'])
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

    private function getTopSellers($startDate, $endDate, $limit = 10)
    {
        return User::whereHas('role', fn($q) => $q->where('slug', 'seller'))
            ->withCount(['sellerOrders as total_orders' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->withSum(['sellerOrders as total_revenue' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }], 'total_price')
            ->orderBy('total_revenue', 'desc')
            ->limit($limit)
            ->get();
    }

    private function getSalesByDay($startDate, $endDate)
    {
        return SalesSummaryDaily::whereBetween('date', [$startDate, $endDate])
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => $item->date->format('Y-m-d'),
                    'orders' => $item->total_orders,
                    'revenue' => $item->total_amount,
                ];
            });
    }
}
