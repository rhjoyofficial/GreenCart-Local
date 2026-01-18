<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Display checkout page
     */
    public function index()
    {
        $user = Auth::user();

        // Get cart items with product details
        $cart = $user->cart()->with('items.product.seller')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('warning', 'Your cart is empty. Add some products first.');
        }

        // Check stock availability
        $outOfStockItems = [];
        foreach ($cart->items as $item) {
            if ($item->product->stock_quantity < $item->quantity) {
                $outOfStockItems[] = $item->product->name;
            }
        }

        if (!empty($outOfStockItems)) {
            return redirect()->route('cart.index')
                ->with('error', 'Some items in your cart are out of stock: ' . implode(', ', $outOfStockItems));
        }

        return view('frontend.checkout.index', [
            'items' => $cart->items,
            'total' => $cart->items->sum('total_price'),
        ]);
    }

    /**
     * Process the checkout
     */
    public function process(Request $request)
    {
        try {
            $request->validate([
                'shipping_address' => 'required|string|max:500',
                'payment_method' => 'required|string|in:cod,card,mobile_banking',
                'phone' => 'required|string|max:20',
                'terms' => 'required|accepted',
            ]);

            $user = Auth::user();

            // Start database transaction
            return DB::transaction(function () use ($request, $user) {
                // Get cart with items
                $cart = $user->cart()->with('items.product')->first();

                if (!$cart || $cart->items->isEmpty()) {
                    throw new \Exception('Your cart is empty.');
                }

                // Check stock again before processing
                foreach ($cart->items as $item) {
                    if ($item->product->stock_quantity < $item->quantity) {
                        throw new \Exception("Insufficient stock for {$item->product->name}");
                    }
                }

                // Generate order number
                $orderNumber = 'ORD-' . strtoupper(Str::random(8)) . '-' . time();

                // Create the order
                $order = Order::create([
                    'customer_id' => $user->id,
                    'order_number' => $orderNumber,
                    'total_amount' => $cart->items->sum('total_price'),
                    'status' => 'pending',
                    'shipping_address' => $request->shipping_address,
                    'billing_address' => $request->billing_address ?? $request->shipping_address,
                    'payment_method' => $request->payment_method,
                    'payment_status' => $request->payment_method === 'cod' ? 'pending' : 'pending',
                    'notes' => $request->notes,
                    'phone' => $request->phone,
                ]);

                // Create order items from cart items
                foreach ($cart->items as $item) {
                    $order->items()->create([
                        'product_id' => $item->product_id,
                        'seller_id' => $item->product->seller_id,
                        'quantity' => $item->quantity,
                        'unit_price' => $item->unit_price,
                        'total_price' => $item->total_price,
                    ]);

                    // Update product stock
                    $item->product->decrement('stock_quantity', $item->quantity);
                }

                // Clear the cart
                $cart->items()->delete();

                // Create a payment record
                $order->payments()->create([
                    'transaction_id' => 'TXN-' . strtoupper(Str::random(10)),
                    'amount' => $order->total_amount,
                    'method' => $request->payment_method,
                    'status' => $request->payment_method === 'cod' ? 'pending' : 'pending',
                ]);

                // Commit transaction
                DB::commit();

                // Redirect to success page
                return redirect()->route('customer.checkout.success', $order)
                    ->with('success', 'Order placed successfully!');
            });
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to process order: ' . $e->getMessage());
        }
    }

    /**
     * Display order success page
     */
    public function success(Order $order)
    {
        // Verify the order belongs to the authenticated user
        if ($order->customer_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Load order with relationships
        $order->load(['items.product', 'payments']);

        return view('frontend.checkout.success', compact('order'));
    }
}
