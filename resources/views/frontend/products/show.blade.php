@extends('layouts.frontend')

@section('title', $product->name . ' - Marketplace')

@push('scripts')
    <script>
        // Image gallery functionality
        document.addEventListener('DOMContentLoaded', function() {
            const mainImage = document.getElementById('main-image');
            const thumbnails = document.querySelectorAll('.thumbnail');

            thumbnails.forEach(thumb => {
                thumb.addEventListener('click', function() {
                    // Update main image
                    mainImage.src = this.dataset.image;
                    mainImage.alt = this.alt;

                    // Update active thumbnail
                    thumbnails.forEach(t => t.classList.remove('border-blue-500', 'border-2'));
                    this.classList.add('border-blue-500', 'border-2');
                });
            });

            // Quantity controls
            const quantityInput = document.getElementById('quantity');
            const decrementBtn = document.getElementById('decrement-quantity');
            const incrementBtn = document.getElementById('increment-quantity');

            decrementBtn?.addEventListener('click', function() {
                let current = parseInt(quantityInput.value);
                if (current > 1) {
                    quantityInput.value = current - 1;
                }
            });

            incrementBtn?.addEventListener('click', function() {
                let current = parseInt(quantityInput.value);
                const max = parseInt(quantityInput.max);
                if (current < max) {
                    quantityInput.value = current + 1;
                }
            });
        });
    </script>
@endpush

