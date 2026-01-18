@extends('layouts.frontend')

@section('title', 'Order Confirmed - Marketplace')

@section('content')
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumbs -->
        @php
            $breadcrumbs = [['url' => route('home'), 'label' => 'Home'], ['url' => '#', 'label' => 'Order Confirmed']];
        @endphp
        @include('components.breadcrumbs')

        <div class="max-w-2xl mx-auto text-center">
            <!-- Success Icon -->
            <div class="mb-8">
                <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto">
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>

            <!-- Success Message -->
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Order Confirmed!</h1>
            <p class="text-lg text-gray-600 mb-8">
                Thank you for your purchase. Your order has been successfully placed and is being processed.
            </p>

            <!-- Order Details -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-3">Order Information</h3>
                        <div class="space-y-2">
                            <p><span class="text-gray-600">Order Number:</span> <span
                                    class="font-medium">{{ $order->order_number }}</span></p>
                            <p><span class="text-gray-600">Order Date:</span> <span
                                    class="font-medium">{{ $order->created_at->format('F d, Y') }}</span></p>
                            <p><span class="text-gray-600">Order Status:</span>
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-medium 
                                @if ($order->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                                @elseif($order->status === 'delivered') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($order->status->value) }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-3">Payment Information</h3>
                        <div class="space-y-2">
                            <p><span class="text-gray-600">Total Amount:</span> <span
                                    class="font-medium">TK{{ number_format($order->total_amount, 2) }}</span></p>
                            <p><span class="text-gray-600">Payment Status:</span>
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-medium 
                                @if ($order->payment_status === 'paid') bg-green-100 text-green-800
                                @elseif($order->payment_status === 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </p>
                            <p><span class="text-gray-600">Payment Method:</span> <span
                                    class="font-medium">{{ $order->payment_method ?? 'Cash on Delivery' }}</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipping Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8 text-left">
                <h3 class="font-semibold text-gray-900 mb-4">Shipping Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-gray-600 mb-1">Shipping Address:</p>
                        <p class="font-medium">{{ $order->shipping_address }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 mb-1">Contact:</p>
                        <p class="font-medium">{{ auth()->user()->phone ?? 'Not provided' }}</p>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8 text-left">
                <h3 class="font-semibold text-gray-900 mb-4">Order Items</h3>
                <div class="space-y-4">
                    @foreach ($order->items as $item)
                        <div class="flex items-center justify-between py-3 border-b border-gray-200 last:border-0">
                            <div class="flex items-center">
                                @if ($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                        alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded-lg mr-4">
                                @endif
                                <div>
                                    <p class="font-medium text-gray-900">{{ $item->product->name }}</p>
                                    <p class="text-sm text-gray-500">Qty: {{ $item->quantity }} ×
                                        TK{{ number_format($item->unit_price, 2) }}</p>
                                </div>
                            </div>
                            <span class="font-medium text-gray-900">TK{{ number_format($item->total_price, 2) }}</span>
                        </div>
                    @endforeach

                    <!-- Order Total -->
                    <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                        <span class="text-lg font-semibold text-gray-900">Total</span>
                        <span class="text-xl font-bold text-gray-900">TK{{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('customer.orders.show', $order) }}"
                    class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    View Order Details
                </a>
                <a href="{{ route('customer.orders.index') }}"
                    class="bg-white border border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                    View All Orders
                </a>
                <a href="{{ route('products.index') }}"
                    class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors font-medium">
                    Continue Shopping
                </a>
            </div>

            <!-- Help Section -->
            <div class="mt-12 pt-8 border-t border-gray-200">
                <h3 class="font-semibold text-gray-900 mb-4">Need Help?</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <svg class="w-8 h-8 text-blue-600 mx-auto mb-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <p class="text-sm text-gray-600">Check your email for order confirmation</p>
                    </div>
                    <div class="text-center">
                        <svg class="w-8 h-8 text-blue-600 mx-auto mb-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                        <p class="text-sm text-gray-600">Contact support for any questions</p>
                    </div>
                    <div class="text-center">
                        <svg class="w-8 h-8 text-blue-600 mx-auto mb-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                        <p class="text-sm text-gray-600">Your transaction is secure and encrypted</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
