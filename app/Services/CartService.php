<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CartService
{
    const SESSION_KEY = 'guest_cart';
    const GUEST_ITEM_PREFIX = 'guest_item_';

    /**
     * Get complete cart data
     */
    public function getCartData(): array
    {
        if (Auth::check()) {
            return $this->getUserCartData();
        }

        return $this->getGuestCartData();
    }

    /**
     * Get cart data for authenticated users
     */
    private function getUserCartData(): array
    {
        $user = Auth::user();
        $cart = $user->cart()->with(['items.product', 'items.product.seller'])->first();

        if (!$cart) {
            return [
                'items' => collect(),
                'subtotal' => 0,
                'total' => 0,
                'item_count' => 0
            ];
        }

        $items = $cart->items->map(function ($item) {
            return [
                'id' => $item->id,
                'cart_item_id' => $item->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
                'total_price' => $item->total_price,
                'product' => [
                    'id' => $item->product->id,
                    'name' => $item->product->name,
                    'slug' => $item->product->slug,
                    'image' => $item->product->image,
                    'stock_quantity' => $item->product->stock_quantity,
                    'seller' => [
                        'name' => $item->product->seller->name ?? 'Unknown Seller',
                        'business_name' => $item->product->seller->business_name ?? null
                    ]
                ]
            ];
        });

        return [
            'items' => $items,
            'subtotal' => $cart->items->sum('total_price'),
            'total' => $cart->items->sum('total_price'),
            'item_count' => $cart->items->sum('quantity')
        ];
    }

    /**
     * Get cart data for guest users
     */
    private function getGuestCartData(): array
    {
        $cart = Session::get(self::SESSION_KEY, ['items' => [], 'subtotal' => 0, 'count' => 0]);

        $items = collect($cart['items'])->map(function ($item, $key) {
            return [
                'id' => $key,
                'cart_item_id' => $key,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'total_price' => $item['price'] * $item['quantity'],
                'product' => [
                    'id' => $item['product_id'],
                    'name' => $item['name'],
                    'slug' => $item['slug'],
                    'image' => $item['image'],
                    'stock_quantity' => $item['stock_quantity'] ?? 999,
                    'seller' => [
                        'name' => $item['seller_name'] ?? 'Guest Seller',
                        'business_name' => null
                    ]
                ]
            ];
        })->values();

        return [
            'items' => $items,
            'subtotal' => $cart['subtotal'] ?? 0,
            'total' => $cart['subtotal'] ?? 0,
            'item_count' => $cart['count'] ?? 0
        ];
    }

    /**
     * Add item to cart
     */
    public function addItem(Product $product, int $quantity): bool
    {
        if (Auth::check()) {
            return $this->addToUserCart($product, $quantity);
        }

        return $this->addToGuestCart($product, $quantity);
    }

    /**
     * Add item to authenticated user's cart
     */
    private function addToUserCart(Product $product, int $quantity): bool
    {
        try {
            $user = Auth::user();
            $cart = $user->cart()->firstOrCreate([]);

            $item = $cart->items()->firstOrNew(['product_id' => $product->id]);
            $item->quantity += $quantity;
            $item->unit_price = $product->price;
            $item->total_price = $item->quantity * $item->unit_price;

            return $item->save();
        } catch (\Exception $e) {
            Log::error('Add to user cart error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Add item to guest cart
     */
    private function addToGuestCart(Product $product, int $quantity): bool
    {
        try {
            $cart = Session::get(self::SESSION_KEY, ['items' => [], 'subtotal' => 0, 'count' => 0]);

            $itemKey = self::GUEST_ITEM_PREFIX . $product->id;

            if (isset($cart['items'][$itemKey])) {
                $cart['items'][$itemKey]['quantity'] += $quantity;
            } else {
                $cart['items'][$itemKey] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'image' => $product->image,
                    'stock_quantity' => $product->stock_quantity,
                    'seller_name' => $product->seller->name ?? 'Unknown Seller'
                ];
            }

            // Recalculate totals
            $this->recalculateGuestCart($cart);

            Session::put(self::SESSION_KEY, $cart);

            return true;
        } catch (\Exception $e) {
            Log::error('Add to guest cart error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update cart item quantity
     */
    public function updateItem($itemId, int $quantity): bool
    {
        if (Auth::check()) {
            return $this->updateUserCartItem($itemId, $quantity);
        }

        return $this->updateGuestCartItem($itemId, $quantity);
    }

    /**
     * Update item in authenticated user's cart
     */
    private function updateUserCartItem($itemId, int $quantity): bool
    {
        try {
            $item = CartItem::find($itemId);

            if (!$item || $item->cart->customer_id !== Auth::id()) {
                return false;
            }

            // Check product stock
            if ($quantity > $item->product->stock_quantity) {
                return false;
            }

            $item->quantity = $quantity;
            $item->total_price = $item->quantity * $item->unit_price;

            return $item->save();
        } catch (\Exception $e) {
            Log::error('Update user cart item error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update item in guest cart
     */
    private function updateGuestCartItem($itemId, int $quantity): bool
    {
        try {
            $cart = Session::get(self::SESSION_KEY, ['items' => [], 'subtotal' => 0, 'count' => 0]);

            if (!isset($cart['items'][$itemId])) {
                return false;
            }

            // Check stock
            if ($quantity > ($cart['items'][$itemId]['stock_quantity'] ?? 999)) {
                return false;
            }

            $cart['items'][$itemId]['quantity'] = $quantity;

            // Recalculate totals
            $this->recalculateGuestCart($cart);

            Session::put(self::SESSION_KEY, $cart);

            return true;
        } catch (\Exception $e) {
            Log::error('Update guest cart item error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Remove item from cart
     */
    public function removeItem($itemId): bool
    {
        if (Auth::check()) {
            return $this->removeUserCartItem($itemId);
        }

        return $this->removeGuestCartItem($itemId);
    }

    /**
     * Remove item from authenticated user's cart
     */
    private function removeUserCartItem($itemId): bool
    {
        try {
            $item = CartItem::find($itemId);

            if (!$item || $item->cart->customer_id !== Auth::id()) {
                return false;
            }

            return $item->delete();
        } catch (\Exception $e) {
            Log::error('Remove user cart item error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Remove item from guest cart
     */
    private function removeGuestCartItem($itemId): bool
    {
        try {
            $cart = Session::get(self::SESSION_KEY, ['items' => [], 'subtotal' => 0, 'count' => 0]);

            if (!isset($cart['items'][$itemId])) {
                return false;
            }

            unset($cart['items'][$itemId]);

            // Recalculate totals
            $this->recalculateGuestCart($cart);

            Session::put(self::SESSION_KEY, $cart);

            return true;
        } catch (\Exception $e) {
            Log::error('Remove guest cart item error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Clear entire cart
     */
    public function clearCart(): void
    {
        if (Auth::check()) {
            Auth::user()->cart?->items()->delete();
        } else {
            Session::forget(self::SESSION_KEY);
        }
    }

    /**
     * Get total item count in cart
     */
    public function getItemCount(): int
    {
        if (Auth::check()) {
            return Auth::user()->cart?->items()->sum('quantity') ?? 0;
        }

        $cart = Session::get(self::SESSION_KEY, ['items' => [], 'subtotal' => 0, 'count' => 0]);
        return $cart['count'] ?? 0;
    }

    /**
     * Get cart total amount
     */
    public function getTotal(): float
    {
        return $this->getSubtotal();
    }

    /**
     * Get cart subtotal amount
     */
    public function getSubtotal(): float
    {
        if (Auth::check()) {
            return Auth::user()->cart?->items()->sum('total_price') ?? 0;
        }

        $cart = Session::get(self::SESSION_KEY, ['items' => [], 'subtotal' => 0, 'count' => 0]);
        return $cart['subtotal'] ?? 0;
    }

    /**
     * Get item total price
     */
    public function getItemTotal($itemId): ?float
    {
        if (Auth::check()) {
            $item = CartItem::find($itemId);
            return $item ? $item->total_price : null;
        }

        $cart = Session::get(self::SESSION_KEY, ['items' => [], 'subtotal' => 0, 'count' => 0]);

        if (!isset($cart['items'][$itemId])) {
            return null;
        }

        $item = $cart['items'][$itemId];
        return $item['price'] * $item['quantity'];
    }

    /**
     * Recalculate guest cart totals
     */
    private function recalculateGuestCart(array &$cart): void
    {
        $subtotal = 0;
        $count = 0;

        foreach ($cart['items'] as $item) {
            $itemTotal = $item['price'] * $item['quantity'];
            $subtotal += $itemTotal;
            $count += $item['quantity'];
        }

        $cart['subtotal'] = $subtotal;
        $cart['count'] = $count;
    }

    /**
     * Migrate guest cart to user cart after login
     */
    public function migrateGuestCartToUser($userId): void
    {
        try {
            $guestCart = Session::get(self::SESSION_KEY, ['items' => [], 'subtotal' => 0, 'count' => 0]);

            if (empty($guestCart['items'])) {
                return;
            }

            $userCart = Cart::firstOrCreate(['customer_id' => $userId]);

            foreach ($guestCart['items'] as $itemData) {
                $product = Product::find($itemData['product_id']);

                if ($product) {
                    $item = $userCart->items()->firstOrNew(['product_id' => $product->id]);
                    $item->quantity += $itemData['quantity'];
                    $item->unit_price = $product->price;
                    $item->total_price = $item->quantity * $item->unit_price;
                    $item->save();
                }
            }

            // Clear guest cart
            Session::forget(self::SESSION_KEY);
        } catch (\Exception $e) {
            Log::error('Cart migration error: ' . $e->getMessage());
        }
    }
}
