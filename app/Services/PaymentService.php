<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;

class PaymentService
{
    public function processPayment(Order $order, array $paymentData): Payment
    {
        // Here you would call your external Gateway API
        // $response = Http::post('gateway.com/pay', ...);

        return $order->payments()->create([
            'transaction_id' => $paymentData['transaction_id'],
            'amount' => $order->total_amount,
            'status' => 'success',
            'gateway_name' => 'SSLCommerz',
        ]);
    }
}
