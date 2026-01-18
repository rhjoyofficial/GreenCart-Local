@extends('layouts.frontend')

@section('title', 'Order Confirmation - GreenCart-Local')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Success Message -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Order Placed Successfully!</h1>
            <p class="text-gray-600">Thank you for your purchase. Your order has been confirmed.</p>
        </div>

        <!-- Order Details Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <!-- Order Header -->
            <div class="bg-green-50 px-6 py-4 border-b border-gray-200">
                <div class="flex flex-col md:flex-row md:items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Order #{{ $order->order_number }}</h2>
                        <p class="text-sm text-gray-600">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
                    </div>
                    <div class="mt-2 md:mt-0">
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">
                            {{ ucfirst($order->status->value) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Shipping Information -->
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-3">Shipping Information</h3>
                        <div class="space-y-2 text-sm">
                            <p class="text-gray-900 font-medium">{{ auth()->user()->name }}</p>
                            <p class="text-gray-600">{{ $order->shipping_address }}</p>
                            <p class="text-gray-600">Phone: {{ $order->phone ?? auth()->user()->phone }}</p>
                            <p class="text-gray-600">Email: {{ auth()->user()->email }}</p>
                        </div>
                    </div>

                    <!-- Order Information -->
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-3">Order Information</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Order Number:</span>
                                <span class="font-medium text-gray-900">{{ $order->order_number }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Payment Method:</span>
                                <span class="font-medium text-gray-900">
                                    @switch($order->payment_method)
                                        @case('cod')
                                            Cash on Delivery
                                        @break

                                        @case('card')
                                            Credit/Debit Card
                                        @break

                                        @case('mobile_banking')
                                            Mobile Banking
                                        @break

                                        @default
                                            {{ ucfirst($order->payment_method) }}
                                    @endswitch
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Payment Status:</span>
                                <span class="font-medium text-gray-900">{{ ucfirst($order->payment_status) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Estimated Delivery:</span>
                                <span class="font-medium text-gray-900">
                                    {{ now()->addDays(3)->format('F d, Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Order Items</h3>
                    <div class="space-y-4">
                        @foreach ($order->items as $item)
                            <div class="flex items-center justify-between py-3 border-b border-gray-200 last:border-0">
                                <div class="flex items-center">
                                    @if ($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}"
                                            alt="{{ $item->product->name }}"
                                            class="w-16 h-16 object-cover rounded-lg mr-4">
                                    @else
                                        <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center mr-4">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $item->product->name }}</p>
                                        <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                                    </div>
                                </div>
                                <span class="font-medium text-gray-900">TK{{ number_format($item->total_price, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Total -->
                <div class="border-t border-gray-200 pt-6 mt-6">
                    <div class="space-y-2">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span>TK{{ number_format($order->items->sum('total_price'), 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Shipping</span>
                            <span class="text-green-600">Free</span>
                        </div>
                        <div class="flex justify-between pt-4 border-t border-gray-200">
                            <span class="text-lg font-semibold text-gray-900">Total</span>
                            <span
                                class="text-xl font-bold text-gray-900">TK{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Next Steps -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
            <h3 class="font-semibold text-gray-900 mb-4">What's Next?</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="text-center p-4 border border-gray-200 rounded-lg">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h4 class="font-medium text-gray-900 mb-1">Order Confirmation</h4>
                    <p class="text-sm text-gray-600">You'll receive an email confirmation shortly.</p>
                </div>
                <div class="text-center p-4 border border-gray-200 rounded-lg">
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h4 class="font-medium text-gray-900 mb-1">Processing</h4>
                    <p class="text-sm text-gray-600">Seller will prepare your order for shipment.</p>
                </div>
                <div class="text-center p-4 border border-gray-200 rounded-lg">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <h4 class="font-medium text-gray-900 mb-1">Delivery</h4>
                    <p class="text-sm text-gray-600">Your order will arrive within 3-5 business days.</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('customer.orders.show', $order) }}"
                class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium text-center">
                View Order Details
            </a>
            <a href="{{ route('products.index') }}"
                class="px-6 py-3 bg-white text-green-600 border border-green-600 rounded-lg hover:bg-green-50 transition-colors font-medium text-center">
                Continue Shopping
            </a>
            <a href="{{ route('customer.dashboard') }}"
                class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium text-center">
                Back to Dashboard
            </a>
        </div>

        <!-- Help Section -->
        <div class="mt-8 text-center">
            <p class="text-gray-600 mb-2">Need help with your order?</p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('contact') }}" class="text-green-600 hover:text-green-700 font-medium">
                    Contact Support
                </a>
                <a href="{{ route('faqs') }}" class="text-green-600 hover:text-green-700 font-medium">
                    View FAQs
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add some celebratory animation
            const successIcon = document.querySelector('.bg-green-100');
            if (successIcon) {
                successIcon.classList.add('animate-bounce');
                setTimeout(() => {
                    successIcon.classList.remove('animate-bounce');
                }, 1000);
            }

            // Print order functionality
            const printOrder = () => {
                window.print();
            };

            // Add print button if needed
            // You can add a print button in the template if required
        });
    </script>
@endpush
