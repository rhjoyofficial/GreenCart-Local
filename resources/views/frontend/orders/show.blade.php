@extends('layouts.customer')

@section('title', 'Order Details: ' . $order->order_number)
@section('page-title', 'Order Details')
@section('page-description', 'Order #' . $order->order_number)

@section('content')
    <div class="space-y-6">
        <!-- Order Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div>
                    <div class="flex items-center space-x-4">
                        <h2 class="text-xl font-bold text-gray-900">{{ $order->order_number }}</h2>
                        <span
                            class="px-3 py-1 rounded-full text-sm font-medium 
                        @if ($order->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                        @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                        @elseif($order->status === 'delivered') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($order->status->value) }}
                        </span>
                    </div>
                    <p class="text-gray-600 mt-2">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <!-- Print Invoice -->
                    <button onclick="window.print()" class="flex items-center text-blue-600 hover:text-blue-700 font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                            </path>
                        </svg>
                        Print Invoice
                    </button>
                </div>
            </div>
        </div>

        <!-- Order Timeline -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Order Timeline</h3>
            <div class="relative">
                <!-- Timeline -->
                <div class="absolute left-0 top-0 bottom-0 w-6 flex items-center justify-center">
                    <div class="h-full w-0.5 bg-gray-200"></div>
                </div>

                <!-- Timeline Steps -->
                <div class="relative space-y-8">
                    <!-- Ordered -->
                    <div class="flex items-start">
                        <div class="z-10 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-8">
                            <p class="font-medium text-gray-900">Order Placed</p>
                            <p class="text-sm text-gray-600">{{ $order->created_at->format('F d, Y h:i A') }}</p>
                            <p class="text-sm text-gray-500 mt-1">Your order has been received</p>
                        </div>
                    </div>

                    <!-- Processing -->
                    <div class="flex items-start">
                        <div
                            class="z-10 w-6 h-6 
                        @if (in_array($order->status, ['processing', 'shipped', 'delivered'])) bg-green-500
                        @else bg-gray-300 @endif rounded-full flex items-center justify-center">
                            @if (in_array($order->status, ['processing', 'shipped', 'delivered']))
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            @endif
                        </div>
                        <div class="ml-8">
                            <p class="font-medium text-gray-900">Processing</p>
                            <p class="text-sm text-gray-600">
                                @if (in_array($order->status, ['processing', 'shipped', 'delivered']))
                                    {{ $order->updated_at->format('F d, Y') }}
                                @else
                                    Pending
                                @endif
                            </p>
                            <p class="text-sm text-gray-500 mt-1">Seller is preparing your order</p>
                        </div>
                    </div>

                    <!-- Shipped -->
                    <div class="flex items-start">
                        <div
                            class="z-10 w-6 h-6 
                        @if (in_array($order->status, ['shipped', 'delivered'])) bg-green-500
                        @else bg-gray-300 @endif rounded-full flex items-center justify-center">
                            @if (in_array($order->status, ['shipped', 'delivered']))
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            @endif
                        </div>
                        <div class="ml-8">
                            <p class="font-medium text-gray-900">Shipped</p>
                            <p class="text-sm text-gray-600">
                                @if (in_array($order->status, ['shipped', 'delivered']))
                                    Shipped
                                @else
                                    Not shipped yet
                                @endif
                            </p>
                            <p class="text-sm text-gray-500 mt-1">Your order is on the way</p>
                        </div>
                    </div>

                    <!-- Delivered -->
                    <div class="flex items-start">
                        <div
                            class="z-10 w-6 h-6 
                        @if ($order->status === 'delivered') bg-green-500
                        @else bg-gray-300 @endif rounded-full flex items-center justify-center">
                            @if ($order->status === 'delivered')
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            @endif
                        </div>
                        <div class="ml-8">
                            <p class="font-medium text-gray-900">Delivered</p>
                            <p class="text-sm text-gray-600">
                                @if ($order->status === 'delivered')
                                    Delivered
                                @else
                                    Not delivered yet
                                @endif
                            </p>
                            <p class="text-sm text-gray-500 mt-1">Your order has been delivered</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Details Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Order Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Order Items</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Product</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Price</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Quantity</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                @if ($item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                                        alt="{{ $item->product->name }}"
                                                        class="w-16 h-16 object-cover rounded mr-4">
                                                @endif
                                                <div>
                                                    <a href="{{ route('products.show', $item->product->slug) }}"
                                                        class="text-sm font-medium text-gray-900 hover:text-blue-600">
                                                        {{ $item->product->name }}
                                                    </a>
                                                    <p class="text-xs text-gray-500">Sold by:
                                                        {{ $item->seller->business_name ?? $item->seller->name }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            TK{{ number_format($item->unit_price, 2) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                            TK{{ number_format($item->total_price, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Column - Order Summary & Shipping -->
            <div class="space-y-6">
                <!-- Order Summary -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span>TK{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Shipping</span>
                            <span class="text-green-600">Free</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Tax</span>
                            <span>TK0.00</span>
                        </div>
                        <div class="border-t border-gray-200 pt-3">
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-900">Total</span>
                                <span
                                    class="text-xl font-bold text-gray-900">TK{{ number_format($order->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Shipping Information</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-600">Shipping Address</p>
                            <p class="font-medium text-gray-900">{{ $order->shipping_address }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Payment Method</p>
                            <p class="font-medium text-gray-900">{{ $order->payment_method ?? 'Cash on Delivery' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Payment Status</p>
                            <span
                                class="px-2 py-1 rounded-full text-xs font-medium 
                            @if ($order->payment_status === 'paid') bg-green-100 text-green-800
                            @elseif($order->payment_status === 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Order Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Need Help?</h3>
                    <div class="space-y-3">
                        @if ($order->status === 'delivered')
                            <button
                                class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition-colors">
                                Write a Review
                            </button>
                        @endif

                        @if (in_array($order->status, ['pending', 'processing']))
                            <form action="{{ route('customer.orders.cancel', $order) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to cancel this order?')">
                                @csrf
                                @method('POST')
                                <button type="submit"
                                    class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 transition-colors">
                                    Cancel Order
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('contact') }}"
                            class="block w-full border border-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-50 transition-colors text-center">
                            Contact Support
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reorder Section -->
        @if ($order->status === 'delivered')
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-blue-900">Reorder Items</h3>
                        <p class="text-blue-700 mt-1">Quickly add these items to your cart again</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <button
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                            Add All to Cart
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
