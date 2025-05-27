<button data-drawer-target="sidebar-multi-level-sidebar" data-drawer-toggle="sidebar-multi-level-sidebar" aria-controls="sidebar-multi-level-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-[#ef476f] rounded-lg sm:hidden hover:bg-[#f8edeb] focus:outline-none focus:ring-2 focus:ring-[#ffd6e0]">
   <span class="sr-only">Open sidebar</span>
   <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
      <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
   </svg>
</button>

<link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>

<aside id="sidebar-multi-level-sidebar" class="fixed top-0 left-0 z-40 w-64 mt-1 h-screen transition-transform -translate-x-full sm:translate-x-0 bg-gradient-to-b from-[#ffe5ec] to-[#b8c6db] border-r border-[#f8edeb]" aria-label="Sidebar">
   <div class="h-full py-4 overflow-y-auto px-1">
      <ul class="space-y-2 font-medium mt-5">
         <!-- Dashboard -->
         <li>
            <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 pl-2 text-[#3d405b] rounded-lg hover:bg-[#f8edeb] group">
               <!-- Home Icon -->
               <svg class="w-5 h-5 text-[#ef476f] group-hover:text-[#118ab2]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M4 10v10a1 1 0 001 1h3m10-11v10a1 1 0 01-1 1h-3m-6 0h6"/>
               </svg>
               <span class="ms-2">Dashboard</span>
            </a>
         </li>

         <!-- Users Dropdown -->
         <li>
            <button type="button" class="flex items-center w-full p-2 pl-2 text-[#3d405b] rounded-lg transition duration-75 group hover:bg-[#f8edeb]" aria-controls="dropdown-users" data-collapse-toggle="dropdown-users">
               <!-- Users Icon -->
               <svg class="w-5 h-5 text-[#ef476f] group-hover:text-[#118ab2]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-4a4 4 0 11-8 0 4 4 0 018 0z"/>
               </svg>
               <span class="flex-1 ms-2 text-left rtl:text-right whitespace-nowrap">Users</span>
               <svg class="w-3 h-3 ms-auto text-[#ffd166]" fill="currentColor" viewBox="0 0 10 6">
                  <path d="M0 0l5 6 5-6H0z"/>
               </svg>
            </button>
            <ul id="dropdown-users" class="hidden py-2 space-y-2">
               <li>
                  <a href="{{ route('user.index') }}" class="flex items-center w-full p-2 pl-8 text-[#3d405b] rounded-lg group hover:bg-[#f8edeb]">
                     <!-- User Icon -->
                     <svg class="w-5 h-5 mr-2 text-[#ffd166]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A4 4 0 0112 15a4 4 0 016.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                     </svg>
                     Regular
                  </a>
               </li>
               <li>
                  <a href="{{ route('admin.index') }}" class="flex items-center w-full p-2 pl-8 text-[#3d405b] rounded-lg group hover:bg-[#f8edeb]">
                     <!-- Shield Check Icon -->
                     <svg class="w-5 h-5 mr-2 text-[#ffd166]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4"/>
                     </svg>
                     Administrator
                  </a>
               </li>
            </ul>
         </li>

         <!-- Inventory Dropdown -->
         <li>
            <button type="button" class="flex items-center w-full p-2 pl-2 text-[#3d405b] rounded-lg transition duration-75 group hover:bg-[#f8edeb]" aria-controls="dropdown-inventory" data-collapse-toggle="dropdown-inventory">
               <!-- Cube Icon -->
               <svg class="w-5 h-5 text-[#ef476f] group-hover:text-[#118ab2]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73z"/>
                  <polyline points="3.27 6.96 12 12.01 20.73 6.96"/>
                  <line x1="12" y1="22.08" x2="12" y2="12"/>
               </svg>
               <span class="flex-1 ms-2 text-left rtl:text-right whitespace-nowrap">Inventory</span>
               <svg class="w-3 h-3 ms-auto text-[#ffd166]" fill="currentColor" viewBox="0 0 10 6">
                  <path d="M0 0l5 6 5-6H0z"/>
               </svg>
            </button>
            <ul id="dropdown-inventory" class="hidden py-2 space-y-2 mt-2">
               <li>
                  <a href="{{ route('products.index') }}" class="flex items-center w-full p-2 pl-8 text-[#3d405b] rounded-lg group hover:bg-[#f8edeb]">
                     <!-- Clipboard List Icon -->
                     <svg class="w-5 h-5 mr-2 text-[#ffd166]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5h6M9 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z"/>
                     </svg>
                     All Products
                  </a>
               </li>
               <li>
                  <a href="{{ route('admin.product.create') }}" class="flex items-center w-full p-2 pl-8 text-[#3d405b] rounded-lg group hover:bg-[#f8edeb]">
                     <!-- Plus Icon -->
                     <svg class="w-5 h-5 mr-2 text-[#ffd166]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                     </svg>
                     Add New Product
                  </a>
               </li>
               <li>
                  <a href="{{ route('category.index') }}" class="flex items-center w-full p-2 pl-8 text-[#3d405b] rounded-lg group hover:bg-[#f8edeb]">
                     <!-- Tag Icon -->
                     <svg class="w-5 h-5 mr-2 text-[#ffd166]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 7a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2V7z"/>
                     </svg>
                     Categories
                  </a>
               </li>
               <li>
                  <a href="#" class="flex items-center w-full p-2 pl-8 text-[#3d405b] rounded-lg group hover:bg-[#f8edeb]">
                     <!-- Chart Bar Icon -->
                     <svg class="w-5 h-5 mr-2 text-[#ffd166]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 17v-6a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v6m4 0v-2a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"/>
                     </svg>
                     Reports
                  </a>
               </li>
               <li>
                  <a href="#" class="flex items-center w-full p-2 pl-8 text-[#3d405b] rounded-lg group hover:bg-[#f8edeb]">
                     <!-- Archive Box Icon -->
                     <svg class="w-5 h-5 mr-2 text-[#ffd166]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v13a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V7"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 3v4H8V3"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16"/>
                     </svg>
                     Product Archive
                  </a>
               </li>
            </ul>
         </li>

         <!-- Transactions Dropdown -->
         <li>
            <button type="button" class="flex items-center w-full p-2 pl-2 text-[#3d405b] rounded-lg transition duration-75 group hover:bg-[#f8edeb]" aria-controls="dropdown-transaction" data-collapse-toggle="dropdown-transaction">
               <!-- Credit Card Icon -->
               <svg class="w-5 h-5 text-[#ef476f] group-hover:text-[#118ab2]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <rect width="20" height="14" x="2" y="5" rx="2" ry="2"/>
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2 10h20"/>
               </svg>
               <span class="flex-1 ms-2 text-left rtl:text-right whitespace-nowrap">Transactions</span>
               <svg class="w-3 h-3 ms-auto text-[#ffd166]" fill="currentColor" viewBox="0 0 10 6">
                  <path d="M0 0l5 6 5-6H0z"/>
               </svg>
            </button>
            <ul id="dropdown-transaction" class="hidden py-2 space-y-2 mt-2">
               <li>
                  <a href="{{ route('all-transaction.index') }}" class="flex items-center w-full p-2 pl-8 text-[#3d405b] rounded-lg group hover:bg-[#f8edeb]">
                     <!-- List Icon -->
                     <svg class="w-5 h-5 mr-2 text-[#ffd166]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                     </svg>
                     All Transaction
                  </a>
               </li>
               <li>
                  <a href="{{ route('failed-transaction.index') }}" class="flex items-center w-full p-2 pl-8 text-[#3d405b] rounded-lg group hover:bg-[#f8edeb]">
                     <!-- X Circle Icon -->
                     <svg class="w-5 h-5 mr-2 text-[#ffd166]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 9l-6 6m0-6l6 6"/>
                     </svg>
                     Failed Transaction
                  </a>
               </li>
               <li>
                  <a href="{{ route('successful-transaction.index') }}" class="flex items-center w-full p-2 pl-8 text-[#3d405b] rounded-lg group hover:bg-[#f8edeb]">
                     <!-- Check Circle Icon -->
                     <svg class="w-5 h-5 mr-2 text-[#ffd166]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2l4-4"/>
                     </svg>
                     Successful Transaction
                  </a>
               </li>
            </ul>
         </li>

         <!-- Statistics & Graphs -->
         <li>
            <a href="{{ route('admin.statistics') }}" class="flex items-center p-2 pl-2 text-[#3d405b] rounded-lg hover:bg-[#f8edeb] group">
               <!-- Chart Pie Icon -->
               <svg class="w-5 h-5 text-[#ef476f] group-hover:text-[#118ab2]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9 9 0 1021 12h-9V3.055z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
               </svg>
               <span class="ms-2">Statistics & Graphs</span>
            </a>
         </li>

         <!-- Event Log -->
         <li>
            <a href="{{ route('admin.event-logs') }}" class="flex items-center p-2 pl-2 text-[#3d405b] rounded-lg hover:bg-[#f8edeb] group">
               <!-- Clipboard Icon -->
               <svg class="w-5 h-5 text-[#ef476f] group-hover:text-[#118ab2]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <rect width="16" height="20" x="4" y="2" rx="2" ry="2"/>
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 2v4h6V2"/>
               </svg>
               <span class="ms-2">Event Log</span>
            </a>
         </li>

         <!-- Settings -->
         <li>
            <a href="#" class="flex items-center p-2 pl-2 text-[#3d405b] rounded-lg hover:bg-[#f8edeb] group">
               <!-- Cog Icon -->
               <svg class="w-5 h-5 text-[#ef476f] group-hover:text-[#118ab2]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0a1.724 1.724 0 002.573 1.01c.797-.46 1.757.38 1.297 1.176a1.724 1.724 0 001.01 2.573c.921.3.921 1.603 0 1.902a1.724 1.724 0 00-1.01 2.573c.46.797-.38 1.757-1.176 1.297a1.724 1.724 0 00-2.573 1.01c-.3.921-1.603.921-1.902 0a1.724 1.724 0 00-2.573-1.01c-.797.46-1.757-.38-1.297-1.176a1.724 1.724 0 00-1.01-2.573c-.921-.3-.921-1.603 0-1.902a1.724 1.724 0 001.01-2.573c-.46-.797.38-1.757 1.176-1.297a1.724 1.724 0 002.573-1.01z"/>
                  <circle cx="12" cy="12" r="3"/>
               </svg>
               <span class="ms-2">Settings</span>
            </a>
         </li>

         <!-- Logout -->
         <li>
            <a href="#" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
               class="flex items-center p-2 pl-2 text-[#3d405b] rounded-lg hover:bg-[#f8edeb] group">
               
               <!-- Logout Icon -->
               <svg class="w-5 h-5 text-[#ef476f] group-hover:text-[#118ab2]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7"/>
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 12a9 9 0 0118 0"/>
               </svg>

               <!-- Logout Text -->
               <span class="ms-2 text-[#3d405b]">Logout</span>
            </a>

            <!-- Hidden Form -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
               @csrf
            </form>
         </li>
      </ul>
   </div>
</aside>