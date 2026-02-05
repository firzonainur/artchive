<nav x-data="{ open: false }" class="glass-nav transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10 rounded-lg shadow-lg object-contain">
                        <span class="font-bold text-xl tracking-tight text-white">Academic<span class="text-purple-400">Archive</span></span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')" class="text-gray-300 hover:text-white hover:border-purple-500 transition-colors">
                        {{ __('Beranda') }}
                    </x-nav-link>
                    <x-nav-link :href="route('artworks.index')" :active="request()->routeIs('artworks.*')" class="text-gray-300 hover:text-white hover:border-purple-500 transition-colors">
                        {{ __('Arsip') }}
                    </x-nav-link>
                    <x-nav-link :href="route('research.index')" :active="request()->routeIs('research.*')" class="text-gray-300 hover:text-white hover:border-purple-500 transition-colors">
                        {{ __('Penelitian') }}
                    </x-nav-link>
                    <x-nav-link :href="route('virtual.exhibition')" :active="request()->routeIs('virtual.exhibition')" class="text-gray-300 hover:text-white hover:border-purple-500 transition-colors">
                        {{ __('Realita Virtual') }}
                    </x-nav-link>
                    <x-nav-link :href="route('learning.index')" :active="request()->routeIs('learning.*')" class="text-gray-300 hover:text-white hover:border-purple-500 transition-colors">
                        {{ __('Belajar') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-300 hover:text-white focus:outline-none transition duration-150 ease-in-out group">
                                <div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center mr-2 border border-purple-500/30 group-hover:border-purple-500 transition-colors">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('dashboard')" class="hover:bg-purple-900/20 text-gray-300">
                                {{ __('Dasbor') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('profile.edit')" class="hover:bg-purple-900/20 text-gray-300">
                                {{ __('Profil') }}
                            </x-dropdown-link>

                            @if(Auth::user()->role === 'admin')
                                <x-dropdown-link :href="route('admin.index')" class="hover:bg-purple-900/20 text-purple-400 font-bold">
                                    {{ __('Panel Admin') }}
                                </x-dropdown-link>
                            @endif

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();" class="hover:bg-red-900/20 text-red-400">
                                    {{ __('Keluar') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-purple-600 hover:bg-purple-500 text-white px-4 py-2 rounded-full text-sm font-semibold transition shadow-[0_0_15px_rgba(147,51,234,0.5)]">
                            Daftar
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-gray-900/95 backdrop-blur-xl border-t border-gray-800">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')" class="text-gray-300">
                {{ __('Beranda') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('artworks.index')" :active="request()->routeIs('artworks.*')" class="text-gray-300">
                {{ __('Arsip') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('research.index')" :active="request()->routeIs('research.*')" class="text-gray-300">
                {{ __('Penelitian') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('learning.index')" :active="request()->routeIs('learning.*')" class="text-gray-300">
                {{ __('Belajar') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-800">
             @auth
                <div class="px-4">
                    <div class="font-medium text-base text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')" class="text-gray-400">
                        {{ __('Profil') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();" class="text-gray-400">
                            {{ __('Keluar') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="mt-3 space-y-1 px-4">
                     <x-responsive-nav-link :href="route('login')" class="text-gray-400">
                        {{ __('Masuk') }}
                    </x-responsive-nav-link>
                </div>
            @endauth
        </div>
    </div>
</nav>
