<div 
    x-data="{
        open: false, 
        modalProduct: null, 
        modalImage: null, 
        modalAvailability: null,
        isAuthenticated: {{ auth()->check() ? 'true' : 'false' }}
    }" 
    class="container mx-auto px-2 md:px-4 py-4 md:py-8"
>
    <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">

        @forelse ($products as $product)
            @php
                $hasImage = false;
                $imagePath = null;
                foreach ($productImages as $productImage) {
                    if ($product->product_id == $productImage->product_id) {
                        $hasImage = true;
                        $imagePath = $productImage->image_path;
                        break;
                    }
                }
            @endphp
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 flex flex-col w-60 md:w-72 h-[340px] md:h-[380px] mb-12">
                <div
                    class="h-44 md:h-56 overflow-hidden flex items-center justify-center cursor-pointer"
                    @click="open = true; modalProduct = {{ json_encode($product) }}; modalImage = '{{ $imagePath }}'; modalAvailability = '{{ $product->category->availability_type ?? '' }}';"
                >
                    @if ($hasImage)
                        <img src="{{ $imagePath }}" alt="{{ $product->product_name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-400 text-xs md:text-sm">No image available</span>
                        </div>
                    @endif
                </div>
                <div class="p-3 md:p-4 flex flex-col justify-between flex-1">
                    <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-1 md:mb-2">{{ $product->product_name }}</h3>
                    <p class="text-gray-600 text-xs md:text-sm mb-3 md:mb-4 line-clamp-2">{{ $product->product_description ?? 'No description available' }}</p>
                    
                    <div class="flex items-center justify-center mt-auto mb-2 md:mb-3">
                        <span class="text-teal-600 font-bold text-sm md:text-base">P{{ number_format($product->price, 2) }}</span>
                    </div>
                    
                    <!-- Authentication-based button below price -->
                    <div>
                        @if (auth()->user())
                            <div class="flex gap-2">
                                <template x-if="modalAvailability === 'online'">
                                    <button
                                        class="flex-1 bg-teal-500 hover:bg-teal-600 text-white px-3 md:px-4 py-1.5 md:py-2 rounded-md text-xs md:text-sm font-medium transition-colors duration-300"
                                        style="background-color: #14b8a6 !important;"
                                    >
                                        BUY
                                    </button>
                                    <button
                                        class="bg-teal-500 hover:bg-teal-600 text-white px-2 py-1.5 md:py-2 rounded-md transition-colors duration-300 flex items-center justify-center add-to-cart-btn"
                                        style="background-color: #14b8a6 !important;"
                                        title="Add to Cart"
                                        data-product-id="{{ $product->product_id }}"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l1.4-7H6.4M7 13l-1.4 7M7 13h10m0 0l1.4 7M7 20a1 1 0 100-2 1 1 0 000 2zm10 0a1 1 0 100-2 1 1 0 000 2z" />
                                        </svg>
                                    </button>
                                </template>
                                <template x-if="modalAvailability !== 'online'">
                                    <button
                                        class="flex-1 bg-teal-500 hover:bg-teal-600 text-white px-3 md:px-4 py-1.5 md:py-2 rounded-md text-xs md:text-sm font-medium transition-colors duration-300"
                                        style="background-color: #14b8a6 !important;"
                                    >
                                        <a href="{{ route('appointments.index') }}">Create Appointment</a>
                                    </button>
                                </template>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="block w-full text-center bg-teal-500 hover:bg-teal-600 text-white px-3 md:px-4 py-1.5 md:py-2 rounded-md text-xs md:text-sm font-medium transition-colors duration-300">Buy</a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-4 md:py-8 text-center">
                <p class="text-gray-500 text-base md:text-lg">No products found.</p>
            </div>
        @endforelse
    </div>

    <div
        x-show="open"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center"
        style="background: rgba(0,0,0,0.15) !important; backdrop-filter: blur(2px);"
        @click.self="open = false"
    >
        <div class="bg-white rounded-lg shadow-lg w-full max-w-4xl flex overflow-hidden relative h-[500px]">
            <!-- Image side - Full height left -->
            <div class="w-1/2 h-full flex items-center justify-center bg-gray-100">
                <template x-if="modalImage">
                    <img :src="modalImage" alt="" class="w-full h-full object-cover object-center">
                </template>
                <template x-if="!modalImage">
                    <div class="w-full h-full flex items-center justify-center bg-gray-200">
                        <span class="text-gray-400 text-sm">No image available</span>
                    </div>
                </template>
            </div>

            <!-- Info side - Top right -->
            <div class="w-1/2 p-6 flex flex-col">
                <!-- Close button -->
                <button class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 text-2xl font-bold" @click="open = false">&times;</button>
                
                <!-- Content at top -->
                <div class="pt-2">
                    <!-- Big bold name -->
                    <h2 class="text-3xl font-bold mb-4 text-gray-800" x-text="modalProduct?.product_name"></h2>
                    
                    <!-- description -->
                    <div class="ml-4 mb-6">
                        <p class="text-gray-600 text-base leading-relaxed" x-text="modalProduct?.product_description ?? 'No description available'"></p>
                    </div>
                    
                    <!-- Price -->
                    <div class="mb-6">
                        <span class="text-teal-600 font-bold text-2xl" x-text="'P' + (Number(modalProduct?.price).toLocaleString(undefined, {minimumFractionDigits: 2}))"></span>
                    </div>
                    
                    <!-- Authentication-based button -->
                    @if (auth()->user())
                            <div class="bottom-6 flex gap-2">
                                <template x-if="modalAvailability === 'online'">
                                    <button
                                        class="flex-1 bg-teal-500 hover:bg-teal-600 text-white px-3 md:px-4 py-1.5 md:py-2 rounded-md text-xs md:text-sm font-medium transition-colors duration-300"
                                        style="background-color: #14b8a6 !important;"
                                    >
                                        BUY
                                    </button>
                                    <button
                                        class="bg-teal-500 hover:bg-teal-600 text-white px-2 py-1.5 md:py-2 rounded-md transition-colors duration-300 flex items-center justify-center add-to-cart-btn"
                                        style="background-color: #14b8a6 !important;"
                                        title="Add to Cart"
                                        data-product-id="{{ $product->product_id }}"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l1.4-7H6.4M7 13l-1.4 7M7 13h10m0 0l1.4 7M7 20a1 1 0 100-2 1 1 0 000 2zm10 0a1 1 0 100-2 1 1 0 000 2z" />
                                        </svg>
                                    </button>
                                </template>
                                <template x-if="modalAvailability !== 'online'">
                                    <button
                                        class="flex-1 bg-teal-500 hover:bg-teal-600 text-white px-3 md:px-4 py-1.5 md:py-2 rounded-md text-xs md:text-sm font-medium transition-colors duration-300"
                                        style="background-color: #14b8a6 !important;"
                                    >
                                        <a href="{{ route('appointments.index') }}">Create Appointment</a>
                                    </button>
                                </template>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="bottom-6 block w-full text-center bg-teal-500 hover:bg-teal-600 text-white px-3 md:px-4 py-1.5 md:py-2 rounded-md text-xs md:text-sm font-medium transition-colors duration-300">Buy</a>
                        @endif
                </div>
            </div>
        </div>
        
    </div>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script src="//unpkg.com/alpinejs" defer></script>
<script>
        document.querySelectorAll('.add-to-cart-btn').forEach(button => {
    const newButton = button.cloneNode(true);
    button.replaceWith(newButton);

    newButton.addEventListener('click', function () {
        console.log('Add to Cart button clicked'); // Debugging
        const productId = this.dataset.productId;
        const quantity = 1;

        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ product_id: productId, quantity: quantity }),
        })
        .then(response => response.json())
        .then(data => {
            alert('Product added to cart!');
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('An error occurred. Please check the console for details.');
        });
    });
});
</script>