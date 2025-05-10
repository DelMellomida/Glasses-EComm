<nav class="fixed w-full z-20 top-0 start-0" style="background-color: #0f7b99; padding-left: 3rem;">
  <div class="max-w-full flex items-center justify-start mx-auto pl-1 text-2x"> 

    <div class="hidden md:flex md:w-auto md:justify-start md:ml-4"> 
      <ul class="flex flex-row font-medium space-x-8 rtl:space-x-reverse">
        <li>
          <x-nav-link href="/" :active="request()->is('/')" class="text-white bg-blue-700 rounded-sm md:bg-transparent md:text-blue-700 md:dark:text-blue-500" aria-current="page">Home</x-nav-link>
        </li>
        <li>
          <x-nav-link href="/" :active="request()->is('/')" class="text-gray-900 hover:text-blue-700 dark:text-white dark:hover:text-blue-500">Products</x-nav-link>
        </li>
        <li>
          <x-nav-link href="/" :active="request()->is('/')" class="text-gray-900 hover:text-blue-700 dark:text-white dark:hover:text-blue-500">About Us</x-nav-link>
        </li>
        <li>
          <x-nav-link href="/" :active="request()->is('/')" class="text-gray-900 hover:text-blue-700 dark:text-white dark:hover:text-blue-500">Contact</x-nav-link>
        </li>
      </ul>
    </div>

    <div style="justify-content: center; display: flex; width: 50%; margin-right: 20%;">
      <x-nav-link href="/" :active="request()->is('/')" class="flex items-center">
        <img src="{{ asset('build/assets/Images/Sarabia-logo-white.jpg') }}" class="h-12" alt="Sarabia Logo" />
      </x-nav-link>
    </div>

    <div class="hidden md:flex md:w-auto md:justify-start md:ml-4">
      <x-nav-link href="/" :active="request()->is('/')" class="text-gray-900 hover:text-blue-700 dark:text-white dark:hover:text-blue-500">Log In</x-nav-link>
    </div>
  </div>    
</nav>