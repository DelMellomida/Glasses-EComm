<div class="container mx-auto px-2 md:px-4 py-4 md:py-8">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-6">
        @forelse ($products as $product)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">

                @php $hasImage = false; @endphp
                
                @foreach ($productImages as $productImage)
                    @if ($product->product_image_id == $productImage->product_id)
                        <div class="h-36 md:h-48 overflow-hidden">
                            <img src="{{ $productImage->image_path }}" alt="{{ $product->product_name }}" class="w-full h-full object-cover">
                        </div>
                        @php $hasImage = true; @endphp
                        @break
                    @endif
                @endforeach
                
                @if (!$hasImage)
                    <div class="h-36 md:h-48 bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-400 text-xs md:text-sm">No image available</span>
                    </div>
                @endif
                
                <div class="p-3 md:p-4">
                    <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-1 md:mb-2">{{ $product->product_name }}</h3>
                    <p class="text-gray-600 text-xs md:text-sm mb-3 md:mb-4 line-clamp-2">{{ $product->product_description ?? 'No description available' }}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-teal-600 font-bold text-sm md:text-base">P{{ number_format($product->price, 2) }}</span>
                        <button class="bg-teal-500 hover:bg-teal-600 text-white px-3 md:px-4 py-1.5 md:py-2 rounded-md text-xs md:text-sm font-medium transition-colors duration-300">BUY</button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-4 md:py-8 text-center">
                <p class="text-gray-500 text-base md:text-lg">No products found.</p>
            </div>
        @endforelse
    </div>
</div>