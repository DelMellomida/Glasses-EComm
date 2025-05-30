@if (auth()->user())
    <x-nav-user></x-nav-user>
    @php
        $userAddress = (auth()->user() && auth()->user()->user_details) ? trim(auth()->user()->user_details->address) : '';
    @endphp
@else
    <x-nav-guest></x-nav-guest>
@endif

<x-guest-layout>
<div class="container mx-auto px-2 md:px-4 py-8 mt-16">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Your Cart</h1>

    @if ($cart && $cart->items->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($cart->items as $item)
                <div class="bg-white rounded-xl shadow-lg flex flex-col md:flex-row items-center p-6 gap-6 hover:shadow-2xl transition-shadow relative">
                    <!-- Product Image -->
                    <div class="w-28 h-28 flex-shrink-0 flex items-center justify-center bg-gray-100 rounded-lg overflow-hidden">
                        @if ($item->product->primaryImage && $item->product->primaryImage->image_path)
                            <img src="{{ $item->product->primaryImage->image_path }}" 
                                 alt="{{ $item->product->product_name }}" 
                                 class="object-cover w-full h-full"
                                 onerror="this.parentElement.innerHTML='<div class=\'flex items-center justify-center w-full h-full text-gray-400 text-xs\'>No image</div>'">
                        @elseif ($item->product->images->count() > 0)
                            <img src="{{ $item->product->images->first()->image_path }}" 
                                 alt="{{ $item->product->product_name }}" 
                                 class="object-cover w-full h-full"
                                 onerror="this.parentElement.innerHTML='<div class=\'flex items-center justify-center w-full h-full text-gray-400 text-xs\'>No image</div>'">
                        @else
                            <div class="flex items-center justify-center w-full h-full text-gray-400 text-xs">No image</div>
                        @endif
                    </div>
                    
                    <!-- Product Info -->
                    <div class="flex-1 flex flex-col justify-between w-full">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $item->product->product_name }}</h3>
                            <p class="text-gray-500 text-sm mb-2">{{ $item->product->product_description ?? 'No description available' }}</p>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-teal-600 font-bold text-base">₱{{ number_format($item->product->price, 2) }}</span>
                                <span class="text-xs text-gray-400">each</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 mt-2">
                            <!-- Quantity Controls -->
                            <button
                                class="decrement-btn bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-1 rounded-full text-lg font-bold transition"
                                data-item-id="{{ $item->id }}"
                                aria-label="Decrease quantity"
                            >-</button>
                            <span class="text-lg font-semibold w-8 text-center">{{ $item->quantity }}</span>
                            <button
                                class="increment-btn bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-1 rounded-full text-lg font-bold transition"
                                data-item-id="{{ $item->id }}"
                                aria-label="Increase quantity"
                            >+</button>
                            <span class="ml-4 text-gray-700 font-bold">Total: ₱{{ number_format($item->product->price * $item->quantity, 2) }}</span>
                        </div>
                    </div>
                    
                    <!-- Remove Button -->
                    <button
                        class="delete-cart-item-btn absolute top-4 right-4 bg-red-100 hover:bg-red-200 text-red-600 rounded-full p-2 transition"
                        data-item-id="{{ $item->id }}"
                        title="Remove from cart"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endforeach
        </div>

        <!-- Cart Summary -->
        <div class="max-w-lg mx-auto mt-12">
            <div class="bg-white rounded-xl shadow-lg p-8 flex flex-col gap-4">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Cart Summary</h2>
                <div class="flex justify-between items-center text-lg">
                    <span class="text-gray-700">Total:</span>
                    <span class="text-teal-600 font-bold text-2xl">
                        ₱{{ number_format($cart->items->sum(fn($item) => $item->product->price * $item->quantity), 2) }}
                    </span>
                </div>
                <button
                    id="buy-now-btn"
                    class="mt-6 bg-teal-500 hover:bg-teal-600 text-white px-8 py-3 rounded-lg text-lg font-semibold transition-colors duration-300 w-full"
                    style="background-color: #14b8a6 !important;"
                >
                    Buy Now
                </button>
            </div>
        </div>
    @else
        <div class="flex flex-col items-center justify-center py-24">
            <svg class="w-20 h-20 text-gray-300 mb-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7A2 2 0 007.48 19h9.04a2 2 0 001.83-1.3L17 13M7 13V6h13"/>
            </svg>
            <p class="text-gray-500 text-lg">Your cart is empty.</p>
        </div>
    @endif
</div>
</x-guest-layout>

<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('delete-cart-item-btn')) {
            const cartItemId = event.target.dataset.itemId;

            if (confirm('Are you sure you want to remove this item from the cart?')) {
                fetch(`/cart-item/${cartItemId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message === 'Cart item removed successfully!') {
                        showNotification('success', 'Removed', 'Item removed from cart!');
                        location.reload();
                    } else {
                        showNotification('error', 'Failed', 'Failed to remove item from cart.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('error', 'Error', 'An error occurred. Please try again.');
                });
            }
        }

        // Increment and Decrement functionality
        if (event.target.classList.contains('increment-btn') || event.target.classList.contains('decrement-btn')) {
            const cartItemId = event.target.dataset.itemId;
            const isIncrement = event.target.classList.contains('increment-btn');

            fetch(`/cart-item/${cartItemId}/${isIncrement ? 'increment' : 'decrement'}`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.message === 'Cart item updated successfully!') {
                    showNotification('success', 'Updated', 'Cart item updated!');
                    location.reload();
                } else if (data.message === 'Cart item removed successfully!') {
                    showNotification('success', 'Removed', 'Item removed from cart!');
                    location.reload();
                } else {
                    showNotification('error', 'Failed', 'Failed to update cart item.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('error', 'Error', 'An error occurred. Please try again.');
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        const buyNowBtn = document.getElementById('buy-now-btn');
        if (buyNowBtn) {
            buyNowBtn.addEventListener('click', function (e) {
                const userAddress = @json($userAddress);
                if (!userAddress) {
                    e.preventDefault();
                    showNotification('warning', 'Address Required', 'Please add your address in your profile before checking out.');
                    return false;
                }
                // Proceed with checkout logic here if address is set
            });
        }
    });
</script>