<nav class="bg-[#055970] border-b border-[#f8edeb] fixed top-0 left-0 w-full z-[9999] shadow">
    <div class="flex items-center justify-between px-6 py-3">
        <!-- Logo -->
        <a href="{{ route('guest.guest-home') }}" class="flex items-center space-x-3">
            <img src="{{ asset('build/assets/Images/Sarabia-Logo-Blue-Col.jpg') }}" class="h-8" alt="Logo" />
            <span class="text-2xl font-semibold text-[#ffffff]">SARABIA OPTICAL</span>
        </a>

        <!-- Hamburger for mobile -->
        <div class="flex items-center md:hidden" x-data="{ open: false }">
            <button @click="open = !open" class="p-2 rounded focus:outline-none focus:ring-2 focus:ring-[#ffd6e0]">
                <svg class="w-6 h-6 text-[#ffffff]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <!-- Mobile menu dropdown -->
            <div x-show="open" @click.away="open = false" class="absolute top-16 right-4 w-56 bg-white rounded shadow-lg z-50 border border-[#ffd6e0]">
                <ul class="py-2">
                    <li><a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-[#3d405b] hover:bg-[#055970]">Dashboard</a></li>
                    <li><a href="{{ route('user.index') }}" class="block px-4 py-2 text-[#3d405b] hover:bg-[#055970]">Users</a></li>
                    <li><a href="{{ route('admin.index') }}" class="block px-4 py-2 text-[#3d405b] hover:bg-[#055970]">Administrators</a></li>
                    <li><a href="{{ route('products.index') }}" class="block px-4 py-2 text-[#3d405b] hover:bg-[#055970]">All Products</a></li>
                    <li><a href="{{ route('admin.product.create') }}" class="block px-4 py-2 text-[#3d405b] hover:bg-[#055970]">Add Product</a></li>
                    <li><a href="{{ route('category.index') }}" class="block px-4 py-2 text-[#3d405b] hover:bg-[#055970]">Categories</a></li>
                    <li><a href="{{ route('all-transaction.index') }}" class="block px-4 py-2 text-[#3d405b] hover:bg-[#055970]">All Transactions</a></li>
                    <li><a href="{{ route('failed-transaction.index') }}" class="block px-4 py-2 text-[#3d405b] hover:bg-[#055970]">Failed Transactions</a></li>
                    <li><a href="{{ route('successful-transaction.index') }}" class="block px-4 py-2 text-[#3d405b] hover:bg-[#055970]">Successful Transactions</a></li>
                    <li><a href="{{ route('admin.statistics') }}" class="block px-4 py-2 text-[#3d405b] hover:bg-[#055970]">Statistics & Graphs</a></li>
                    <li><a href="{{ route('admin.event-logs') }}" class="block px-4 py-2 text-[#3d405b] hover:bg-[#055970]">Event Log</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-[#ef476f] hover:bg-[#055970]">Sign out</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

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
                  <span class="block text-xs text-[#055970] truncate">{{ Auth::user()->email ?? 'admin@email.com' }}</span>
              </div>
              <ul class="py-2">
                  <li>
                      <a href="{{ route('admin.dashboard') }}"
                        class="block px-4 py-2 text-sm text-[#3d405b] group-hover:text-[#ffffff] hover:bg-[#055970]">Dashboard</a>
                  </li>
                  <li>
                      <a href="#"
                        class="block px-4 py-2 text-sm text-[#3d405b] group-hover:text-[#ffffff] hover:bg-[#055970]">Settings</a>
                  </li>
                  <li>
                      <a href="#"
                        class="block px-4 py-2 text-sm text-[#3d405b] group-hover:text-[#ffffff] hover:bg-[#055970]">Earnings</a>
                  </li>
                  <li>
                      <form method="POST" action="{{ route('logout') }}">
                          @csrf
                          <button type="submit"
                              class="w-full text-left px-4 py-2 text-sm text-[#ef476f] group-hover:text-[#ffffff] hover:bg-[#055970]">
                              Sign out
                          </button>
                      </form>
                  </li>
              </ul>
          </div>
      </div>
    </div>
</nav>