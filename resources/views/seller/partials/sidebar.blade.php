<aside id="seller-sidebar" class="hidden lg:block w-64 bg-gray-900 text-white h-screen overflow-y-auto sticky top-0"
    x-data="sellerSidebar()" x-init="init()">
    <div class="p-6">
        <!-- Logo -->
        <a href="{{ route('seller.dashboard') }}" class="flex items-center space-x-2 mb-8">
            <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
            </div>
            <span class="text-xl font-bold">Seller Panel</span>
        </a>

        <!-- Navigation -->
        <nav class="space-y-1">
            <!-- Dashboard -->
            <a href="{{ route('seller.dashboard') }}"
                class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('seller.dashboard') ? 'bg-green-600 text-white' : 'hover:bg-gray-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                <span>Dashboard</span>
            </a>

            <!-- Products -->
            <div x-data="{ open: {{ request()->routeIs('seller.products.*') ? 'true' : 'false' }} }">
                <button @click="open = !open"
                    class="flex items-center justify-between w-full px-4 py-3 rounded-lg transition-colors hover:bg-gray-800 {{ request()->routeIs('seller.products.*') ? 'bg-green-600 text-white' : '' }}">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                            </path>
                        </svg>
                        <span>Products</span>
                    </div>
                    <svg :class="open ? 'transform rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" x-collapse class="ml-3 mt-1 space-y-1">
                    <a href="{{ route('seller.products.index') }}"
                        class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('seller.products.index') ? 'bg-green-600 text-white' : 'hover:bg-gray-800' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                        <span>All Products</span>
                    </a>
                    <a href="{{ route('seller.products.create') }}"
                        class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('seller.products.create') ? 'bg-green-600 text-white' : 'hover:bg-gray-800' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        <span>Add New Product</span>
                    </a>
                    <a href="{{ route('seller.products.index') }}?status=active"
                        class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors hover:bg-gray-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Active Products</span>
                        <span class="ml-auto text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">
                            {{ auth()->user()->products()->where('is_active', true)->where('approval_status', 'approved')->count() }}
                        </span>
                    </a>
                    <a href="{{ route('seller.products.index') }}?status=pending"
                        class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors hover:bg-gray-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Pending Approval</span>
                        <span class="ml-auto text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">
                            {{ auth()->user()->products()->where('approval_status', 'pending')->count() }}
                        </span>
                    </a>
                </div>
            </div>

            <!-- Orders -->
            <div x-data="{ open: {{ request()->routeIs('seller.orders.*') ? 'true' : 'false' }} }">
                <button @click="open = !open"
                    class="flex items-center justify-between w-full px-4 py-3 rounded-lg transition-colors hover:bg-gray-800 {{ request()->routeIs('seller.orders.*') ? 'bg-green-600 text-white' : '' }}">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span>Orders</span>
                    </div>
                    <svg :class="open ? 'transform rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                        </path>
                    </svg>
                </button>
                <div x-show="open" x-collapse class="ml-3 mt-1 space-y-1">
                    <a href="{{ route('seller.orders.index') }}"
                        class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('seller.orders.index') ? 'bg-green-600 text-white' : 'hover:bg-gray-800' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                        <span>All Orders</span>
                        <span class="ml-auto text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">
                            {{ auth()->user()->sellerOrders()->count() }}
                        </span>
                    </a>
                    <a href="{{ route('seller.orders.index') }}?status=pending"
                        class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors hover:bg-gray-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Pending Orders</span>
                        <span class="ml-auto text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">
                            {{ auth()->user()->sellerOrders()->whereHas('order', function ($q) {
                                    $q->where('status', 'pending');
                                })->count() }}
                        </span>
                    </a>
                    <a href="{{ route('seller.orders.index') }}?status=processing"
                        class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors hover:bg-gray-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                            </path>
                        </svg>
                        <span>Processing</span>
                    </a>
                    <a href="{{ route('seller.orders.index') }}?status=shipped"
                        class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors hover:bg-gray-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4">
                            </path>
                        </svg>
                        <span>Shipped</span>
                    </a>
                    <a href="{{ route('seller.orders.index') }}?status=delivered"
                        class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors hover:bg-gray-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Delivered</span>
                        <span class="ml-auto text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">
                            {{ auth()->user()->sellerOrders()->whereHas('order', function ($q) {
                                    $q->where('status', 'delivered');
                                })->count() }}
                        </span>
                    </a>
                </div>
            </div>

            <!-- Profile -->
            <div x-data="{ open: {{ request()->routeIs('seller.profile.*') ? 'true' : 'false' }} }">
                <button @click="open = !open"
                    class="flex items-center justify-between w-full px-4 py-3 rounded-lg transition-colors hover:bg-gray-800 {{ request()->routeIs('seller.profile.*') ? 'bg-green-600 text-white' : '' }}">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>Profile</span>
                    </div>
                    <svg :class="open ? 'transform rotate-180' : ''" class="w-4 h-4 transition-transform"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                        </path>
                    </svg>
                </button>
                <div x-show="open" x-collapse class="ml-3 mt-1 space-y-1">
                    <a href="{{ route('seller.profile.edit') }}"
                        class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('seller.profile.edit') ? 'bg-green-600 text-white' : 'hover:bg-gray-800' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        <span>Edit Profile</span>
                    </a>
                    <a href="{{ route('seller.profile.seller') }}"
                        class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('seller.profile.seller') ? 'bg-green-600 text-white' : 'hover:bg-gray-800' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                        <span>Business Info</span>
                    </a>
                    <a href="{{ route('seller.profile.addresses') }}"
                        class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('seller.profile.addresses') ? 'bg-green-600 text-white' : 'hover:bg-gray-800' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Addresses</span>
                    </a>
                    <a href="#"
                        class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors hover:bg-gray-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                        <span>Change Password</span>
                    </a>
                </div>
            </div>

            <!-- Analytics -->
            <div x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center justify-between w-full px-4 py-3 rounded-lg transition-colors hover:bg-gray-800">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                        <span>Analytics</span>
                    </div>
                    <svg :class="open ? 'transform rotate-180' : ''" class="w-4 h-4 transition-transform"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                        </path>
                    </svg>
                </button>
                <div x-show="open" x-collapse class="ml-3 mt-1 space-y-1">
                    <a href="#"
                        class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors hover:bg-gray-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z">
                            </path>
                        </svg>
                        <span>Sales Report</span>
                    </a>
                    <a href="#"
                        class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors hover:bg-gray-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                        <span>Product Performance</span>
                    </a>
                    <a href="#"
                        class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors hover:bg-gray-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span>Revenue Analytics</span>
                    </a>
                </div>
            </div>

            <!-- Support -->
            <a href="#"
                class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors hover:bg-gray-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
                <span>Support</span>
            </a>
        </nav>

        <!-- Quick Stats -->
        <div class="mt-8 pt-6 border-t border-gray-800">
            <h4 class="text-xs uppercase tracking-wider text-gray-400 mb-4">Quick Stats</h4>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-400">Total Revenue</span>
                    <span class="text-sm font-semibold text-green-400">
                        TK{{ number_format(auth()->user()->sellerOrders()->sum('total_price'), 2) }}
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-400">Active Products</span>
                    <span class="text-sm font-semibold text-white">
                        {{ auth()->user()->products()->where('is_active', true)->where('approval_status', 'approved')->count() }}
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-400">Pending Orders</span>
                    <span class="text-sm font-semibold text-yellow-400">
                        {{ auth()->user()->sellerOrders()->whereHas('order', function ($q) {
                                $q->where('status', 'pending');
                            })->count() }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Logout -->
        <div class="mt-8 pt-6 border-t border-gray-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="flex items-center space-x-3 w-full px-4 py-3 rounded-lg transition-colors hover:bg-red-900 hover:text-red-100 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>

<script>
    function sellerSidebar() {
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
