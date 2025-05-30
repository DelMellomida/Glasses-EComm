<div class="max-w-7xl mx-auto px-6 py-16 bg-gradient-to-b from-white via-gray-50 to-white" x-data="branchesCarousel()">
<p class="text-5xl font-extrabold text-center mb-14 tracking-wide"
   style="color: #0f7b99; line-height: 1.2;">
  R. SARABIA OPTICAL BRANCHES
</p>




  <div class="relative">
    <!-- Prev Button -->
    <button
      class="scroll-button absolute left-0 top-1/2 transform -translate-y-1/2 z-30 shadow-lg"
      @click="prev"
      x-show="canGoPrev"
      aria-label="Previous"
      x-transition
      style="will-change: transform;"
    >
      &#10094;
    </button>

    <!-- Next Button -->
    <button
      class="scroll-button absolute right-0 top-1/2 transform -translate-y-1/2 z-30 shadow-lg"
      @click="next"
      x-show="canGoNext"
      aria-label="Next"
      x-transition
      style="will-change: transform;"
    >
      &#10095;
    </button>

    <!-- Branches Carousel -->
    <div class="flex space-x-8 overflow-hidden">
      <template x-for="(branch, index) in visibleBranches" :key="index">
        <div
          class="flex-none w-80 bg-white rounded-3xl shadow-lg p-6 cursor-pointer transition-all duration-300 ease-in-out hover:shadow-2xl hover:border-2 hover:border-[#eb5638] hover:scale-[1.05]"
          x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 translate-x-4"
          x-transition:enter-end="opacity-100 translate-x-0"
          x-transition:leave="transition ease-in duration-300"
          x-transition:leave-start="opacity-100 translate-x-0"
          x-transition:leave-end="opacity-0 -translate-x-4"
          @mouseenter="$el.style.zIndex = 40"
          @mouseleave="$el.style.zIndex = 10"
        >
          <div class="overflow-hidden rounded-2xl shadow-inner">
            <img
              :src="branch.image"
              :alt="branch.name + ' Image'"
              class="w-full h-52 object-cover"
              loading="lazy"
              decoding="async"
            />
          </div>
          <h3
            class="mt-4 text-2xl font-bold"
            style="color: #0f7b99;"
            x-text="branch.name"
          ></h3>
          <p class="text-gray-700 mt-2 leading-relaxed text-sm"><span class="font-semibold">Address:</span> <span x-text="branch.address"></span></p>
          <p class="text-gray-700 mt-1 text-sm"><span class="font-semibold">Tel. No.:</span> <span x-text="branch.tel"></span></p>
          <p class="text-gray-700 mt-1 text-sm"><span class="font-semibold">Mobile No.:</span> <span x-text="branch.mobile"></span></p>
          <a
            href="#"
            class="inline-block mt-5 px-6 py-2 bg-[#eb5638] text-white font-semibold rounded-full shadow-md hover:bg-[#d13e2b] transition-colors duration-300"
          >
            Book an Appointment
          </a>
        </div>
      </template>
    </div>
  </div>
</div>

<script src="//unpkg.com/alpinejs" defer></script>
<script>
  function branchesCarousel() {
    return {
      branches: [
        {
          name: 'Sta. Elena Branch',
          address: '#187 Shoe. Ave. Brgy. Sta Elena, Marikina City',
          tel: '027956-6679',
          mobile: '09269060613',
          image: '{{ asset("images/sta-elena.jpg") }}',
        },
        {
          name: 'Phil. Trust Branch',
          address: '#23 Phil. Trust Bank Bldg. Sumulong Hi-way cor. P. Burgos St. Brgy. Sto. Nino, Marikina City',
          tel: '027949-0061',
          mobile: '09550618296',
          image: '{{ asset("images/philtrust.jpg") }}',
        },
        {
          name: 'Pasig Branch',
          address: '#34-A Mabini St. Brgy. Kapasigan, Pasig City',
          tel: '027002-2998',
          mobile: '09269060760',
          image: '{{ asset("images/pasig.jpg") }}',
        },
        {
          name: 'Masinag Branch',
          address: '#272 Sumulong Hi-way Brgy. Mayamot, Antipolo City',
          tel: '088470-8822',
          mobile: '09269060726',
          image: '{{ asset("images/masinag.jpg") }}',
        },
        {
          name: 'SM Center Downtown Antipolo',
          address: '2nd floor SM Center Downtown Antipolo, Marcos Hi-way Brgy. Mayamot, Antipolo City',
          tel: '028330-7791',
          mobile: '09338680057',
          image: '{{ asset("images/sm-downtown.jpg") }}',
        },
      ],
      currentIndex: 0,
      itemsToShow: 3,

      get visibleBranches() {
        return this.branches.slice(this.currentIndex, this.currentIndex + this.itemsToShow);
      },
      get canGoPrev() {
        return this.currentIndex > 0;
      },
      get canGoNext() {
        return this.currentIndex + this.itemsToShow < this.branches.length;
      },
      next() {
        if (this.canGoNext) this.currentIndex++;
      },
      prev() {
        if (this.canGoPrev) this.currentIndex--;
      },
    };
  }
</script>

<style>
  .scroll-button {
    background-color: #eb5638;
    color: white;
    border: none;
    padding: 0.75rem 1.25rem;
    border-radius: 9999px;
    font-size: 2rem;
    line-height: 1;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease;
    user-select: none;
    box-shadow: 0 3px 8px rgb(235 86 56 / 0.6);
  }
  .scroll-button:hover {
    background-color: #d13e2b;
    transform: scale(1.1);
  }
</style>
