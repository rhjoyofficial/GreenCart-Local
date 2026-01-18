<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    /**
     * Determine if the user can view the order.
     */
    public function view(User $user, Order $order): bool
    {
        if ($user->hasRole('admin')) return true;

        if ($user->hasRole('customer')) {
            return $user->id === $order->customer_id;
        }

        if ($user->hasRole('seller')) {
            // Seller can view if any item in the order belongs to them
            return $order->items()->where('seller_id', $user->id)->exists();
        }

        return false;
    }
}
