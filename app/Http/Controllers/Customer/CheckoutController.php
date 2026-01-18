<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $cart = $user->cart?->items()->with('product')->get();

        if (!$cart || $cart->isEmpty()) {
            return redirect()->route('products.index')
                ->with('warning', 'Your cart is empty.');
        }

        return view('frontend.checkout.index', [
            'items' => $cart,
            'total' => $cart->sum('total_price'),
        ]);
    }

    public function process(
        Request $request,
        OrderService $orderService,
        PaymentService $paymentService
    ) {
        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'payment_method' => 'required|string',
        ]);

        $user = Auth::user();
        $cart = $user->cart?->items()->with('product')->get();

        if (!$cart || $cart->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Cart is empty',
            ], 422);
        }

        return DB::transaction(function () use (
            $user,
            $cart,
            $request,
            $orderService,
            $paymentService
        ) {
            /** ------------------------------
             * 1. Stock validation & locking
             * ------------------------------ */
            foreach ($cart as $item) {
                if ($item->product->stock_quantity < $item->quantity) {
                    abort(422, "Insufficient stock for {$item->product->name}");
                }

                $item->product->decrement('stock_quantity', $item->quantity);
            }

            /** ------------------------------
             * 2. Create order + items
             * ------------------------------ */
            $order = $orderService->createOrder(
                $user,
                [
                    'shipping_address' => $request->shipping_address,
                    'total_amount' => $cart->sum('total_price'),
                ],
                $cart->map(fn($item) => [
                    'product_id' => $item->product_id,
                    'seller_id' => $item->product->seller_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'total_price' => $item->total_price,
                ])->toArray()
            );

            /** ------------------------------
             * 3. Process payment
             * ------------------------------ */
            $payment = $paymentService->processPayment($order, [
                'payment_method' => $request->payment_method,
                'transaction_id' => 'TXN-' . uniqid(),
            ]);

            if ($payment->status !== 'success') {
                abort(500, 'Payment failed');
            }

            /** ------------------------------
             * 4. Clear cart
             * ------------------------------ */
            $user->cart->items()->delete();

            return response()->json([
                'success' => true,
                'redirect' => route('customer.checkout.success', $order),
            ]);
        });
    }

    public function success(Order $order)
    {
        $this->authorize('view', $order);

        return view('frontend.checkout.success', compact('order'));
    }
}
