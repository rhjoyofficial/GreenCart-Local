@extends('layouts.admin')

@section('title', 'System Settings')
@section('page-title', 'System Settings')

@section('content')
    <div class="space-y-6">
        <!-- Tabs -->
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8">
                <button data-tab="general"
                    class="tab-btn py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200
                border-blue-500 text-blue-600">
                    General
                </button>
                <button data-tab="payment"
                    class="tab-btn py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200
                border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Payment
                </button>
                <button data-tab="shipping"
                    class="tab-btn py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200
                border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Shipping
                </button>
                <button data-tab="notifications"
                    class="tab-btn py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200
                border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Notifications
                </button>
                <button data-tab="seo"
                    class="tab-btn py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200
                border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    SEO
                </button>
            </nav>
        </div>

        <!-- General Settings -->
        <div id="general-tab" class="tab-content">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">General Settings</h3>
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="section" value="general">

                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Site Name -->
                            <div>
                                <label for="site_name" class="block text-sm font-medium text-gray-700 mb-2">Site Name
                                    *</label>
                                <input type="text" name="site_name" id="site_name" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                    value="{{ $settings['general']['site_name'] }}">
                            </div>

                            <!-- Site Email -->
                            <div>
                                <label for="site_email" class="block text-sm font-medium text-gray-700 mb-2">Site Email
                                    *</label>
                                <input type="email" name="site_email" id="site_email" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                    value="{{ $settings['general']['site_email'] }}">
                            </div>

                            <!-- Site Phone -->
                            <div>
                                <label for="site_phone" class="block text-sm font-medium text-gray-700 mb-2">Site
                                    Phone</label>
                                <input type="text" name="site_phone" id="site_phone"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                    value="{{ $settings['general']['site_phone'] }}">
                            </div>

                            <!-- Site Currency -->
                            <div>
                                <label for="site_currency" class="block text-sm font-medium text-gray-700 mb-2">Currency
                                    *</label>
                                <select name="site_currency" id="site_currency" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                                    <option value="BDT"
                                        {{ $settings['general']['site_currency'] == 'BDT' ? 'selected' : '' }}>BDT (৳)
                                    </option>
                                    <option value="USD"
                                        {{ $settings['general']['site_currency'] == 'USD' ? 'selected' : '' }}>USD ($)
                                    </option>
                                    <option value="EUR"
                                        {{ $settings['general']['site_currency'] == 'EUR' ? 'selected' : '' }}>EUR (€)
                                    </option>
                                    <option value="GBP"
                                        {{ $settings['general']['site_currency'] == 'GBP' ? 'selected' : '' }}>GBP (£)
                                    </option>
                                </select>
                            </div>

                            <!-- Site Address -->
                            <div class="md:col-span-2">
                                <label for="site_address" class="block text-sm font-medium text-gray-700 mb-2">Site
                                    Address</label>
                                <textarea name="site_address" id="site_address" rows="3"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">{{ $settings['general']['site_address'] }}</textarea>
                            </div>
                        </div>

                        <!-- Maintenance Mode -->
                        <div class="flex items-center">
                            <input type="checkbox" name="maintenance_mode" id="maintenance_mode" value="1"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                {{ $settings['general']['maintenance_mode'] ? 'checked' : '' }}>
                            <label for="maintenance_mode" class="ml-2 text-sm text-gray-700">Enable Maintenance Mode</label>
                        </div>

                        <!-- Save Button -->
                        <div class="pt-6 border-t border-gray-200">
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Save General Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Payment Settings -->
        <div id="payment-tab" class="tab-content hidden">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">Payment Settings</h3>
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="section" value="payment">

                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Default Gateway -->
                            <div>
                                <label for="default_gateway" class="block text-sm font-medium text-gray-700 mb-2">Default
                                    Payment Gateway *</label>
                                <select name="default_gateway" id="default_gateway" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                                    <option value="cash"
                                        {{ $settings['payment']['default_gateway'] == 'cash' ? 'selected' : '' }}>Cash on
                                        Delivery</option>
                                    <option value="sslcommerz"
                                        {{ $settings['payment']['default_gateway'] == 'sslcommerz' ? 'selected' : '' }}>
                                        SSLCommerz</option>
                                    <option value="bkash"
                                        {{ $settings['payment']['default_gateway'] == 'bkash' ? 'selected' : '' }}>bKash
                                    </option>
                                </select>
                            </div>

                            <!-- SSLCommerz Mode -->
                            <div>
                                <label for="sslcommerz_mode" class="block text-sm font-medium text-gray-700 mb-2">SSLCommerz
                                    Mode *</label>
                                <select name="sslcommerz_mode" id="sslcommerz_mode" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                                    <option value="sandbox"
                                        {{ $settings['payment']['sslcommerz_mode'] == 'sandbox' ? 'selected' : '' }}>
                                        Sandbox (Test)</option>
                                    <option value="live"
                                        {{ $settings['payment']['sslcommerz_mode'] == 'live' ? 'selected' : '' }}>Live
                                        (Production)</option>
                                </select>
                            </div>

                            <!-- SSLCommerz Store ID -->
                            <div>
                                <label for="sslcommerz_store_id"
                                    class="block text-sm font-medium text-gray-700 mb-2">SSLCommerz Store ID</label>
                                <input type="text" name="sslcommerz_store_id" id="sslcommerz_store_id"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                    value="{{ $settings['payment']['sslcommerz_store_id'] }}">
                            </div>

                            <!-- SSLCommerz Store Password -->
                            <div>
                                <label for="sslcommerz_store_password"
                                    class="block text-sm font-medium text-gray-700 mb-2">SSLCommerz Store Password</label>
                                <input type="password" name="sslcommerz_store_password" id="sslcommerz_store_password"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                    value="{{ $settings['payment']['sslcommerz_store_password'] }}">
                            </div>

                            <!-- bKash App Key -->
                            <div>
                                <label for="bkash_app_key" class="block text-sm font-medium text-gray-700 mb-2">bKash App
                                    Key</label>
                                <input type="text" name="bkash_app_key" id="bkash_app_key"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                    value="{{ $settings['payment']['bkash_app_key'] }}">
                            </div>

                            <!-- bKash App Secret -->
                            <div>
                                <label for="bkash_app_secret" class="block text-sm font-medium text-gray-700 mb-2">bKash
                                    App Secret</label>
                                <input type="password" name="bkash_app_secret" id="bkash_app_secret"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                    value="{{ $settings['payment']['bkash_app_secret'] }}">
                            </div>
                        </div>

                        <!-- Enable COD -->
                        <div class="flex items-center">
                            <input type="checkbox" name="enable_cod" id="enable_cod" value="1"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                {{ $settings['payment']['enable_cod'] ? 'checked' : '' }}>
                            <label for="enable_cod" class="ml-2 text-sm text-gray-700">Enable Cash on Delivery</label>
                        </div>

                        <!-- Save Button -->
                        <div class="pt-6 border-t border-gray-200">
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Save Payment Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Shipping Settings -->
        <div id="shipping-tab" class="tab-content hidden">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">Shipping Settings</h3>
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="section" value="shipping">

                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Default Shipping Method -->
                            <div>
                                <label for="default_shipping_method"
                                    class="block text-sm font-medium text-gray-700 mb-2">Default Shipping Method *</label>
                                <select name="default_shipping_method" id="default_shipping_method" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                                    <option value="standard"
                                        {{ $settings['shipping']['default_shipping_method'] == 'standard' ? 'selected' : '' }}>
                                        Standard Shipping</option>
                                    <option value="express"
                                        {{ $settings['shipping']['default_shipping_method'] == 'express' ? 'selected' : '' }}>
                                        Express Shipping</option>
                                </select>
                            </div>

                            <!-- Standard Shipping Cost -->
                            <div>
                                <label for="standard_shipping_cost"
                                    class="block text-sm font-medium text-gray-700 mb-2">Standard Shipping Cost (TK)
                                    *</label>
                                <input type="number" name="standard_shipping_cost" id="standard_shipping_cost"
                                    step="0.01" min="0" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                    value="{{ $settings['shipping']['standard_shipping_cost'] }}">
                            </div>

                            <!-- Express Shipping Cost -->
                            <div>
                                <label for="express_shipping_cost"
                                    class="block text-sm font-medium text-gray-700 mb-2">Express Shipping Cost (TK)
                                    *</label>
                                <input type="number" name="express_shipping_cost" id="express_shipping_cost"
                                    step="0.01" min="0" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                    value="{{ $settings['shipping']['express_shipping_cost'] }}">
                            </div>

                            <!-- Free Shipping Threshold -->
                            <div>
                                <label for="free_shipping_threshold"
                                    class="block text-sm font-medium text-gray-700 mb-2">Free Shipping Threshold
                                    (TK)</label>
                                <input type="number" name="free_shipping_threshold" id="free_shipping_threshold"
                                    step="0.01" min="0"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                    value="{{ $settings['shipping']['free_shipping_threshold'] }}">
                            </div>
                        </div>

                        <!-- Enable Tracking -->
                        <div class="flex items-center">
                            <input type="checkbox" name="enable_tracking" id="enable_tracking" value="1"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                {{ $settings['shipping']['enable_tracking'] ? 'checked' : '' }}>
                            <label for="enable_tracking" class="ml-2 text-sm text-gray-700">Enable Order Tracking</label>
                        </div>

                        <!-- Save Button -->
                        <div class="pt-6 border-t border-gray-200">
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Save Shipping Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Notification Settings -->
        <div id="notifications-tab" class="tab-content hidden">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">Notification Settings</h3>
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="section" value="notifications">

                    <div class="space-y-6">
                        <!-- Email Notifications -->
                        <div class="space-y-4">
                            <h4 class="text-md font-medium text-gray-700">Email Notifications</h4>

                            <div class="flex items-center">
                                <input type="checkbox" name="email_order_confirmation" id="email_order_confirmation"
                                    value="1"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                    {{ $settings['notifications']['email_order_confirmation'] ? 'checked' : '' }}>
                                <label for="email_order_confirmation" class="ml-2 text-sm text-gray-700">Order
                                    Confirmation Emails</label>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="email_shipping_update" id="email_shipping_update"
                                    value="1"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                    {{ $settings['notifications']['email_shipping_update'] ? 'checked' : '' }}>
                                <label for="email_shipping_update" class="ml-2 text-sm text-gray-700">Shipping Update
                                    Emails</label>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="email_product_approval" id="email_product_approval"
                                    value="1"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                    {{ $settings['notifications']['email_product_approval'] ? 'checked' : '' }}>
                                <label for="email_product_approval" class="ml-2 text-sm text-gray-700">Product Approval
                                    Emails</label>
                            </div>
                        </div>

                        <!-- SMS Notifications -->
                        <div class="space-y-4">
                            <h4 class="text-md font-medium text-gray-700">SMS Notifications</h4>

                            <div class="flex items-center">
                                <input type="checkbox" name="sms_order_confirmation" id="sms_order_confirmation"
                                    value="1"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                    {{ $settings['notifications']['sms_order_confirmation'] ? 'checked' : '' }}>
                                <label for="sms_order_confirmation" class="ml-2 text-sm text-gray-700">Order Confirmation
                                    SMS</label>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="sms_shipping_update" id="sms_shipping_update"
                                    value="1"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                    {{ $settings['notifications']['sms_shipping_update'] ? 'checked' : '' }}>
                                <label for="sms_shipping_update" class="ml-2 text-sm text-gray-700">Shipping Update
                                    SMS</label>
                            </div>
                        </div>

                        <!-- Admin Email -->
                        <div>
                            <label for="admin_email" class="block text-sm font-medium text-gray-700 mb-2">Admin Email
                                *</label>
                            <input type="email" name="admin_email" id="admin_email" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                value="{{ $settings['notifications']['admin_email'] }}">
                        </div>

                        <!-- Save Button -->
                        <div class="pt-6 border-t border-gray-200">
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Save Notification Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- SEO Settings -->
        <div id="seo-tab" class="tab-content hidden">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">SEO Settings</h3>
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="section" value="seo">

                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Meta Title -->
                            <div class="md:col-span-2">
                                <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-2">Meta Title
                                    *</label>
                                <input type="text" name="meta_title" id="meta_title" required maxlength="60"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                    value="{{ $settings['seo']['meta_title'] }}">
                                <p class="text-xs text-gray-500 mt-1">Recommended: 50-60 characters</p>
                            </div>

                            <!-- Meta Description -->
                            <div class="md:col-span-2">
                                <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">Meta
                                    Description</label>
                                <textarea name="meta_description" id="meta_description" rows="3" maxlength="160"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">{{ $settings['seo']['meta_description'] }}</textarea>
                                <p class="text-xs text-gray-500 mt-1">Recommended: 150-160 characters</p>
                            </div>

                            <!-- Meta Keywords -->
                            <div class="md:col-span-2">
                                <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-2">Meta
                                    Keywords</label>
                                <textarea name="meta_keywords" id="meta_keywords" rows="2"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">{{ $settings['seo']['meta_keywords'] }}</textarea>
                                <p class="text-xs text-gray-500 mt-1">Separate keywords with commas</p>
                            </div>

                            <!-- Google Analytics ID -->
                            <div>
                                <label for="google_analytics_id"
                                    class="block text-sm font-medium text-gray-700 mb-2">Google Analytics ID</label>
                                <input type="text" name="google_analytics_id" id="google_analytics_id"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                    value="{{ $settings['seo']['google_analytics_id'] }}">
                            </div>

                            <!-- Facebook Pixel ID -->
                            <div>
                                <label for="facebook_pixel_id"
                                    class="block text-sm font-medium text-gray-700 mb-2">Facebook Pixel ID</label>
                                <input type="text" name="facebook_pixel_id" id="facebook_pixel_id"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                    value="{{ $settings['seo']['facebook_pixel_id'] }}">
                            </div>
                        </div>

                        <!-- Save Button -->
                        <div class="pt-6 border-t border-gray-200">
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Save SEO Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Tab switching functionality
            document.querySelectorAll('.tab-btn').forEach(button => {
                button.addEventListener('click', () => {
                    // Remove active class from all tabs
                    document.querySelectorAll('.tab-btn').forEach(btn => {
                        btn.classList.remove('border-blue-500', 'text-blue-600');
                        btn.classList.add('border-transparent', 'text-gray-500');
                    });

                    // Hide all tab contents
                    document.querySelectorAll('.tab-content').forEach(content => {
                        content.classList.add('hidden');
                    });

                    // Activate clicked tab
                    button.classList.remove('border-transparent', 'text-gray-500');
                    button.classList.add('border-blue-500', 'text-blue-600');

                    // Show corresponding content
                    const tabId = button.dataset.tab;
                    document.getElementById(`${tabId}-tab`).classList.remove('hidden');
                });
            });
        </script>
    @endpush
@endsection
