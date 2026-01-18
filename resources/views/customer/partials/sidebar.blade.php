<aside class="lg:w-1/4" x-data="customerSidebar()" x-init="init()">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 overflow-hidden">
        <!-- User Info -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <span class="text-blue-600 font-semibold text-lg">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">{{ auth()->user()->name }}</h3>
                    <p class="text-sm text-gray-600">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="p-4">
            <ul class="space-y-1">
                <!-- Dashboard -->
                <li>
                    <a href="{{ route('customer.dashboard') }}"
                        class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('customer.dashboard') ? 'bg-blue-50 text-blue-600' : 'hover:bg-gray-50 text-gray-700' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        Dashboard
                    </a>
                </li>

                <!-- Orders -->
                <li x-data="{ open: {{ request()->routeIs('customer.orders.*') || request()->routeIs('customer.dashboard.orders') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full px-4 py-3 rounded-lg transition-colors hover:bg-gray-50 text-gray-700 {{ request()->routeIs('customer.orders.*') || request()->routeIs('customer.dashboard.orders') ? 'bg-blue-50 text-blue-600' : '' }}">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            My Orders
                            <span class="ml-2 bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded-full">
                                {{ auth()->user()->orders()->count() }}
                            </span>
                        </div>
                        <svg :class="open ? 'transform rotate-180' : ''" class="w-4 h-4 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="ml-3 mt-1 space-y-1">
                        <a href="{{ route('customer.orders.index') }}"
                            class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('customer.orders.index') ? 'bg-blue-50 text-blue-600' : 'hover:bg-gray-50 text-gray-700' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                            All Orders
                        </a>
                        {{-- {{ route('customer.dashboard.orders-history') }} --}}
                        <a href="#"
                            class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('customer.dashboard.orders') ? 'bg-blue-50 text-blue-600' : 'hover:bg-gray-50 text-gray-700' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Order History
                        </a>
                    </div>
                </li>

                <!-- Checkout -->
                <li x-data="{ open: {{ request()->routeIs('customer.checkout.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full px-4 py-3 rounded-lg transition-colors hover:bg-gray-50 text-gray-700 {{ request()->routeIs('customer.checkout.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Checkout
                        </div>
                        <svg :class="open ? 'transform rotate-180' : ''" class="w-4 h-4 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="ml-3 mt-1 space-y-1">
                        <a href="{{ route('customer.checkout.index') }}"
                            class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('customer.checkout.index') ? 'bg-blue-50 text-blue-600' : 'hover:bg-gray-50 text-gray-700' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Checkout
                        </a>
                    </div>
                </li>

                <!-- Dashboard Sections -->
                <li x-data="{ open: {{ request()->routeIs('customer.dashboard.*') && !request()->routeIs('customer.dashboard') && !request()->routeIs('customer.dashboard.orders') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full px-4 py-3 rounded-lg transition-colors hover:bg-gray-50 text-gray-700 {{ request()->routeIs('customer.dashboard.*') && !request()->routeIs('customer.dashboard') && !request()->routeIs('customer.dashboard.orders') ? 'bg-blue-50 text-blue-600' : '' }}">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Dashboard Sections
                        </div>
                        <svg :class="open ? 'transform rotate-180' : ''" class="w-4 h-4 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="ml-3 mt-1 space-y-1">
                        <a href="{{ route('customer.dashboard.wishlist') }}"
                            class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('customer.dashboard.wishlist') ? 'bg-blue-50 text-blue-600' : 'hover:bg-gray-50 text-gray-700' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                </path>
                            </svg>
                            Wishlist
                            <span class="ml-auto bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded-full">
                                {{ auth()->user()->defaultWishlist?->products()->count() ?? 0 }}
                            </span>
                        </a>
                        <a href="{{ route('customer.dashboard.addresses') }}"
                            class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('customer.dashboard.addresses') ? 'bg-blue-50 text-blue-600' : 'hover:bg-gray-50 text-gray-700' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Addresses
                        </a>
                        <a href="{{ route('customer.dashboard.notifications') }}"
                            class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('customer.dashboard.notifications') ? 'bg-blue-50 text-blue-600' : 'hover:bg-gray-50 text-gray-700' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                </path>
                            </svg>
                            Notifications
                        </a>
                        <a href="{{ route('customer.dashboard.settings') }}"
                            class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('customer.dashboard.settings') ? 'bg-blue-50 text-blue-600' : 'hover:bg-gray-50 text-gray-700' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Settings
                        </a>
                    </div>
                </li>

                <!-- Profile -->
                <li x-data="{ open: {{ request()->routeIs('customer.profile.*') || request()->routeIs('customer.dashboard.profile') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full px-4 py-3 rounded-lg transition-colors hover:bg-gray-50 text-gray-700 {{ request()->routeIs('customer.profile.*') || request()->routeIs('customer.dashboard.profile') ? 'bg-blue-50 text-blue-600' : '' }}">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profile
                        </div>
                        <svg :class="open ? 'transform rotate-180' : ''" class="w-4 h-4 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="ml-3 mt-1 space-y-1">
                        <a href="{{ route('customer.dashboard.profile') }}"
                            class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('customer.dashboard.profile') ? 'bg-blue-50 text-blue-600' : 'hover:bg-gray-50 text-gray-700' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            My Profile
                        </a>
                        <a href="{{ route('customer.profile.edit') }}"
                            class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('customer.profile.edit') ? 'bg-blue-50 text-blue-600' : 'hover:bg-gray-50 text-gray-700' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                            Edit Profile
                        </a>
                        <a href="{{ route('customer.dashboard.changePassword') }}"
                            class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('customer.dashboard.changePassword') ? 'bg-blue-50 text-blue-600' : 'hover:bg-gray-50 text-gray-700' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                            Change Password
                        </a>
                    </div>
                </li>

                <!-- Shopping -->
                <li>
                    <a href="{{ route('wishlist.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('wishlist.*') ? 'bg-blue-50 text-blue-600' : 'hover:bg-gray-50 text-gray-700' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                            </path>
                        </svg>
                        Wishlist
                        <span class="ml-auto bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded-full">
                            {{ auth()->user()->defaultWishlist?->products()->count() ?? 0 }}
                        </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('cart.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('cart.*') ? 'bg-blue-50 text-blue-600' : 'hover:bg-gray-50 text-gray-700' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        Shopping Cart
                        <span class="ml-auto bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded-full">
                            {{ auth()->user()->cart?->items()->sum('quantity') ?? 0 }}
                        </span>
                    </a>
                </li>

                <!-- Support -->
                <li>
                    <a href="#"
                        class="flex items-center px-4 py-3 rounded-lg transition-colors hover:bg-gray-50 text-gray-700">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        Support
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Logout -->
        <div class="p-4 border-t border-gray-200">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="flex items-center w-full px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h4 class="font-semibold text-gray-900 mb-4">Account Overview</h4>
        <div class="space-y-4">
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Total Orders</span>
                <span class="font-medium">{{ auth()->user()->orders()->count() }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Pending Orders</span>
                <span class="font-medium">{{ auth()->user()->orders()->where('status', 'pending')->count() }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Wishlist Items</span>
                <span class="font-medium">{{ auth()->user()->defaultWishlist?->products()->count() ?? 0 }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Cart Items</span>
                <span class="font-medium">{{ auth()->user()->cart?->items()->sum('quantity') ?? 0 }}</span>
            </div>
        </div>
    </div>
</aside>

<script>
    function customerSidebar() {
        return {
            init() {
                // Initialize sidebar state
                this.$watch('$store.sidebar.open', (value) => {
                    if (value) {
                        this.openAllActiveMenus();
                    }
                });
            },
            openAllActiveMenus() {
                // This function can be used to programmatically open menus if needed
            }
        }
    }
</script>
