<!-- Outer Wrapper -->
<div class="my-20 px-6 md:px-12">

    <!-- Orange Background Section -->
    <section class="bg-[#eb5638] rounded-3xl py-16 md:py-20 px-6 md:px-12 shadow-xl overflow-hidden relative">
        <div class="max-w-7xl mx-auto">

        <div class="flex justify-between items-center mb-10 -mt-5">
        <h2 class="font-extrabold text-white tracking-tight" style="font-size: 70px; line-height: 1;">
            NEW ARRIVALS
        </h2>

  <a href="/products"
     class="font-semibold text-sm md:text-base px-5 py-2 rounded-full border border-white backdrop-blur-md transition-all duration-300 ease-in-out"
     style="color: white; background-color: transparent; border-color: white;"
     onmouseover="this.style.color='#eb5638'; this.style.backgroundColor='white';"
     onmouseout="this.style.color='white'; this.style.backgroundColor='transparent';"
     onfocus="this.style.color='#eb5638'; this.style.backgroundColor='white';"
     onblur="this.style.color='white'; this.style.backgroundColor='transparent';"
     onmousedown="this.style.color='#eb5638'; this.style.backgroundColor='white';"
     onmouseup="this.style.color='#eb5638'; this.style.backgroundColor='white';"
  >
    SEE ALL
  </a>
</div>



            <!-- Product Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                {{ $slot }}
            </div>

        </div>
    </section>

</div>
