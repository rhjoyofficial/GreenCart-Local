<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Enums\OrderStatus;
use App\Guards\OrderStatusGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * List all orders that contain seller items
     */
    public function index()
    {
        $sellerId = Auth::id();

        $orders = Order::whereHas('items', function ($q) use ($sellerId) {
            $q->where('seller_id', $sellerId);
        })
            ->with(['items' => fn($q) => $q->where('seller_id', $sellerId)])
            ->latest()
            ->paginate(15);

        return view('seller.orders.index', compact('orders'));
    }

    /**
     * Show a single order (seller slice only)
     */
    public function show(Order $order)
    {
        $this->authorize('view', $order);

        $order->load([
            'items' => fn($q) => $q->where('seller_id', Auth::id())->with('product'),
        ]);

        return view('seller.orders.show', compact('order'));
    }

    /**
     * Update order status (seller-allowed transitions only)
     */
    public function update(Request $request, Order $order)
    {
        $this->authorize('view', $order);

        $request->validate([
            'status' => 'required|string',
        ]);

        $currentStatus = $order->status->value;
        $newStatus = $request->status;

        // Guard status transition
        if (!OrderStatusGuard::canTransition($currentStatus, $newStatus)) {
            return back()->withErrors([
                'status' => 'Invalid status transition.',
            ]);
        }

        /**
         * Seller rule:
         * Seller can move:
         * pending → processing
         * processing → shipped
         */
        if (!in_array($newStatus, [
            OrderStatus::Processing->value,
            OrderStatus::Shipped->value,
        ])) {
            abort(403, 'Unauthorized status update.');
        }

        $order->update(['status' => $newStatus]);

        return back()->with('success', 'Order status updated.');
    }
}
