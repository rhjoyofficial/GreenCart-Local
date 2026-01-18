@extends('layouts.admin')

@section('title', 'Sellers Management')
@section('page-title', 'Sellers')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">Seller Management</h2>
                <p class="text-sm text-gray-600">Manage seller accounts and their businesses</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <form action="{{ route('admin.sellers.index') }}" method="GET"
                class="space-y-4 md:space-y-0 md:flex md:space-x-4">
                <!-- Search -->
                <div class="md:w-1/3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" name="search" placeholder="Search sellers..." value="{{ request('search') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                </div>

                <!-- Status Filter -->
                <div class="md:w-1/3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="is_active"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                        <option value="all" {{ request('is_active') == 'all' ? 'selected' : '' }}>All Status</option>
                        <option value="active" {{ request('is_active') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('is_active') == 'inactive' ? 'selected' : '' }}>Inactive
                        </option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="md:w-1/3 flex items-end space-x-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex-1">
                        Filter
                    </button>
                    <a href="{{ route('admin.sellers.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Sellers Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Seller</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Business</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Products</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Orders</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Revenue</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Joined</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($sellers as $seller)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center font-semibold">
                                            {{ strtoupper(substr($seller->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.sellers.show', $seller) }}"
                                                class="text-sm font-medium text-gray-900 hover:text-blue-600">
                                                {{ $seller->name }}
                                            </a>
                                            <div class="text-xs text-gray-500">{{ $seller->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $seller->business_name ?? 'N/A' }}</div>
                                    <div class="text-xs text-gray-500">{{ $seller->phone ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                                        {{ $seller->products_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-medium">
                                        {{ $seller->seller_orders_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-green-600">
                                    TK{{ number_format($seller->sellerOrders->sum('total_price'), 2) }}
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('admin.sellers.toggleStatus', $seller) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="px-2 py-1 rounded-full text-xs font-medium {{ $seller->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $seller->is_active ? 'Active' : 'Inactive' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $seller->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <div class="flex space-x-3">
                                        <a href="{{ route('admin.sellers.show', $seller) }}"
                                            class="text-blue-600 hover:text-blue-700">View</a>
                                        <a href="{{ route('admin.sellers.edit', $seller) }}"
                                            class="text-green-600 hover:text-green-700">Edit</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No sellers found</h3>
                                    <p class="text-gray-600">Try changing your search or filters.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($sellers->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $sellers->links('partials.pagination') }}
                </div>
            @endif
        </div>
    </div>
@endsection
