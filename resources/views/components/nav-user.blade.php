<nav class="fixed w-full z-20 top-0 start-0" style="background-color: #0f7b99; ">
  <div class="max-w-full flex items-center justify-between mx-auto md:pl-1 "> 

    <div style="justify-content: left; display: flex; margin-left: 2rem; margin-right: 1rem;">
      <x-nav-link href="/" :active="request()->is('/')" class="flex items-center">
        <img src="{{ asset('build/assets/Images/Sarabia-logo-white.jpg') }}" class="h-12" alt="Sarabia Logo" />
      </x-nav-link>
    </div>

    <div class="hidden md:flex md:w-auto md:justify-start md:ml-auto "> 
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

      <div class="hidden md:flex md:w-auto md:justify-end "> <!-- kayo na bahala sa mga icons gamit kayo svg -->
        <x-nav-link href="/" :active="request()->is('/')" class="flex items-center">
                <img src="{{ asset('/') }}" class="h-12" alt="Calendar?" />
        </x-nav-link>
        <x-nav-link href="/" :active="request()->is('/')" class="flex items-center">
                <img src="{{ asset('/') }}" class="h-12" alt="Cart" />
        </x-nav-link>
        
        <!-- complicated ng dropdown mo jhondel tinanggal ko akin--> 
    </div>
    </div>

    

</nav>