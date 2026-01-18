<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\CartItem;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Display the cart page
     */
    public function index()
    {
        try {
            $cartData = $this->cartService->getCartData();

            return view('frontend.cart.index', [
                'items' => $cartData['items'],
                'subtotal' => $cartData['subtotal'],
                'total' => $cartData['total'],
                'itemCount' => $cartData['item_count'],
                'cartEmpty' => $cartData['item_count'] === 0
            ]);
        } catch (\Exception $e) {
            Log::error('Cart index error: ' . $e->getMessage());

            return view('frontend.cart.index', [
                'items' => collect(),
                'subtotal' => 0,
                'total' => 0,
                'itemCount' => 0,
                'cartEmpty' => true
            ]);
        }
    }

    /**
     * Add item to cart
     */
    public function add(Product $product, Request $request): JsonResponse
    {
        try {
            $request->validate([
                'quantity' => 'required|integer|min:1|max:' . $product->stock_quantity
            ]);

            $quantity = $request->quantity ?? 1;

            // Check stock availability
            if ($quantity > $product->stock_quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock. Only ' . $product->stock_quantity . ' items available.',
                    'cart_count' => $this->cartService->getItemCount(),
                    'cart_total' => $this->cartService->getTotal()
                ], 400);
            }

            // Add to cart
            $this->cartService->addItem($product, $quantity);

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully!',
                'cart_count' => $this->cartService->getItemCount(),
                'cart_total' => $this->cartService->getTotal(),
                'cart_subtotal' => $this->cartService->getSubtotal(),
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image' => $product->image
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Cart add error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to add product to cart. Please try again.',
                'cart_count' => $this->cartService->getItemCount(),
                'cart_total' => $this->cartService->getTotal()
            ], 500);
        }
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $itemId): JsonResponse
    {
        try {
            $request->validate([
                'quantity' => 'required|integer|min:1'
            ]);

            $quantity = $request->quantity;

            // Update cart item
            $updated = $this->cartService->updateItem($itemId, $quantity);

            if (!$updated) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found in cart.',
                    'cart_count' => $this->cartService->getItemCount(),
                    'cart_total' => $this->cartService->getTotal()
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully.',
                'cart_count' => $this->cartService->getItemCount(),
                'cart_total' => $this->cartService->getTotal(),
                'cart_subtotal' => $this->cartService->getSubtotal(),
                'item_total' => $this->cartService->getItemTotal($itemId)
            ]);
        } catch (\Exception $e) {
            Log::error('Cart update error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to update cart. Please try again.',
                'cart_count' => $this->cartService->getItemCount(),
                'cart_total' => $this->cartService->getTotal()
            ], 500);
        }
    }

    /**
     * Remove item from cart
     */
    public function remove($itemId): JsonResponse
    {
        try {
            $removed = $this->cartService->removeItem($itemId);

            if (!$removed) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found in cart.',
                    'cart_count' => $this->cartService->getItemCount(),
                    'cart_total' => $this->cartService->getTotal()
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart.',
                'cart_count' => $this->cartService->getItemCount(),
                'cart_total' => $this->cartService->getTotal(),
                'cart_subtotal' => $this->cartService->getSubtotal()
            ]);
        } catch (\Exception $e) {
            Log::error('Cart remove error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to remove item. Please try again.',
                'cart_count' => $this->cartService->getItemCount(),
                'cart_total' => $this->cartService->getTotal()
            ], 500);
        }
    }

    /**
     * Clear entire cart
     */
    public function clear(): JsonResponse
    {
        try {
            $this->cartService->clearCart();

            return response()->json([
                'success' => true,
                'message' => 'Cart cleared successfully.',
                'cart_count' => 0,
                'cart_total' => 0,
                'cart_subtotal' => 0
            ]);
        } catch (\Exception $e) {
            Log::error('Cart clear error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to clear cart. Please try again.',
                'cart_count' => $this->cartService->getItemCount(),
                'cart_total' => $this->cartService->getTotal()
            ], 500);
        }
    }

    /**
     * Get cart item count (for AJAX requests)
     */
    public function count(): JsonResponse
    {
        return response()->json([
            'count' => $this->cartService->getItemCount(),
            'total' => $this->cartService->getTotal()
        ]);
    }

    /**
     * Get cart summary (for mini-cart or header)
     */
    public function summary(): JsonResponse
    {
        try {
            $cartData = $this->cartService->getCartData();

            return response()->json([
                'success' => true,
                'items' => $cartData['items'],
                'count' => $cartData['item_count'],
                'subtotal' => $cartData['subtotal'],
                'total' => $cartData['total']
            ]);
        } catch (\Exception $e) {
            Log::error('Cart summary error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'items' => [],
                'count' => 0,
                'subtotal' => 0,
                'total' => 0
            ], 500);
        }
    }
}
