@extends('layouts.frontend')

@section('title', 'Server Error - Marketplace')

@section('content')
    <div class="min-h-[70vh] flex items-center justify-center">
        <div class="text-center max-w-lg mx-auto px-4">
            <div class="mb-8">
                <div class="w-32 h-32 bg-red-100 rounded-full flex items-center justify-center mx-auto">
                    <svg class="w-16 h-16 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.698-.833-2.464 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z">
                        </path>
                    </svg>
                </div>
            </div>

            <h1 class="text-4xl font-bold text-gray-900 mb-4">500 - Server Error</h1>
            <p class="text-lg text-gray-600 mb-6">
                Something went wrong on our end. We're working to fix the issue.
            </p>
            <p class="text-gray-500 mb-8">
                Please try again later or contact our support team if the problem persists.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('home') }}"
                    class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    Go to Homepage
                </a>
                <a href="{{ url()->previous() }}"
                    class="bg-white border border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                    Go Back
                </a>
                <a href="{{ route('contact') }}"
                    class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition-colors font-medium">
                    Contact Support
                </a>
            </div>
        </div>
    </div>
@endsection
