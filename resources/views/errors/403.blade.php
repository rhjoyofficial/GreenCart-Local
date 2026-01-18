@extends('layouts.frontend')

@section('title', 'Access Denied - Marketplace')

@section('content')
    <div class="min-h-[70vh] flex items-center justify-center">
        <div class="text-center max-w-lg mx-auto px-4">
            <!-- Error Icon -->
            <div class="mb-8">
                <div class="w-32 h-32 bg-yellow-100 rounded-full flex items-center justify-center mx-auto">
                    <svg class="w-16 h-16 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m0 0v2m0-2h2m-2 0H9.5m4.5-5.5v-5a2 2 0 00-2-2h-2a2 2 0 00-2 2v5"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
            </div>

            <!-- Error Message -->
            <h1 class="text-4xl font-bold text-gray-900 mb-4">403 - Access Denied</h1>
            <p class="text-lg text-gray-600 mb-6">
                You don't have permission to access this page or resource.
            </p>
            <p class="text-gray-500 mb-8">
                This area may require special permissions or you may need to log in with a different account.
            </p>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    @if (auth()->user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}"
                            class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                            Go to Admin Dashboard
                        </a>
                    @elseif(auth()->user()->hasRole('seller'))
                        <a href="{{ route('seller.dashboard') }}"
                            class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors font-medium">
                            Go to Seller Dashboard
                        </a>
                    @else
                        <a href="{{ route('customer.dashboard') }}"
                            class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                            Go to My Account
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        Log In
                    </a>
                    <a href="{{ route('register') }}"
                        class="bg-white border border-blue-600 text-blue-600 px-6 py-3 rounded-lg hover:bg-blue-50 transition-colors font-medium">
                        Sign Up
                    </a>
                @endauth
                <a href="{{ route('home') }}"
                    class="bg-gray-100 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                    Go to Homepage
                </a>
            </div>

            <!-- Help Section -->
            <div class="mt-12 pt-8 border-t border-gray-200">
                <p class="text-gray-600 mb-4">Need help? Contact our support team:</p>
                <div class="space-y-2">
                    <p class="text-gray-700">
                        <strong>Email:</strong> support@marketplace.com
                    </p>
                    <p class="text-gray-700">
                        <strong>Phone:</strong> +880 1234 567890
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
