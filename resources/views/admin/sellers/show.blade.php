@extends('layouts.admin')

@section('title', 'Seller Details')
@section('page-title', 'Seller Details')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <!-- Avatar -->
                        <div
                            class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-xl font-semibold">
                            {{ strtoupper(substr($seller->name, 0, 1)) }}
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800">{{ $seller->name }}</h2>
                            <div class="flex items-center space-x-3 mt-1">
                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Seller
                                </span>
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-medium {{ $seller->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $seller->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                @if ($seller->business_name)
                                    <span class="text-sm text-gray-600">{{ $seller->business_name }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.sellers.edit', $seller) }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Edit Seller
                        </a>
                        <a href="{{ route('admin.sellers.analytics', $seller) }}"
                            class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                            Analytics
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6">
                <!-- Left Column: Seller Info -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Seller Statistics -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_products'] }}</p>
                            <p class="text-sm text-gray-600">Products</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['active_products'] }}</p>
                            <p class="text-sm text-gray-600">Active</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_orders'] }}</p>
                            <p class="text-sm text-gray-600">Orders</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <p class="text-2xl font-bold text-gray-900">TK{{ number_format($stats['total_revenue'], 2) }}
                            </p>
                            <p class="text-sm text-gray-600">Revenue</p>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Contact Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-gray-600">Email</label>
                                <p class="text-gray-900">{{ $seller->email }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Phone</label>
                                <p class="text-gray-900">{{ $seller->phone ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Business Name</label>
                                <p class="text-gray-900">{{ $seller->business_name ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Member Since</label>
                                <p class="text-gray-900">{{ $seller->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Orders -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Recent Orders</h3>
                            <a href="{{ route('admin.sellers.orders', $seller) }}"
                                class="text-sm text-blue-600 hover:text-blue-700">
                                View All
                            </a>
                        </div>
                        <div class="space-y-3">
                            @forelse($recentOrders as $orderItem)
                                <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                                    <div>
                                        <a href="{{ route('admin.orders.show', $orderItem->order) }}"
                                            class="text-sm font-medium text-gray-900 hover:text-blue-600">
                                            {{ $orderItem->order->order_number }}
                                        </a>
                                        <p class="text-xs text-gray-500">Customer: {{ $orderItem->order->customer->name }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-900">{{ $orderItem->product->name }}</p>
                                        <p class="text-xs text-gray-500">TK{{ number_format($orderItem->total_price, 2) }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-600 text-center py-4">No recent orders</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right Column: Actions & Products -->
                <div class="space-y-6">
                    <!-- Quick Actions -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                        <div class="space-y-2">
                            <form action="{{ route('admin.sellers.toggleStatus', $seller) }}" method="POST"
                                class="inline-block w-full">
                                @csrf
                                <button type="submit"
                                    class="w-full px-4 py-2 {{ $seller->is_active ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} text-white rounded-lg">
                                    {{ $seller->is_active ? 'Deactivate Seller' : 'Activate Seller' }}
                                </button>
                            </form>
                            <a href="{{ route('admin.sellers.products', $seller) }}"
                                class="block w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-center">
                                View Products
                            </a>
                            <a href="{{ route('admin.sellers.orders', $seller) }}"
                                class="block w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 text-center">
                                View Orders
                            </a>
                            <a href="{{ route('admin.sellers.analytics', $seller) }}"
                                class="block w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-center">
                                View Analytics
                            </a>
                        </div>
                    </div>

                    <!-- Recent Products -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Recent Products</h3>
                            <a href="{{ route('admin.sellers.products', $seller) }}"
                                class="text-sm text-blue-600 hover:text-blue-700">
                                View All
                            </a>
                        </div>
                        <div class="space-y-3">
                            @forelse($recentProducts as $product)
                                <div class="flex items-center space-x-3 p-3 bg-white rounded-lg">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                            class="w-12 h-12 object-cover rounded">
                                    @else
                                        <div class="w-12 h-12 bg-gray-200 rounded"></div>
                                    @endif
                                    <div class="flex-1">
                                        <a href="{{ route('admin.products.show', $product) }}"
                                            class="text-sm font-medium text-gray-900 hover:text-blue-600">
                                            {{ $product->name }}
                                        </a>
                                        <div class="flex items-center justify-between mt-1">
                                            <span
                                                class="text-xs text-gray-500">{{ $product->category->name ?? 'Uncategorized' }}</span>
                                            <span
                                                class="text-sm font-medium text-gray-900">TK{{ number_format($product->price, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-600 text-center py-4">No products added yet</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Seller Information -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Account Information</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Pending Products</span>
                                <span class="font-medium">{{ $stats['pending_products'] }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Monthly Revenue</span>
                                <span class="font-medium">TK{{ number_format($stats['monthly_revenue'], 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total Customers</span>
                                <span class="font-medium">{{ $recentOrders->unique('order.customer_id')->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
