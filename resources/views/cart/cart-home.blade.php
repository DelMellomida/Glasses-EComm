
@if (auth()->user())
        <x-nav-user></x-nav-user>
    @else
        <x-nav-guest></x-nav-guest>
    @endif
<x-guest-layout>

<div class="container mx-auto px-4 py-8 mt-16">
    <h1 class="text-2xl font-bold mb-6">Your Cart</h1>

    @if ($cart && $cart->items->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($cart->items as $item)
                <div class="bg-white rounded-lg shadow-md p-4">
                    <div class="flex items-center">
                        @if ($item->product)
                            <img src="{{ $item->product->image_path }}" alt="{{ $item->product->product_name }}" class="w-16 h-16 object-cover rounded-md">
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold">{{ $item->product->product_name }}</h3>
                                <p class="text-gray-600 text-sm">Price: P{{ number_format($item->product->price, 2) }}</p>
                                <div class="flex items-center mt-2">
                                    <button
                                        class="decrement-btn bg-gray-300 hover:bg-gray-400 text-gray-800 px-2 py-1 rounded-md"
                                        data-item-id="{{ $item->id }}"
                                    >
                                        -
                                    </button>
                                    <span class="mx-4 text-lg font-semibold">{{ $item->quantity }}</span>
                                    <button
                                        class="increment-btn bg-gray-300 hover:bg-gray-400 text-gray-800 px-2 py-1 rounded-md"
                                        data-item-id="{{ $item->id }}"
                                    >
                                        +
                                    </button>
                                </div>
                                <p class="text-gray-800 font-bold mt-2">Total: P{{ number_format($item->product->price * $item->quantity, 2) }}</p>
                            </div>
                        @else
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-red-500">Product not found</h3>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            <h2 class="text-xl font-bold">Cart Summary</h2>
            <p class="text-gray-800 text-lg">
                Total: P{{ number_format($cart->items->sum(fn($item) => $item->product->price * $item->quantity), 2) }}
            </p>
        </div>

        <div class="mt-6 text-right">
            <button
                class="bg-teal-500 hover:bg-teal-600 text-white px-6 py-2 rounded-md text-lg font-semibold transition-colors duration-300"
                style="background-color: #14b8a6 !important;"
            >
                Buy Now
            </button>
        </div>
    @else
        <p class="text-gray-500 text-lg">Your cart is empty.</p>
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
                        alert('Item removed from cart!');
                        location.reload(); // Reload the page to reflect changes
                    } else {
                        alert('Failed to remove item from cart.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
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
                console.log('Response:', data); // Debugging

                if (data.message === 'Cart item updated successfully!') {
                    location.reload(); // Reload the page to reflect changes
                } else if (data.message === 'Cart item removed successfully!') {
                    location.reload(); // Reload the page to reflect changes
                } else {
                    alert('Failed to update cart item.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        }
    });
</script>
