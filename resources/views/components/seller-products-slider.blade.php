@props(['seller', 'products', 'title' => null])

<div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    <!-- Seller Header -->
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <div class="w-16 h-16 rounded-full overflow-hidden border-4 border-white shadow-lg">
                        <img src="{{ $seller->image ?? 'https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80' }}"
                            alt="{{ $seller->name }}" class="w-full h-full object-cover">
                    </div>
                    <div
                        class="absolute bottom-0 right-0 w-6 h-6 bg-green-500 border-2 border-white rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-white text-xs"></i>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">{{ $seller->name }}</h3>
                    <div class="flex items-center mt-1">
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <span class="text-gray-600 text-sm ml-2">4.5 (120 reviews)</span>
                    </div>
                    <p class="text-gray-600 text-sm mt-1">{{ $products->count() }} Products</p>
                </div>
            </div>
            <a href="#"
                class="hidden md:inline-flex items-center px-4 py-2 border-2 border-primary-600 text-primary-600 font-medium rounded-lg hover:bg-primary-50 transition-colors duration-200">
                View All Products
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>

    <!-- Products Slider -->
    <div class="relative">
        <!-- Navigation Buttons -->
        <button
            class="seller-slider-prev absolute left-4 top-1/2 transform -translate-y-1/2 z-10 w-10 h-10 bg-white rounded-full shadow-lg flex items-center justify-center hover:bg-gray-50 transition-colors duration-200">
            <i class="fas fa-chevron-left text-gray-700"></i>
        </button>
        <button
            class="seller-slider-next absolute right-4 top-1/2 transform -translate-y-1/2 z-10 w-10 h-10 bg-white rounded-full shadow-lg flex items-center justify-center hover:bg-gray-50 transition-colors duration-200">
            <i class="fas fa-chevron-right text-gray-700"></i>
        </button>

        <!-- Slider Container -->
        <div class="seller-slider swiper px-4 py-6">
            <div class="swiper-wrapper">
                @foreach ($products as $product)
                    <div class="swiper-slide">
                        <div
                            class="bg-white rounded-xl border border-gray-200 hover:border-primary-300 hover:shadow-md transition-all duration-300 p-4 h-full">
                            <!-- Product Image -->
                            <a href="{{ route('products.show', $product->slug) }}" class="block mb-4">
                                <div class="relative overflow-hidden rounded-lg aspect-square">
                                    <img src="{{ $product->image ?? 'https://images.unsplash.com/photo-1542838132-92c53300491e?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80' }}"
                                        alt="{{ $product->name }}"
                                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                    @if ($product->stock_quantity > 0)
                                        <span
                                            class="absolute top-2 left-2 bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded-full">
                                            In Stock
                                        </span>
                                    @else
                                        <span
                                            class="absolute top-2 left-2 bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded-full">
                                            Out of Stock
                                        </span>
                                    @endif
                                </div>
                            </a>

                            <!-- Product Info -->
                            <div>
                                <a class="hover:underline text-xs"
                                    href="{{ route('categories.show', $product->category->slug ?? '#') }}" <span
                                    class="text-xs text-gray-500">{{ $product->category->name ?? 'Uncategorized' }}</span>
                                </a>
                                <a href="{{ route('products.show', $product->slug) }}" class="block">
                                    <h4
                                        class="font-medium text-gray-900 mt-1 hover:text-primary-600 transition-colors duration-200 line-clamp-2">
                                        {{ $product->name }}
                                    </h4>
                                </a>

                                <!-- Rating -->
                                <div class="flex items-center mt-2">
                                    <div class="flex text-yellow-400 text-xs">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <span class="text-xs text-gray-500 ml-1">(45)</span>
                                </div>

                                <!-- Price & Add to Cart -->
                                <div class="flex items-center justify-between mt-4">
                                    <div>
                                        <span class="text-lg font-bold text-gray-900"><span
                                                class="font-bengali">৳</span>{{ number_format($product->price, 2) }}</span>
                                        @if ($product->price > 50)
                                            <span class="text-sm text-gray-500 line-through ml-1"><span
                                                    class="font-bengali">৳</span>{{ number_format($product->price * 1.2, 2) }}</span>
                                        @endif
                                    </div>
                                    <button data-product-id="{{ $product->id }}"
                                        class="add-to-cart w-9 h-9 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors duration-200 flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed"
                                        {{ $product->stock_quantity == 0 ? 'disabled' : '' }}>
                                        <i class="fas fa-shopping-cart text-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Mobile View All Button -->
    <div class="p-6 border-t border-gray-200 md:hidden">
        <a href="#"
            class="block w-full px-4 py-2 border-2 border-primary-600 text-primary-600 font-medium rounded-lg hover:bg-primary-50 transition-colors duration-200 text-center">
            View All Products
            <i class="fas fa-arrow-right ml-2"></i>
        </a>
    </div>
</div>
