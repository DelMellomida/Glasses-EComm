@if (auth()->user())
        <x-nav-user></x-nav-user>
    @else
    <x-nav-guest></x-nav-guest>
    @endif
<x-guest-layout>
<div class= 'flex flex-col max-w-full md:w-full bg-black-100 text-white mb-1 md:pt-16' >
    <div class="flex flex-col items-center justify-center w-full md:h-20 font-extrabold " style="background-color: #701218">
        <h1 class="text-2xl ">About Us</h1>
    </div>
    <div class="flex flex-col items-center justify-center w-full md:p-20" style="background-color:rgb(28, 13, 14)">
        <div class="flex flex-col items-center justify-center w-full md:h-1/2">
            <p class="text-lg md:text-xl text-center mt-4">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed interdum tempus arcu, sit amet rhoncus libero tincidunt vel. In finibus egestas odio. Aliquam cursus non ante in porttitor. Nam accumsan nisi a congue efficitur. 
            Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Curabitur sed libero ut lectus mollis auctor. Morbi suscipit elit at cursus blandit. Pellentesque massa libero, fermentum non tellus sit amet,
            bibendum rhoncus urna. In eu risus aliquam, tincidunt erat at, ultricies velit.</p>
        </div>
    </div>
    <div class="flex flex-col items-center justify-center w-full md:h-20" style="background-color: #701218"></div>
    <x-branches-info></x-branches-info>
</div>
</x-guest-layout>
<x-footer></x-footer>