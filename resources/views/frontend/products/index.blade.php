@extends('layouts.frontend')

@section('title', 'All Products - Marketplace')

@section('content')
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumbs -->
        @php
            $breadcrumbs = [['url' => route('home'), 'label' => 'Home'], ['url' => '#', 'label' => 'Products']];
        @endphp
        @include('components.breadcrumbs')

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <div class="lg:w-1/4">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 sticky top-24">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Filters</h3>

                    <!-- Category Filter -->
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-700 mb-3">Categories</h4>
                        <div class="space-y-2">
                            @foreach ($navCategories as $category)
                                <label class="flex items-center">
                                    <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-gray-600">{{ $category->name }}</span>
                                    <span class="ml-auto text-sm text-gray-500">({{ $category->products_count }})</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-700 mb-3">Price Range</h4>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Min: TK100</span>
                                <span class="text-sm text-gray-600">Max: TK50,000</span>
                            </div>
                            <input type="range" min="100" max="50000" step="100"
                                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                        </div>
                    </div>

                    <!-- Apply Filters Button -->
                    <button class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Apply Filters
                    </button>

                    <!-- Clear Filters -->
                    <button
                        class="w-full mt-2 border border-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                        Clear All
                    </button>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:w-3/4">
                <!-- Header -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">All Products</h1>
                        <p class="text-gray-600 mt-1">{{ $products->total() }} products found</p>
                    </div>

                    <!-- Sort Options -->
                    <div class="mt-4 sm:mt-0">
                        <select
                            class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                            <option>Sort by: Featured</option>
                            <option>Price: Low to High</option>
                            <option>Price: High to Low</option>
                            <option>Newest First</option>
                            <option>Best Selling</option>
                        </select>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                    @forelse($products as $product)
                        <div
                            class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-shadow overflow-hidden border border-gray-100">
                            <a href="{{ route('products.show', $product->slug) }}" class="block">
                                <div class="h-56 bg-gray-200 overflow-hidden relative">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                            class="w-full h-full object-cover hover:scale-110 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif
                                    <!-- Wishlist Button -->
                                    @auth
                                        <form action="{{ route('wishlist.toggle', $product) }}" method="POST"
                                            class="add-to-wishlist-form absolute top-3 right-3">
                                            @csrf
                                            <button type="submit"
                                                class="wishlist-btn bg-white/80 hover:bg-white backdrop-blur-sm p-2 rounded-full shadow-sm">
                                                <svg class="w-5 h-5 {{ auth()->user()->defaultWishlist?->products()->where('product_id', $product->id)->exists() ? 'text-red-500 fill-red-500' : 'text-gray-500' }}"
                                                    fill="{{ auth()->user()->defaultWishlist?->products()->where('product_id', $product->id)->exists() ? 'currentColor' : 'none' }}"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endauth
                                </div>
                            </a>
                            <div class="p-4">
                                <a href="{{ route('products.show', $product->slug) }}" class="block">
                                    <h3
                                        class="font-semibold text-gray-900 hover:text-blue-600 transition-colors line-clamp-1">
                                        {{ $product->name }}
                                    </h3>
                                </a>
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ $product->seller->business_name ?? $product->seller->name }}</p>
                                <div class="flex items-center mt-2">
                                    <div class="flex text-yellow-400">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= 4 ? 'fill-current' : '' }}"
                                                fill="{{ $i <= 4 ? 'currentColor' : 'none' }}" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                                                </path>
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="text-sm text-gray-500 ml-2">(42)</span>
                                </div>
                                <div class="flex items-center justify-between mt-4">
                                    <div>
                                        <span
                                            class="text-lg font-bold text-gray-900">TK{{ number_format($product->price, 2) }}</span>
                                        @if ($product->stock_quantity > 0)
                                            <span class="text-sm text-green-600 ml-2">In Stock</span>
                                        @else
                                            <span class="text-sm text-red-600 ml-2">Out of Stock</span>
                                        @endif
                                    </div>
                                    <form action="{{ route('cart.add', $product) }}" method="POST"
                                        class="add-to-cart-form">
                                        @csrf
                                        <button type="submit"
                                            class="add-to-cart-btn bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                            {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No products found</h3>
                            <p class="text-gray-600 mb-4">Try adjusting your search or filter to find what you're looking
                                for.</p>
                            <a href="{{ route('products.index') }}"
                                class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                Clear Filters
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if ($products->hasPages())
                    <div class="mt-8">
                        {{ $products->links('partials.pagination') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
