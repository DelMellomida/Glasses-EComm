<style>
  /* Custom scrollbar for horizontal scrolling */
  .custom-scrollbar::-webkit-scrollbar {
    height: 10px;
  }

  .custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
  }

  .custom-scrollbar::-webkit-scrollbar-thumb {
    background: #f04e37;
    border-radius: 10px;
  }

  .custom-scrollbar {
    scrollbar-color: #f04e37 #f1f1f1;
    scrollbar-width: thin;
  }
</style>

<section class="bg-white w-full py-20 px-6">
  <div class="mx-auto max-w-7xl">
    <h2 class="text-4xl font-extrabold text-gray-800 mb-8">
      Featured <span class="text-[#f04e37]">Products</span>
    </h2>

    <!-- Horizontal scrollable product list -->
    <div class="flex flex-row gap-6 overflow-x-auto overflow-y-hidden custom-scrollbar pb-4">

      <!-- Repeat this block for each product -->
      @foreach ([
        ['name' => 'Classic Sunglasses', 'frame' => 'Black Frame', 'price' => '99'],
        ['name' => 'Modern Eyeglasses', 'frame' => 'Brown Frame', 'price' => '120'],
        ['name' => 'Retro Glasses', 'frame' => 'Tortoise Shell', 'price' => '110'],
        ['name' => 'Aviator Sunglasses', 'frame' => 'Gold Frame', 'price' => '130'],
        ['name' => 'Sporty Shades', 'frame' => 'Silver Frame', 'price' => '115'],
        ['name' => 'Round Eyewear', 'frame' => 'Matte Black', 'price' => '105']
      ] as $product)
      <div class="group flex-shrink-0 w-64 border border-transparent rounded-xl overflow-hidden shadow-md hover:shadow-xl hover:border-[#f04e37] transition duration-300 ease-in-out bg-white transform hover:scale-[1.03]">
        <div class="flex flex-col h-full">
          <img
            src="{{ asset('build/assets/images/sunglasses.png') }}"
            alt="{{ $product['name'] }}"
            class="w-full h-48 object-cover bg-gray-100 group-hover:opacity-90"
          />
          <div class="mt-4 px-6 pb-6 flex flex-col justify-between flex-grow">
            <div>
              <h3 class="text-lg font-semibold text-gray-800 group-hover:text-[#f04e37] transition-colors">
                <a href="#">{{ $product['name'] }}</a>
              </h3>
              <p class="mt-1 text-sm text-gray-500">{{ $product['frame'] }}</p>
            </div>
            <p class="mt-4 text-xl font-bold text-gray-900">{{ $product['price'] }}</p>
          </div>
        </div>
      </div>
      @endforeach

    </div>
  </div>
</section>
