@extends('layouts.admin')

@section('title', 'Products Management')
@section('page-title', 'Products')

@section('content')
    <div class="space-y-6">
        <!-- Header with Search -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">All Products</h2>
                <p class="text-sm text-gray-600">Manage products from all sellers</p>
            </div>

            <!-- Search -->
            <form action="{{ route('admin.products.index') }}" method="GET" class="w-full md:w-auto">
                <div class="relative">
                    <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}"
                        class="w-full md:w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                    <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </form>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <form action="{{ route('admin.products.index') }}" method="GET"
                class="space-y-4 md:space-y-0 md:flex md:space-x-4">
                <!-- Seller Filter -->
                <div class="md:w-1/3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Seller</label>
                    <select name="seller_id"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                        <option value="">All Sellers</option>
                        @foreach ($sellers as $seller)
                            <option value="{{ $seller->id }}" {{ request('seller_id') == $seller->id ? 'selected' : '' }}>
                                {{ $seller->business_name }} ({{ $seller->name }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="md:w-1/3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Approval Status</label>
                    <select name="approval_status"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                        <option value="all" {{ request('approval_status') == 'all' ? 'selected' : '' }}>All Status
                        </option>
                        <option value="pending" {{ request('approval_status') == 'pending' ? 'selected' : '' }}>Pending
                        </option>
                        <option value="approved" {{ request('approval_status') == 'approved' ? 'selected' : '' }}>Approved
                        </option>
                        <option value="rejected" {{ request('approval_status') == 'rejected' ? 'selected' : '' }}>Rejected
                        </option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="md:w-1/3 flex items-end space-x-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex-1">
                        Filter
                    </button>
                    <a href="{{ route('admin.products.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Products Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Seller</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        @if ($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                alt="{{ $product->name }}" class="w-10 h-10 rounded object-cover">
                                        @else
                                            <div class="w-10 h-10 bg-gray-200 rounded flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <a href="{{ route('admin.products.show', $product) }}"
                                                class="text-sm font-medium text-gray-900 hover:text-blue-600">
                                                {{ $product->name }}
                                            </a>
                                            <div class="text-xs text-gray-500">{{ $product->sku }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $product->seller->business_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $product->seller->name }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $product->category->name ?? 'Uncategorized' }}
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                    TK{{ number_format($product->price, 2) }}
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="text-sm {{ $product->stock_quantity > 10 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $product->stock_quantity }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        <!-- Approval Status -->
                                        <span
                                            class="px-2 py-1 rounded-full text-xs font-medium 
                                    @if ($product->approval_status === 'approved') bg-green-100 text-green-800
                                    @elseif($product->approval_status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($product->approval_status) }}
                                        </span>
                                        <!-- Active Status -->
                                        <span
                                            class="px-2 py-1 rounded-full text-xs font-medium 
                                    @if ($product->is_active) bg-blue-100 text-blue-800 @else bg-gray-100 text-gray-800 @endif">
                                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.products.show', $product) }}"
                                            class="text-blue-600 hover:text-blue-700">View</a>
                                        <a href="{{ route('admin.products.edit', $product) }}"
                                            class="text-green-600 hover:text-green-700">Edit</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                        </path>
                                    </svg>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No products found</h3>
                                    <p class="text-gray-600">Try changing your search or filters.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($products->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $products->links('partials.pagination') }}
                </div>
            @endif
        </div>
    </div>
@endsection
