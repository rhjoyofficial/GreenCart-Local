@extends('layouts.frontend')

@section('title', 'Page Not Found - Marketplace')

@section('content')
    <div class="min-h-[70vh] flex items-center justify-center">
        <div class="text-center max-w-lg mx-auto px-4">
            <!-- Error Icon -->
            <div class="mb-8">
                <div class="w-32 h-32 bg-red-100 rounded-full flex items-center justify-center mx-auto">
                    <svg class="w-16 h-16 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Error Message -->
            <h1 class="text-4xl font-bold text-gray-900 mb-4">404 - Page Not Found</h1>
            <p class="text-lg text-gray-600 mb-8">
                Oops! The page you're looking for doesn't exist or has been moved.
            </p>

            <!-- Search -->
            <div class="mb-8">
                <div class="relative max-w-md mx-auto">
                    <input type="text" placeholder="Search for products..."
                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                    <svg class="absolute left-4 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ url()->previous() }}"
                    class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    Go Back
                </a>
                <a href="{{ route('home') }}"
                    class="bg-white border border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                    Go to Homepage
                </a>
            </div>

            <!-- Quick Links -->
            <div class="mt-12 pt-8 border-t border-gray-200">
                <p class="text-gray-600 mb-4">Or try one of these pages:</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-700">
                        Products
                    </a>
                    <a href="{{ route('categories.index') }}" class="text-blue-600 hover:text-blue-700">
                        Categories
                    </a>
                    <a href="{{ route('cart.index') }}" class="text-blue-600 hover:text-blue-700">
                        Shopping Cart
                    </a>
                    <a href="{{ route('contact') }}" class="text-blue-600 hover:text-blue-700">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
