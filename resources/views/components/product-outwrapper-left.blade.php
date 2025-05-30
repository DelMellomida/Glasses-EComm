<div class="my-28 px-6 md:px-12 lg:px-24">
  <!-- Minimalist Section with colored inner vertical bars -->
  <section class="relative bg-white rounded-[0px_50px_0px_50px] shadow-lg py-20 px-6 md:px-16 overflow-hidden">

    <!-- Left colored bar -->
    <div class="absolute top-0 left-0 w-6 h-full bg-[#29B6F6] rounded-tr-[50px] rounded-br-[50px]"></div>

    <!-- Right colored bar -->
    <div class="absolute top-0 right-0 w-6 h-full bg-[#29B6F6] rounded-tl-[50px] rounded-bl-[50px]"></div>

    <div class="max-w-7xl mx-auto relative z-10">
      <!-- Section Header -->
      <div class="mb-14 text-center">
        <h2 class="text-4xl sm:text-5xl font-extrabold text-[#81D4FA] tracking-wide uppercase">
          Mens Section
        </h2>
        <p class="mt-4 text-lg sm:text-xl text-gray-500 font-light max-w-2xl mx-auto">
          A powerful blend of bold design and cool sophistication discover premium eyewear for men.
        </p>
      </div>

      <!-- Product Grid -->
      <div class="grid grid-cols-auto">
        {{ $slot }}
      </div>
    </div>
  </section>
</div>
