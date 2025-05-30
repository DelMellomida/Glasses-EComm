<section class="bg-white w-full py-20 px-6" x-data="carousel()">
  <div class="mx-auto max-w-7xl">
    <p class="text-7xl font-black text-gray-800 mb-10">
      Featured <span class="text-[#f04e37]">Product</span>
    </p>

    <div class="relative">
      <!-- Buttons -->
      <button
        class="scroll-button absolute left-0 top-1/2 transform -translate-y-1/2 z-10"
        @click="prev"
        x-show="canGoPrev"
        aria-label="Previous"
      >&#10094;</button>

      <button
        class="scroll-button absolute right-0 top-1/2 transform -translate-y-1/2 z-10"
        @click="next"
        x-show="canGoNext"
        aria-label="Next"
      >&#10095;</button>

      <!-- Product Display Area -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <template x-for="(product, index) in visibleProducts" :key="index">
          <div class="group border border-transparent rounded-xl overflow-hidden shadow-md hover:shadow-xl hover:border-[#f04e37] transition duration-300 ease-in-out bg-white transform hover:scale-[1.03]">
            <div class="flex flex-col h-full">
              <img
                :src="product.image"
                :alt="product.name"
                class="w-full h-48 object-cover bg-gray-100 group-hover:opacity-90"
              />
              <div class="mt-4 px-6 pb-6 flex flex-col justify-between flex-grow">
                <div>
                  <h3 class="text-lg font-semibold text-gray-800 group-hover:text-[#f04e37] transition-colors">
                    <a href="#" x-text="product.name"></a>
                  </h3>
                  <p class="mt-1 text-sm text-gray-500" x-text="product.frame"></p>
                </div>
                <p class="mt-4 text-xl font-bold text-gray-900">P<span x-text="product.price.toFixed(2)"></span></p>
              </div>
            </div>
          </div>
        </template>
      </div>
    </div>
  </div>
</section>

<!-- Alpine Carousel Script -->
<script src="//unpkg.com/alpinejs" defer></script>
<script>
  function carousel() {
    return {
      products: [
        { name: 'Classic Sunglasses', frame: 'Black Frame', price: 99, image: '{{ asset("build/assets/images/sunglasses.png") }}' },
        { name: 'Modern Eyeglasses', frame: 'Brown Frame', price: 120, image: '{{ asset("build/assets/images/sunglasses.png") }}' },
        { name: 'Retro Glasses', frame: 'Tortoise Shell', price: 110, image: '{{ asset("build/assets/images/sunglasses.png") }}' },
        { name: 'Aviator Sunglasses', frame: 'Gold Frame', price: 130, image: '{{ asset("build/assets/images/sunglasses.png") }}' },
        { name: 'Sporty Shades', frame: 'Silver Frame', price: 115, image: '{{ asset("build/assets/images/sunglasses.png") }}' },
        { name: 'Round Eyewear', frame: 'Matte Black', price: 105, image: '{{ asset("build/assets/images/sunglasses.png") }}' }
      ],
      currentIndex: 0,
      itemsToShow: 3,

      get visibleProducts() {
        return this.products.slice(this.currentIndex, this.currentIndex + this.itemsToShow);
      },
      get canGoPrev() {
        return this.currentIndex > 0;
      },
      get canGoNext() {
        return this.currentIndex + this.itemsToShow < this.products.length;
      },
      next() {
        if (this.canGoNext) this.currentIndex++;
      },
      prev() {
        if (this.canGoPrev) this.currentIndex--;
      }
    };
  }
</script>

<style>
  .scroll-button {
    background-color: #f04e37;
    color: white;
    border: none;
    padding: 0.5rem 0.75rem;
    border-radius: 9999px;
    font-size: 1.25rem;
    line-height: 1;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  .scroll-button:hover {
    background-color: #d13e2b;
  }
</style>
