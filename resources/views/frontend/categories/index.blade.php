@extends('layouts.frontend')

@section('title', 'Product Categories - Marketplace')

@section('content')
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumbs -->
        @php
            $breadcrumbs = [['url' => route('home'), 'label' => 'Home'], ['url' => '#', 'label' => 'Categories']];
        @endphp
        @include('components.breadcrumbs')

        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Product Categories</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Browse products by category. Find exactly what you're looking for from our extensive collection.
            </p>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($categories as $category)
                <a href="{{ route('categories.show', $category->slug) }}"
                    class="group bg-white rounded-xl shadow-sm hover:shadow-lg transition-all overflow-hidden border border-gray-200 hover:border-blue-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div
                                class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4 group-hover:bg-blue-200 transition-colors">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">
                                    {{ $category->name }}
                                </h3>
                                <p class="text-sm text-gray-500 mt-1">{{ $category->products_count ?? 0 }} products</p>
                            </div>
                        </div>
                        @if ($category->description)
                            <p class="mt-4 text-gray-600 text-sm line-clamp-2">{{ $category->description }}</p>
                        @endif
                    </div>
                    <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 group-hover:bg-blue-50 transition-colors">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-blue-600 font-medium">Browse Products</span>
                            <svg class="w-4 h-4 text-blue-600 transform group-hover:translate-x-1 transition-transform"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        @if ($categories->isEmpty())
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No categories found</h3>
                <p class="text-gray-600 mb-4">Categories will appear here once they are added.</p>
            </div>
        @endif
    </div>
@endsection
