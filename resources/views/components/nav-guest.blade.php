<nav class="fixed w-full z-20 top-0 start-0 pl-10 pr-6 md:h-auto" style="background-color: #0f7b99;">
  <div class="max-w-full flex items-center justify-start mx-auto pl-1 text-2x"> 

    <!-- Navigation Links -->
    <div class="hidden md:flex">
      <ul class="flex items-center mr-8">
        <li class="px-6">
          <x-nav-link href="/" :active="request()->is('/')" class="text-white hover:text-blue-200 py-1">Home</x-nav-link>
        </li>
        <li class="px-6">
          <x-nav-link href="/products" :active="request()->is('products')" class="text-white hover:text-blue-200 py-1">Products</x-nav-link>
        </li>
        <li class="px-6">
          <x-nav-link href="/about" :active="request()->is('about')" class="text-white hover:text-blue-200 ">About Us</x-nav-link>
        </li>
        <li class="px-6">
          <x-nav-link href="/contact" :active="request()->is('contact')" class="text-white hover:text-blue-200 py-1">Contact</x-nav-link>
        </li>
      </ul>
    </div>

    <!-- Logo Section -->
    <div style="justify-content: center; display: flex; width: 50%; margin-right: 20%;">
      <x-nav-link href="/" :active="request()->is('/')" class="flex items-center">
        <img src="{{ asset('build/assets/Images/Sarabia-logo-white.jpg') }}" class="h-12" alt="Sarabia Logo" />
      </x-nav-link>
    </div>

    <!-- Log In Section -->
    <div class="hidden md:flex md:w-auto md:justify-start md:ml-4">
      <a href="{{ route('login') }}" class="text-white hover:text-blue-200">Log In</a>
    </div>
  </div>    
</nav>