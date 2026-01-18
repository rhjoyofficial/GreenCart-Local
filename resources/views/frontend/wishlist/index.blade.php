@extends('layouts.customer')

@section('title', 'My Wishlist')
@section('page-title', 'My Wishlist')
@section('page-description', 'Your saved items')

@section('content')
    <div class="space-y-6">
        <!-- Wishlist Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">My Wishlist</h2>
                <p class="text-gray-600 mt-1">Items you've saved for later</p>
            </div>
            <div class="mt-4 md:mt-0 flex items-center space-x-4">
                <!-- Share Wishlist -->
                <button class="flex items-center text-gray-600 hover:text-gray-900">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z">
                        </path>
                    </svg>
                    Share
                </button>
                <!-- Clear Wishlist -->
                <button class="text-red-600 hover:text-red-700 font-medium">
                    Clear All
                </button>
            </div>
        </div>

        <!-- Wishlist Items -->
        @if ($items && $items->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($items as $product)
                    <div
                        class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                        <!-- Product Image -->
                        <a href="{{ route('products.show', $product->slug) }}" class="block">
                            <div class="h-48 bg-gray-200 overflow-hidden relative">
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
                                <!-- Remove from Wishlist Button -->
                                <form action="{{ route('wishlist.toggle', $product) }}" method="POST"
                                    class="absolute top-3 right-3 add-to-wishlist-form">
                                    @csrf
                                    <button type="submit"
                                        class="wishlist-remove-btn bg-white/80 hover:bg-white backdrop-blur-sm p-2 rounded-full shadow-sm">
                                        <svg class="w-5 h-5 text-red-500 fill-red-500" fill="currentColor"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                            </path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </a>

                        <!-- Product Info -->
                        <div class="p-4">
                            <a href="{{ route('products.show', $product->slug) }}" class="block">
                                <h3 class="font-semibold text-gray-900 hover:text-blue-600 transition-colors line-clamp-1">
                                    {{ $product->name }}
                                </h3>
                            </a>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $product->seller->business_name ?? $product->seller->name }}</p>

                            <!-- Rating -->
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

                            <!-- Price & Actions -->
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
                                <div class="flex items-center space-x-2">
                                    <!-- Add to Cart -->
                                    <form action="{{ route('cart.add', $product) }}" method="POST"
                                        class="add-to-cart-form">
                                        @csrf
                                        <button type="submit"
                                            class="add-to-cart-btn bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                            {{ $product->stock_quantity <= 0 ? 'disabled' : '' }} title="Add to Cart">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if ($items->hasPages())
                <div class="mt-8">
                    {{ $items->links('partials.pagination') }}
                </div>
            @endif
        @else
            <!-- Empty Wishlist -->
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                    </path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Your wishlist is empty</h3>
                <p class="text-gray-600 mb-4">Save items you like to your wishlist for easy access later</p>
                <a href="{{ route('products.index') }}"
                    class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                    Start Shopping
                </a>
            </div>
        @endif

        <!-- Recently Viewed -->
        <div class="mt-12">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Recently Viewed</h3>
                <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                    View All
                </a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                <!-- Sample Recently Viewed Items -->
                @for ($i = 0; $i < 6; $i++)
                    <div class="bg-white rounded-lg border border-gray-200 p-3">
                        <div class="aspect-square bg-gray-200 rounded mb-2"></div>
                        <p class="text-sm text-gray-900 truncate">Product {{ $i + 1 }}</p>
                        <p class="text-sm font-medium text-gray-900">TK{{ rand(100, 1000) }}</p>
                    </div>
                @endfor
            </div>
        </div>
    </div>
@endsection
