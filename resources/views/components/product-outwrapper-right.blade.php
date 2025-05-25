<div class="my-28 px-6 md:px-12 lg:px-24">
    <!-- Minimalist Section with pointed border accents -->
    <section class="relative bg-white border-l-[6px] border-r-[6px] border-[#ec4899] rounded-[0px_50px_0px_50px] shadow-lg py-20 px-6 md:px-16">
        <div class="max-w-7xl mx-auto">

            <!-- Section Header -->
            <div class="mb-14 text-center">
                <h2 class="text-4xl sm:text-5xl font-extrabold text-[#ec4899] tracking-wide uppercase">
                    Women Section
                </h2>
                <p class="mt-4 text-lg sm:text-xl text-gray-500 font-light max-w-2xl mx-auto">
                    Elegant. Confident. Timeless. Discover our curated collection for modern women.
                </p>
            </div>

            <!-- Product Grid -->
            <div class="grid grid-cols-auto">
                {{ $slot }}
            </div>

        </div>
    </section>
</div>
