<div>
    @auth
        <nav x-data="{ open: false, scrolled: false }" @scroll.window="scrolled = (window.scrollY > 20)"
            :class="{ 'bg-white/40 backdrop-blur-sm shadow-md': scrolled }" id="navbar-guest"
            class="fixed top-0 left-0 right-0 py-4 transition-all duration-300 z-50">
            <div class="container mx-auto px-6 lg:px-24">
                <div class="flex justify-between items-center">
                    <div class="flex-shrink-0">
                        <a href="{{ route('screening.start') }}" id="navbar-logo"
                            :class="{ 'text-white': !scrolled, 'text-blue-500': scrolled }"
                            class="text-2xl font-bold text-white transition-colors duration-300">
                            RelasiBaik.
                        </a>
                    </div>
                    <div class="hidden md:flex items-center gap-4">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center text-sm font-medium text-slate-900 hover:text-blue-500 transition ease-in-out duration-150"
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
                                <x-dropdown-link :href="3" wire:navigate>{{ __('Profil') }}</x-dropdown-link>
                                <x-dropdown-link href="#">{{ __('Riwayat Pengisian') }}</x-dropdown-link>
                                <button wire:click="logout"
                                    class="w-full text-start"><x-dropdown-link>{{ __('Keluar') }}</x-dropdown-link></button>
                            </x-slot>
                        </x-dropdown>
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
                    <x-responsive-nav-link :href="3" wire:navigate>{{ __('Profil') }}</x-responsive-nav-link>
                    <x-responsive-nav-link href="#">{{ __('Riwayat Pengisian') }}</x-responsive-nav-link>
                    <button wire:click="logout"
                        class="w-full text-start"><x-responsive-nav-link>{{ __('Keluar') }}</x-responsive-nav-link></button>
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
                        <a href="/#beranda" class="text-slate-700 hover:text-blue-500 font-medium transition">Beranda</a>
                        <a href="/#alur" class="text-slate-700 hover:text-blue-500 font-medium transition">Alur Kerja</a>
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 border border-blue-500 text-blue-500 rounded-full hover:bg-blue-500 hover:text-white font-medium transition">Masuk</a>
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 border border-blue-500 text-white bg-blue-500 rounded-full hover:bg-white hover:text-blue-500 font-medium transition">Daftar</a>
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
                <a href="/#beranda" class="block px-4 py-3 text-slate-700 hover:bg-slate-100">Beranda</a>
                <a href="/#alur" class="block px-4 py-3 text-slate-700 hover:bg-slate-100">Alur Kerja</a>
                <hr>
                <a href="{{ route('login') }}" class="block px-4 py-3 text-slate-700 hover:bg-slate-100">Masuk</a>
                <a href="{{ route('register') }}"
                    class="block px-4 py-3 text-blue-500 font-semibold hover:bg-slate-100">Daftar</a>
            </div>
        </nav>
    @endguest
</div>
