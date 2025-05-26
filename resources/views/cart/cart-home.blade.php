<div class="container mx-auto px-4 py-8">
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
                                <p class="text-gray-600 text-sm">Quantity: {{ $item->quantity }}</p>
                                <p class="text-gray-800 font-bold">Total: P{{ number_format($item->product->price * $item->quantity, 2) }}</p>
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
    @else
        <p class="text-gray-500 text-lg">Your cart is empty.</p>
    @endif
</div>
