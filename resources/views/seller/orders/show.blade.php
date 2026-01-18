@extends('layouts.seller')

@section('title', 'Order Details: ' . $order->order_number)
@section('page-title', 'Order Details')

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Update order status
            const statusButtons = document.querySelectorAll('.update-status-btn');
            statusButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const newStatus = this.dataset.status;
                    const statusLabel = this.dataset.label;
                    const statusClasses = this.dataset.classes;

                    if (confirm('Update order status to "' + statusLabel + '"?')) {
                        // In a real app, you would make an AJAX call here
                        document.getElementById('current-status').innerHTML = `
                        <span class="px-3 py-1 rounded-full text-sm font-medium ${statusClasses}">
                            ${statusLabel}
                        </span>
                    `;

                        // Show success message
                        if (typeof window.flash === 'function') {
                            window.flash('Order status updated successfully', 'success');
                        }
                    }
                });
            });

            // Print invoice
            const printBtn = document.getElementById('print-invoice');
            if (printBtn) {
                printBtn.addEventListener('click', function() {
                    window.print();
                });
            }
        });
    </script>
@endpush

@section('content')
    <div class="space-y-6">
        <!-- Order Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div>
                    <div class="flex items-center space-x-4">
                        <h2 class="text-xl font-bold text-gray-900">{{ $order->order_number }}</h2>
                        <span id="current-status"
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
                <div class="mt-4 md:mt-0 flex items-center space-x-3">
                    <!-- Print Invoice -->
                    <button id="print-invoice" class="flex items-center text-blue-600 hover:text-blue-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                            </path>
                        </svg>
                        Print Invoice
                    </button>

                    <!-- Status Update Dropdown -->
                    @if (!in_array($order->status, ['delivered', 'cancelled']))
                        <div class="relative">
                            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                Update Status
                            </button>
                            <div
                                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-10 hidden">
                                @if ($order->status === 'pending')
                                    <button
                                        class="update-status-btn block w-full text-left px-4 py-2 text-sm text-blue-600 hover:bg-blue-50"
                                        data-status="processing" data-label="Processing"
                                        data-classes="bg-blue-100 text-blue-800">
                                        Mark as Processing
                                    </button>
                                @endif
                                @if ($order->status === 'processing')
                                    <button
                                        class="update-status-btn block w-full text-left px-4 py-2 text-sm text-purple-600 hover:bg-purple-50"
                                        data-status="shipped" data-label="Shipped"
                                        data-classes="bg-purple-100 text-purple-800">
                                        Mark as Shipped
                                    </button>
                                @endif
                                @if ($order->status === 'shipped')
                                    <button
                                        class="update-status-btn block w-full text-left px-4 py-2 text-sm text-green-600 hover:bg-green-50"
                                        data-status="delivered" data-label="Delivered"
                                        data-classes="bg-green-100 text-green-800">
                                        Mark as Delivered
                                    </button>
                                @endif
                                <button
                                    class="update-status-btn block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50"
                                    data-status="cancelled" data-label="Cancelled" data-classes="bg-red-100 text-red-800">
                                    Cancel Order
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Order Details Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Order Items -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Customer Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Customer Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-medium text-gray-700 mb-2">Contact</h4>
                            <p class="text-gray-900">{{ $order->customer->name }}</p>
                            <p class="text-gray-600">{{ $order->customer->email }}</p>
                            <p class="text-gray-600">{{ $order->customer->phone ?? 'No phone provided' }}</p>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-700 mb-2">Shipping Address</h4>
                            <p class="text-gray-900">{{ $order->shipping_address }}</p>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
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
                                @php
                                    $sellerItems = $order
                                        ->items()
                                        ->where('seller_id', auth()->id())
                                        ->get();
                                    $sellerTotal = $sellerItems->sum('total_price');
                                @endphp
                                @foreach ($sellerItems as $item)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                @if ($item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                                        alt="{{ $item->product->name }}"
                                                        class="w-10 h-10 object-cover rounded mr-3">
                                                @endif
                                                <div>
                                                    <a href="{{ route('products.show', $item->product->slug) }}"
                                                        target="_blank"
                                                        class="text-sm font-medium text-gray-900 hover:text-blue-600">
                                                        {{ $item->product->name }}
                                                    </a>
                                                    <p class="text-xs text-gray-500">{{ $item->product->sku }}</p>
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

            <!-- Right Column - Order Summary & Actions -->
            <div class="space-y-6">
                <!-- Order Summary -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span>TK{{ number_format($sellerTotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Shipping</span>
                            <span class="text-green-600">Free</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Platform Fee ({{ config('marketplace.commission_rate', 10) }}%)</span>
                            <span>TK{{ number_format($sellerTotal * (config('marketplace.commission_rate', 10) / 100), 2) }}</span>
                        </div>
                        <div class="border-t border-gray-200 pt-3">
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-900">Your Earnings</span>
                                <span class="text-xl font-bold text-gray-900">
                                    TK{{ number_format($sellerTotal * (1 - config('marketplace.commission_rate', 10) / 100), 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Information</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status</span>
                            <span
                                class="px-2 py-1 rounded-full text-xs font-medium 
                            @if ($order->payment_status === 'paid') bg-green-100 text-green-800
                            @elseif($order->payment_status === 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Method</span>
                            <span class="font-medium">{{ $order->payment_method ?? 'Cash on Delivery' }}</span>
                        </div>
                        <div class="pt-3 border-t border-gray-200">
                            <p class="text-sm text-gray-600">
                                Payouts are processed on the 15th of each month for delivered orders.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Order Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Actions</h3>
                    <div class="space-y-3">
                        <!-- Shipping Label -->
                        <button
                            class="w-full border border-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                            Print Shipping Label
                        </button>

                        <!-- Contact Customer -->
                        <button
                            class="w-full border border-blue-300 text-blue-600 py-2 rounded-lg hover:bg-blue-50 transition-colors">
                            Contact Customer
                        </button>

                        <!-- Order Notes -->
                        <div class="pt-3 border-t border-gray-200">
                            <h4 class="font-medium text-gray-700 mb-2">Add Note</h4>
                            <textarea rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none text-sm"
                                placeholder="Add private note about this order..."></textarea>
                            <button
                                class="mt-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                                Save Note
                            </button>
                        </div>
                    </div>
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
                        </div>
                    </div>

                    <!-- Payment -->
                    <div class="flex items-start">
                        <div
                            class="z-10 w-6 h-6 
                        @if ($order->payment_status === 'paid') bg-green-500
                        @else bg-gray-300 @endif rounded-full flex items-center justify-center">
                            @if ($order->payment_status === 'paid')
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            @endif
                        </div>
                        <div class="ml-8">
                            <p class="font-medium text-gray-900">Payment {{ ucfirst($order->payment_status) }}</p>
                            <p class="text-sm text-gray-600">
                                @if ($order->payment_status === 'paid')
                                    Paid via {{ $order->payment_method }}
                                @else
                                    Payment pending
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Processing -->
                    <div class="flex items-start">
                        <div
                            class="z-10 w-6 h-6 
                        @if (in_array($order->status, ['processing', 'shipped', 'delivered'])) bg-green-500
                        @else bg-gray-300 @endif rounded-full flex items-center justify-center">
                            @if (in_array($order->status, ['processing', 'shipped', 'delivered']))
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            @endif
                        </div>
                        <div class="ml-8">
                            <p class="font-medium text-gray-900">Order Processing</p>
                            <p class="text-sm text-gray-600">
                                @if (in_array($order->status, ['processing', 'shipped', 'delivered']))
                                    Order is being prepared
                                @else
                                    Waiting to process
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Shipped -->
                    <div class="flex items-start">
                        <div
                            class="z-10 w-6 h-6 
                        @if (in_array($order->status, ['shipped', 'delivered'])) bg-green-500
                        @else bg-gray-300 @endif rounded-full flex items-center justify-center">
                            @if (in_array($order->status, ['shipped', 'delivered']))
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            @endif
                        </div>
                        <div class="ml-8">
                            <p class="font-medium text-gray-900">Order Shipped</p>
                            <p class="text-sm text-gray-600">
                                @if (in_array($order->status, ['shipped', 'delivered']))
                                    Order has been shipped
                                @else
                                    Not shipped yet
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Delivered -->
                    <div class="flex items-start">
                        <div
                            class="z-10 w-6 h-6 
                        @if ($order->status === 'delivered') bg-green-500
                        @else bg-gray-300 @endif rounded-full flex items-center justify-center">
                            @if ($order->status === 'delivered')
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            @endif
                        </div>
                        <div class="ml-8">
                            <p class="font-medium text-gray-900">Order Delivered</p>
                            <p class="text-sm text-gray-600">
                                @if ($order->status === 'delivered')
                                    Order delivered successfully
                                @else
                                    Not delivered yet
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
