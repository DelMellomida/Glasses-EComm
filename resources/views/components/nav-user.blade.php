<nav class="fixed w-full z-20 top-0 start-0" style="background-color: #0f7b99;">
  <div class="max-w-full flex items-center justify-between mx-auto md:pl-1"> 

    <div class="flex items-center ml-8">
      <x-nav-link href="/" :active="request()->is('/')" class="flex items-center">
        <img src="{{ asset('build/assets/Images/Sarabia-logo-white.jpg') }}" class="h-12" alt="Sarabia Logo" />
      </x-nav-link>
    </div>

    <div class="hidden md:flex  "> 
      <ul class="flex flex-row font-medium space-x-8 rtl:space-x-reverse">
        <li>
          <x-nav-link href="/" :active="request()->is('/')" class="text-gray-900 hover:text-blue-700 dark:text-white dark:hover:text-blue-500 ">Home</x-nav-link>
        </li>
        <li>
          <x-nav-link href="/" :active="request()->is('/')" class="text-gray-900 hover:text-blue-700 dark:text-white dark:hover:text-blue-500 ">Products</x-nav-link>
        </li>
        <li>
          <x-nav-link href="/" :active="request()->is('/')" class="text-gray-900 hover:text-blue-700 dark:text-white dark:hover:text-blue-500">About Us</x-nav-link>
        </li>
        <li>
          <x-nav-link href="/" :active="request()->is('/')" class="text-gray-900 hover:text-blue-700 dark:text-white dark:hover:text-blue-500">Contact</x-nav-link>
        </li>
      </ul>

      <div class="hidden md:flex md:w-auto md:justify-end"> 
        <x-nav-link href="/" :active="request()->is('/')" class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700 hover:text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 4h10M5 11h14M5 19h14M5 15h14M5 11V9a2 2 0 012-2h10a2 2 0 012 2v2M5 19v2a2 2 0 002 2h10a2 2 0 002-2v-2" />
            </svg>
        </x-nav-link>

        <x-nav-link href="/" :active="request()->is('/')" class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700 hover:text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l1.4-7H6.4M7 13l-1.4 7M7 13h10m0 0l1.4 7M7 20a1 1 0 100-2 1 1 0 000 2zm10 0a1 1 0 100-2 1 1 0 000 2z" />
            </svg>
        </x-nav-link>
    </div>
    </div>

</nav>