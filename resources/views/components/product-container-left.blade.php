<!-- Section Header -->
<div class="flex justify-between items-center mb-6 md:mb-8 mt-3 ml-2 md:ml-4 mr-2 md:mr-4">
    <a href="/products" class="text-[#0f7b99] hover:text-[#0d6b8a] font-semibold text-sm md:text-base transition-colors duration-300">
        SEE ALL
    </a>
    <h2 class="text-xl md:text-4xl lg:text-5xl font-bold text-[#0f7b99] tracking-wide">
        BEST SELLERS
    </h2>
</div>
<div class="w-1/2 py-8 md:py-12 md:m-10 rounded-3xl overflow-hidden" style="background-color: #eb5638;">
    <div class="container mx-auto px-4">
        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
            {{ $slot }}
        </div>
    </div>
</div>