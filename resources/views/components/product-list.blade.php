product-list blade

<div class="w-full bg-gradient-to-r from-[#0f7b99] via-[#145d6d] to-[#0b4a58] rounded-xl p-14 shadow-lg text-white" x-data="carousel()" x-init="init()">
  <div class="max-w-7xl mx-auto text-center relative">
    <h2 class="text-4xl font-extrabold tracking-tight mb-6 drop-shadow-md">New Arrivals</h2>
    <p class="max-w-3xl mx-auto mb-16 text-gray-200/90 text-lg font-light leading-relaxed drop-shadow-sm">
      Discover our latest collection just dropped! Fresh styles that stand out.
    </p>

    <!-- Carousel Wrapper -->
    <div class="overflow-hidden relative">
      <!-- Product Cards Container -->
      <div
        class="flex transition-transform duration-500"
        :style="`transform: translateX(-${currentIndex * 100}%);`"
      >
        <!-- Product Cards -->
        <template x-for="(product, index) in products" :key="index">
          <div class="flex-shrink-0 w-full sm:w-1/2 md:w-1/3 lg:w-1/5 px-6">
            <div
              class="bg-white rounded-lg overflow-hidden shadow-lg transform hover:scale-105 transition-transform duration-300 cursor-pointer flex flex-col h-full"
            >
              <img :src="product.image" :alt="product.name" class="w-full object-cover h-52" />
              <div class="p-6 text-center text-gray-900 flex flex-col flex-grow justify-between">
                <div>
                  <h3 class="font-semibold text-lg tracking-wide mb-2" x-text="product.name"></h3>
                  <p class="text-sm text-gray-600 italic" x-text="product.description"></p>
                </div>
                <p class="mt-6 font-bold text-xl" x-text="`$${product.price}`"></p>
              </div>
            </div>
          </div>
        </template>
      </div>

      <!-- Navigation Arrows -->
      <button
        @click="prev()"
        class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-white/30 hover:bg-white/60 rounded-full p-4 text-gray-800 shadow-lg transition"
        aria-label="Previous"
      >
        &#8592;
      </button>
      <button
        @click="next()"
        class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-white/30 hover:bg-white/60 rounded-full p-4 text-gray-800 shadow-lg transition"
        aria-label="Next"
      >
        &#8594;
      </button>
    </div>
  </div>
</div>


<script>
  function carousel() {
    return {
      currentIndex: 0,
      products: [
        { name: "Retro Glasses", description: "Round Frames", price: 110, image: "/images/Sunglasses.png" },
        { name: "Retro Glasses", description: "Round Frames", price: 110, image: "/images/Sunglasses.png" },
        { name: "Retro Glasses", description: "Round Frames", price: 110, image: "/images/Sunglasses.png" },
        { name: "Retro Glasses", description: "Round Frames", price: 110, image: "/images/Sunglasses.png" },
        { name: "Retro Glasses", description: "Round Frames", price: 110, image: "/images/Sunglasses.png" },
        { name: "Retro Glasses", description: "Round Frames", price: 110, image: "/images/Sunglasses.png" },
      ],
      init() {},
      next() {
        if (this.products.length === 0) return;
        if (this.currentIndex < this.products.length - 1) this.currentIndex++;
      },
      prev() {
        if (this.products.length === 0) return;
        if (this.currentIndex > 0) this.currentIndex--;
      },
    };
  }
  
</script>