@extends('layouts.admin')

@section('title', 'Create Order')
@section('page-title', 'Create Order')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Create New Order</h2>
                <p class="text-sm text-gray-600 mt-1">Manually create an order for a customer</p>
            </div>

            <form action="{{ route('admin.orders.store') }}" method="POST" id="order-form">
                @csrf

                <div class="p-6 space-y-6">
                    <!-- Customer Selection -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Customer Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Customer -->
                            <div>
                                <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-2">Select
                                    Customer *</label>
                                <select name="customer_id" id="customer_id" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                                    <option value="">Choose a customer</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">
                                            {{ $customer->name }} - {{ $customer->email }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Shipping Address -->
                            <div>
                                <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-2">Shipping
                                    Address *</label>
                                <textarea name="shipping_address" id="shipping_address" rows="3" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                    placeholder="Enter shipping address"></textarea>
                            </div>

                            <!-- Billing Address -->
                            <div>
                                <label for="billing_address" class="block text-sm font-medium text-gray-700 mb-2">Billing
                                    Address</label>
                                <textarea name="billing_address" id="billing_address" rows="3"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                    placeholder="Enter billing address (optional)"></textarea>
                            </div>

                            <!-- Notes -->
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Order
                                    Notes</label>
                                <textarea name="notes" id="notes" rows="2"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                    placeholder="Any special instructions or notes"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Order Items</h3>
                            <button type="button" id="add-item"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                                Add Item
                            </button>
                        </div>

                        <!-- Items Container -->
                        <div id="items-container" class="space-y-4">
                            <!-- Initial item row -->
                            <div
                                class="item-row grid grid-cols-1 md:grid-cols-12 gap-4 p-4 bg-white rounded-lg border border-gray-200">
                                <!-- Product Selection -->
                                <div class="md:col-span-5">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Product *</label>
                                    <select name="items[0][product_id]" required
                                        class="product-select w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                                        <option value="">Select Product</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                                                data-seller="{{ $product->seller_id }}"
                                                data-stock="{{ $product->stock_quantity }}">
                                                {{ $product->name }} - TK{{ number_format($product->price, 2) }} (Stock:
                                                {{ $product->stock_quantity }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Seller (auto-filled from product) -->
                                <div class="md:col-span-3">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Seller *</label>
                                    <select name="items[0][seller_id]" required
                                        class="seller-select w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                                        <option value="">Select Seller</option>
                                        @foreach ($sellers as $seller)
                                            <option value="{{ $seller->id }}">
                                                {{ $seller->business_name ?? $seller->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Quantity -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Quantity *</label>
                                    <input type="number" name="items[0][quantity]" min="1" value="1" required
                                        class="quantity-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                                    <div class="stock-info text-xs text-gray-500 mt-1"></div>
                                </div>

                                <!-- Price & Total -->
                                <div class="md:col-span-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Price</label>
                                    <div class="price-display px-4 py-2 bg-gray-50 rounded-lg text-gray-900">TK0.00</div>
                                    <input type="hidden" class="unit-price" value="0">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Total</label>
                                    <div class="total-display px-4 py-2 bg-gray-100 rounded-lg font-medium text-gray-900">
                                        TK0.00</div>
                                </div>

                                <!-- Remove Button -->
                                <div class="md:col-span-12 flex justify-end md:col-span-1 md:justify-center">
                                    <button type="button"
                                        class="remove-item mt-6 md:mt-0 p-2 text-red-600 hover:text-red-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="text-gray-600">Total Items:</span>
                                    <span id="total-items" class="ml-2 font-medium">1</span>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-gray-900" id="order-total">TK0.00</div>
                                    <div class="text-sm text-gray-600">Total Amount</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Payment Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Payment Method -->
                            <div>
                                <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">Payment
                                    Method *</label>
                                <select name="payment_method" id="payment_method" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                                    <option value="">Select Method</option>
                                    <option value="Cash on Delivery">Cash on Delivery</option>
                                    <option value="Credit Card">Credit Card</option>
                                    <option value="bKash">bKash</option>
                                    <option value="Nagad">Nagad</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                </select>
                            </div>

                            <!-- Payment Status -->
                            <div>
                                <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-2">Payment
                                    Status *</label>
                                <select name="payment_status" id="payment_status" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                                    <option value="pending">Pending</option>
                                    <option value="paid">Paid</option>
                                    <option value="failed">Failed</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.orders.index') }}"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Create Order
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let itemCount = 0;

        // Add item row
        document.getElementById('add-item').addEventListener('click', function() {
            itemCount++;
            const container = document.getElementById('items-container');
            const template = document.querySelector('.item-row').cloneNode(true);

            // Update indices
            template.querySelectorAll('[name]').forEach(input => {
                const name = input.getAttribute('name').replace('[0]', `[${itemCount}]`);
                input.setAttribute('name', name);
            });

            // Reset values
            template.querySelector('.product-select').value = '';
            template.querySelector('.seller-select').value = '';
            template.querySelector('.quantity-input').value = 1;
            template.querySelector('.price-display').textContent = 'TK0.00';
            template.querySelector('.unit-price').value = 0;
            template.querySelector('.total-display').textContent = 'TK0.00';
            template.querySelector('.stock-info').textContent = '';

            container.appendChild(template);
            updateOrderSummary();
        });

        // Remove item row
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-item')) {
                const row = e.target.closest('.item-row');
                if (document.querySelectorAll('.item-row').length > 1) {
                    row.remove();
                    updateOrderSummary();
                }
            }
        });

        // Update seller when product changes
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('product-select')) {
                const row = e.target.closest('.item-row');
                const selectedOption = e.target.options[e.target.selectedIndex];
                const sellerId = selectedOption.getAttribute('data-seller');
                const price = selectedOption.getAttribute('data-price');
                const stock = selectedOption.getAttribute('data-stock');

                // Set seller
                const sellerSelect = row.querySelector('.seller-select');
                sellerSelect.value = sellerId;

                // Set price
                row.querySelector('.price-display').textContent = 'TK' + parseFloat(price).toFixed(2);
                row.querySelector('.unit-price').value = price;

                // Update stock info
                const stockInfo = row.querySelector('.stock-info');
                stockInfo.textContent = 'Stock: ' + stock;

                // Update quantity max
                const quantityInput = row.querySelector('.quantity-input');
                quantityInput.setAttribute('max', stock);

                // Recalculate total for this row
                calculateRowTotal(row);
                updateOrderSummary();
            }
        });

        // Update total when quantity changes
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('quantity-input')) {
                const row = e.target.closest('.item-row');
                calculateRowTotal(row);
                updateOrderSummary();
            }
        });

        // Calculate total for a single row
        function calculateRowTotal(row) {
            const quantity = parseInt(row.querySelector('.quantity-input').value) || 0;
            const unitPrice = parseFloat(row.querySelector('.unit-price').value) || 0;
            const total = quantity * unitPrice;
            row.querySelector('.total-display').textContent = 'TK' + total.toFixed(2);
        }

        // Update order summary
        function updateOrderSummary() {
            const items = document.querySelectorAll('.item-row');
            let totalItems = 0;
            let orderTotal = 0;

            items.forEach(row => {
                const quantity = parseInt(row.querySelector('.quantity-input').value) || 0;
                const unitPrice = parseFloat(row.querySelector('.unit-price').value) || 0;
                totalItems += quantity;
                orderTotal += quantity * unitPrice;
            });

            document.getElementById('total-items').textContent = totalItems;
            document.getElementById('order-total').textContent = 'TK' + orderTotal.toFixed(2);
        }

        // Form validation
        document.getElementById('order-form').addEventListener('submit', function(e) {
            let valid = true;
            const errorMessages = [];

            // Check customer
            if (!document.getElementById('customer_id').value) {
                errorMessages.push('Please select a customer');
                valid = false;
            }

            // Check items
            const items = document.querySelectorAll('.item-row');
            items.forEach((row, index) => {
                const productSelect = row.querySelector('.product-select');
                const quantityInput = row.querySelector('.quantity-input');
                const sellerSelect = row.querySelector('.seller-select');

                if (!productSelect.value) {
                    errorMessages.push(`Item ${index + 1}: Please select a product`);
                    valid = false;
                }

                if (!sellerSelect.value) {
                    errorMessages.push(`Item ${index + 1}: Please select a seller`);
                    valid = false;
                }

                if (!quantityInput.value || parseInt(quantityInput.value) < 1) {
                    errorMessages.push(`Item ${index + 1}: Please enter a valid quantity`);
                    valid = false;
                }
            });

            if (!valid) {
                e.preventDefault();
                alert('Please fix the following errors:\n\n' + errorMessages.join('\n'));
            }
        });

        // Initialize first row
        updateOrderSummary();
    </script>
@endpush
