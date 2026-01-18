<nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-xl">M</span>
                    </div>
                    <span class="text-xl font-bold text-gray-900 hidden sm:block">Marketplace</span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}"
                    class="text-gray-700 hover:text-blue-600 font-medium transition-colors {{ request()->routeIs('home') ? 'text-blue-600' : '' }}">
                    Home
                </a>
                <a href="{{ route('products.index') }}"
                    class="text-gray-700 hover:text-blue-600 font-medium transition-colors {{ request()->routeIs('products.*') ? 'text-blue-600' : '' }}">
                    Products
                </a>
                <a href="{{ route('categories.index') }}"
                    class="text-gray-700 hover:text-blue-600 font-medium transition-colors {{ request()->routeIs('categories.*') ? 'text-blue-600' : '' }}">
                    Categories
                </a>
                <a href="{{ route('contact') }}"
                    class="text-gray-700 hover:text-blue-600 font-medium transition-colors {{ request()->routeIs('contact') ? 'text-blue-600' : '' }}">
                    Contact
                </a>
            </div>

            <!-- Right Side Actions -->
            <div class="flex items-center space-x-4">
                <!-- Search -->
                <div class="hidden lg:block">
                    <div class="relative">
                        <input type="text" placeholder="Search products..."
                            class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                        <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Wishlist -->
                <a href="{{ route('wishlist.index') }}" class="p-2 text-gray-600 hover:text-red-500 relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                        </path>
                    </svg>
                    <span id="wishlist-count"
                        class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center {{ auth()->check() && auth()->user()->defaultWishlist?->products()->count() ? '' : 'hidden' }}">
                        {{ auth()->check() ? auth()->user()->defaultWishlist?->products()->count() : 0 }}
                    </span>
                </a>

                <!-- Cart -->
                <a href="{{ route('cart.index') }}" class="p-2 text-gray-600 hover:text-blue-600 relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                    <span id="cart-count"
                        class="cart-count absolute -top-1 -right-1 bg-blue-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center {{ $cartCount > 0 ? '' : 'hidden' }}">
                        {{ $cartCount }}
                    </span>
                </a>

                <!-- User Menu -->
                @auth
                    <div class="relative">
                        <button id="user-menu-button" class="flex items-center space-x-2 focus:outline-none">
                            <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                <span class="text-gray-700 font-medium">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                            </div>
                            <span class="hidden md:inline text-sm font-medium text-gray-700">
                                {{ auth()->user()->name }}
                            </span>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="user-menu"
                            class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 border border-gray-200 z-50">
                            @if (auth()->user()->hasRole('admin'))
                                <a href="{{ route('admin.dashboard') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Admin Dashboard
                                </a>
                            @elseif(auth()->user()->hasRole('seller'))
                                <a href="{{ route('seller.dashboard') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Seller Dashboard
                                </a>
                            @else
                                <a href="{{ route('customer.dashboard') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    My Account
                                </a>
                            @endif
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Profile Settings
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-blue-600">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                            Sign Up
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button id="mobile-menu-button" class="text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div id="mobile-menu" class="md:hidden hidden bg-white border-t border-gray-200">
        <div class="px-4 py-3 space-y-3">
            <a href="{{ route('home') }}" class="block text-gray-700 hover:text-blue-600 font-medium py-2">
                Home
            </a>
            <a href="{{ route('products.index') }}" class="block text-gray-700 hover:text-blue-600 font-medium py-2">
                Products
            </a>
            <a href="{{ route('categories.index') }}" class="block text-gray-700 hover:text-blue-600 font-medium py-2">
                Categories
            </a>
            <a href="{{ route('contact') }}" class="block text-gray-700 hover:text-blue-600 font-medium py-2">
                Contact
            </a>
            <div class="pt-2 border-t border-gray-200">
                <input type="text" placeholder="Search products..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
            </div>
        </div>
    </div>
</nav>

<script>
    // Mobile menu toggle
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });

    // User menu toggle
    const userMenuButton = document.getElementById('user-menu-button');
    if (userMenuButton) {
        userMenuButton.addEventListener('click', function() {
            document.getElementById('user-menu').classList.toggle('hidden');
        });

        // Close when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('#user-menu-button')) {
                document.getElementById('user-menu').classList.add('hidden');
            }
        });
    }
</script>
