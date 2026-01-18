<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use App\Guards\OrderStatusGuard;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function createOrder(User $user, array $data, array $items): Order
    {
        return DB::transaction(function () use ($user, $data, $items) {
            $order = $user->orders()->create([
                'order_number' => OrderNumberGenerator::generate(),
                'total_amount' => $data['total_amount'],
                'status' => \App\Enums\OrderStatus::Pending,
                'shipping_address' => $data['shipping_address'],
            ]);

            foreach ($items as $item) {
                $order->items()->create($item);
            }

            return $order;
        });
    }

    public function transitionStatus(Order $order, string $newStatus): bool
    {
        OrderStatusGuard::validate($order->status->value, $newStatus);
        return $order->update(['status' => $newStatus]);
    }
}
