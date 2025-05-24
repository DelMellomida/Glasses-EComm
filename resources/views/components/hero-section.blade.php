<section class="relative bg-blue-100 overflow-hidden py-24">
  <div class="max-w-7xl mx-auto px-6 flex flex-row items-center justify-start gap-[80px] ml-[80px] relative">

    <!-- Text Content -->
    <div class="w-1/3 text-left space-y-6 z-10">
      <p class="text-5xl sm:text-7xl lg:text-8xl font-extrabold text-gray-900 leading-tight tracking-tight">
        See the <span class="text-orange-500 animate-pulse">Difference!</span>
      </p>

      <p class="text-xl text-gray-700 leading-relaxed">
        Elevate your style with eyewear made to impress perfect for every occasion.
      </p>
      <a href="/products"
         class="inline-block bg-[#f04e37] text-white px-10 py-4 rounded-full shadow-lg font-semibold text-lg hover:bg-[#0d6b8a] hover:scale-105 transition-transform duration-300 ease-in-out focus:outline-none focus:ring-4 focus:ring-[#f04e37]/40">
        Buy now
      </a>
    </div>

    <!-- Large image overlapping right -->
    <div class="absolute right-[-100px] top-1/2 -translate-y-1/2 z-0">
      <div class="absolute -top-12 -left-12 w-[500px] h-[500px] bg-[#f04e37]/20 rounded-full blur-3xl z-0"></div>
      <img 
        src="{{ asset('build/assets/Images/sunglasses.png') }}" 
        alt="Stylish sunglasses" 
        class="relative z-10 w-[800px] transform -rotate-12 drop-shadow-2xl motion-safe:hover:scale-105 transition-transform duration-500 ease-in-out"
      >
    </div>

  </div>
</section>
