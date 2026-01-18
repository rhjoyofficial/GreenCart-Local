@extends('layouts.frontend')

@section('title', 'Frequently Asked Questions - Marketplace')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h1>
            <p class="text-xl text-gray-600">Find answers to common questions about shopping on Marketplace</p>
        </div>

        <!-- Search FAQ -->
        <div class="mb-12">
            <div class="relative max-w-2xl mx-auto">
                <input type="text" placeholder="Search for answers..."
                    class="w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                <svg class="absolute left-4 top-4 w-6 h-6 text-gray-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>

        <!-- FAQ Categories -->
        <div class="mb-12">
            <div class="flex flex-wrap justify-center gap-4">
                <button class="px-6 py-2 bg-blue-600 text-white rounded-lg font-medium">
                    All Questions
                </button>
                <button class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    Shopping
                </button>
                <button class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    Orders
                </button>
                <button class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    Payments
                </button>
                <button class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    Shipping
                </button>
                <button class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    Returns
                </button>
            </div>
        </div>

        <!-- FAQ Accordion -->
        <div class="space-y-4">
            <!-- Shopping Questions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">Shopping Questions</h2>
                </div>
                <div class="divide-y divide-gray-200">
                    <!-- FAQ Item 1 -->
                    <div class="faq-item">
                        <button
                            class="faq-question w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50">
                            <span class="font-medium text-gray-900">How do I create an account?</span>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div class="faq-answer px-6 py-4 hidden">
                            <p class="text-gray-700">
                                Click on the "Sign Up" button in the top right corner of the website.
                                Fill in your details including name, email address, and create a password.
                                Verify your email address by clicking the link we send you, and your account will be ready
                                to use.
                            </p>
                        </div>
                    </div>

                    <!-- FAQ Item 2 -->
                    <div class="faq-item">
                        <button
                            class="faq-question w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50">
                            <span class="font-medium text-gray-900">How do I search for products?</span>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div class="faq-answer px-6 py-4 hidden">
                            <p class="text-gray-700">
                                Use the search bar at the top of any page to search for products by name, brand, or
                                keywords.
                                You can also browse products by category using the main navigation menu.
                                Use filters to narrow down search results by price range, category, or seller rating.
                            </p>
                        </div>
                    </div>

                    <!-- FAQ Item 3 -->
                    <div class="faq-item">
                        <button
                            class="faq-question w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50">
                            <span class="font-medium text-gray-900">How do I save items to my wishlist?</span>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div class="faq-answer px-6 py-4 hidden">
                            <p class="text-gray-700">
                                Click the heart icon on any product page or product listing to add it to your wishlist.
                                You must be logged in to save items to your wishlist.
                                Access your wishlist by clicking the heart icon in the top navigation or from your account
                                dashboard.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Questions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">Order Questions</h2>
                </div>
                <div class="divide-y divide-gray-200">
                    <!-- FAQ Item 4 -->
                    <div class="faq-item">
                        <button
                            class="faq-question w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50">
                            <span class="font-medium text-gray-900">How do I place an order?</span>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div class="faq-answer px-6 py-4 hidden">
                            <p class="text-gray-700">
                                1. Add items to your cart by clicking "Add to Cart" on product pages<br>
                                2. Go to your shopping cart to review items<br>
                                3. Click "Proceed to Checkout"<br>
                                4. Enter your shipping address and contact information<br>
                                5. Choose a payment method and complete the payment<br>
                                6. You'll receive an order confirmation email with your order details
                            </p>
                        </div>
                    </div>

                    <!-- FAQ Item 5 -->
                    <div class="faq-item">
                        <button
                            class="faq-question w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50">
                            <span class="font-medium text-gray-900">How can I track my order?</span>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div class="faq-answer px-6 py-4 hidden">
                            <p class="text-gray-700">
                                Log in to your account and go to "My Orders" section.
                                Click on the order you want to track.
                                You'll see the current order status and tracking information if available.
                                You can also track orders using the tracking link sent to your email.
                            </p>
                        </div>
                    </div>

                    <!-- FAQ Item 6 -->
                    <div class="faq-item">
                        <button
                            class="faq-question w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50">
                            <span class="font-medium text-gray-900">Can I modify or cancel my order?</span>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div class="faq-answer px-6 py-4 hidden">
                            <p class="text-gray-700">
                                You can cancel orders that are still in "Pending" or "Processing" status.
                                Go to "My Orders", select the order you want to cancel, and click "Cancel Order".
                                Once an order starts processing or shipping, it cannot be cancelled.
                                For modifications, please contact customer support immediately after placing your order.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Questions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">Payment Questions</h2>
                </div>
                <div class="divide-y divide-gray-200">
                    <!-- FAQ Item 7 -->
                    <div class="faq-item">
                        <button
                            class="faq-question w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50">
                            <span class="font-medium text-gray-900">What payment methods do you accept?</span>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div class="faq-answer px-6 py-4 hidden">
                            <p class="text-gray-700">
                                We accept multiple payment methods:<br>
                                • Credit/Debit Cards (Visa, MasterCard, American Express)<br>
                                • Mobile Banking (bKash, Nagad, Rocket)<br>
                                • Cash on Delivery (available in selected areas)<br>
                                • Bank Transfer<br>
                                All payments are processed securely through encrypted channels.
                            </p>
                        </div>
                    </div>

                    <!-- FAQ Item 8 -->
                    <div class="faq-item">
                        <button
                            class="faq-question w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50">
                            <span class="font-medium text-gray-900">Is it safe to pay online?</span>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div class="faq-answer px-6 py-4 hidden">
                            <p class="text-gray-700">
                                Yes, all online payments are processed through secure payment gateways with SSL encryption.
                                We never store your complete credit card information.
                                Look for the padlock icon in your browser address bar and "https://" in the URL to ensure
                                you're on a secure connection.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Still Have Questions -->
        <div class="mt-12 bg-blue-50 border border-blue-200 rounded-2xl p-8 text-center">
            <h3 class="text-2xl font-bold text-blue-900 mb-4">Still have questions?</h3>
            <p class="text-blue-700 mb-6">Can't find the answer you're looking for? Our support team is here to help.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact') }}"
                    class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    Contact Support
                </a>
                <a href="tel:+8801234567890"
                    class="bg-white border border-blue-600 text-blue-600 px-8 py-3 rounded-lg hover:bg-blue-50 transition-colors font-medium">
                    Call Now: +880 1234 567890
                </a>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // FAQ Accordion
                document.querySelectorAll('.faq-question').forEach(button => {
                    button.addEventListener('click', function() {
                        const answer = this.nextElementSibling;
                        const icon = this.querySelector('svg');

                        // Toggle answer
                        answer.classList.toggle('hidden');

                        // Rotate icon
                        icon.classList.toggle('rotate-180');

                        // Close other open FAQs
                        document.querySelectorAll('.faq-question').forEach(otherButton => {
                            if (otherButton !== this) {
                                const otherAnswer = otherButton.nextElementSibling;
                                const otherIcon = otherButton.querySelector('svg');
                                otherAnswer.classList.add('hidden');
                                otherIcon.classList.remove('rotate-180');
                            }
                        });
                    });
                });
            });
        </script>
    @endpush

    <style>
        .faq-question:hover {
            background-color: #f9fafb;
        }

        .faq-answer {
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
        }
    </style>
@endsection
