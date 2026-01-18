<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class CartMigrationService
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function migrate(): void
    {
        if (Auth::check()) {
            $this->cartService->migrateGuestCartToUser(Auth::id());
        }
    }
}
