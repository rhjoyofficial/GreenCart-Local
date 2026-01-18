@extends('layouts.admin')

@section('title', 'Order Details: ' . $order->order_number)
@section('page-title', 'Order Details')

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
                    <!-- Status Update Form -->
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST"
                        class="flex items-center space-x-2">
                        @csrf
                        <select name="status"
                            class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing
                            </option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered
                            </option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                        </select>
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            Update
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Order Details Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Customer & Shipping -->
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
                                        Seller</th>
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
                                                        class="w-10 h-10 object-cover rounded mr-3">
                                                @endif
                                                <div>
                                                    <a href="{{ route('admin.products.show', $item->product) }}"
                                                        class="text-sm font-medium text-gray-900 hover:text-blue-600">
                                                        {{ $item->product->name }}
                                                    </a>
                                                    <p class="text-xs text-gray-500">{{ $item->product->sku }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $item->seller->business_name ?? $item->seller->name }}
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

            <!-- Right Column - Summary & Actions -->
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
                        @if ($order->payments->count() > 0)
                            <div class="pt-3 border-t border-gray-200">
                                <h4 class="font-medium text-gray-700 mb-2">Payment History</h4>
                                @foreach ($order->payments as $payment)
                                    <div class="text-sm text-gray-600">
                                        {{ $payment->gateway_name }} -
                                        TK{{ number_format($payment->amount, 2) }} -
                                        {{ $payment->status }}
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Order Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('admin.orders.invoice', $order) }}"
                            class="w-full bg-blue-600 text-white text-center py-2 rounded-lg hover:bg-blue-700 transition-colors block">
                            Generate Invoice
                        </a>
                        @if ($order->status !== 'cancelled' && $order->status !== 'delivered')
                            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to cancel this order?')"
                                    class="w-full bg-red-600 text-white text-center py-2 rounded-lg hover:bg-red-700 transition-colors">
                                    Cancel Order
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
