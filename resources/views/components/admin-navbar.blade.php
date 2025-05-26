<nav class="bg-gradient-to-r from-[#ffe5ec] to-[#b8c6db] border-b border-[#f8edeb] fixed top-0 left-0 w-full z-[9999] shadow">
    <div class="flex items-center justify-between px-6 py-3">
        <!-- Logo -->
        <a href="{{ route('guest.guest-home') }}" class="flex items-center space-x-3">
            <img src="{{ asset('build/assets/Images/Sarabia-Logo-Blue-Col.jpg') }}" class="h-8" alt="Logo" />
            <span class="text-2xl font-semibold text-[#3d405b]">Sarabia Optical</span>
        </a>

        <!-- User Dropdown (Alpine.js for toggle) -->
        <div x-data="{ open: false }" class="relative flex items-center">
          <button @click="open = !open" @keydown.escape="open = false"
              class="flex items-center text-sm bg-[#ffd6e0] rounded-full focus:ring-4 focus:ring-[#f8edeb] border-2 border-[#ef476f]"
              id="user-menu-button" aria-expanded="false" aria-haspopup="true">
              <span class="sr-only">Open user menu</span>
              <img class="w-8 h-8 rounded-full border-2 border-[#ffd166]" src="{{ Auth::user()->profile_photo_url ?? '/docs/images/people/profile-picture-3.jpg' }}" alt="user photo">
          </button>
          <div x-show="open" @click.away="open = false"
              class="absolute right-0 top-full origin-top-right min-w-[12rem] bg-[#fff1f1] rounded-lg shadow-lg py-2 z-50 transition border border-[#ffd6e0]"
              x-cloak>
              <div class="px-4 py-3 border-b border-[#ffd6e0]">
                  <span class="block text-sm font-semibold text-[#3d405b]">{{ Auth::user()->name ?? 'Admin User' }}</span>
                  <span class="block text-xs text-[#ef476f] truncate">{{ Auth::user()->email ?? 'admin@email.com' }}</span>
              </div>
              <ul class="py-2">
                  <li>
                      <a href="{{ route('admin.dashboard') }}"
                        class="block px-4 py-2 text-sm text-[#3d405b] hover:bg-[#ffd6e0]">Dashboard</a>
                  </li>
                  <li>
                      <a href="#"
                        class="block px-4 py-2 text-sm text-[#3d405b] hover:bg-[#ffd6e0]">Settings</a>
                  </li>
                  <li>
                      <a href="#"
                        class="block px-4 py-2 text-sm text-[#3d405b] hover:bg-[#ffd6e0]">Earnings</a>
                  </li>
                  <li>
                      <form method="POST" action="{{ route('logout') }}">
                          @csrf
                          <button type="submit"
                              class="w-full text-left px-4 py-2 text-sm text-[#ef476f] hover:bg-[#ffd6e0]">
                              Sign out
                          </button>
                      </form>
                  </li>
              </ul>
          </div>
      </div>
    </div>
</nav>