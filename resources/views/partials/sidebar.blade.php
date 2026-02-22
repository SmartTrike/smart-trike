<aside id="sidebar-multi-level-sidebar" class="w-64  h-full sm:translate-x-0 fixed top-0 left-0 transition-transform -translate-x-full z-50" :class="{'-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen}">
    <div class="  px-1.5 overflow-y-auto h-full flex flex-col bg-neutral-primary-soft border-r border-gray-200">
        <!-- Close Button for Mobile -->
        <button @click="sidebarOpen = false" class="sm:hidden absolute top-4 right-4 text-gray-500 hover:text-gray-700">
          X
        </button>

        <!-- Header -->
        <div class="flex flex-col items-center justify-center mt-5">
            <img src="{{ asset('logo.png') }}" width="95" height="95" alt="Logo" class="shadow-sm z-50 rounded-full">
            <p class="text-xl text-[#0053A1] font-bold text-center">SMART TRIKE</p>
        </div>

        <!-- Sidebar Menu -->
        <ul class="space-y-3 font-medium mt-6">

            {{-- Home: Visible to all --}}
            <li>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 text-body rounded hover:bg-neutral-tertiary hover:text-fg-brand group {{ request()->routeIs('admin.dashboard') ? 'bg-neutral-tertiary text-fg-brand' : '' }}">
                    <x-heroicon-o-home class="w-5 h-5 text-gray-500 group-hover:text-fg-brand transition duration-150" />
                    <span class="ml-3 font-semibold">Home</span>
                </a>
            </li>

            {{-- Admin Only --}}
            @if(auth()->user()->role === 'admin')

                <li>
                    <a href="#" class="flex items-center px-3 py-2 text-body rounded hover:bg-neutral-tertiary hover:text-fg-brand group">
                        <x-heroicon-o-clipboard-document-check class="w-5 h-5 text-gray-500 group-hover:text-fg-brand transition duration-150" />
                        <span class="ml-3 font-semibold">Trip History</span>
                    </a>
                </li>

                <!-- Manage Dispatcher Dropdown -->
                <!-- <li x-data="{ open: false }">
                    <button @click="open = ! open" class="flex items-center w-full justify-between px-3 py-2 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group">
                        <x-heroicon-o-users class="w-5 h-5 text-gray-500 group-hover:text-fg-brand transition duration-150" />
                        <span class="flex-1 ml-3 text-left whitespace-nowrap font-semibold">Manage Dispatchers</span>
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                        </svg>
                    </button>
                    <ul x-show="open" x-transition class="py-2 space-y-2 pl-8 mt-2">
                        <li>
                            <a href="#" class="flex items-center px-3 py-2 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group font-semibold">View All Dispatchers</a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center px-3 py-2 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group font-semibold">Add New Dispatcher</a>
                        </li>
                    </ul>
                </li>


                
                <li x-data="{ open: false }">
                    <button @click="open = ! open" class="flex items-center w-full justify-between px-3 py-2 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group">
                        <x-tabler-helmet class="w-5 h-5 text-gray-500 group-hover:text-fg-brand transition duration-150" />
                        <span class="flex-1 ml-3 text-left whitespace-nowrap font-semibold">Manage Drivers</span>
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                        </svg>
                    </button>
                    <ul x-show="open" x-transition class="py-2 space-y-2 pl-8 mt-2">
                        <li>
                            <a href="#" class="flex items-center px-3 py-2 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group font-semibold">View All Drivers</a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center px-3 py-2 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group font-semibold">Add New Driver</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#" class="flex items-center px-3 py-2 text-body rounded hover:bg-neutral-tertiary hover:text-fg-brand group {{ request()->routeIs('admin.reports') ? 'bg-neutral-tertiary text-fg-brand' : '' }}">
                        <x-heroicon-o-chart-bar class="w-5 h-5 text-gray-500 group-hover:text-fg-brand transition duration-150" />
                        <span class="ml-3 font-semibold">Reports & Analytics</span>
                    </a>
                </li> -->
            @endif

            {{-- Dispatcher Only --}}
            @if(auth()->user()->role === 'dispatcher')
                <li>
                    <a href="#" class="flex items-center px-3 py-2 text-body rounded hover:bg-neutral-tertiary hover:text-fg-brand group">
                        <x-heroicon-o-clipboard-document class="w-5 h-5 text-gray-500 group-hover:text-fg-brand transition duration-150" />
                        <span class="ml-3 font-semibold">Tricycle Queue</span>
                    </a>
                </li>

                <li>
                    <a href="#" class="flex items-center px-3 py-2 text-body rounded hover:bg-neutral-tertiary hover:text-fg-brand group">
                        <x-heroicon-o-clock class="w-5 h-5 text-gray-500 group-hover:text-fg-brand transition duration-150" />
                        <span class="ml-3 font-semibold">Shift Management</span>
                    </a>
                </li>
            @endif

            {{-- Driver Only --}}
            @if(auth()->user()->role === 'driver')
                <li>
                    <a href="#" class="flex items-center px-3 py-2 text-body rounded hover:bg-neutral-tertiary hover:text-fg-brand group">
                        <x-heroicon-o-user class="w-5 h-5 text-gray-500 group-hover:text-fg-brand transition duration-150" />
                        <span class="ml-3 font-semibold">My Profile</span>
                    </a>
                </li>

                <li>
                    <a href="#" class="flex items-center px-3 py-2 text-body rounded hover:bg-neutral-tertiary hover:text-fg-brand group">
                        <x-heroicon-o-clipboard-document-check class="w-5 h-5 text-gray-500 group-hover:text-fg-brand transition duration-150" />
                        <span class="ml-3 font-semibold">Trip History</span>
                    </a>
                </li>
            @endif
        </ul>

        {{-- Logout Button --}}
        <form method="POST" class="mt-auto" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm cursor-pointer border-t font-medium py-4 hover:bg-red-50 border-gray-300 w-full flex items-center justify-center">
                <x-heroicon-o-arrow-right-start-on-rectangle class="w-5 h-5 text-gray-500 mr-2" />
                Logout
            </button>
        </form>
    </div>
</aside>

<!-- Burger Button (Mobile) -->
<button @click="sidebarOpen = !sidebarOpen" type="button" class=" h-auto   text-heading bg-transparent box-border border border-transparent hover:bg-neutral-secondary-medium focus:ring-4 focus:ring-neutral-tertiary font-medium leading-5 rounded-base ms-3 mt-3 text-sm p-2 focus:outline-none inline-flex sm:hidden">
    <span class="sr-only">Open sidebar</span>
    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m5 7h14M5 12h14M5 17h10" />
    </svg>
</button>
