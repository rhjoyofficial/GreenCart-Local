@extends('layouts.frontend')

@section('title', 'Privacy Policy - Marketplace')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Privacy Policy</h1>
            <p class="text-gray-600">Last updated: {{ date('F d, Y') }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
            <div class="prose max-w-none">
                <!-- Introduction -->
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">1. Introduction</h2>
                    <p class="text-gray-700 mb-4">
                        At Marketplace, we are committed to protecting your privacy. This Privacy Policy explains how we
                        collect, use, disclose, and safeguard your information when you use our platform.
                    </p>
                    <p class="text-gray-700">
                        Please read this privacy policy carefully. If you do not agree with the terms of this privacy
                        policy, please do not access the platform.
                    </p>
                </section>

                <!-- Information We Collect -->
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">2. Information We Collect</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">2.1 Personal Information</h3>
                            <p class="text-gray-700">
                                We collect personal information that you voluntarily provide to us when you:
                            </p>
                            <ul class="list-disc pl-6 text-gray-700 space-y-1 mt-2">
                                <li>Register for an account</li>
                                <li>Make a purchase</li>
                                <li>Subscribe to our newsletter</li>
                                <li>Contact our customer support</li>
                                <li>Participate in surveys or promotions</li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">2.2 Automatically Collected Information
                            </h3>
                            <p class="text-gray-700">
                                When you use our platform, we automatically collect certain information including:
                            </p>
                            <ul class="list-disc pl-6 text-gray-700 space-y-1 mt-2">
                                <li>IP address and device information</li>
                                <li>Browser type and version</li>
                                <li>Pages you visit and time spent on pages</li>
                                <li>Referring/exit pages</li>
                                <li>Clickstream data</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- How We Use Your Information -->
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">3. How We Use Your Information</h2>
                    <p class="text-gray-700 mb-4">
                        We use the information we collect for various purposes:
                    </p>
                    <ul class="list-disc pl-6 text-gray-700 space-y-2">
                        <li>To create and manage your account</li>
                        <li>To process your orders and payments</li>
                        <li>To communicate with you about your orders and account</li>
                        <li>To send you marketing communications (with your consent)</li>
                        <li>To improve our platform and services</li>
                        <li>To prevent fraud and enhance security</li>
                        <li>To comply with legal obligations</li>
                    </ul>
                </section>

                <!-- Information Sharing -->
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">4. Information Sharing</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">4.1 With Sellers</h3>
                            <p class="text-gray-700">
                                When you purchase from a seller, we share necessary information (name, shipping address,
                                contact details) to fulfill your order.
                            </p>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">4.2 Service Providers</h3>
                            <p class="text-gray-700">
                                We may share information with third-party service providers who perform services on our
                                behalf, such as payment processing, shipping, and marketing.
                            </p>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">4.3 Legal Requirements</h3>
                            <p class="text-gray-700">
                                We may disclose your information if required by law or in response to valid requests by
                                public authorities.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Data Security -->
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">5. Data Security</h2>
                    <p class="text-gray-700 mb-4">
                        We implement appropriate technical and organizational security measures to protect your personal
                        information against unauthorized access, alteration, disclosure, or destruction.
                    </p>
                    <p class="text-gray-700">
                        However, no method of transmission over the Internet or electronic storage is 100% secure. While we
                        strive to use commercially acceptable means to protect your personal information, we cannot
                        guarantee its absolute security.
                    </p>
                </section>

                <!-- Your Rights -->
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">6. Your Rights</h2>
                    <p class="text-gray-700 mb-4">
                        Depending on your location, you may have the following rights regarding your personal information:
                    </p>
                    <ul class="list-disc pl-6 text-gray-700 space-y-2">
                        <li><strong>Access:</strong> Request access to your personal information</li>
                        <li><strong>Correction:</strong> Request correction of inaccurate information</li>
                        <li><strong>Deletion:</strong> Request deletion of your personal information</li>
                        <li><strong>Objection:</strong> Object to processing of your personal information</li>
                        <li><strong>Portability:</strong> Request transfer of your data to another service</li>
                        <li><strong>Withdraw Consent:</strong> Withdraw consent at any time</li>
                    </ul>
                    <p class="text-gray-700 mt-4">
                        To exercise these rights, please contact us using the information provided below.
                    </p>
                </section>

                <!-- Cookies -->
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">7. Cookies and Tracking Technologies</h2>
                    <p class="text-gray-700 mb-4">
                        We use cookies and similar tracking technologies to track activity on our platform and store certain
                        information. Cookies are files with a small amount of data that may include an anonymous unique
                        identifier.
                    </p>
                    <p class="text-gray-700">
                        You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent.
                        However, if you do not accept cookies, you may not be able to use some portions of our platform.
                    </p>
                </section>

                <!-- Children's Privacy -->
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">8. Children's Privacy</h2>
                    <p class="text-gray-700">
                        Our platform is not intended for children under 18 years of age. We do not knowingly collect
                        personal information from children under 18. If you are a parent or guardian and believe your child
                        has provided us with personal information, please contact us.
                    </p>
                </section>

                <!-- Changes to Policy -->
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">9. Changes to This Privacy Policy</h2>
                    <p class="text-gray-700">
                        We may update our Privacy Policy from time to time. We will notify you of any changes by posting the
                        new Privacy Policy on this page and updating the "Last updated" date.
                    </p>
                </section>

                <!-- Contact Us -->
                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">10. Contact Us</h2>
                    <p class="text-gray-700 mb-2">
                        If you have any questions about this Privacy Policy, please contact us:
                    </p>
                    <div class="mt-4 space-y-2">
                        <p class="text-gray-700"><strong>Email:</strong> privacy@marketplace.com</p>
                        <p class="text-gray-700"><strong>Phone:</strong> +880 1234 567890</p>
                        <p class="text-gray-700"><strong>Address:</strong> Dhaka Commerce Center, Gulshan-1, Dhaka 1212,
                            Bangladesh</p>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
