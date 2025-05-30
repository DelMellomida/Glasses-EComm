<div 
    x-data="{
        open: false, 
        modalProduct: null, 
        modalImage: null, 
        modalAvailability: null,
        isAuthenticated: {{ auth()->check() ? 'true' : 'false' }},
        buying: false,
        buyingModal: false,
        buyingProduct: null,
        quantity: 1,
        get total() {
            return this.buyingProduct ? this.quantity * this.buyingProduct.price : 0;
        }
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
                $availability = strtolower(trim($product->category->availability_type ?? ''));
            @endphp
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 flex flex-col w-60 md:w-72 h-[340px] md:h-[380px] mb-12">
                <div
                    class="h-44 md:h-56 overflow-hidden flex items-center justify-center cursor-pointer"
                    @click="
                        open = true; 
                        modalProduct = {{ json_encode($product) }}; 
                        modalImage = '{{ $imagePath }}'; 
                        modalAvailability = '{{ $availability }}';
                        buying = false; 
                        quantity = 1;
                    "
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
                            <div class="bottom-6 flex flex-col gap-2">
                                @if ($availability === 'online')
                                    <button
                                        class="flex-1 bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors duration-300"
                                        style="background-color: #14b8a6 !important;"
                                        @click="
                                            buyingModal = true; 
                                            buyingProduct = Object.assign({{ json_encode($product) }}, {image_path: '{{ $imagePath }}'}); 
                                            quantity = 1;
                                        "
                                    >
                                        BUY
                                    </button>
                                @else
                                    <button
                                        class="flex-1 bg-teal-500 hover:bg-teal-600 text-white px-3 md:px-4 py-1.5 md:py-2 rounded-md text-xs md:text-sm font-medium transition-colors duration-300"
                                        style="background-color: #14b8a6 !important;"
                                    >
                                        <a href="{{ route('appointments.index') }}">Create Appointment</a>
                                    </button>
                                @endif
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="bottom-6 block w-full text-center bg-teal-500 hover:bg-teal-600 text-white px-3 md:px-4 py-1.5 md:py-2 rounded-md text-xs md:text-sm font-medium transition-colors duration-300">Buy</a>
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

    <!-- Modal -->
    <div
        x-show="open"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center"
        style="background: rgba(0,0,0,0.15) !important; backdrop-filter: blur(2px);"
        @click.self="open = false"
    >
        <div class="bg-white rounded-lg shadow-lg w-full max-w-4xl flex overflow-hidden relative h-[500px]">
            <!-- Image side -->
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
            <!-- Info side -->
            <div class="w-1/2 p-6 flex flex-col">
                <button class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 text-2xl font-bold" @click="open = false">&times;</button>
                <div class="pt-2">
                    <h2 class="text-3xl font-bold mb-4 text-gray-800" x-text="modalProduct?.product_name"></h2>
                    <div class="ml-4 mb-6">
                        <p class="text-gray-600 text-base leading-relaxed" x-text="modalProduct?.product_description ?? 'No description available'"></p>
                    </div>
                    <div class="mb-6">
                        <span class="text-teal-600 font-bold text-2xl" x-text="'P' + (Number(modalProduct?.price).toLocaleString(undefined, {minimumFractionDigits: 2}))"></span>
                    </div>
                    @if (auth()->user())
                        <div class="bottom-6 flex flex-col gap-2">
                            <template x-if="modalAvailability === 'online'">
                                <button
                                    class="flex-1 bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors duration-300"
                                    style="background-color: #14b8a6 !important;"
                                    @click="
                                        buyingModal = true; 
                                        buyingProduct = Object.assign(modalProduct, {image_path: modalImage}); 
                                        quantity = 1;
                                    "
                                >
                                    BUY
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

    <!-- Buying Modal (Outside the product loop) -->
    <div
        x-show="buyingModal"
        x-cloak
        class="fixed inset-0 z-60 flex items-center justify-center"
        style="background: rgba(0,0,0,0.5) !important; backdrop-filter: blur(4px);"
        @click.self="buyingModal = false"
    >
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 relative transform transition-all duration-300">
            <button class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 text-2xl font-bold z-10" @click="buyingModal = false">&times;</button>
            
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-4 text-gray-800">Purchase Details</h2>
                
                <!-- Product Info -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <template x-if="buyingProduct?.image_path">
                        <img :src="buyingProduct.image_path" :alt="buyingProduct.product_name" class="w-full h-32 object-cover rounded mb-3">
                    </template>
                    <template x-if="!buyingProduct?.image_path">
                        <div class="w-full h-32 bg-gray-200 flex items-center justify-center rounded mb-3">
                            <span class="text-gray-400 text-xs md:text-sm">No image available</span>
                        </div>
                    </template>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2" x-text="buyingProduct?.product_name"></h3>
                    <p class="text-gray-600 text-sm mb-3" x-text="buyingProduct?.product_description ?? 'No description available'"></p>
                    <div class="text-teal-600 font-bold text-lg" x-text="'P' + (Number(buyingProduct?.price).toLocaleString(undefined, {minimumFractionDigits: 2})) + ' each'"></div>
                </div>
                
                <!-- Quantity Selection -->
                <div class="mb-6">
                    <label for="buy-quantity" class="block text-sm font-semibold text-gray-700 mb-2">Quantity:</label>
                    <div class="flex items-center gap-3">
                        <button 
                            @click="quantity = Math.max(1, quantity - 1)"
                            class="w-10 h-10 bg-gray-200 hover:bg-gray-300 rounded-full flex items-center justify-center text-lg font-bold text-gray-600 transition-colors"
                        >
                            -
                        </button>
                        <input
                            id="buy-quantity"
                            type="number"
                            min="1"
                            x-model.number="quantity"
                            class="w-20 text-center border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                        >
                        <button 
                            @click="quantity = quantity + 1"
                            class="w-10 h-10 bg-gray-200 hover:bg-gray-300 rounded-full flex items-center justify-center text-lg font-bold text-gray-600 transition-colors"
                        >
                            +
                        </button>
                    </div>
                </div>
                
                <!-- Total Amount -->
                <div class="mb-6 p-4 bg-teal-50 rounded-lg border border-teal-200">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold text-gray-700">Total Amount:</span>
                        <span class="text-2xl font-bold text-teal-600" x-text="'P' + (total).toLocaleString(undefined, {minimumFractionDigits: 2})"></span>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex gap-3">
                    <button
                        class="flex-1 bg-teal-500 hover:bg-teal-600 text-white px-6 py-3 rounded-lg text-lg font-semibold transition-colors duration-300"
                        style="background-color: #14b8a6 !important;"
                        @click="
                            fetch('/cart/add', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                                },
                                body: JSON.stringify({ product_id: buyingProduct.product_id, quantity: quantity }),
                            })
                            .then(response => response.json())
                            .then(data => { 
                                alert('Product added to cart!'); 
                                buyingModal = false; 
                                open = false; 
                                quantity = 1;
                            })
                            .catch(error => { alert('An error occurred.'); });
                        "
                    >
                        Add to Cart
                    </button>
                    <button
                        class="px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg text-lg font-semibold transition-colors duration-300"
                        @click="buyingModal = false; quantity = 1;"
                    >
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script src="//unpkg.com/alpinejs" defer></script>