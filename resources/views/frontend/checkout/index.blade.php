@extends('layouts.frontend')

@section('title', 'Checkout - GreenCart-Local')

@section('content')
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumbs -->
        @php
            $breadcrumbs = [
                ['url' => route('home'), 'label' => 'Home'],
                ['url' => route('cart.index'), 'label' => 'Cart'],
                ['url' => '#', 'label' => 'Checkout'],
            ];
        @endphp
        @include('components.breadcrumbs')

        <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>

        @if ($items && $items->count() > 0)
            <form id="checkout-form" action="{{ route('customer.checkout.process') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column - Forms -->
                    <div class="lg:col-span-2 space-y-8">
                        <!-- Shipping Information -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-6">Shipping Information</h2>

                            <!-- Shipping Address -->
                            <div class="mb-6">
                                <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-2">
                                    Shipping Address *
                                </label>
                                <textarea id="shipping_address" name="shipping_address" rows="3"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none"
                                    placeholder="Enter your complete shipping address" required>{{ auth()->user()->address_line1 }}</textarea>
                            </div>

                            <!-- Contact Information -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Full Name
                                    </label>
                                    <input type="text" value="{{ auth()->user()->name }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none"
                                        readonly>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Email Address
                                    </label>
                                    <input type="email" value="{{ auth()->user()->email }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none"
                                        readonly>
                                </div>
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Phone Number *
                                </label>
                                <input type="tel" name="phone" value="{{ auth()->user()->phone ?? '' }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none"
                                    placeholder="Enter your phone number" required>
                            </div>
                        </div>

                        <!-- Billing Information -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-xl font-semibold text-gray-900">Billing Information</h2>
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" id="use_different_address" name="use_different_address"
                                        class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                                    <span class="text-sm text-gray-700">Use different billing address</span>
                                </label>
                            </div>

                            <!-- Billing Address (Hidden by default) -->
                            <div id="billing-address-section" class="hidden">
                                <div class="mb-6">
                                    <label for="billing_address" class="block text-sm font-medium text-gray-700 mb-2">
                                        Billing Address
                                    </label>
                                    <textarea id="billing_address" name="billing_address" rows="3"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none"
                                        placeholder="Enter your billing address (if different)"></textarea>
                                </div>
                            </div>

                            <!-- Same as shipping message -->
                            <div id="same-address-message" class="text-gray-600">
                                <p>Billing address will be the same as shipping address.</p>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-6">Payment Method</h2>

                            <div class="space-y-4">
                                <!-- Credit/Debit Card -->
                                <label
                                    class="flex items-center p-4 border border-gray-300 rounded-lg hover:border-green-500 cursor-pointer">
                                    <input type="radio" name="payment_method" value="card"
                                        class="h-4 w-4 text-green-600 focus:ring-green-500">
                                    <div class="ml-3">
                                        <span class="font-medium text-gray-900">Credit/Debit Card</span>
                                        <p class="text-sm text-gray-500">Pay with your credit or debit card</p>
                                    </div>
                                    <div class="ml-auto flex space-x-2">
                                        <div class="w-10 h-6 bg-gray-200 rounded"></div>
                                        <div class="w-10 h-6 bg-gray-200 rounded"></div>
                                    </div>
                                </label>

                                <!-- Mobile Banking -->
                                <label
                                    class="flex items-center p-4 border border-gray-300 rounded-lg hover:border-green-500 cursor-pointer">
                                    <input type="radio" name="payment_method" value="mobile_banking"
                                        class="h-4 w-4 text-green-600 focus:ring-green-500">
                                    <div class="ml-3">
                                        <span class="font-medium text-gray-900">Mobile Banking</span>
                                        <p class="text-sm text-gray-500">bKash, Nagad, Rocket, etc.</p>
                                    </div>
                                    <div class="ml-auto">
                                        <div class="w-10 h-6 bg-green-100 rounded"></div>
                                    </div>
                                </label>

                                <!-- Cash on Delivery -->
                                <label
                                    class="flex items-center p-4 border border-gray-300 rounded-lg hover:border-green-500 cursor-pointer">
                                    <input type="radio" name="payment_method" value="cod"
                                        class="h-4 w-4 text-green-600 focus:ring-green-500" checked>
                                    <div class="ml-3">
                                        <span class="font-medium text-gray-900">Cash on Delivery</span>
                                        <p class="text-sm text-gray-500">Pay when you receive your order</p>
                                    </div>
                                    <div class="ml-auto">
                                        <div class="w-10 h-6 bg-green-100 rounded"></div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-24">
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h2>

                            <!-- Order Items -->
                            <div class="mb-6">
                                @foreach ($items as $item)
                                    <div
                                        class="flex items-center justify-between py-3 border-b border-gray-200 last:border-0">
                                        <div class="flex-1">
                                            <p class="font-medium text-gray-900">{{ $item->product->name }}</p>
                                            <p class="text-sm text-gray-500">Qty: {{ $item->quantity }} ×
                                                TK{{ number_format($item->unit_price, 2) }}</p>
                                        </div>
                                        <span
                                            class="font-medium text-gray-900">TK{{ number_format($item->total_price, 2) }}</span>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Order Totals -->
                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between text-gray-600">
                                    <span>Subtotal</span>
                                    <span>TK{{ number_format($total, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Shipping</span>
                                    <span class="text-green-600">Free</span>
                                </div>

                            </div>

                            <!-- Total -->
                            <div class="border-t border-gray-200 pt-4 mb-6">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-semibold text-gray-900">Total</span>
                                    <span class="text-xl font-bold text-gray-900">TK{{ number_format($total, 2) }}</span>
                                </div>
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="mb-6">
                                <label class="flex items-start space-x-2">
                                    <input type="checkbox" name="terms" id="terms-checkbox"
                                        class="mt-1 rounded border-gray-300 text-green-600 focus:ring-green-500" required>
                                    <span class="text-sm text-gray-600">
                                        I agree to the <a href="{{ route('terms') }}"
                                            class="text-green-600 hover:text-green-700">Terms and Conditions</a>
                                        and <a href="{{ route('privacy') }}"
                                            class="text-green-600 hover:text-green-700">Privacy Policy</a>
                                    </span>
                                </label>
                            </div>

                            <!-- Place Order Button -->
                            <button id="place-order-btn" type="button"
                                class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition-colors font-medium disabled:opacity-50 disabled:cursor-not-allowed">
                                Place Order
                            </button>

                            <!-- Loading Overlay -->
                            <div id="loading-overlay"
                                class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
                                <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4 text-center">
                                    <div class="flex justify-center mb-4">
                                        <svg class="animate-spin h-12 w-12 text-green-600"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Processing Your Order</h3>
                                    <p class="text-gray-600">Please wait while we process your order. This may take a few
                                        moments.</p>
                                </div>
                            </div>

                            <div class="flex items-center justify-between mt-4">
                                <!-- Secure Checkout -->
                                <div class="flex items-center justify-center text-sm text-gray-500">
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                        </path>
                                    </svg>
                                    100% Secure Checkout
                                </div>

                                <!-- Need Help -->
                                <div class="text-center">
                                    <p class="text-sm text-gray-600">Need help? <a href="{{ route('contact') }}"
                                            class="text-green-600 hover:text-green-700">Contact us</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @else
            <!-- Empty Cart Message -->
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Your cart is empty</h3>
                <p class="text-gray-600 mb-4">Add some products to your cart before checkout.</p>
                <a href="{{ route('products.index') }}"
                    class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors font-medium">
                    Continue Shopping
                </a>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle checkout process
            const checkoutForm = document.getElementById('checkout-form');
            const placeOrderBtn = document.getElementById('place-order-btn');
            const loadingOverlay = document.getElementById('loading-overlay');
            const termsCheckbox = document.getElementById('terms-checkbox');

            // Toggle address form
            const useDifferentAddress = document.getElementById('use_different_address');
            const billingAddressSection = document.getElementById('billing-address-section');

            if (useDifferentAddress && billingAddressSection) {
                useDifferentAddress.addEventListener('change', function() {
                    billingAddressSection.classList.toggle('hidden', !this.checked);
                });
            }

            // Handle place order button click
            if (placeOrderBtn && checkoutForm) {
                placeOrderBtn.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Show loading state
                    const originalText = placeOrderBtn.innerHTML;
                    placeOrderBtn.disabled = true;
                    placeOrderBtn.innerHTML = `
                        <span class="flex items-center justify-center">
                            <svg class="animate-spin h-5 w-5 mr-2" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                            </svg>
                            Processing...
                        </span>
                    `;

                    // Show loading overlay
                    if (loadingOverlay) {
                        loadingOverlay.classList.remove('hidden');
                        document.body.classList.add('overflow-hidden');
                    }

                    // Validate form
                    const shippingAddress = document.getElementById('shipping_address').value;
                    const phone = document.querySelector('input[name="phone"]').value;
                    const paymentMethod = document.querySelector('input[name="payment_method"]:checked')
                        ?.value;

                    let errors = [];

                    if (!shippingAddress.trim()) {
                        errors.push('Please enter your shipping address.');
                    }

                    if (!phone.trim()) {
                        errors.push('Please enter your phone number.');
                    }

                    if (!paymentMethod) {
                        errors.push('Please select a payment method.');
                    }

                    if (!termsCheckbox.checked) {
                        errors.push('Please accept the terms and conditions.');
                    }

                    if (errors.length > 0) {
                        // Reset button
                        placeOrderBtn.disabled = false;
                        placeOrderBtn.innerHTML = originalText;

                        // Hide loading overlay
                        if (loadingOverlay) {
                            loadingOverlay.classList.add('hidden');
                            document.body.classList.remove('overflow-hidden');
                        }

                        // Show errors
                        alert(errors.join('\n'));
                        return;
                    }

                    // Submit form
                    checkoutForm.submit();
                });
            }

            // Prevent form submission on Enter key
            checkoutForm.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                }
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        /* Custom loading overlay styles */
        #loading-overlay {
            backdrop-filter: blur(4px);
        }
    </style>
@endpush
