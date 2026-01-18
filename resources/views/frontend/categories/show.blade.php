@extends('layouts.frontend')

@section('title', $category->name)

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Category Header -->
        <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg p-8 mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $category->name }}</h1>
                    <p class="text-gray-600">{{ $category->description }}</p>
                </div>
                <div class="bg-white px-4 py-2 rounded-lg shadow-sm">
                    <span class="text-blue-600 font-semibold">{{ $products->total() }} Products</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Filters Sidebar -->
            <div class="lg:w-1/4">
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Filters</h3>

                    <!-- Price Range -->
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-700 mb-3">Price Range</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Min: TK0</span>
                                <span class="text-gray-600">Max: TK{{ number_format($products->max('price'), 0) }}</span>
                            </div>
                            <input type="range" min="0" max="{{ $products->max('price') }}"
                                value="{{ $products->max('price') }}"
                                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                        </div>
                    </div>

                    <!-- Stock Status -->
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-700 mb-3">Stock Status</h4>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded text-blue-600">
                                <span class="ml-2 text-gray-600">In Stock</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded text-blue-600">
                                <span class="ml-2 text-gray-600">Out of Stock</span>
                            </label>
                        </div>
                    </div>

                    <button class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                        Apply Filters
                    </button>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="lg:w-3/4">
                <!-- Header with Sort -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                    <h2 class="text-xl font-semibold text-gray-800">Products in {{ $category->name }}</h2>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600">Sort by:</span>
                        <select
                            class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                            <option>Featured</option>
                            <option>Price: Low to High</option>
                            <option>Price: High to Low</option>
                            <option>Newest Arrivals</option>
                        </select>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @forelse($products as $product)
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition duration-300">
                            <div class="relative">
                                <a href="{{ route('products.show', $product->slug) }}">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                            class="w-full h-48 object-cover">
                                    @else
                                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif
                                </a>
                                <button
                                    class="absolute top-2 right-2 p-2 bg-white rounded-full shadow-md hover:bg-gray-100 wishlist-toggle"
                                    data-product-id="{{ $product->id }}">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <div class="p-4">
                                <a href="{{ route('products.show', $product->slug) }}" class="block">
                                    <h3 class="font-medium text-gray-800 hover:text-blue-600 mb-1">{{ $product->name }}
                                    </h3>
                                    <p class="text-sm text-gray-600 mb-2">By
                                        {{ $product->seller->business_name ?? $product->seller->name }}</p>
                                    <div class="flex justify-between items-center">
                                        <span
                                            class="text-lg font-bold text-gray-900">TK{{ number_format($product->price, 2) }}</span>
                                        @if ($product->stock_quantity > 0)
                                            <span class="text-sm text-green-600">In Stock</span>
                                        @else
                                            <span class="text-sm text-red-600">Out of Stock</span>
                                        @endif
                                    </div>
                                </a>
                                <button
                                    class="w-full mt-4 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-300 add-to-cart"
                                    data-product-id="{{ $product->id }}">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                </path>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No products found in this category</h3>
                            <p class="text-gray-600">Check back later for new products.</p>
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

@push('scripts')
    <script>
        // Add to cart functionality
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.productId;
                fetch(`/cart/add/${productId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            quantity: 1
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update cart count in navbar
                            document.getElementById('cart-count').textContent = data.cart_count;

                            // Show success message
                            const flash = document.createElement('div');
                            flash.className =
                                'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                            flash.innerHTML = 'Product added to cart!';
                            document.body.appendChild(flash);

                            setTimeout(() => {
                                flash.remove();
                            }, 3000);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });

        // Wishlist toggle functionality
        document.querySelectorAll('.wishlist-toggle').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.productId;
                fetch(`/wishlist/toggle/${productId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update wishlist count if element exists
                            const wishlistCount = document.getElementById('wishlist-count');
                            if (wishlistCount) {
                                wishlistCount.textContent = data.wishlist_count;
                            }

                            // Toggle button color
                            const svg = this.querySelector('svg');
                            if (svg.classList.contains('text-gray-400')) {
                                svg.classList.remove('text-gray-400');
                                svg.classList.add('text-red-500');
                            } else {
                                svg.classList.remove('text-red-500');
                                svg.classList.add('text-gray-400');
                            }
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script>
@endpush
