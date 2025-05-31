@php
$policy = <<<HTML
<h1 class="text-3xl font-extrabold mb-4">Privacy Policy</h1>
<p class="text-gray-600 mb-6">Effective Date: April 26, 2025</p>
<p>Welcome to our website. Your privacy is important to us. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our site.</p>
<h2>Information We Collect</h2>
<ul>
    <li><strong>Personal Data:</strong> Name, email address, and other contact details you voluntarily provide.</li>
    <li><strong>Usage Data:</strong> Pages visited, time spent, browser type, and IP address collected automatically.</li>
</ul>
<h2>How We Use Your Information</h2>
<ul>
    <li>To provide and maintain our service</li>
    <li>To notify you about changes to our website</li>
    <li>To respond to customer support requests</li>
</ul>
<h2>Sharing Your Information</h2>
<p>We do not sell, trade, or rent your personal information to others. We may share information with service providers who help us operate our website.</p>
<h2>Security</h2>
<p>We implement appropriate security measures to protect your personal information from unauthorized access.</p>
<h2>Your Rights</h2>
<p>You have the right to access, update, or delete your personal information. Contact us for assistance.</p>
<h2>Changes to This Policy</h2>
<p>We may update our Privacy Policy from time to time. We encourage you to review this page periodically for any changes.</p>
<p>If you have questions, contact us at: <strong>support@example.com</strong></p>
HTML;
@endphp

<x-guest-layout>
    <div class="min-h-screen bg-gray-100 flex flex-col">
        <!-- Navigation -->
        <div class="w-full">
            @if (auth()->user())
                <x-nav-user />
            @else
                <x-nav-guest />
            @endif
        </div>
        <!-- Main Content -->
        <div class="flex flex-1 justify-center items-start py-12 px-4 sm:px-8">
            <div class="w-full max-w-3xl bg-white shadow-lg rounded-2xl p-8 sm:p-12 prose prose-blue">
                {!! $policy !!}
            </div>
        </div>
    </div>
</x-guest-layout>