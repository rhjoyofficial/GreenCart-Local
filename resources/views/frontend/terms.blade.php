@extends('layouts.frontend')

@section('title', 'Terms & Conditions - Marketplace')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Terms & Conditions</h1>
            <p class="text-gray-600">Last updated: {{ date('F d, Y') }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
            <div class="prose max-w-none">
                <!-- Introduction -->
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">1. Introduction</h2>
                    <p class="text-gray-700 mb-4">
                        Welcome to Marketplace. These Terms and Conditions govern your use of our website and services.
                        By accessing or using our platform, you agree to be bound by these terms.
                    </p>
                    <p class="text-gray-700">
                        Please read these terms carefully before using our services. If you do not agree with any part
                        of these terms, you must not use our platform.
                    </p>
                </section>

                <!-- Account Terms -->
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">2. Account Registration</h2>
                    <ul class="list-disc pl-6 text-gray-700 space-y-2">
                        <li>You must be at least 18 years old to create an account</li>
                        <li>You are responsible for maintaining the confidentiality of your account credentials</li>
                        <li>You must provide accurate and complete information during registration</li>
                        <li>You are responsible for all activities that occur under your account</li>
                        <li>We reserve the right to suspend or terminate accounts that violate our policies</li>
                    </ul>
                </section>

                <!-- Buyer Terms -->
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">3. Buying on Marketplace</h2>
                    <p class="text-gray-700 mb-4">
                        When you purchase products on our platform:
                    </p>
                    <ul class="list-disc pl-6 text-gray-700 space-y-2">
                        <li>All prices are in Bangladeshi Taka (TK) and include applicable taxes</li>
                        <li>Orders are processed and shipped by individual sellers</li>
                        <li>Shipping times vary depending on the seller and location</li>
                        <li>Payment is processed securely through our payment gateway</li>
                        <li>You agree to receive order-related communications via email or SMS</li>
                    </ul>
                </section>

                <!-- Seller Terms -->
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">4. Selling on Marketplace</h2>
                    <p class="text-gray-700 mb-4">
                        If you register as a seller, you agree to:
                    </p>
                    <ul class="list-disc pl-6 text-gray-700 space-y-2">
                        <li>Provide accurate product information and images</li>
                        <li>Maintain sufficient stock for listed products</li>
                        <li>Process and ship orders within the specified timeframe</li>
                        <li>Handle customer inquiries and support requests promptly</li>
                        <li>Comply with all applicable laws and regulations</li>
                        <li>Pay applicable commission fees on completed sales</li>
                    </ul>
                </section>

                <!-- Payments & Fees -->
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">5. Payments & Fees</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">5.1 Buyer Fees</h3>
                            <p class="text-gray-700">
                                Buyers pay the listed product price plus any applicable shipping fees.
                                There are no additional hidden charges.
                            </p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">5.2 Seller Fees</h3>
                            <p class="text-gray-700">
                                Sellers pay a commission fee on each completed sale. The commission rate
                                is clearly displayed during seller registration and may vary by product category.
                            </p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">5.3 Payment Processing</h3>
                            <p class="text-gray-700">
                                All payments are processed through secure payment gateways.
                                We never store your complete payment card information.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Returns & Refunds -->
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">6. Returns & Refunds</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">6.1 Return Policy</h3>
                            <p class="text-gray-700">
                                Most products are eligible for return within 30 days of delivery,
                                provided they are in original condition with all tags and packaging.
                            </p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">6.2 Refund Process</h3>
                            <p class="text-gray-700">
                                Refunds are processed within 7-10 business days after we receive the returned item.
                                The refund amount will be credited to your original payment method.
                            </p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">6.3 Non-Returnable Items</h3>
                            <p class="text-gray-700">
                                Certain items such as perishable goods, personalized products,
                                and digital downloads are not eligible for return.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Intellectual Property -->
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">7. Intellectual Property</h2>
                    <p class="text-gray-700 mb-4">
                        All content on our platform, including text, graphics, logos, and software,
                        is the property of Marketplace or its content suppliers and is protected by
                        copyright and intellectual property laws.
                    </p>
                    <p class="text-gray-700">
                        You may not reproduce, distribute, modify, or create derivative works from
                        any content without our express written permission.
                    </p>
                </section>

                <!-- Limitation of Liability -->
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">8. Limitation of Liability</h2>
                    <p class="text-gray-700 mb-4">
                        Marketplace acts as a platform connecting buyers and sellers. We are not
                        responsible for:
                    </p>
                    <ul class="list-disc pl-6 text-gray-700 space-y-2">
                        <li>The quality, safety, or legality of products listed by sellers</li>
                        <li>The accuracy of product descriptions or images provided by sellers</li>
                        <li>The ability of sellers to sell items or buyers to pay for items</li>
                        <li>Any disputes between buyers and sellers</li>
                    </ul>
                </section>

                <!-- Changes to Terms -->
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">9. Changes to Terms</h2>
                    <p class="text-gray-700">
                        We reserve the right to modify these terms at any time. We will notify users
                        of significant changes via email or through platform announcements.
                        Continued use of our services after changes constitutes acceptance of the new terms.
                    </p>
                </section>

                <!-- Contact -->
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">10. Contact Information</h2>
                    <p class="text-gray-700">
                        For questions about these Terms & Conditions, please contact us:
                    </p>
                    <div class="mt-4 space-y-2">
                        <p class="text-gray-700"><strong>Email:</strong> legal@marketplace.com</p>
                        <p class="text-gray-700"><strong>Phone:</strong> +880 1234 567890</p>
                        <p class="text-gray-700"><strong>Address:</strong> Dhaka Commerce Center, Gulshan-1, Dhaka 1212,
                            Bangladesh</p>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
