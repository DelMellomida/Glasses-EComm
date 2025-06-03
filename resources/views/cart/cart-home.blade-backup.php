@if (auth()->user())
    <x-nav-user></x-nav-user>
    @php
        $userAddress = (auth()->user() && auth()->user()->userDetail) ? trim(auth()->user()->userDetail->address) : '';
    @endphp
@else
    <x-nav-guest></x-nav-guest>
@endif

<x-app-layout>
<div class="flex justify-center py-40">

    @if ($cart && $cart->items->count() > 0)
    <div class="bg-white rounded-l-lg shadow-xl px-5 py-5 overflow:auto flex justify-center">

        <form id="cart-buy-form" method="POST" action="{{ route('payment.method') }}">
            @csrf
            <div class="grid">
                    <div class="">
                        @foreach ($cart->items as $item)    
                        <div class="md:flex-row items-center p-6 gap-6 hover:shadow-2xl transition-shadow relative flex justify-center">
                        <!-- Checkbox -->
                        <input type="checkbox"
                            class="cart-item-checkbox absolute top-4 left-4 w-5 h-5 accent-teal-500"
                            name="cart_items[]"
                            value="{{ $item->id }}"
                            data-price="{{ $item->product->price * $item->quantity }}"
                        >
                        <!-- Product Image -->
                        <div class="w-28 h-28 flex-shrink-0 flex items-center justify-center bg-gray-100 rounded-lg overflow-hidden ml-8 md:ml-0">
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
                                    type="button"
                                    class="decrement-btn bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-1 rounded-full text-lg font-bold transition"
                                    data-item-id="{{ $item->id }}"
                                    aria-label="Decrease quantity"
                                >-</button>
                                <span class="text-lg font-semibold w-8 text-center">{{ $item->quantity }}</span>
                                <button
                                    type="button"
                                    class="increment-btn bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-1 rounded-full text-lg font-bold transition"
                                    data-item-id="{{ $item->id }}"
                                    aria-label="Increase quantity"
                                >+</button>
                                <span class="ml-4 text-gray-700 font-bold">Total: ₱{{ number_format($item->product->price * $item->quantity, 2) }}</span>
                            </div>
                        </div>
                        
                        <!-- Remove Button -->
                        <button
                            class="delete-cart-item-btn top-4 bg-red-100 hover:bg-red-200 text-red-600 rounded-full p-2 transition"
                            data-item-id="{{ $item->id }}"
                            title="Remove from cart"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                        </div>
                        <div class="border-t border-gray-200"></div>
                    </div>
                @endforeach


                </div>

            </div>

        </form>
    @else
        <div class="flex flex-col items-center justify-center py-24">
            <svg class="w-20 h-20 text-gray-300 mb-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7A2 2 0 007.48 19h9.04a2 2 0 001.83-1.3L17 13M7 13V6h13"/>
            </svg>
            <p class="text-gray-500 text-lg">Your cart is empty.</p>
        </div>
    @endif
    
    </div>
                        <!-- Cart Summary -->
                    <div class="max-w-lg px-auto col-span-2 grid grid-cols-subgrid">
                        <div class="bg-gray-200 px-20 pt-5 flex flex-col gap-4 rounded-r-lg shadow-xl">
                            <h2 class="text-2xl font-bold text-gray-800 mb-2">Cart Summary</h2>
                            <div class="flex justify-between items-center text-lg">
                            <span class="text-gray-700">Total: </span>
                            <span id="cart-total" class="text-teal-600 font-bold text-2xl"> ₱0.00</span>
                        </div>
                        <div class="border-t border-gray-400 py-2"></div>
                        <button
                            id="buy-now-btn"
                            type="submit"
                            class="mt-6 bg-teal-500 hover:bg-teal-600 text-white px-8 py-1 rounded-lg text-lg font-semibold transition-colors duration-300 w-full"
                            style="background-color: #14b8a6 !important;"
                            >
                            Buy Now
                        </button>
                    </div>


    
</div>

<!-- <pre>
{{ var_dump(auth()->user()->userDetail) }}
</pre> -->

</x-app-layout>

<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    // Checkbox total calculation
    function updateCartTotal() {
        let total = 0;
        document.querySelectorAll('.cart-item-checkbox:checked').forEach(function(checkbox) {
            total += parseFloat(checkbox.dataset.price);
        });
        document.getElementById('cart-total').textContent = '₱' + total.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Update total on checkbox change
        document.querySelectorAll('.cart-item-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', updateCartTotal);
        });

        // Optionally, check all by default:
        // document.querySelectorAll('.cart-item-checkbox').forEach(cb => cb.checked = true);
        // updateCartTotal();

        // Buy Now validation
        document.getElementById('cart-buy-form').addEventListener('submit', function(e) {
            const checked = document.querySelectorAll('.cart-item-checkbox:checked');
            const userAddress = @json($userAddress);
            console.log("Address is" + userAddress);
            if (!userAddress) {
                e.preventDefault();
                showNotification('warning', 'Address Required', 'Please add your address in your profile before checking out.');
                return false;
            }
            if (checked.length === 0) {
                e.preventDefault();
                showNotification('warning', 'No Items Selected', 'Please select at least one item to buy.');
                return false;
            }
        });
    });

    // Existing increment/decrement/delete logic
    document.addEventListener('click', function (event) {
        if (event.target.closest('.delete-cart-item-btn')) {
            const btn = event.target.closest('.delete-cart-item-btn');
            const cartItemId = btn.dataset.itemId;

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
                    setTimeout(() => {
                        location.reload();
                    }, 3000); // 3000 ms = 3 seconds
                } else if (data.message === 'Cart item removed successfully!') {
                    showNotification('success', 'Removed', 'Item removed from cart!');
                    setTimeout(() => {
                        location.reload();
                    }, 3000); // 3000 ms = 3 seconds
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
</script>