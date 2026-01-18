<aside class="lg:w-1/4" x-data="customerSidebar()" x-init="init()">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 overflow-hidden">
        <!-- User Info -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <span class="text-green-600 font-semibold text-lg">
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
                        class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('customer.dashboard') ? 'bg-green-50 text-green-600' : 'hover:bg-gray-50 text-gray-700' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        Dashboard
                    </a>
                </li>

                <!-- Orders -->
                <li x-data="{ open: {{ request()->routeIs('customer.orders.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full px-4 py-3 rounded-lg transition-colors hover:bg-gray-50 text-gray-700 {{ request()->routeIs('customer.orders.*') ? 'bg-green-50 text-green-600' : '' }}">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            My Orders
                            <span class="ml-2 bg-green-100 text-green-600 text-xs px-2 py-1 rounded-full">
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
                            class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('customer.orders.index') ? 'bg-green-50 text-green-600' : 'hover:bg-gray-50 text-gray-700' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                            All Orders
                        </a>
                        <a href="{{ route('customer.orders.index') }}?status=pending"
                            class="flex items-center px-4 py-2 rounded-lg transition-colors hover:bg-gray-50 text-gray-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Pending Orders
                        </a>
                    </div>
                </li>

                <!-- Wishlist -->
                {{-- <li>
                    <a href="{{ route('customer.wishlist.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('customer.wishlist.*') ? 'bg-green-50 text-green-600' : 'hover:bg-gray-50 text-gray-700' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                            </path>
                        </svg>
                        My Wishlist
                        <span class="ml-auto bg-green-100 text-green-600 text-xs px-2 py-1 rounded-full">
                            {{ auth()->user()->defaultWishlist?->products()->count() ?? 0 }}
                        </span>
                    </a>
                </li> --}}

                <!-- Addresses -->
                <li>
                    <a href="{{ route('customer.addresses') }}"
                        class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('customer.addresses') ? 'bg-green-50 text-green-600' : 'hover:bg-gray-50 text-gray-700' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        My Addresses
                    </a>
                </li>

                <!-- Profile -->
                <li x-data="{ open: {{ request()->routeIs('customer.profile.*') || request()->routeIs('customer.profile') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full px-4 py-3 rounded-lg transition-colors hover:bg-gray-50 text-gray-700 {{ request()->routeIs('customer.profile.*') || request()->routeIs('customer.profile') ? 'bg-green-50 text-green-600' : '' }}">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profile Settings
                        </div>
                        <svg :class="open ? 'transform rotate-180' : ''" class="w-4 h-4 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="ml-3 mt-1 space-y-1">
                        <a href="{{ route('customer.profile') }}"
                            class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('customer.profile') ? 'bg-green-50 text-green-600' : 'hover:bg-gray-50 text-gray-700' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            View Profile
                        </a>
                        <a href="{{ route('customer.profile.edit') }}"
                            class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('customer.profile.edit') ? 'bg-green-50 text-green-600' : 'hover:bg-gray-50 text-gray-700' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                            Edit Profile
                        </a>
                        <a href="#"
                            onclick="event.preventDefault(); document.getElementById('change-password-form').classList.toggle('hidden');"
                            class="flex items-center px-4 py-2 rounded-lg transition-colors hover:bg-gray-50 text-gray-700">
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
                        class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('wishlist.*') ? 'bg-green-50 text-green-600' : 'hover:bg-gray-50 text-gray-700' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                            </path>
                        </svg>
                        Public Wishlist
                    </a>
                </li>

                <li>
                    <a href="{{ route('cart.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('cart.*') ? 'bg-green-50 text-green-600' : 'hover:bg-gray-50 text-gray-700' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        Shopping Cart
                        <span class="ml-auto bg-green-100 text-green-600 text-xs px-2 py-1 rounded-full">
                            {{ auth()->user()->cart?->items()->sum('quantity') ?? 0 }}
                        </span>
                    </a>
                </li>

                <!-- Settings -->
                <li>
                    <a href="{{ route('customer.settings') }}"
                        class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('customer.settings') ? 'bg-green-50 text-green-600' : 'hover:bg-gray-50 text-gray-700' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Account Settings
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

<!-- Password Change Form (hidden by default) -->
<div id="change-password-form" class="hidden mt-4 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <h4 class="font-semibold text-gray-900 mb-4">Change Password</h4>
    <form action="{{ route('customer.profile.change-password') }}" method="POST">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                <input type="password" name="current_password" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                <input type="password" name="password" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                <input type="password" name="password_confirmation" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button"
                    onclick="document.getElementById('change-password-form').classList.add('hidden')"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Change Password
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function customerSidebar() {
        return {
            init() {
                // Initialize sidebar state
                console.log('Customer sidebar initialized');
            }
        }
    }
</script>
