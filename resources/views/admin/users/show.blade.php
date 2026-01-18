@extends('layouts.admin')

@section('title', 'User Details')
@section('page-title', 'User Details')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <!-- Avatar -->
                        <div
                            class="w-16 h-16 rounded-full flex items-center justify-center text-xl font-semibold
                        @if ($user->hasRole('admin')) bg-red-100 text-red-600
                        @elseif($user->hasRole('seller')) bg-green-100 text-green-600
                        @else bg-blue-100 text-blue-600 @endif">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800">{{ $user->name }}</h2>
                            <div class="flex items-center space-x-3 mt-1">
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-medium 
                                @if ($user->hasRole('admin')) bg-red-100 text-red-800
                                @elseif($user->hasRole('seller')) bg-green-100 text-green-800
                                @else bg-blue-100 text-blue-800 @endif">
                                    {{ $user->role->name }}
                                </span>
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-medium {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.users.edit', $user) }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Edit User
                        </a>
                        @if ($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700"
                                    onclick="return confirm('Are you sure you want to delete this user?')">
                                    Delete
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6">
                <!-- Left Column: User Info -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Personal Information -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Personal Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-gray-600">Email</label>
                                <p class="text-gray-900">{{ $user->email }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Phone</label>
                                <p class="text-gray-900">{{ $user->phone ?? 'Not provided' }}</p>
                            </div>
                            @if ($user->business_name)
                                <div class="md:col-span-2">
                                    <label class="text-sm font-medium text-gray-600">Business Name</label>
                                    <p class="text-gray-900">{{ $user->business_name }}</p>
                                </div>
                            @endif
                            <div>
                                <label class="text-sm font-medium text-gray-600">Member Since</label>
                                <p class="text-gray-900">{{ $user->created_at->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Last Updated</label>
                                <p class="text-gray-900">{{ $user->updated_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Address Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-gray-600">Address Line 1</label>
                                <p class="text-gray-900">{{ $user->address_line1 ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Address Line 2</label>
                                <p class="text-gray-900">{{ $user->address_line2 ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">City</label>
                                <p class="text-gray-900">{{ $user->city ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">State</label>
                                <p class="text-gray-900">{{ $user->state ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Postal Code</label>
                                <p class="text-gray-900">{{ $user->postal_code ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Country</label>
                                <p class="text-gray-900">{{ $user->country ?? 'Not provided' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Activity Based on Role -->
                    @if ($user->hasRole('seller'))
                        <!-- Seller Stats -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Seller Statistics</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div class="text-center p-4 bg-white rounded-lg">
                                    <div class="text-2xl font-bold text-gray-900">{{ $user->products->count() }}</div>
                                    <div class="text-sm text-gray-600">Products</div>
                                </div>
                                <div class="text-center p-4 bg-white rounded-lg">
                                    <div class="text-2xl font-bold text-gray-900">{{ $user->sellerOrders->count() }}</div>
                                    <div class="text-sm text-gray-600">Orders</div>
                                </div>
                                <div class="text-center p-4 bg-white rounded-lg">
                                    <div class="text-2xl font-bold text-gray-900">
                                        TK{{ number_format($user->sellerOrders->sum('total_price'), 2) }}</div>
                                    <div class="text-sm text-gray-600">Revenue</div>
                                </div>
                                <div class="text-center p-4 bg-white rounded-lg">
                                    <div class="text-2xl font-bold text-gray-900">
                                        {{ $user->sellerOrders->unique('order_id')->count() }}</div>
                                    <div class="text-sm text-gray-600">Customers</div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($user->hasRole('customer'))
                        <!-- Customer Stats -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Customer Statistics</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div class="text-center p-4 bg-white rounded-lg">
                                    <div class="text-2xl font-bold text-gray-900">{{ $user->orders->count() }}</div>
                                    <div class="text-sm text-gray-600">Total Orders</div>
                                </div>
                                <div class="text-center p-4 bg-white rounded-lg">
                                    <div class="text-2xl font-bold text-gray-900">
                                        TK{{ number_format($user->orders->sum('total_amount'), 2) }}</div>
                                    <div class="text-sm text-gray-600">Total Spent</div>
                                </div>
                                <div class="text-center p-4 bg-white rounded-lg">
                                    <div class="text-2xl font-bold text-gray-900">{{ $user->wishlists->count() }}</div>
                                    <div class="text-sm text-gray-600">Wishlists</div>
                                </div>
                                <div class="text-center p-4 bg-white rounded-lg">
                                    <div class="text-2xl font-bold text-gray-900">
                                        {{ $user->cart ? $user->cart->items->count() : 0 }}</div>
                                    <div class="text-sm text-gray-600">Cart Items</div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column: Actions & Stats -->
                <div class="space-y-6">
                    <!-- Quick Actions -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                        <div class="space-y-2">
                            <form action="{{ route('admin.users.activate', $user) }}" method="POST"
                                class="inline-block w-full">
                                @csrf
                                <button type="submit"
                                    class="w-full px-4 py-2 {{ $user->is_active ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} text-white rounded-lg">
                                    {{ $user->is_active ? 'Deactivate User' : 'Activate User' }}
                                </button>
                            </form>
                            <a href="{{ route('admin.users.edit', $user) }}"
                                class="block w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-center">
                                Edit User
                            </a>
                            @if ($user->hasRole('seller'))
                                <a href="{{ route('admin.sellers.products', $user) }}"
                                    class="block w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-center">
                                    View Products
                                </a>
                                <a href="{{ route('admin.sellers.orders', $user) }}"
                                    class="block w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 text-center">
                                    View Orders
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Activity</h3>
                        @if ($user->hasRole('seller'))
                            <!-- Recent Seller Products -->
                            <div class="space-y-3">
                                <h4 class="text-sm font-medium text-gray-700">Recent Products</h4>
                                @foreach ($user->products->take(3) as $product)
                                    <div class="flex items-center space-x-3 p-2 bg-white rounded-lg">
                                        @if ($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                alt="{{ $product->name }}" class="w-10 h-10 object-cover rounded">
                                        @else
                                            <div class="w-10 h-10 bg-gray-200 rounded"></div>
                                        @endif
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $product->name }}</p>
                                            <p class="text-xs text-gray-500">TK{{ number_format($product->price, 2) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if ($user->hasRole('customer'))
                            <!-- Recent Customer Orders -->
                            <div class="space-y-3">
                                <h4 class="text-sm font-medium text-gray-700">Recent Orders</h4>
                                @foreach ($user->orders->take(3) as $order)
                                    <div class="p-3 bg-white rounded-lg">
                                        <div class="flex justify-between items-center">
                                            <p class="text-sm font-medium text-gray-900">{{ $order->order_number }}</p>
                                            <span
                                                class="px-2 py-1 text-xs rounded-full {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ ucfirst($order->status->value) }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">{{ $order->created_at->format('M d, Y') }}
                                        </p>
                                        <p class="text-sm text-gray-700 mt-1">
                                            TK{{ number_format($order->total_amount, 2) }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
