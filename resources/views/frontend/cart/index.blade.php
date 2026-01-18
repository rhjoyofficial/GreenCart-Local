@extends('layouts.frontend')

@section('title', 'Shopping Cart - Marketplace')

@push('scripts')
    <script>
        // Cart page specific JavaScript
        document.addEventListener('DOMContentLoaded', function() {
            // Update quantity when typing in input
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('change', function() {
                    const form = this.closest('.cart-item-form');
                    const productId = this.dataset.productId;
                    const quantity = parseInt(this.value);

                    if (quantity < 1) {
                        this.value = 1;
                        return;
                    }

                    // Update via cart manager
                    if (window.cartManager) {
                        const event = new Event('change');
                        this.dispatchEvent(event);
                    }
                });
            });

            // Remove item confirmation
            document.querySelectorAll('.cart-remove-item').forEach(button => {
                button.addEventListener('click', function(e) {
                    if (!confirm('Are you sure you want to remove this item from your cart?')) {
                        e.preventDefault();
                    }
                });
            });

            // Update cart totals when quantity changes
            function updateCartTotals() {
                // This would typically be handled via AJAX
                // For now, we'll just show the loading state
                const updateButtons = document.querySelectorAll('.update-cart-btn');
                updateButtons.forEach(btn => {
                    btn.disabled = true;
                    btn.innerHTML =
                        '<svg class="animate-spin h-4 w-4" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle></svg>';
                });
            }
        });
    </script>
@endpush

@section('content')
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumbs -->
        @php
            $breadcrumbs = [['url' => route('home'), 'label' => 'Home'], ['url' => '#', 'label' => 'Shopping Cart']];
        @endphp
        @include('components.breadcrumbs')

        <h1 class="text-3xl font-bold text-gray-900 mb-8">Shopping Cart</h1>

        @if (auth()->check() && auth()->user()->cart?->items->count())
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <!-- Cart Header -->
                    <div class="hidden md:grid grid-cols-12 gap-4 mb-4 px-4 text-sm font-medium text-gray-500">
                        <div class="col-span-6">Product</div>
                        <div class="col-span-2 text-center">Price</div>
                        <div class="col-span-2 text-center">Quantity</div>
                        <div class="col-span-2 text-center">Total</div>
                    </div>

                    <!-- Cart Items List -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 divide-y divide-gray-200">
                        @foreach (auth()->user()->cart->items as $item)
                            <div class="cart-item p-4 hover:bg-gray-50 transition-colors"
                                data-product-id="{{ $item->product_id }}">
                                <div class="flex flex-col md:flex-row md:items-center gap-4">
                                    <!-- Product Image & Info -->
                                    <div class="flex-1 flex items-center">
                                        <a href="{{ route('products.show', $item->product->slug) }}" class="flex-shrink-0">
                                            <div class="w-20 h-20 bg-gray-200 rounded-lg overflow-hidden">
                                                @if ($item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                                        alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                                        <svg class="w-8 h-8 text-gray-400" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                        </a>
                                        <div class="ml-4">
                                            <a href="{{ route('products.show', $item->product->slug) }}"
                                                class="font-medium text-gray-900 hover:text-blue-600 transition-colors">
                                                {{ $item->product->name }}
                                            </a>
                                            <p class="text-sm text-gray-500 mt-1">
                                                {{ $item->product->seller->business_name ?? $item->product->seller->name }}
                                            </p>
                                            @if ($item->product->stock_quantity < $item->quantity)
                                                <p class="text-sm text-red-600 mt-1">Only
                                                    {{ $item->product->stock_quantity }} left in stock</p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Price -->
                                    <div class="md:w-32 text-center">
                                        <span
                                            class="font-medium text-gray-900">TK{{ number_format($item->unit_price, 2) }}</span>
                                    </div>

                                    <!-- Quantity -->
                                    <div class="md:w-32">
                                        <form action="{{ route('cart.update', $item) }}" method="POST"
                                            class="cart-item-form">
                                            @csrf
                                            @method('PUT')
                                            <div class="flex items-center justify-center">
                                                <div class="flex items-center border border-gray-300 rounded-lg">
                                                    <button type="button"
                                                        class="quantity-decrement px-3 py-2 text-gray-600 hover:text-gray-900 disabled:text-gray-300"
                                                        {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M20 12H4"></path>
                                                        </svg>
                                                    </button>
                                                    <input type="number" name="quantity" value="{{ $item->quantity }}"
                                                        min="1" max="{{ $item->product->stock_quantity }}"
                                                        data-product-id="{{ $item->product_id }}"
                                                        class="quantity-input w-16 text-center border-x border-gray-300 py-2 focus:outline-none">
                                                    <button type="button"
                                                        class="quantity-increment px-3 py-2 text-gray-600 hover:text-gray-900 disabled:text-gray-300"
                                                        {{ $item->quantity >= $item->product->stock_quantity ? 'disabled' : '' }}>
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Total & Actions -->
                                    <div class="md:w-32 flex flex-col items-center space-y-2">
                                        <span class="item-total font-bold text-gray-900">
                                            TK{{ number_format($item->total_price, 2) }}
                                        </span>
                                        <form action="{{ route('cart.remove', $item) }}" method="POST"
                                            class="cart-remove-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="cart-remove-item text-sm text-red-600 hover:text-red-800">
                                                Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Continue Shopping -->
                    <div class="mt-6 flex justify-between items-center">
                        <a href="{{ route('products.index') }}"
                            class="flex items-center text-blue-600 hover:text-blue-700 font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Continue Shopping
                        </a>

                        <!-- Clear Cart Button -->
                        <form action="{{ route('cart.clear') }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to clear your cart?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium">
                                Clear Shopping Cart
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-24">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h2>

                        <div class="space-y-3">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span
                                    id="cart-subtotal">TK{{ number_format(auth()->user()->cart->items->sum('total_price'), 2) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Shipping</span>
                                <span class="text-green-600">Free</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Tax</span>
                                <span>TK0.00</span>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 my-4 pt-4">
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-900">Total</span>
                                <span id="cart-total" class="text-xl font-bold text-gray-900">
                                    TK{{ number_format(auth()->user()->cart->items->sum('total_price'), 2) }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-500 mt-2">Including all taxes</p>
                        </div>

                        <!-- Checkout Button -->
                        @if (auth()->user()->cart->items->count() > 0)
                            <a href="{{ route('customer.checkout.index') }}"
                                class="block w-full bg-green-600 text-white text-center py-3 rounded-lg hover:bg-green-700 transition-colors font-medium mt-6">
                                Proceed to Checkout
                            </a>
                        @endif

                        <!-- Payment Methods -->
                        <div class="mt-6">
                            <p class="text-sm text-gray-600 mb-3">We Accept:</p>
                            <div class="flex space-x-2">
                                <div class="w-10 h-6 bg-gray-200 rounded"></div>
                                <div class="w-10 h-6 bg-gray-200 rounded"></div>
                                <div class="w-10 h-6 bg-gray-200 rounded"></div>
                            </div>
                        </div>

                        <!-- Secure Checkout -->
                        <div class="mt-6 flex items-center text-sm text-gray-500">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                            Secure checkout
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Your cart is empty</h3>
                <p class="text-gray-600 mb-4">Looks like you haven't added any products to your cart yet.</p>
                <a href="{{ route('products.index') }}"
                    class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    Start Shopping
                </a>
            </div>
        @endif
    </div>
@endsection
