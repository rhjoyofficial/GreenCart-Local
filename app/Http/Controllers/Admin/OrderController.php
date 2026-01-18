<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use App\Guards\OrderStatusGuard;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\OrderNumberGenerator;

class OrderController extends Controller
{
    /**
     * List all orders (global view)
     */
    public function index()
    {
        $orders = Order::with([
            'customer',
            'items.product',
            'items.seller',
        ])
            ->latest()
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show full order details
     */
    public function show(Order $order)
    {
        $order->load([
            'customer',
            'items.product',
            'items.seller',
            'payments',
        ]);

        return view('admin.orders.show', compact('order'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = User::whereHas('role', fn($q) => $q->where('slug', 'customer'))
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $sellers = User::whereHas('role', fn($q) => $q->where('slug', 'seller'))
            ->where('is_active', true)
            ->orderBy('business_name')
            ->get();

        $products = Product::where('approval_status', 'approved')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.orders.create', compact('customers', 'sellers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.seller_id' => 'required|exists:users,id',
            'shipping_address' => 'required|string|max:500',
            'billing_address' => 'nullable|string|max:500',
            'payment_method' => 'required|string',
            'payment_status' => 'required|in:pending,paid,failed',
            'notes' => 'nullable|string',
        ]);

        return DB::transaction(function () use ($request) {
            // Calculate total amount
            $totalAmount = 0;
            $orderItems = [];

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);

                // Check stock
                if ($product->stock_quantity < $item['quantity']) {
                    return back()->withErrors([
                        'items' => "Insufficient stock for product: {$product->name}. Available: {$product->stock_quantity}"
                    ]);
                }

                $unitPrice = $product->price;
                $itemTotal = $unitPrice * $item['quantity'];
                $totalAmount += $itemTotal;

                $orderItems[] = [
                    'product_id' => $item['product_id'],
                    'seller_id' => $item['seller_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $unitPrice,
                    'total_price' => $itemTotal,
                ];

                // Decrement stock
                $product->decrement('stock_quantity', $item['quantity']);
            }

            // Create order
            $order = Order::create([
                'customer_id' => $request->customer_id,
                'order_number' => OrderNumberGenerator::generate(),
                'total_amount' => $totalAmount,
                'status' => OrderStatus::Processing,
                'shipping_address' => $request->shipping_address,
                'billing_address' => $request->billing_address ?? $request->shipping_address,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_status,
                'notes' => $request->notes,
            ]);

            // Create order items
            foreach ($orderItems as $item) {
                $order->items()->create($item);
            }

            return redirect()->route('admin.orders.show', $order)
                ->with('success', 'Order created successfully.');
        });
    }
    /**
     * Admin-controlled status update
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $current = $order->status->value;
        $next = $request->status;

        if (!OrderStatusGuard::canTransition($current, $next)) {
            return back()->withErrors([
                'status' => "Invalid transition: $current → $next",
            ]);
        }

        DB::transaction(function () use ($order, $next) {
            $order->update(['status' => $next]);

            /**
             * Optional hooks (future-ready):
             * - shipped → create shipment
             * - delivered → release seller payout
             * - cancelled → restore stock
             */
            if ($next === OrderStatus::Cancelled->value) {
                foreach ($order->items as $item) {
                    $item->product->increment('stock_quantity', $item->quantity);
                }
            }
        });

        return back()->with('success', 'Order status updated successfully.');
    }

    /**
     * Simple invoice view (HTML / PDF later)
     */
    public function invoice(Order $order)
    {
        $order->load([
            'customer',
            'items.product',
            'items.seller',
        ]);

        return view('admin.orders.invoice', compact('order'));
    }
}
