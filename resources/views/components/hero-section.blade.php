<!-- Hero Section -->
<div class="w-full relative flex justify-center items-center min-h-[10vh] md:min-h-[5vh]">
    <!-- Product Image -->
    <img src="{{ asset('build/assets/Images/sunglasses.png') }}"
        alt="Sunglasses"  />

    <!-- Text Content Overlay -->
    <div class="absolute inset-0 flex flex-col justify-center items-end text-right space-y-8 px-8 md:px-16 lg:px-24">
        <div class="max-w-lg ">
            <span class="md:text-2xl font-extrabold leading-tight text-white tracking-tight drop-shadow-lg">
                See the <span class="text-[#f04e37]">Difference!</span>
                </span>
            <p class="text-2xl   text-gray-100 leading-relaxed drop-shadow mt-6">
                Stylish eyewear for any occasion.
            </p>
            @if (auth()->user())
            <a href="#products-section"
                class="mt-8 inline-block bg-[#f04e37] text-white px-8 py-3 rounded-lg shadow-lg font-semibold md:text-xl md:lg:text-2xl hover:bg-[#0d6b8a] hover:scale-105 transition-transform duration-300">
                Buy now
            </a>
            @else
            <a href="{{ route('login') }}"
                class="mt-8 inline-block bg-[#f04e37] text-white px-8 py-3 rounded-lg shadow-lg font-semibold md:text-xl md:lg:text-2xl hover:bg-[#0d6b8a] hover:scale-105 transition-transform duration-300">
                Buy now
            </a>
            @endif
            
        </div>
    </div>
</div>

