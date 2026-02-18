<div>
    @auth
        <nav x-data="{ open: false, scrolled: false }" @scroll.window="scrolled = (window.scrollY > 20)"
            :class="{ 'bg-white/40 backdrop-blur-sm shadow-md': scrolled }" id="navbar-guest"
            class="fixed top-0 left-0 right-0 py-4 transition-all duration-300 z-50">
            <div class="container mx-auto px-6 lg:px-16">
                <div class="flex justify-between items-center">
                    <div class="flex-shrink-0">
                        <a href="/" id="navbar-logo" :class="{ 'text-white': !scrolled, 'text-blue-500': scrolled }"
                            class="text-2xl font-bold text-white transition-colors duration-300">
                            RelasiBaik.
                        </a>
                    </div>
                    <div class="hidden md:flex items-center gap-8">
                        <div class="hidden md:flex items-center gap-8">
                            <a href="/#beranda"
                                class="text-slate-700 hover:text-blue-500 font-medium transition dark:text-slate-50 dark:hover:text-blue-500">Beranda</a>
                            <a href="/#alur"
                                class="text-slate-700 hover:text-blue-500 font-medium transition dark:text-slate-50 dark:hover:text-blue-500">Alur
                                Kerja</a>
                        </div>
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center text-slate-700 hover:text-blue-500 font-medium transition dark:text-slate-50 dark:hover:text-blue-500"
                                    type="button">
                                    <div>{{ Auth::user()->name }}</div>
                                    <div class="ms-1">
                                        <svg class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 1 4 4 4-4" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link
                                    class="text-slate-700 hover:bg-slate-50 dark:text-slate-400 dark:hover:bg-slate-600 dark:hover:text-slate-50"
                                    href="{{ route('profile') }}" wire:navigate>{{ __('Profil') }}</x-dropdown-link>
                                <x-dropdown-link
                                    class="text-slate-700 hover:bg-slate-50 dark:text-slate-400 dark:hover:bg-slate-600 dark:hover:text-slate-50"
                                    href="{{ route('history') }}">{{ __('Riwayat Pengisian') }}</x-dropdown-link>
                                <button wire:click="logout" class="w-full text-start"><x-dropdown-link
                                        class="text-slate-700 hover:bg-slate-50 dark:text-slate-400 dark:hover:bg-slate-600 dark:hover:text-slate-50">{{ __('Keluar') }}</x-dropdown-link></button>
                            </x-slot>
                        </x-dropdown>
                        <button @click="darkMode = !darkMode" type="button"
                            class="relative inline-flex h-8 w-14 items-center rounded-full transition-colors duration-300 focus:outline-none ml-2"
                            :class="darkMode ? 'bg-slate-700' : 'bg-yellow-500'">
                            <span class="sr-only">Toggle Dark Mode</span>
                            <span
                                class="h-6 w-6 transform rounded-full bg-white shadow-lg transition-transform duration-300 flex items-center justify-center"
                                :class="darkMode ? 'translate-x-7' : 'translate-x-1'">

                                {{-- Ikon Matahari --}}
                                <svg x-show="!darkMode" class="h-4 w-4 text-yellow-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>

                                {{-- Ikon Bulan --}}
                                <svg x-show="darkMode" class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                            </span>
                        </button>
                    </div>
                    <div class="-me-2 flex items-center md:hidden">
                        <button @click="open = ! open"
                            class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div :class="{ 'block': open, 'hidden': !open }"
                class="hidden md:hidden mt-4 bg-white rounded-lg shadow-lg mx-6">
                <div class="pt-2 pb-2 space-y-1">
                    <x-responsive-nav-link href="{{ route('profile') }}"
                        wire:navigate>{{ __('Profil') }}</x-responsive-nav-link>
                    <x-responsive-nav-link
                        href="{{ route('history') }}">{{ __('Riwayat Pengisian') }}</x-responsive-nav-link>
                    <button wire:click="logout"
                        class="w-full text-start"><x-responsive-nav-link>{{ __('Keluar') }}</x-responsive-nav-link></button>
                    <div class="px-4 py-3 border-t flex justify-between items-center">
                        <span class="text-sm text-slate-600">Mode Gelap</span>
                        <button @click="darkMode = !darkMode" type="button"
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none"
                            :class="darkMode ? 'bg-blue-600' : 'bg-gray-200'">
                            <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"
                                :class="darkMode ? 'translate-x-6' : 'translate-x-1'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </nav>
    @endauth

    @guest
        <nav x-data="{ open: false, scrolled: false }" @scroll.window="scrolled = (window.scrollY > 20)"
            :class="{ 'bg-white/40 backdrop-blur-sm shadow-md': scrolled }" id="navbar-guest"
            class="fixed top-0 left-0 right-0 py-4 transition-all duration-300 z-50">

            <div class="container mx-auto px-6 lg:px-24">
                <div class="flex justify-between items-center">
                    <a href="/" id="navbar-logo" :class="{ 'text-white': !scrolled, 'text-blue-500': scrolled }"
                        class="text-2xl font-bold text-white transition-colors duration-300">RelasiBaik.</a>
                    <div class="hidden md:flex items-center gap-6">
                        <a href="/#beranda"
                            class="text-slate-800 hover:text-blue-500 font-medium transition dark:text-slate-50 dark:hover:text-blue-500">Beranda</a>
                        <a href="/#alur"
                            class="text-slate-800 hover:text-blue-500 font-medium transition dark:text-slate-50 dark:hover:text-blue-500">Alur
                            Kerja</a>
                        <div class="space-x-2">
                            <a href="{{ route('login') }}"
                                class="px-4 py-2 border border-blue-500 text-blue-500 rounded-full hover:bg-blue-500 hover:text-white font-medium transition-colors duration-300 ease-in-out">Masuk</a>
                            <a href="{{ route('register') }}"
                                class="px-4 py-2 border border-blue-500 text-white bg-blue-500 rounded-full hover:bg-white dark:hover:bg-slate-800 hover:text-blue-500 font-medium transition-colors duration-300 ease-in-out">Daftar</a>
                        </div>
                        <button @click="darkMode = !darkMode" type="button"
                            class="relative inline-flex h-8 w-14 items-center rounded-full transition-colors duration-300 focus:outline-none ml-2"
                            :class="darkMode ? 'bg-slate-700' : 'bg-yellow-500'">
                            <span class="sr-only">Toggle Dark Mode</span>
                            <span
                                class="h-6 w-6 transform rounded-full bg-white shadow-lg transition-transform duration-300 flex items-center justify-center"
                                :class="darkMode ? 'translate-x-7' : 'translate-x-1'">

                                {{-- Ikon Matahari --}}
                                <svg x-show="!darkMode" class="h-4 w-4 text-yellow-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>

                                {{-- Ikon Bulan --}}
                                <svg x-show="darkMode" class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                            </span>
                        </button>
                    </div>
                    <div class="-me-2 flex items-center md:hidden">
                        <button @click="open = ! open"
                            class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition-colors duration-500 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                </div>
            </div>
            <div :class="{ 'block': open, 'hidden': !open }"
                class="hidden md:hidden mt-4 bg-white rounded-lg shadow-lg mx-6">
                <a href="/#beranda" class="block px-4 py-3 text-slate-700 hover:bg-slate-100">Beranda</a>
                <a href="/#alur" class="block px-4 py-3 text-slate-700 hover:bg-slate-100">Alur Kerja</a>
                <hr>
                <a href="{{ route('login') }}" class="block px-4 py-3 text-slate-700 hover:bg-slate-100">Masuk</a>
                <a href="{{ route('register') }}"
                    class="block px-4 py-3 text-blue-500 font-semibold hover:bg-slate-100">Daftar</a>

                {{-- Tambahan Toggle di Menu Mobile (Opsional, agar user HP juga bisa ubah mode) --}}
                <div class="px-4 py-3 border-t flex justify-between items-center">
                    <span class="text-sm text-slate-600">Mode Gelap</span>
                    <button @click="darkMode = !darkMode" type="button"
                        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none"
                        :class="darkMode ? 'bg-blue-600' : 'bg-gray-200'">
                        <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"
                            :class="darkMode ? 'translate-x-6' : 'translate-x-1'"></span>
                    </button>
                </div>
            </div>
        </nav>
    @endguest
</div>
