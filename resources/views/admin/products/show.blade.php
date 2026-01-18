@extends('layouts.admin')

@section('title', 'Product Details')
@section('page-title', 'Product Details')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">{{ $product->name }}</h2>
                        <div class="flex items-center space-x-3 mt-1">
                            <span class="text-sm text-gray-600">SKU: {{ $product->sku }}</span>
                            <span
                                class="text-sm px-2 py-1 rounded-full 
                            @if ($product->approval_status === 'approved') bg-green-100 text-green-800
                            @elseif($product->approval_status === 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($product->approval_status) }}
                            </span>
                        </div>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.products.edit', $product) }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Edit Product
                        </a>
                        <form action="{{ route('admin.products.approve', $product) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                Approve
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6">
                <!-- Left Column: Product Info -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Product Image -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                class="w-full h-64 object-contain rounded">
                        @else
                            <div class="w-full h-64 bg-gray-200 rounded flex items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Product Details -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-800">Product Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-gray-600">Price</label>
                                <p class="text-lg font-semibold text-gray-900">TK{{ number_format($product->price, 2) }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Stock Quantity</label>
                                <p class="text-lg font-semibold text-gray-900">{{ $product->stock_quantity }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Category</label>
                                <p class="text-gray-900">{{ $product->category->name ?? 'Uncategorized' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Status</label>
                                <p>
                                    <span
                                        class="px-2 py-1 rounded-full text-xs font-medium 
                                    @if ($product->is_active) bg-green-100 text-green-800 @else bg-red-100 text-red-800 @endif">
                                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-2">Description</label>
                            <div class="prose max-w-none text-gray-700">
                                {!! nl2br(e($product->description)) !!}
                            </div>
                        </div>
                    </div>

                    <!-- Order History -->
                    @if ($product->orderItems->count() > 0)
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Order History</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm">
                                        <thead>
                                            <tr class="border-b border-gray-200">
                                                <th class="py-2 text-left font-medium text-gray-600">Order #</th>
                                                <th class="py-2 text-left font-medium text-gray-600">Date</th>
                                                <th class="py-2 text-left font-medium text-gray-600">Quantity</th>
                                                <th class="py-2 text-left font-medium text-gray-600">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($product->orderItems->take(5) as $item)
                                                <tr class="border-b border-gray-100">
                                                    <td class="py-2">{{ $item->order->order_number }}</td>
                                                    <td class="py-2">{{ $item->created_at->format('M d, Y') }}</td>
                                                    <td class="py-2">{{ $item->quantity }}</td>
                                                    <td class="py-2">TK{{ number_format($item->total_price, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column: Seller Info & Actions -->
                <div class="space-y-6">
                    <!-- Seller Information -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Seller Information</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm font-medium text-gray-600">Business Name</label>
                                <p class="text-gray-900">{{ $product->seller->business_name }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Seller Name</label>
                                <p class="text-gray-900">{{ $product->seller->name }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Email</label>
                                <p class="text-gray-900">{{ $product->seller->email }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Phone</label>
                                <p class="text-gray-900">{{ $product->seller->phone }}</p>
                            </div>
                            <a href="{{ route('admin.sellers.show', $product->seller) }}"
                                class="inline-block text-blue-600 hover:text-blue-700 text-sm font-medium">
                                View Seller Profile →
                            </a>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                        <div class="space-y-2">
                            <form action="{{ route('admin.products.toggleStatus', $product) }}" method="POST"
                                class="inline-block w-full">
                                @csrf
                                <button type="submit"
                                    class="w-full px-4 py-2 {{ $product->is_active ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} text-white rounded-lg">
                                    {{ $product->is_active ? 'Deactivate Product' : 'Activate Product' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.products.approve', $product) }}" method="POST"
                                class="inline-block w-full">
                                @csrf
                                <button type="submit"
                                    class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                    Approve Product
                                </button>
                            </form>
                            <form action="{{ route('admin.products.reject', $product) }}" method="POST"
                                class="inline-block w-full">
                                @csrf
                                <button type="submit"
                                    class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                    Reject Product
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Product Stats -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Product Stats</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total Sold</span>
                                <span class="font-semibold">{{ $product->orderItems->sum('quantity') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total Revenue</span>
                                <span
                                    class="font-semibold">TK{{ number_format($product->orderItems->sum('total_price'), 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Created</span>
                                <span class="text-gray-900">{{ $product->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Last Updated</span>
                                <span class="text-gray-900">{{ $product->updated_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
