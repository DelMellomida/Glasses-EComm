{{-- Payment Form Blade Component --}}
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-12 lg:py-16 mt-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        <!-- Page Header -->
        <!-- <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl mb-6 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                    <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                </svg>
            </div>
            <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">Secure Payment</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Choose your preferred payment method and complete your transaction securely</p>
        </div> -->

        <!-- Main Payment Container -->
        <div class="grid lg:grid-cols-3 gap-8 lg:gap-12">
            <!-- Payment Methods Section -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                    <!-- Section Header -->
                    <div class="bg-gradient-to-r from-gray-900 to-gray-800 px-8 py-6">
                        <h2 class="text-2xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Payment Methods
                        </h2>
                        <p class="text-gray-300 mt-2">Select your preferred payment option below</p>
                    </div>

                    <!-- Form Content -->
                    <div class="p-8 lg:p-10">
                        <form method="POST" action="{{ route('payment.process') }}" id="paymentForm" class="space-y-8">
                            @csrf

                            @foreach($selectedCartItems as $item)
                                <input type="hidden" name="cart_items[{{ $item['id'] }}]" value="{{ $item['quantity'] }}">
                            @endforeach

                            <!-- Payment Options Grid -->
                            <div class="grid gap-6">
                                <!-- Credit Card Option -->
                                <div class="payment-option group border-2 border-gray-200 rounded-2xl p-6 cursor-pointer transition-all duration-300 hover:border-blue-400 hover:shadow-lg hover:bg-gradient-to-r hover:from-blue-50 hover:to-transparent" data-method="credit_card">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="radio" name="payment_method" value="credit_card" required class="sr-only payment-radio">
                                        <div class="flex items-center w-full">
                                            <div class="flex-shrink-0 w-6 h-6 border-2 border-gray-300 rounded-full flex items-center justify-center radio-indicator transition-all duration-200 mr-5">
                                                <div class="w-3 h-3 bg-blue-600 rounded-full opacity-0 scale-0 transition-all duration-200"></div>
                                            </div>
                                            <div class="flex items-center flex-1">
                                                <div class="bg-blue-100 p-4 rounded-xl group-hover:bg-blue-200 transition-colors mr-5">
                                                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                                                    </svg>
                                                </div>
                                                <div class="flex-1">
                                                    <h3 class="font-bold text-gray-900 text-xl mb-1">Credit Card</h3>
                                                    <p class="text-gray-600">Visa, Mastercard, American Express, Discover</p>
                                                    <div class="flex items-center mt-2 space-x-2">
                                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">Instant</span>
                                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800">Most Popular</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <svg class="w-6 h-6 text-gray-400 group-hover:text-blue-600 transition-colors ml-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </label>
                                </div>

                                <!-- Credit Card Fields -->
                                <div class="payment-fields hidden transition-all duration-300" id="credit-card-fields">
                                    <div class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-2xl p-8 border-2 border-gray-200 ml-11">
                                        <div class="grid lg:grid-cols-2 gap-6">
                                            <div class="lg:col-span-2">
                                                <label class="block text-sm font-bold text-gray-800 mb-3">Card Number</label>
                                                <div class="relative">
                                                    <input type="text" name="card_number" class="w-full border-2 border-gray-300 rounded-xl p-4 text-lg focus:border-blue-500 focus:ring-4 focus:ring-blue-200 focus:outline-none transition-all duration-200" placeholder="1234 5678 9012 3456" maxlength="19">
                                                    <div class="absolute right-4 top-1/2 transform -translate-y-1/2">
                                                        <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="lg:col-span-2">
                                                <label class="block text-sm font-bold text-gray-800 mb-3">Cardholder Name</label>
                                                <input type="text" name="card_holder" class="w-full border-2 border-gray-300 rounded-xl p-4 text-lg focus:border-blue-500 focus:ring-4 focus:ring-blue-200 focus:outline-none transition-all duration-200" placeholder="John Doe">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-bold text-gray-800 mb-3">Expiry Date</label>
                                                <input type="text" name="expiry_date" class="w-full border-2 border-gray-300 rounded-xl p-4 text-lg focus:border-blue-500 focus:ring-4 focus:ring-blue-200 focus:outline-none transition-all duration-200" placeholder="MM/YY" maxlength="5">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-bold text-gray-800 mb-3">CVV</label>
                                                <input type="text" name="cvv" class="w-full border-2 border-gray-300 rounded-xl p-4 text-lg focus:border-blue-500 focus:ring-4 focus:ring-blue-200 focus:outline-none transition-all duration-200" placeholder="123" maxlength="4">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- PayPal Option
                                <div class="payment-option group border-2 border-gray-200 rounded-2xl p-6 cursor-pointer transition-all duration-300 hover:border-yellow-400 hover:shadow-lg hover:bg-gradient-to-r hover:from-yellow-50 hover:to-transparent" data-method="paypal">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="radio" name="payment_method" value="paypal" class="sr-only payment-radio">
                                        <div class="flex items-center w-full">
                                            <div class="flex-shrink-0 w-6 h-6 border-2 border-gray-300 rounded-full flex items-center justify-center radio-indicator transition-all duration-200 mr-5">
                                                <div class="w-3 h-3 bg-blue-600 rounded-full opacity-0 scale-0 transition-all duration-200"></div>
                                            </div>
                                            <div class="flex items-center flex-1">
                                                <div class="bg-yellow-100 p-4 rounded-xl group-hover:bg-yellow-200 transition-colors mr-5">
                                                    <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M7.076 21.337H2.47a.641.641 0 0 1-.633-.74L4.944.901C5.026.382 5.474 0 5.998 0h7.46c2.57 0 4.578.543 5.69 1.81 1.01 1.15 1.304 2.42 1.012 4.287-.023.143-.047.288-.077.435-.983 4.814-4.494 6.823-8.843 6.823H8.17a.75.75 0 0 0-.741.846l-.584 3.75c-.067.428-.069.428-.558.428zm.65-13.224h2.29c1.743 0 3.174-.402 4.05-1.146.875-.744 1.13-1.678.72-2.64-.41-.962-1.39-1.327-2.91-1.327H9.461c-.404 0-.74.305-.805.716L7.726 8.113z"/>
                                                    </svg>
                                                </div>
                                                <div class="flex-1">
                                                    <h3 class="font-bold text-gray-900 text-xl mb-1">PayPal</h3>
                                                    <p class="text-gray-600">Pay securely with your PayPal account</p>
                                                    <div class="flex items-center mt-2">
                                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">Secure</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <svg class="w-6 h-6 text-gray-400 group-hover:text-yellow-600 transition-colors ml-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </label>
                                </div> -->

                                <div class="payment-option group border-2 border-gray-200 rounded-2xl p-6 cursor-pointer transition-all duration-300 hover:border-blue-400 hover:shadow-lg hover:bg-gradient-to-r hover:from-blue-50 hover:to-transparent" data-method="gcash">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="radio" name="payment_method" value="gcash" class="sr-only payment-radio">
                                        <div class="flex items-center w-full">
                                            <div class="flex-shrink-0 w-6 h-6 border-2 border-gray-300 rounded-full flex items-center justify-center radio-indicator transition-all duration-200 mr-5">
                                                <div class="w-3 h-3 bg-blue-600 rounded-full opacity-0 scale-0 transition-all duration-200"></div>
                                            </div>
                                            <div class="flex items-center flex-1">
                                                <div class="bg-blue-100 p-4 rounded-xl group-hover:bg-blue-200 transition-colors mr-5">
                                                    <!-- GCash SVG Icon -->
                                                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                                        <circle cx="12" cy="12" r="10" fill="#0076FF"/>
                                                        <text x="12" y="16" text-anchor="middle" fill="#fff" font-size="10" font-family="Arial" dy=".3em">GCash</text>
                                                    </svg>
                                                </div>
                                                <div class="flex-1">
                                                    <h3 class="font-bold text-gray-900 text-xl mb-1">GCash</h3>
                                                    <p class="text-gray-600">Pay with your GCash account</p>
                                                    <div class="flex items-center mt-2">
                                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">Instant</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <svg class="w-6 h-6 text-gray-400 group-hover:text-blue-600 transition-colors ml-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </label>
                                </div>

                                <div class="payment-option group border-2 border-gray-200 rounded-2xl p-6 cursor-pointer transition-all duration-300 hover:border-green-400 hover:shadow-lg hover:bg-gradient-to-r hover:from-green-50 hover:to-transparent" data-method="cod">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="radio" name="payment_method" value="cod" class="sr-only payment-radio">
                                        <div class="flex items-center w-full">
                                            <div class="flex-shrink-0 w-6 h-6 border-2 border-gray-300 rounded-full flex items-center justify-center radio-indicator transition-all duration-200 mr-5">
                                                <div class="w-3 h-3 bg-blue-600 rounded-full opacity-0 scale-0 transition-all duration-200"></div>
                                            </div>
                                            <div class="flex items-center flex-1">
                                                <div class="bg-green-100 p-4 rounded-xl group-hover:bg-green-200 transition-colors mr-5">
                                                    <!-- Cash SVG Icon -->
                                                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                                        <rect x="2" y="7" width="20" height="10" rx="2" fill="#34D399"/>
                                                        <circle cx="12" cy="12" r="3" fill="#fff"/>
                                                    </svg>
                                                </div>
                                                <div class="flex-1">
                                                    <h3 class="font-bold text-gray-900 text-xl mb-1">Cash on Delivery</h3>
                                                    <p class="text-gray-600">Pay with cash upon delivery</p>
                                                    <div class="flex items-center mt-2">
                                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-yellow-100 text-yellow-800">No upfront payment</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <svg class="w-6 h-6 text-gray-400 group-hover:text-green-600 transition-colors ml-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </label>
                                </div>

                                <!-- Bank Transfer Fields
                                <div class="payment-fields hidden transition-all duration-300" id="bank-fields">
                                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-8 border-2 border-green-200 ml-11">
                                        <div class="grid lg:grid-cols-2 gap-6">
                                            <div>
                                                <label class="block text-sm font-bold text-gray-800 mb-3">Bank Name</label>
                                                <input type="text" name="bank_name" class="w-full border-2 border-gray-300 rounded-xl p-4 text-lg focus:border-green-500 focus:ring-4 focus:ring-green-200 focus:outline-none transition-all duration-200" placeholder="Bank of America">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-bold text-gray-800 mb-3">Account Number</label>
                                                <input type="text" name="account_number" class="w-full border-2 border-gray-300 rounded-xl p-4 text-lg focus:border-green-500 focus:ring-4 focus:ring-green-200 focus:outline-none transition-all duration-200" placeholder="1234567890">
                                            </div>
                                            <div class="lg:col-span-2">
                                                <label class="block text-sm font-bold text-gray-800 mb-3">Routing Number</label>
                                                <input type="text" name="routing_number" class="w-full border-2 border-gray-300 rounded-xl p-4 text-lg focus:border-green-500 focus:ring-4 focus:ring-green-200 focus:outline-none transition-all duration-200" placeholder="021000021">
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Payment Summary Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky top-8">
                    <!-- Shipping Address Display -->
                    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-6 mb-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Shipping Address</h3>
                        <p class="text-gray-700">
                            {{ $address }}
                        </p>
                    </div>

                    <!-- Order Summary -->
                    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Order Summary
                        </h3>
                        
                        <div class="space-y-2 mb-6">
                            @if(isset($selectedCartItems) && count($selectedCartItems))
                                @foreach($selectedCartItems as $item)
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <div>
                                            <div class="font-semibold text-gray-900">{{ $item['product_name'] }}</div>
                                            <div class="text-xs text-gray-500">Qty: {{ $item['quantity'] }}</div>
                                        </div>
                                        <div class="font-semibold text-gray-900">
                                            ₱{{ number_format($item['subtotal'], 2) }}
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-gray-400 text-sm">No items selected.</div>
                            @endif
                        </div>
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-semibold text-gray-900">₱{{ number_format($subtotal ?? 0, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-gray-600">Processing Fee</span>
                                <span class="font-semibold text-gray-900">₱{{ number_format($processingFee ?? 0, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-gray-600">Tax</span>
                                <span class="font-semibold text-gray-900">₱{{ number_format($tax ?? 0, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center py-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl px-4">
                                <span class="text-xl font-bold text-gray-900">Total</span>
                                <span class="text-2xl font-bold text-blue-600">₱{{ number_format($subtotal ?? 0, 2) }}</span>
                            </div>
                        </div>

                        <!-- Process Payment Button -->
                        <button type="submit" form="paymentForm" class="w-full bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white font-bold text-lg py-4 px-6 rounded-2xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-blue-300 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span class="flex items-center justify-center space-x-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                <span>Complete Payment</span>
                            </span>
                        </button>
                    </div>

                    <!-- Security Features -->
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-3xl border-2 border-green-200 p-6">
                        <h4 class="font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                            </svg>
                            Security Guaranteed
                        </h4>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                256-bit SSL encryption
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                PCI DSS compliant
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Fraud protection
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Money-back guarantee
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .payment-option.selected {
        @apply border-blue-500 bg-gradient-to-r from-blue-50 to-indigo-50 shadow-lg;
    }
    
    .payment-option.selected .radio-indicator {
        @apply border-blue-500;
    }
    
    .payment-option.selected .radio-indicator > div {
        @apply opacity-100 scale-100;
    }

    .payment-option[data-method="paypal"].selected {
        @apply border-yellow-500 bg-gradient-to-r from-yellow-50 to-orange-50;
    }

    .payment-option[data-method="bank_transfer"].selected {
        @apply border-green-500 bg-gradient-to-r from-green-50 to-emerald-50;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentOptions = document.querySelectorAll('.payment-option');
        const paymentFields = document.querySelectorAll('.payment-fields');
        
        paymentOptions.forEach(option => {
            option.addEventListener('click', function() {
                const method = this.dataset.method;
                const radio = this.querySelector('input[type="radio"]');
                
                // Remove selected class from all options
                paymentOptions.forEach(opt => opt.classList.remove('selected'));
                
                // Add selected class to clicked option
                this.classList.add('selected');
                
                // Check the radio button
                radio.checked = true;
                
                // Hide all payment fields with smooth transition
                paymentFields.forEach(fields => {
                    fields.classList.add('hidden');
                });
                
                // Show relevant payment fields
                const targetFields = document.getElementById(method.replace('_', '-') + '-fields');
                if (targetFields) {
                    setTimeout(() => {
                        targetFields.classList.remove('hidden');
                        targetFields.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    }, 200);
                }
            });
        });
        
        // Format card number input
        const cardNumberInput = document.querySelector('input[name="card_number"]');
        if (cardNumberInput) {
            cardNumberInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
                let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
                e.target.value = formattedValue;
            });
        }
        
        // Format expiry date input
        const expiryInput = document.querySelector('input[name="expiry_date"]');
        if (expiryInput) {
            expiryInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length >= 2) {
                    value = value.substring(0, 2) + '/' + value.substring(2, 4);
                }
                e.target.value = value;
            });
        }
        
        // Format CVV input (numbers only)
        const cvvInput = document.querySelector('input[name="cvv"]');
        if (cvvInput) {
            cvvInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/\D/g, '');
            });
        }

        // Format account number input (numbers only)
        const accountNumberInput = document.querySelector('input[name="account_number"]');
        if (accountNumberInput) {
            accountNumberInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/\D/g, '');
            });
        }

        // Format routing number input (numbers only)
        const routingNumberInput = document.querySelector('input[name="routing_number"]');
        if (routingNumberInput) {
            routingNumberInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/\D/g, '');
            });
        }

        // Form validation
        const form = document.getElementById('paymentForm');
        form.addEventListener('submit', function(e) {
            const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
            if (!selectedMethod) {
                e.preventDefault();
                alert('Please select a payment method.');
                return;
            }

            // Validate based on selected method
            if (selectedMethod.value === 'credit_card') {
                const cardNumber = document.querySelector('input[name="card_number"]').value;
                const cardHolder = document.querySelector('input[name="card_holder"]').value;
                const expiryDate = document.querySelector('input[name="expiry_date"]').value;
                const cvv = document.querySelector('input[name="cvv"]').value;

                if (!cardNumber || !cardHolder || !expiryDate || !cvv) {
                    e.preventDefault();
                    alert('Please fill in all credit card fields.');
                    return;
                }
            } else if (selectedMethod.value === 'paypal') {
                const paypalEmail = document.querySelector('input[name="paypal_email"]').value;
                if (!paypalEmail) {
                    e.preventDefault();
                    alert('Please enter your PayPal email address.');
                    return;
                }
            } else if (selectedMethod.value === 'bank_transfer') {
                const bankName = document.querySelector('input[name="bank_name"]').value;
                const accountNumber = document.querySelector('input[name="account_number"]').value;
                const routingNumber = document.querySelector('input[name="routing_number"]').value;

                if (!bankName || !accountNumber || !routingNumber) {
                    e.preventDefault();
                    alert('Please fill in all bank transfer fields.');
                    return;
                }
            } else if (selectedMethod.value === 'gcash') {
                // Optionally, validate GCash number if you add a field
            } else if (selectedMethod.value === 'cod') {
                // No extra validation needed for COD
            }
        });

        // Auto-select first payment method if none selected
        const firstOption = document.querySelector('.payment-option');
        if (firstOption && !document.querySelector('input[name="payment_method"]:checked')) {
            firstOption.click();
        }
    });
</script>