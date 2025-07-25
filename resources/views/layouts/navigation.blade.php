<nav x-data="{ open: false }" class="bg-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-full mx-auto px-4">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-[-4px]">
                        <img src="{{ asset('storage/assets/images/KanboardFavIconBlack.png') }}" alt="KanBoard" class="w-7 h-8">
                        <span class="text-white text-xl font-bold">anBoard</span>
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="items-center hidden sm:flex">
                <button id="theme-toggle" class="p-2 text-white hover:text-gray-300" aria-label="Toggle dark mode">
                    <x-iconpark-sun class="w-6 h-6" id="light-icon" />
                    <x-iconpark-moon class="w-6 h-6 hidden" id="dark-icon" />
                </button>
                <form action="{{ route('language.switch') }}" method="POST" class="ml-2">
                    @csrf
                    <input type="hidden" name="locale" value="{{ app()->getLocale() === 'en' ? 'fr' : 'en' }}">
                    <button type="submit" class="p-2 text-white hover:text-gray-300 rounded transition">
                        {{ app()->getLocale() === 'en' ? 'FR' : 'EN' }}
                    </button>
                </form>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm text-white hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            {{-- <div class="ms-1">
                                <x-iconpark-remind-o class="w-6 h-6 text-gray-100" />
                            </div>     --}}
                            <div class="ms-1">
                                <x-iconpark-user-o class="w-6 h-6 text-gray-100" />
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
