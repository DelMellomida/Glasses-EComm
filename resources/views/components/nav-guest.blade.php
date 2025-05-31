<nav class="fixed w-full z-50 top-0 start-0 bg-[#0f7b99] bg-opacity-100" x-data="{ open: false }">
  <div class="max-w-full flex items-center mx-auto px-4 py-2">
    <!-- Burger button (shown on small screens) -->
    <div class="sm:hidden flex items-center">
      <button @click="open = !open" class="text-white focus:outline-none">
        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
          <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
    </div>

    <!-- Navigation links (hidden on small screens) -->
    <div class="hidden sm:flex items-center">
      <ul class="flex items-center space-x-2">
        <li>
          <x-nav-link href="/" :active="request()->is('/')" class="text-white hover:text-blue-200 px-4 py-1">Home</x-nav-link>
        </li>
        <li>
          <x-nav-link href="/products" :active="request()->is('products')" class="text-white hover:text-blue-200 px-4 py-1">Products</x-nav-link>
        </li>
        <li>
          <x-nav-link href="{{ route('about-us') }}" :active="request()->is('about')" class="text-white hover:text-blue-200 px-4 py-1">About Us</x-nav-link>
        </li>
        <li>
          <x-nav-link href="{{ route('contacts') }}" :active="request()->is('contact')" class="text-white hover:text-blue-200 px-4 py-1">Contact</x-nav-link>
        </li>
      </ul>
    </div>

    <!-- Centered Logo -->
    <div class="flex flex-grow justify-center">
      <a href="/" :active="request()->is('/')" class="flex items-center">
        <img src="{{ asset('build/assets/Images/Sarabia-logo-white.jpg') }}" class="h-12" alt="Sarabia Logo" />
      </a>
    </div>

    <!-- Login button (always visible, right aligned) -->
    <div class="flex flex-grow justify-end">
      <x-nav-link href="{{ route('login') }}" class="text-white hover:text-blue-200 px-4 py-1">Log In</x-nav-link>
    </div>
  </div>

  <!-- Dropdown menu for burger (only on small screens) -->
  <div x-show="open" @click.away="open = false" class="sm:hidden bg-[#0f7b99] bg-opacity-100 w-full shadow-md">
    <ul class="flex flex-col items-center py-2 space-y-1">
      <li>
        <x-nav-link href="/" :active="request()->is('/')" class="text-white hover:text-blue-200 block px-4 py-2">Home</x-nav-link>
      </li>
      <li>
        <x-nav-link href="/products" :active="request()->is('products')" class="text-white hover:text-blue-200 block px-4 py-2">Products</x-nav-link>
      </li>
      <li>
        <x-nav-link href="{{ route('about-us') }}" :active="request()->is('about')" class="text-white hover:text-blue-200 block px-4 py-2">About Us</x-nav-link>
      </li>
      <li>
        <x-nav-link href="{{ route('contacts') }}" :active="request()->is('contact')" class="text-white hover:text-blue-200 block px-4 py-2">Contact</x-nav-link>
      </li>
      <li>
        <x-nav-link href="{{ route('login') }}" class="text-white hover:text-blue-200 block px-4 py-2">Log In</x-nav-link>
      </li>
    </ul>
  </div>
</nav>