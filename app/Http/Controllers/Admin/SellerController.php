<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SellerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::whereHas('role', fn($q) => $q->where('slug', 'seller'))
            ->withCount(['products', 'sellerOrders']);

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('business_name', 'like', "%$search%");
            });
        }

        // Filter by status
        if ($request->has('is_active') && $request->is_active !== 'all') {
            $query->where('is_active', $request->is_active === 'active');
        }

        $sellers = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.sellers.index', compact('sellers'));
    }

    public function show(User $seller)
    {
        // Verify this is a seller
        if (!$seller->hasRole('seller')) {
            abort(404);
        }

        $seller->load(['products.category']);

        // Seller statistics
        $stats = [
            'total_products' => $seller->products()->count(),
            'active_products' => $seller->products()->where('is_active', true)->count(),
            'pending_products' => $seller->products()->where('approval_status', 'pending')->count(),
            'total_orders' => OrderItem::where('seller_id', $seller->id)->distinct('order_id')->count('order_id'),
            'total_revenue' => OrderItem::where('seller_id', $seller->id)->sum('total_price'),
            'monthly_revenue' => OrderItem::where('seller_id', $seller->id)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('total_price'),
        ];

        // Recent orders
        $recentOrders = OrderItem::where('seller_id', $seller->id)
            ->with(['order.customer', 'product'])
            ->latest()
            ->take(10)
            ->get();

        // Recent products
        $recentProducts = $seller->products()
            ->with('category')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.sellers.show', compact('seller', 'stats', 'recentOrders', 'recentProducts'));
    }

    public function edit(User $seller)
    {
        if (!$seller->hasRole('seller')) {
            abort(404);
        }

        return view('admin.sellers.edit', compact('seller'));
    }

    public function update(Request $request, User $seller)
    {
        if (!$seller->hasRole('seller')) {
            abort(404);
        }

        $request->validate([
            'business_name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:30',
            'address_line1' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);

        $seller->update($request->all());

        return redirect()->route('admin.sellers.index')
            ->with('success', 'Seller updated successfully.');
    }

    public function destroy(User $seller)
    {
        if (!$seller->hasRole('seller')) {
            abort(404);
        }

        // Check if seller has products or orders
        if ($seller->products()->exists() || OrderItem::where('seller_id', $seller->id)->exists()) {
            return back()->with('error', 'Cannot delete seller with existing products or orders.');
        }

        $seller->delete();

        return redirect()->route('admin.sellers.index')
            ->with('success', 'Seller deleted successfully.');
    }

    public function toggleStatus(User $seller)
    {
        if (!$seller->hasRole('seller')) {
            abort(404);
        }

        $seller->update(['is_active' => !$seller->is_active]);

        $status = $seller->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "Seller {$status} successfully.");
    }

    public function products(User $seller)
    {
        if (!$seller->hasRole('seller')) {
            abort(404);
        }

        $products = $seller->products()
            ->with('category')
            ->latest()
            ->paginate(20);

        return view('admin.sellers.products', compact('seller', 'products'));
    }

    public function orders(User $seller)
    {
        if (!$seller->hasRole('seller')) {
            abort(404);
        }

        $orders = OrderItem::where('seller_id', $seller->id)
            ->with(['order.customer', 'product'])
            ->select('order_id', DB::raw('MAX(created_at) as latest_date'))
            ->groupBy('order_id')
            ->orderBy('latest_date', 'desc')
            ->paginate(20);

        return view('admin.sellers.orders', compact('seller', 'orders'));
    }

    public function analytics(User $seller)
    {
        if (!$seller->hasRole('seller')) {
            abort(404);
        }

        // Sales data for last 6 months
        $salesData = [];
        $salesLabels = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $salesLabels[] = $month->format('M Y');

            $monthRevenue = OrderItem::where('seller_id', $seller->id)
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->sum('total_price');

            $salesData[] = $monthRevenue;
        }

        // Top selling products
        $topProducts = Product::where('seller_id', $seller->id)
            ->withCount(['orderItems as total_sold' => function ($query) {
                $query->select(DB::raw('SUM(quantity)'));
            }])
            ->withSum(['orderItems as total_revenue'], 'total_price')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        // Order status distribution
        $orderStatusData = OrderItem::where('seller_id', $seller->id)
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->select('orders.status', DB::raw('COUNT(DISTINCT orders.id) as count'))
            ->groupBy('orders.status')
            ->get();

        // Total statistics
        $totalStats = [
            'total_orders' => OrderItem::where('seller_id', $seller->id)->distinct('order_id')->count('order_id'),
            'total_revenue' => OrderItem::where('seller_id', $seller->id)->sum('total_price'),
            'total_products' => $seller->products()->count(),
            'avg_order_value' => OrderItem::where('seller_id', $seller->id)
                ->select('order_id', DB::raw('SUM(total_price) as order_total'))
                ->groupBy('order_id')
                ->get()
                ->avg('order_total'),
        ];

        return view('admin.sellers.analytics', compact(
            'seller',
            'salesData',
            'salesLabels',
            'topProducts',
            'orderStatusData',
            'totalStats'
        ));
    }

    public function payouts(User $seller)
    {
        if (!$seller->hasRole('seller')) {
            abort(404);
        }

        // This would integrate with your payout system
        $payouts = []; // Payout::where('seller_id', $seller->id)->get();
        $pendingAmount = OrderItem::where('seller_id', $seller->id)
            ->whereHas('order', fn($q) => $q->where('status', 'delivered'))
            ->sum('total_price');

        return view('admin.sellers.payouts', compact('seller', 'payouts', 'pendingAmount'));
    }
}
