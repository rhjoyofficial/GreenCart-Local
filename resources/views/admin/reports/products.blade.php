@extends('layouts.admin')

@section('title', 'Products Report')
@section('page-title', 'Products Performance Report')

@section('content')
    <div class="space-y-6">
        <!-- Header & Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">Products Performance Report</h2>
                    <p class="text-sm text-gray-600">Product sales from {{ $startDate }} to {{ $endDate }}</p>
                </div>
            </div>

            <!-- Date Range Form -->
            <form action="{{ route('admin.reports.products') }}" method="GET"
                class="space-y-4 md:space-y-0 md:flex md:space-x-4">
                <div class="md:w-1/3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input type="date" name="start_date" value="{{ $startDate }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                </div>
                <div class="md:w-1/3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                    <input type="date" name="end_date" value="{{ $endDate }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                </div>
                <div class="md:w-1/3 flex items-end space-x-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex-1">
                        Update
                    </button>
                    <a href="{{ route('admin.reports.products') }}"
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sold
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Revenue</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        @if ($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                                class="w-10 h-10 object-cover rounded">
                                        @else
                                            <div class="w-10 h-10 bg-gray-200 rounded"></div>
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
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                    {{ $product->total_sold ?? 0 }}
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-green-600">
                                    TK{{ number_format($product->total_revenue ?? 0, 2) }}
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
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                        </path>
                                    </svg>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No products found</h3>
                                    <p class="text-gray-600">Try changing the date range.</p>
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
