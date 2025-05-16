<nav class="fixed w-full z-50 top-0 start-0 bg-[#0f7b99] bg-opacity-100" >
  <div class="max-w-full flex items-center mx-auto px-4 py-2">
    <!-- Left side: Navigation menu -->
    <div class="flex items-center">
      <ul class="flex items-center space-x-2">
        <li>
          <x-nav-link href="/" :active="request()->is('/')" class="text-white hover:text-blue-200 px-4 py-1">Home</x-nav-link>
        </li>
        <li>
          <x-nav-link href="/products" :active="request()->is('products')" class="text-white hover:text-blue-200 px-4 py-1">Products</x-nav-link>
        </li>
        <li>
          <x-nav-link href="/about" :active="request()->is('about')" class="text-white hover:text-blue-200 px-4 py-1">About Us</x-nav-link>
        </li>
        <li>
          <x-nav-link href="/contact" :active="request()->is('contact')" class="text-white hover:text-blue-200 px-4 py-1">Contact</x-nav-link>
        </li>
      </ul>
    </div>

    <!-- Center: Logo -->
    <div class="flex flex-grow justify-center ml-30">
      <a href="/" :active="request()->is('/')" class="flex items-center">
        <img src="{{ asset('build/assets/Images/Sarabia-logo-white.jpg') }}" class="h-12" alt="Sarabia Logo" />
      </a>
    </div>

    <!-- Right side: Login -->
    <div class="flex flex-grow justify-end">
      <x-nav-link href="{{ route('login') }}" class="text-white hover:text-blue-200 px-4 py-1">Log In</x-nav-link>
    </div>
  </div>    
</nav>


</style>