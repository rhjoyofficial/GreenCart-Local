<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\Order;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $orders = Order::all();

        foreach ($orders as $order) {
            $paymentStatus = ($order->payment_status === 'paid') ? 'success' : $order->payment_status;

            Payment::create([
                'order_id' => $order->id,
                'gateway_name' => $this->getGatewayFromMethod($order->payment_method),
                'transaction_id' => 'TXN' . strtoupper(uniqid()),
                'amount' => $order->total_amount,
                'status' => $paymentStatus,
                'currency' => 'BDT',
                'raw_response' => json_encode([
                    'payment_method' => $order->payment_method,
                    'order_id' => $order->id,
                    'timestamp' => now()->toISOString(),
                ]),
                'created_at' => $order->created_at,
            ]);
        }
    }

    private function getGatewayFromMethod(string $method): string
    {
        $mapping = [
            'Cash on Delivery' => 'COD',
            'Credit Card' => 'SSLCommerz',
            'bKash' => 'bKash',
            'Nagad' => 'Nagad',
            'Bank Transfer' => 'Bank',
        ];

        return $mapping[$method] ?? 'SSLCommerz';
    }
}