@section('content')
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumbs -->
        @php
            $breadcrumbs = [
                ['url' => route('home'), 'label' => 'Home'],
                ['url' => route('products.index'), 'label' => 'Products'],
                ['url' => '#', 'label' => $product->name],
            ];
        @endphp
        @include('components.breadcrumbs')

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-6">
                <!-- Product Images -->
                <div>
                    <!-- Main Image -->
                    <div class="mb-4">
                        <div class="bg-gray-100 rounded-lg overflow-hidden aspect-square">
                            <img id="main-image"
                                src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/600' }}"
                                alt="{{ $product->name }}" class="w-full h-full object-cover">
                        </div>
                    </div>

                    <!-- Thumbnails -->
                    <div class="grid grid-cols-4 gap-2">
                        <div class="thumbnail border-2 border-blue-500 rounded-lg overflow-hidden cursor-pointer">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/150' }}"
                                alt="{{ $product->name }} - 1"
                                data-image="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/600' }}"
                                class="w-full h-20 object-cover">
                        </div>
                        <!-- Add more thumbnails here if available -->
                    </div>
                </div>

                <!-- Product Info -->
                <div>
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $product->name }}</h1>
                            <div class="flex items-center mt-2">
                                <div class="flex text-yellow-400">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="w-5 h-5 {{ $i <= 4 ? 'fill-current' : '' }}"
                                            fill="{{ $i <= 4 ? 'currentColor' : 'none' }}" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                                            </path>
                                        </svg>
                                    @endfor
                                </div>
                                <span class="text-sm text-gray-500 ml-2">(42 reviews)</span>
                            </div>
                        </div>

                        <!-- Wishlist Button -->
                        @auth
                            <form action="{{ route('wishlist.toggle', $product) }}" method="POST" class="add-to-wishlist-form">
                                @csrf
                                <button type="submit"
                                    class="p-2 rounded-full border border-gray-300 hover:border-red-300 hover:bg-red-50 transition-colors">
                                    <svg class="w-6 h-6 {{ auth()->user()->defaultWishlist?->products()->where('product_id', $product->id)->exists() ? 'text-red-500 fill-red-500' : 'text-gray-500' }}"
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

                    <!-- Seller Info -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Sold by</p>
                                <p class="text-gray-600">{{ $product->seller->business_name ?? $product->seller->name }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="mb-6">
                        <div class="flex items-baseline">
                            <span class="text-3xl font-bold text-gray-900">TK{{ number_format($product->price, 2) }}</span>
                            @if ($product->stock_quantity > 0)
                                <span class="ml-4 px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">
                                    In Stock ({{ $product->stock_quantity }} available)
                                </span>
                            @else
                                <span class="ml-4 px-3 py-1 bg-red-100 text-red-800 text-sm font-medium rounded-full">
                                    Out of Stock
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-900 mb-2">Description</h3>
                        <div class="text-gray-600 prose max-w-none">
                            {{ $product->description ?? 'No description available.' }}
                        </div>
                    </div>

                    <!-- Add to Cart -->
                    <div class="border-t border-gray-200 pt-6">
                        <div class="flex flex-col sm:flex-row gap-4">
                            <!-- Quantity -->
                            <div class="flex items-center">
                                <span class="mr-4 text-gray-700">Quantity:</span>
                                <div class="flex items-center border border-gray-300 rounded-lg">
                                    <button type="button" id="decrement-quantity"
                                        class="px-3 py-2 text-gray-600 hover:text-gray-900 disabled:text-gray-300"
                                        {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 12H4"></path>
                                        </svg>
                                    </button>
                                    <input type="number" id="quantity" name="quantity" value="1" min="1"
                                        max="{{ $product->stock_quantity }}"
                                        class="w-16 text-center border-x border-gray-300 py-2 focus:outline-none">
                                    <button type="button" id="increment-quantity"
                                        class="px-3 py-2 text-gray-600 hover:text-gray-900 disabled:text-gray-300"
                                        {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Add to Cart Button -->
                            <form action="{{ route('cart.add', $product) }}" method="POST"
                                class="add-to-cart-form flex-1">
                                @csrf
                                <input type="hidden" name="quantity" id="cart-quantity" value="1">
                                <button type="submit"
                                    class="w-full add-to-cart-btn bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed font-medium flex items-center justify-center"
                                    {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                    Add to Cart
                                </button>
                            </form>

                            <!-- Buy Now Button -->
                            <form action="{{ route('customer.checkout.index') }}" method="GET" class="flex-1">
                                <button type="submit"
                                    class="w-full bg-green-600 text-white py-3 px-6 rounded-lg hover:bg-green-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed font-medium flex items-center justify-center"
                                    {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                    Buy Now
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Product Details -->
                    <div class="mt-8 grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">SKU:</span>
                            <span class="ml-2 font-medium">{{ $product->sku }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Category:</span>
                            <span class="ml-2 font-medium">{{ $product->category->name ?? 'Uncategorized' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Shipping:</span>
                            <span class="ml-2 font-medium">Free Shipping</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Return Policy:</span>
                            <span class="ml-2 font-medium">30 Days Return</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Customer Reviews</h2>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Rating Summary -->
                <div class="lg:col-span-1">
                    <div class="text-center">
                        <div class="text-5xl font-bold text-gray-900 mb-2">4.2</div>
                        <div class="flex justify-center text-yellow-400 mb-2">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-6 h-6 {{ $i <= 4 ? 'fill-current' : '' }}"
                                    fill="{{ $i <= 4 ? 'currentColor' : 'none' }}" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                                    </path>
                                </svg>
                            @endfor
                        </div>
                        <p class="text-gray-600">Based on 42 reviews</p>
                    </div>
                </div>

                <!-- Review List -->
                <div class="lg:col-span-2">
                    <!-- Add Review Button -->
                    @auth
                        <button class="mb-6 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            Write a Review
                        </button>
                    @else
                        <a href="{{ route('login') }}"
                            class="inline-block mb-6 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            Login to Review
                        </a>
                    @endauth

                    <!-- Sample Reviews -->
                    <div class="space-y-6">
                        <div class="border-b border-gray-200 pb-6">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h4 class="font-semibold text-gray-900">John Doe</h4>
                                    <div class="flex items-center mt-1">
                                        <div class="flex text-yellow-400">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= 5 ? 'fill-current' : '' }}"
                                                    fill="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                                                    </path>
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <span class="text-sm text-gray-500">2 days ago</span>
                            </div>
                            <p class="text-gray-600">Excellent product! Quality is much better than expected. Delivery was
                                fast too.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Update cart quantity when quantity input changes
        document.getElementById('quantity').addEventListener('change', function() {
            document.getElementById('cart-quantity').value = this.value;
        });
    </script>
@endsection
