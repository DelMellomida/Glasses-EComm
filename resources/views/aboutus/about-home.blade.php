@if (auth()->user()) 
    <x-nav-user></x-nav-user>
@else
    <x-nav-guest></x-nav-guest>
@endif

<x-guest-layout>
  <div class="w-full min-h-screen bg-white font-sans text-gray-800">

  <!-- Modern About Us Banner -->
<div class="w-full bg-[#eb5638] h-40 md:h-52 flex items-end justify-center relative text-white text-center">
  <div class="mb-7">
    <p class="text-5xl md:text-7xl font-semibold tracking-wide">About Us</p>
    <p class="text-sm md:text-base mt-1 text-white/90">Trusted Vision Care Since 1906</p>
  </div>
</div>





    <<!-- About Section (Full Width) -->
<div class="w-full bg-white py-6 md:py-7">
  <div class="px-3 md:px-4">
    <h2 class="text-2xl md:text-3xl font-semibold text-center mb-8 text-[#0f7b99]">About Sarabia Optical</h2>

    <div class="text-base md:text-lg font-light leading-relaxed tracking-wide text-justify text-gray-900">
      <p>
        For over a century, <span class="font-medium text-black">Sarabia Optical</span> has been a trusted name in eye care for Filipino families,
        especially our seniors. Since 1906, we’ve remained committed to providing exceptional vision care with compassion and expertise.
        We understand how important your eyesight is as you age, which is why we offer
        <span class="font-medium text-[#eb5638]">gentle, expert care</span> in a warm and professional environment.
      </p>

      <p class="mt-6">
        From comprehensive eye check-ups to high-quality, comfortable eyeglasses and contact lenses, our goal is to help you see clearly
        and live fully. At <span class="font-medium text-black">Sarabia Optical</span>,
        <span class="font-semibold text-[#eb5638]">your comfort, clarity, and confidence come first.</span>
        You can trust us, just like generations before you have.
      </p>
    </div>
  </div>
</div>


    <!-- Optional Footer Band to Match Theme -->
    <div class="w-full h-12 bg-[#eb5638]"></div>

    <x-branches-info></x-branches-info>
  </div>
</x-guest-layout>

<x-footer></x-footer>
