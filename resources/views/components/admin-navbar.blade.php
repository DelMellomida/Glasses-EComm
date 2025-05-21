<nav class="bg-[#1f2937] border-b border-gray-700 fixed top-0 left-0 w-full z-[9999] shadow">
    <div class="flex items-center justify-between px-6 py-3">
        <!-- Logo -->
        <a href="{{ route('guest.guest-home') }}" class="flex items-center space-x-3">
            <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Logo" />
            <span class="text-2xl font-semibold text-white">Sarabia Optical</span>
        </a>

        <!-- User Dropdown (Alpine.js for toggle) -->
        <div x-data="{ open: false }" class="relative flex items-center">
          <button @click="open = !open" @keydown.escape="open = false"
              class="flex items-center text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300"
              id="user-menu-button" aria-expanded="false" aria-haspopup="true">
              <span class="sr-only">Open user menu</span>
              <img class="w-8 h-8 rounded-full border-2 border-white" src="{{ Auth::user()->profile_photo_url ?? '/docs/images/people/profile-picture-3.jpg' }}" alt="user photo">
          </button>
          <div x-show="open" @click.away="open = false"
              class="absolute right-0 top-full origin-top-right min-w-[12rem] bg-white rounded-lg shadow-lg py-2 z-50 transition"
              x-cloak>
              <div class="px-4 py-3 border-b border-gray-100">
                  <span class="block text-sm font-semibold text-gray-900">{{ Auth::user()->name ?? 'Admin User' }}</span>
                  <span class="block text-xs text-gray-500 truncate">{{ Auth::user()->email ?? 'admin@email.com' }}</span>
              </div>
              <ul class="py-2">
                  <li>
                      <a href="{{ route('admin.dashboard') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                  </li>
                  <li>
                      <a href="#"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                  </li>
                  <li>
                      <a href="#"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Earnings</a>
                  </li>
                  <li>
                      <form method="POST" action="{{ route('logout') }}">
                          @csrf
                          <button type="submit"
                              class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                              Sign out
                          </button>
                      </form>
                  </li>
              </ul>
          </div>
      </div>
    </div>
</nav>