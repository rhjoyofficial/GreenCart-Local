@extends('layouts.guest')

@section('title', 'Register')

@section('content')
    <div class="space-y-6">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-gray-900">Join GreenCart</h2>
            <p class="mt-2 text-sm text-gray-600">Your local organic marketplace</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <p class="text-red-800">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-5" id="registerForm">
            @csrf

            <!-- Role Selection -->
            @if (request('role'))
                <input type="hidden" name="role" value="{{ request('role') }}">
                <div class="p-3 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-green-500 mr-3"></i>
                        <span class="text-green-800">
                            Registering as <span class="font-semibold">{{ ucfirst(request('role')) }}</span>
                        </span>
                    </div>
                </div>
            @else
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">I want to join as:</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label
                            class="relative flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                            <input type="radio" name="role" value="customer" class="sr-only" checked>
                            <div class="flex items-center">
                                <i class="fas fa-user text-green-600 mr-3"></i>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Customer</p>
                                    <p class="text-xs text-gray-500">Browse & buy products</p>
                                </div>
                            </div>
                        </label>
                        <label
                            class="relative flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                            <input type="radio" name="role" value="seller" class="sr-only">
                            <div class="flex items-center">
                                <i class="fas fa-store text-green-600 mr-3"></i>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Seller</p>
                                    <p class="text-xs text-gray-500">Sell your products</p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            @endif

            <div>
                <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                <input type="text" name="name" id="full_name" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                    placeholder="Enter your full name" value="{{ old('full_name') }}">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                <input type="email" name="email" id="email" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                    placeholder="Enter your email" value="{{ old('email') }}">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password *</label>
                    <input type="password" name="password" id="password" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                        placeholder="Create password">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password
                        *</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                        placeholder="Confirm password">
                </div>
            </div>

            <!-- Additional fields for sellers -->
            <div id="seller_fields" class="grid grid-cols-2 gap-4 hidden">
                <div>
                    <label for="business_name" class="block text-sm font-medium text-gray-700 mb-1">Business Name *</label>
                    <input type="text" name="business_name" id="business_name"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition seller-required"
                        placeholder="Your business name" value="{{ old('business_name') }}">
                    <p class="mt-1 text-xs text-gray-500">This will be displayed to customers</p>
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number *</label>
                    <input type="tel" name="phone" id="phone"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition seller-required"
                        placeholder="Business phone number" value="{{ old('phone') }}">
                    <p class="mt-1 text-xs text-gray-500">For order notifications and customer contact</p>
                </div>
            </div>

            <div class="flex items-start">
                <input type="checkbox" name="terms" id="terms" required
                    class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded mt-1">
                <label for="terms" class="ml-2 block text-sm text-gray-700">
                    I agree to the <a href="/terms" class="text-green-600 hover:text-green-500">Terms of Service</a> and <a
                        href="/privacy" class="text-green-600 hover:text-green-500">Privacy Policy</a>
                </label>
            </div>

            <button type="submit"
                class="w-full bg-green-600 text-white py-2.5 px-4 rounded-lg font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
                Create Account
            </button>
        </form>

        <div class="text-center">
            <p class="text-sm text-gray-600">
                Already have an account?
                <a href="{{ route('login') }}" class="font-medium text-green-600 hover:text-green-500">
                    Sign in
                </a>
            </p>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleRadios = document.querySelectorAll('input[name="role"]');
            const sellerFields = document.getElementById('seller_fields');
            const registerForm = document.getElementById('registerForm');
            const businessNameInput = document.getElementById('business_name');
            const phoneInput = document.getElementById('phone');
            const hiddenRoleInput = document.querySelector('input[name="role"][type="hidden"]');

            // Check if role is coming from URL parameter (hidden input)
            const hasRoleFromURL = hiddenRoleInput !== null;
            const roleFromURL = hasRoleFromURL ? hiddenRoleInput.value : null;
            // console.log('Role from URL:', roleFromURL);
            // console.log('Role from URL:', hasRoleFromURL);

            function toggleSellerFields() {
                let selectedRole;

                if (hasRoleFromURL) {
                    // Role is from URL parameter (hidden input)
                    selectedRole = roleFromURL;
                    // console.log('Selected Role from URL:', selectedRole);
                } else {
                    // Role is from radio button selection
                    const checkedRadio = document.querySelector('input[name="role"]:checked');
                    selectedRole = checkedRadio ? checkedRadio.value : 'customer'; // Default to customer
                    // console.log('Selected Role from Radio:', selectedRole);
                }

                if (selectedRole === 'seller') { // Seller role
                    sellerFields.classList.remove('hidden');
                    // Make fields required for sellers
                    businessNameInput.setAttribute('required', 'required');
                    phoneInput.setAttribute('required', 'required');
                } else { // Customer role
                    sellerFields.classList.add('hidden');
                    // Remove required attribute for customers
                    businessNameInput.removeAttribute('required');
                    phoneInput.removeAttribute('required');
                    businessNameInput.value = ''; // Clear business name
                    phoneInput.value = ''; // Clear phone number
                }
            }

            // Form validation
            registerForm.addEventListener('submit', function(e) {
                let selectedRole;

                if (hasRoleFromURL) {
                    // Role is from URL parameter
                    selectedRole = roleFromURL;
                } else {
                    // Role is from radio button
                    const checkedRadio = document.querySelector('input[name="role"]:checked');
                    selectedRole = checkedRadio ? checkedRadio.value : 'customer';
                }

                if (selectedRole === 'seller') { // Seller
                    // Validate seller fields
                    if (!businessNameInput.value.trim()) {
                        e.preventDefault();
                        alert('Business name is required for sellers');
                        businessNameInput.focus();
                        return;
                    }

                    if (!phoneInput.value.trim()) {
                        e.preventDefault();
                        alert('Phone number is required for sellers');
                        phoneInput.focus();
                        return;
                    }

                    // Validate phone format (basic validation for Bangladesh)
                    const phoneRegex = /^(\+88)?01[3-9]\d{8}$/;
                    const phoneValue = phoneInput.value.trim();

                    if (!phoneRegex.test(phoneValue)) {
                        e.preventDefault();
                        alert(
                            'Please enter a valid Bangladeshi phone number (e.g., +8801712345678 or 01712345678)'
                        );
                        phoneInput.focus();
                        return;
                    }
                }
            });

            // If role is from URL parameter, we don't need radio button listeners
            if (!hasRoleFromURL) {
                // Toggle seller fields when role changes (only for radio buttons)
                roleRadios.forEach(radio => {
                    radio.addEventListener('change', toggleSellerFields);
                });
            }

            // Initial check on page load
            toggleSellerFields();
        });
    </script>
@endpush
