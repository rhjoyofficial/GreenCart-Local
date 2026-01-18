<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderItem;

class DashboardController extends Controller
{
    public function index()
    {
        $sellerId = Auth::id();

        $orderItems = OrderItem::where('seller_id', $sellerId);

        return view('seller.dashboard.index', [
            'totalOrders' => $orderItems->distinct('order_id')->count('order_id'),
            'totalRevenue' => $orderItems->sum('total_price'),
            'pendingOrders' => $orderItems
                ->whereHas('order', fn($q) => $q->where('status', 'pending'))
                ->count(),
            'recentOrders' => OrderItem::with(['order', 'product'])
                ->where('seller_id', $sellerId)
                ->latest()
                ->limit(10)
                ->get(),
        ]);
    }
}
