<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->order_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-8">
        <!-- Invoice Header -->
        <div class="flex justify-between items-start border-b border-gray-300 pb-6 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">INVOICE</h1>
                <p class="text-gray-600">Order #{{ $order->order_number }}</p>
                <p class="text-gray-600">Date: {{ $order->created_at->format('F d, Y') }}</p>
            </div>
            <div class="text-right">
                <h2 class="text-xl font-bold text-gray-800">{{ config('app.name') }}</h2>
                <p class="text-gray-600">Multi-Vendor E-Commerce Platform</p>
                <p class="text-gray-600">Dhaka, Bangladesh</p>
            </div>
        </div>

        <!-- Bill To & Order Status -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Bill To:</h3>
                <p class="font-medium text-gray-900">{{ $order->customer->name }}</p>
                <p class="text-gray-600">{{ $order->customer->email }}</p>
                <p class="text-gray-600">{{ $order->customer->phone ?? 'N/A' }}</p>
                <p class="text-gray-600">{{ $order->shipping_address }}</p>
            </div>
            <div class="text-right md:text-left">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Order Details:</h3>
                <p class="text-gray-600">
                    <span class="font-medium">Status:</span>
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
                <p class="text-gray-600">
                    <span class="font-medium">Payment:</span>
                    <span
                        class="px-2 py-1 rounded-full text-xs font-medium 
                        @if ($order->payment_status === 'paid') bg-green-100 text-green-800
                        @elseif($order->payment_status === 'pending') bg-yellow-100 text-yellow-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </p>
                <p class="text-gray-600"><span class="font-medium">Payment Method:</span>
                    {{ $order->payment_method ?? 'N/A' }}</p>
            </div>
        </div>

        <!-- Order Items Table -->
        <div class="mb-6">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-3 px-4 text-left font-medium text-gray-700 border-b">Product</th>
                        <th class="py-3 px-4 text-right font-medium text-gray-700 border-b">Price</th>
                        <th class="py-3 px-4 text-right font-medium text-gray-700 border-b">Qty</th>
                        <th class="py-3 px-4 text-right font-medium text-gray-700 border-b">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr class="border-b border-gray-200">
                            <td class="py-4 px-4">
                                <div class="font-medium text-gray-900">{{ $item->product->name }}</div>
                                <div class="text-sm text-gray-600">Seller:
                                    {{ $item->seller->business_name ?? $item->seller->name }}</div>
                            </td>
                            <td class="py-4 px-4 text-right">TK{{ number_format($item->unit_price, 2) }}</td>
                            <td class="py-4 px-4 text-right">{{ $item->quantity }}</td>
                            <td class="py-4 px-4 text-right font-medium">TK{{ number_format($item->total_price, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Totals -->
        <div class="flex justify-end">
            <div class="w-64">
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal:</span>
                        <span class="font-medium">TK{{ number_format($order->total_amount, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Shipping:</span>
                        <span class="font-medium">TK{{ number_format(0, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tax:</span>
                        <span class="font-medium">TK{{ number_format(0, 2) }}</span>
                    </div>
                    <div class="border-t border-gray-300 pt-2 mt-2">
                        <div class="flex justify-between">
                            <span class="text-lg font-bold text-gray-900">Total:</span>
                            <span
                                class="text-lg font-bold text-gray-900">TK{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Notes -->
        <div class="mt-8 pt-6 border-t border-gray-300">
            <div class="text-center text-gray-600 text-sm">
                <p>Thank you for your order!</p>
                <p>If you have any questions, please contact our support team.</p>
                <p class="mt-2">This is a computer-generated invoice and does not require a signature.</p>
            </div>
        </div>

        <!-- Print Button -->
        <div class="mt-8 text-center no-print">
            <button onclick="window.print()" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Print Invoice
            </button>
            <a href="{{ route('admin.orders.show', $order) }}"
                class="ml-4 px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Back to Order
            </a>
        </div>
    </div>
</body>

</html>
