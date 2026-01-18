<?php

namespace App\Policies;

use App\Models\OrderItem;
use App\Models\User;

class OrderItemPolicy
{
    public function update(User $user, OrderItem $item): bool
    {
        if ($user->hasRole('admin')) return true;

        // Sellers can only manage their own items
        return $user->hasRole('seller') && $user->id === $item->product->seller_id;
    }
}
