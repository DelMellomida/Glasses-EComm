@php
$terms = <<<HTML
<h1>Terms of Service</h1>

<p>Effective Date: April 26, 2025</p>

<p>Welcome to our website. By accessing or using our services, you agree to be bound by the following terms and conditions. If you do not agree with any part of these terms, you must not use our site.</p>

<h2>1. Use of Our Services</h2>
<p>You agree to use our services only for lawful purposes and in accordance with these Terms. You must not misuse or interfere with our services or try to access them using a method other than the interface we provide.</p>

<h2>2. User Accounts</h2>
<p>You may be required to create an account to access certain features. You are responsible for maintaining the confidentiality of your account information and for all activities under your account.</p>

<h2>3. Intellectual Property</h2>
<p>All content on this site, including text, graphics, logos, and software, is the property of the site owner and is protected by copyright and other laws. You may not reproduce, distribute, or create derivative works without permission.</p>

<h2>4. Termination</h2>
<p>We reserve the right to suspend or terminate your access to the site at any time, without notice, for conduct that we believe violates these Terms or is harmful to other users or us.</p>

<h2>5. Disclaimer</h2>
<p>Our website and services are provided "as is" without warranties of any kind. We do not guarantee that the site will be error-free or uninterrupted.</p>

<h2>6. Limitation of Liability</h2>
<p>We shall not be liable for any damages arising out of your use or inability to use the site, including but not limited to direct, indirect, incidental, or consequential damages.</p>

<h2>7. Changes to These Terms</h2>
<p>We may update these Terms from time to time. Any changes will be posted on this page. Your continued use of the site constitutes acceptance of the revised terms.</p>

<p>If you have any questions, please contact us at: <strong>support@example.com</strong></p>
HTML;
@endphp


<x-guest-layout>
    <div class="pt-4 bg-gray-100">
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                @if (auth()->user())
                    <x-nav-user></x-nav-user>
                @else
                    <x-nav-guest></x-nav-guest>
                @endif
            <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                {!! $terms !!}
            </div>
        </div>
    </div>
</x-guest-layout>
