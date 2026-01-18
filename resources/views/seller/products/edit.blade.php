@extends('layouts.seller')

@section('title', 'Edit Product: ' . $product->name)
@section('page-title', 'Edit Product')

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Image preview
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('image-preview');

            if (imageInput && imagePreview) {
                imageInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            imagePreview.innerHTML = `
                            <img src="${e.target.result}" alt="Preview" class="w-full h-full object-cover rounded-lg">
                        `;
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }

            // Price formatting
            const priceInput = document.getElementById('price');
            if (priceInput) {
                priceInput.addEventListener('blur', function() {
                    const value = parseFloat(this.value);
                    if (!isNaN(value)) {
                        this.value = value.toFixed(2);
                    }
                });
            }

            // Stock validation
            const stockInput = document.getElementById('stock_quantity');
            if (stockInput) {
                stockInput.addEventListener('input', function() {
                    if (this.value < 0) {
                        this.value = 0;
                    }
                });
            }

            // Delete product confirmation
            const deleteBtn = document.getElementById('delete-product-btn');
            if (deleteBtn) {
                deleteBtn.addEventListener('click', function(e) {
                    if (!confirm(
                            'Are you sure you want to delete this product? This action cannot be undone.'
                            )) {
                        e.preventDefault();
                    }
                });
            }
        });
    </script>
@endpush

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Edit Product</h2>
                <p class="text-gray-600 mt-1">Update product information</p>
            </div>

            <form action="{{ route('seller.products.update', $product) }}" method="POST" enctype="multipart/form-data"
                class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-8">
                    <!-- Basic Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Product Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Product Name *
                                </label>
                                <input type="text" id="name" name="name"
                                    value="{{ old('name', $product->name) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                    placeholder="Enter product name" required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- SKU -->
                            <div>
                                <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">
                                    SKU (Stock Keeping Unit) *
                                </label>
                                <input type="text" id="sku" name="sku" value="{{ old('sku', $product->sku) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                    placeholder="e.g., PROD-001" required>
                                @error('sku')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Category
                                </label>
                                <select id="category_id" name="category_id"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Price -->
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                    Price (TK) *
                                </label>
                                <input type="number" id="price" name="price"
                                    value="{{ old('price', $product->price) }}" step="0.01" min="0"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                    placeholder="0.00" required>
                                @error('price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Product Image -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Product Image</h3>
                        <div class="flex flex-col md:flex-row items-start gap-6">
                            <!-- Current Image -->
                            <div class="md:w-1/3">
                                <p class="text-sm font-medium text-gray-700 mb-2">Current Image</p>
                                <div class="w-full h-48 bg-gray-100 rounded-lg overflow-hidden">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- New Image Upload -->
                            <div class="md:w-2/3">
                                <p class="text-sm font-medium text-gray-700 mb-2">Upload New Image (Optional)</p>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                                    <div id="image-preview" class="mb-4">
                                        <div
                                            class="w-32 h-32 bg-gray-100 rounded-lg flex items-center justify-center mx-auto">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                    <label for="image"
                                        class="cursor-pointer bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors inline-block">
                                        Choose New Image
                                    </label>
                                    <input type="file" id="image" name="image" class="hidden" accept="image/*">
                                    <p class="text-sm text-gray-500 mt-2">JPG, PNG, or GIF (Max: 2MB)</p>
                                </div>
                                @error('image')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Description</h3>
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Product Description *
                            </label>
                            <textarea id="description" name="description" rows="6"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                placeholder="Describe your product in detail..." required>{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Stock & Status -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Stock & Status</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Stock Quantity -->
                            <div>
                                <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-2">
                                    Stock Quantity *
                                </label>
                                <input type="number" id="stock_quantity" name="stock_quantity"
                                    value="{{ old('stock_quantity', $product->stock_quantity) }}" min="0"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                    required>
                                @error('stock_quantity')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Active Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Product Status
                                </label>
                                <div class="flex items-center space-x-4">
                                    <label class="flex items-center">
                                        <input type="radio" name="is_active" value="1"
                                            {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="ml-2 text-gray-700">Active</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="is_active" value="0"
                                            {{ !old('is_active', $product->is_active) ? 'checked' : '' }}
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="ml-2 text-gray-700">Inactive</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Status -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Product Status</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-900">Approval Status</p>
                                    <p class="text-sm text-gray-600">Current status:
                                        <span
                                            class="font-medium 
                                        @if ($product->approval_status === 'approved') text-green-600
                                        @elseif($product->approval_status === 'pending') text-yellow-600
                                        @else text-red-600 @endif">
                                            {{ ucfirst($product->approval_status) }}
                                        </span>
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-600">Created: {{ $product->created_at->format('M d, Y') }}
                                    </p>
                                    <p class="text-sm text-gray-600">Updated: {{ $product->updated_at->format('M d, Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <div>
                            <form action="{{ route('seller.products.destroy', $product) }}" method="POST"
                                class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" id="delete-product-btn"
                                    class="text-red-600 hover:text-red-700 font-medium">
                                    Delete Product
                                </button>
                            </form>
                        </div>
                        <div class="flex space-x-4">
                            <a href="{{ route('seller.products.index') }}"
                                class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                Cancel
                            </a>
                            <button type="submit"
                                class="bg-blue-600 text-white px-8 py-2 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                Update Product
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
