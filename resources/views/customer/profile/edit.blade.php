@extends('layouts.customer')

@section('title', 'Profile Settings')
@section('page-title', 'Profile Settings')
@section('page-description', 'Manage your account information and preferences')

@section('content')
    <div class="space-y-6">
        <!-- Profile Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Personal Information</h3>
                <p class="text-gray-600 mt-1">Update your personal details</p>
            </div>

            <form action="{{ route('profile.update') }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Profile Picture -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-4">Profile Picture</label>
                        <div class="flex items-center">
                            <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mr-6">
                                <span class="text-blue-600 font-semibold text-2xl">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                            </div>
                            <div>
                                <input type="file" id="avatar" name="avatar" class="hidden" accept="image/*">
                                <label for="avatar"
                                    class="cursor-pointer bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors inline-block">
                                    Change Photo
                                </label>
                                <p class="text-sm text-gray-500 mt-2">JPG, PNG, or GIF (Max: 2MB)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Basic Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Full Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Full Name *
                            </label>
                            <input type="text" id="name" name="name"
                                value="{{ old('name', auth()->user()->name) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address *
                            </label>
                            <input type="email" id="email" name="email"
                                value="{{ old('email', auth()->user()->email) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Phone Number
                            </label>
                            <input type="tel" id="phone" name="phone"
                                value="{{ old('phone', auth()->user()->phone) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">
                                Date of Birth
                            </label>
                            <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Address Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Address Line 1 -->
                            <div>
                                <label for="address_line1" class="block text-sm font-medium text-gray-700 mb-2">
                                    Address Line 1
                                </label>
                                <input type="text" id="address_line1" name="address_line1"
                                    value="{{ old('address_line1', auth()->user()->address_line1) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                            </div>

                            <!-- Address Line 2 -->
                            <div>
                                <label for="address_line2" class="block text-sm font-medium text-gray-700 mb-2">
                                    Address Line 2
                                </label>
                                <input type="text" id="address_line2" name="address_line2"
                                    value="{{ old('address_line2', auth()->user()->address_line2) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                            </div>

                            <!-- City -->
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                                    City
                                </label>
                                <input type="text" id="city" name="city"
                                    value="{{ old('city', auth()->user()->city) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                            </div>

                            <!-- State -->
                            <div>
                                <label for="state" class="block text-sm font-medium text-gray-700 mb-2">
                                    State/Province
                                </label>
                                <input type="text" id="state" name="state"
                                    value="{{ old('state', auth()->user()->state) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                            </div>

                            <!-- Postal Code -->
                            <div>
                                <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">
                                    Postal Code
                                </label>
                                <input type="text" id="postal_code" name="postal_code"
                                    value="{{ old('postal_code', auth()->user()->postal_code) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                            </div>

                            <!-- Country -->
                            <div>
                                <label for="country" class="block text-sm font-medium text-gray-700 mb-2">
                                    Country
                                </label>
                                <select id="country" name="country"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                                    <option value="">Select Country</option>
                                    <option value="Bangladesh"
                                        {{ old('country', auth()->user()->country) == 'Bangladesh' ? 'selected' : '' }}>
                                        Bangladesh</option>
                                    <!-- Add more countries as needed -->
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <div>
                            <a href="{{ route('customer.dashboard') }}"
                                class="text-gray-600 hover:text-gray-900 font-medium">
                                Cancel
                            </a>
                        </div>
                        <div class="flex space-x-4">
                            <button type="reset"
                                class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                Reset
                            </button>
                            <button type="submit"
                                class="bg-blue-600 text-white px-8 py-2 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Password Change -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Change Password</h3>
                <p class="text-gray-600 mt-1">Update your password to keep your account secure</p>
            </div>

            <form action="{{ route('password.update') }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Current Password -->
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                                Current Password *
                            </label>
                            <input type="password" id="current_password" name="current_password"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                required>
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                New Password *
                            </label>
                            <input type="password" id="password" name="password"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                required>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Password Confirmation -->
                    <div class="max-w-md">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirm New Password *
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                            required>
                    </div>

                    <!-- Password Requirements -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-medium text-gray-900 mb-2">Password Requirements</h4>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Minimum 8 characters
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                At least one uppercase letter
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                At least one number
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                At least one special character
                            </li>
                        </ul>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-green-600 text-white px-8 py-2 rounded-lg hover:bg-green-700 transition-colors font-medium">
                            Update Password
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Account Preferences -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Account Preferences</h3>
                <p class="text-gray-600 mt-1">Manage your notification and privacy settings</p>
            </div>

            <form class="p-6">
                <div class="space-y-6">
                    <!-- Notification Settings -->
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-4">Notification Preferences</h4>
                        <div class="space-y-3">
                            <label class="flex items-center justify-between">
                                <div>
                                    <span class="font-medium text-gray-900">Order Updates</span>
                                    <p class="text-sm text-gray-600">Receive updates about your orders</p>
                                </div>
                                <input type="checkbox" checked class="h-5 w-5 text-blue-600 rounded focus:ring-blue-500">
                            </label>
                            <label class="flex items-center justify-between">
                                <div>
                                    <span class="font-medium text-gray-900">Promotional Emails</span>
                                    <p class="text-sm text-gray-600">Receive special offers and promotions</p>
                                </div>
                                <input type="checkbox" checked class="h-5 w-5 text-blue-600 rounded focus:ring-blue-500">
                            </label>
                            <label class="flex items-center justify-between">
                                <div>
                                    <span class="font-medium text-gray-900">Product Recommendations</span>
                                    <p class="text-sm text-gray-600">Personalized product suggestions</p>
                                </div>
                                <input type="checkbox" class="h-5 w-5 text-blue-600 rounded focus:ring-blue-500">
                            </label>
                        </div>
                    </div>

                    <!-- Privacy Settings -->
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-4">Privacy Settings</h4>
                        <div class="space-y-3">
                            <label class="flex items-center justify-between">
                                <div>
                                    <span class="font-medium text-gray-900">Public Profile</span>
                                    <p class="text-sm text-gray-600">Allow others to see your profile</p>
                                </div>
                                <input type="checkbox" class="h-5 w-5 text-blue-600 rounded focus:ring-blue-500">
                            </label>
                            <label class="flex items-center justify-between">
                                <div>
                                    <span class="font-medium text-gray-900">Show Purchase History</span>
                                    <p class="text-sm text-gray-600">Display your purchase history on profile</p>
                                </div>
                                <input type="checkbox" checked class="h-5 w-5 text-blue-600 rounded focus:ring-blue-500">
                            </label>
                        </div>
                    </div>

                    <!-- Save Preferences -->
                    <div class="flex justify-end pt-6 border-t border-gray-200">
                        <button type="submit"
                            class="bg-blue-600 text-white px-8 py-2 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                            Save Preferences
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Danger Zone -->
        <div class="bg-red-50 border border-red-200 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-red-900 mb-4">Danger Zone</h3>
            <p class="text-red-700 mb-6">
                These actions are irreversible. Please proceed with caution.
            </p>

            <div class="space-y-4">
                <!-- Deactivate Account -->
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-red-900">Deactivate Account</p>
                        <p class="text-sm text-red-700">Temporarily disable your account</p>
                    </div>
                    <button
                        class="px-4 py-2 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition-colors">
                        Deactivate
                    </button>
                </div>

                <!-- Delete Account -->
                <div class="flex items-center justify-between pt-4 border-t border-red-200">
                    <div>
                        <p class="font-medium text-red-900">Delete Account</p>
                        <p class="text-sm text-red-700">Permanently delete your account and all data</p>
                    </div>
                    <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors"
                        onclick="return confirm('Are you sure you want to permanently delete your account? This action cannot be undone.')">
                        Delete Account
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
