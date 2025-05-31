<nav class="fixed w-full h-20 z-20 top-0 start-0" style="background-color: #0f7b99;" x-data="{ open: false }">
  <div class="max-w-full flex items-center mx-auto p-4"> 
    <!-- Logo on the left -->
    <div class="flex-shrink-0">
      <a href="/" :active="request()->is('/')" class="flex items-center">
        <img src="{{ asset('build/assets/Images/Sarabia-logo-white.jpg') }}" class="h-12" alt="Sarabia Logo" />
      </a>
    </div>
    
    <!-- Spacer that pushes everything else to the right -->
    <div class="flex-grow"></div>
    
    <!-- Navigation links on the right (hidden on small screens) -->
    <div class="hidden sm:flex items-center">
      <ul class="flex items-center mr-4">
        <li class="px-3">
          <x-nav-link href="/" :active="request()->is('/')" class="text-white hover:text-blue-200 py-1">Home</x-nav-link>
        </li>
        <li class="px-3">
          <x-nav-link href="/products" :active="request()->is('products')" class="text-white hover:text-blue-200 py-1">Products</x-nav-link>
        </li>
        <li class="px-3">
          <x-nav-link href="{{ route('about-us') }}" :active="request()->is('about')" class="text-white hover:text-blue-200 py-1">About Us</x-nav-link>
        </li>
        <li class="px-3">
          <x-nav-link href="{{ route('contacts') }}" :active="request()->is('contact')" class="text-white hover:text-blue-200 py-1">Contact</x-nav-link>
        </li>
      </ul>

      @if(auth()->user())
        <div class="flex items-center space-x-4 mr-4"> 
          <x-nav-link href="{{ route('appointments.index') }}" :active="request()->is('calendar')" class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white hover:text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 4h10M5 11h14M5 19h14M5 15h14M5 11V9a2 2 0 012-2h10a2 2 0 012 2v2M5 19v2a2 2 0 002 2h10a2 2 0 002-2v-2" />
            </svg>
          </x-nav-link>

          <x-nav-link href="{{ route('cart-home') }}" :active="request()->is('cart')" class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white hover:text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l1.4-7H6.4M7 13l-1.4 7M7 13h10m0 0l1.4 7M7 20a1 1 0 100-2 1 1 0 000 2zm10 0a1 1 0 100-2 1 1 0 000 2z" />
            </svg>
          </x-nav-link>
        </div>
      @endif
    </div>

    <!-- Burger Menu Button (always visible on small screens) -->
    <div class="relative">
      @if(auth()->user())
        <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-blue-200 focus:outline-none transition duration-150 ease-in-out sm:hidden">
          <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      @else
        <div class="flex flex-grow justify-end">
          <x-nav-link href="{{ route('login') }}" class="text-white hover:text-blue-200 px-4 py-1">Log In</x-nav-link>
        </div>
      @endif

      <!-- Account Menu Dropdown & Main Links for Mobile -->
      <div :class="{'block': open, 'hidden': ! open}" class="absolute right-0 mt-2 w-56 rounded-md shadow-lg py-1 bg-white z-50 sm:w-48">
        @auth
          <!-- Main navigation links (shown only on mobile) -->
          <div class="block sm:hidden">
            <x-dropdown-link href="/">
              Home
            </x-dropdown-link>
            <x-dropdown-link href="/products">
              Products
            </x-dropdown-link>
            <x-dropdown-link href="{{ route('about-us') }}">
              About Us
            </x-dropdown-link>
            <x-dropdown-link href="{{ route('contacts') }}">
              Contact
            </x-dropdown-link>
            <x-dropdown-link href="{{ route('appointments.index') }}">
              Appointments
            </x-dropdown-link>
            <x-dropdown-link href="{{ route('cart-home') }}">
              Cart
            </x-dropdown-link>
          </div>
          <div class="px-4 py-2 text-xs text-gray-400 border-t border-gray-200 mt-2">
            {{ __('Manage Account') }}
          </div>
          <x-dropdown-link href="{{ route('order.history') }}">
            {{ __('Order History') }}
          </x-dropdown-link>
          <x-dropdown-link href="{{ route('profile.show') }}">
            {{ __('Profile') }}
          </x-dropdown-link>
          @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
            <x-dropdown-link href="{{ route('api-tokens.index') }}">
              {{ __('API Tokens') }}
            </x-dropdown-link>
          @endif

          <div class="border-t border-gray-200"></div>

          <!-- Team Management -->
          @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
            <div class="block px-4 py-2 text-xs text-gray-400">
              {{ __('Manage Team') }}
            </div>
            <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
              {{ __('Team Settings') }}
            </x-dropdown-link>
            @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
              <x-dropdown-link href="{{ route('teams.create') }}">
                {{ __('Create New Team') }}
              </x-dropdown-link>
            @endcan
            <div class="border-t border-gray-200"></div>
            <div class="block px-4 py-2 text-xs text-gray-400">
              {{ __('Switch Teams') }}
            </div>
            @foreach (Auth::user()->allTeams() as $team)
              <x-switchable-team :team="$team" />
            @endforeach
          @endif

          <div class="border-t border-gray-200"></div>
          <!-- Authentication -->
          <form method="POST" action="{{ route('logout') }}" x-data>
            @csrf
            <x-dropdown-link href="{{ route('logout') }}"
                    @click.prevent="$root.submit();">
              {{ __('Log Out') }}
            </x-dropdown-link>
          </form>
        @else
          <x-dropdown-link href="{{ route('login') }}">
            {{ __('Log in') }}
          </x-dropdown-link>
          <x-dropdown-link href="{{ route('register') }}">
            {{ __('Register') }}
          </x-dropdown-link>
        @endauth
      </div>
    </div>
  </div>
</nav>