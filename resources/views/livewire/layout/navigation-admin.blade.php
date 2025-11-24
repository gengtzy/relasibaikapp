<div>
    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                        aria-controls="logo-sidebar" type="button"
                        class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                            </path>
                        </svg>
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="flex ms-2 md:me-24">
                        <img src="{{ asset('images/relasibaiklogoblue.svg') }}" class="h-8 me-3"
                            alt="RelasiBaik Logo" />
                        <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap">RelasiBaik.</span>
                    </a>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center ms-3">
                        <div>
                            <button type="button"
                                class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300"
                                aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                <span class="sr-only">Open user menu</span>
                                <img class="w-8 h-8 rounded-full"
                                    src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
                                    alt="user photo">
                            </button>
                        </div>
                        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow"
                            id="dropdown-user">
                            <div class="px-4 py-3" role="none">
                                <p class="text-sm text-gray-900" role="none">{{ Auth::user()->name }}</p>
                                <p class="text-sm font-medium text-gray-900 truncate" role="none">
                                    {{ Auth::user()->email }}</p>
                            </div>
                            <ul class="py-1" role="none">
                                <li><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        role="menuitem">Pengaturan</a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                            role="menuitem">
                                            Keluar
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-30 w-66 h-screen pt-20 transition-transform -translate-x-full bg-white sm:translate-x-0"
        aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white">
            <h3 class="text-sm font-semibold text-slate-500 mb-4 ml-2">MENU</h3>
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="{{ route('admin.dashboard') }}" wire:navigate @class([
                        'flex items-center p-2 rounded-lg group',
                        'text-blue-500 bg-gray-50' => request()->routeIs('admin.dashboard*'),
                        'text-gray-700 hover:bg-gray-50' => !request()->routeIs('admin.dashboard*'),
                    ])>
                        <i class="fas fa-home"></i>
                        <span class="ms-3">Dasbor Utama</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('screeningresult') }}" wire:navigate @class([
                        'flex items-center p-2 rounded-lg group',
                        'text-blue-500 bg-gray-50' => request()->routeIs('screeningresult*'),
                        'text-gray-700 hover:bg-gray-50' => !request()->routeIs(
                            'screeningresult*'),
                    ])>
                        <i class="fas fa-poll-h ml-1"></i>
                        <span class="ms-3">Hasil Skrining</span>
                    </a>
                </li>
            </ul>
            <h3 class="text-sm font-semibold text-slate-500 my-4 ml-2">MANAJEMEN DATA</h3>
            <ul class="space-y-2 font-medium">
                <li>
                    <button type="button" wire:navigate @class([
                        'flex items-center p-2 w-full rounded-lg',
                        'text-blue-500 bg-gray-50' => request()->routeIs([
                            'instrumentindex*',
                            'instrumentcreate*',
                            'instrumentedit*',
                            'questionsindex',
                            'questionscreate',
                            'questionsedit',
                        ]),
                        'text-gray-700 hover:bg-gray-50' => !request()->routeIs([
                            'instrumentindex*',
                            'instrumentcreate*',
                            'instrumentedit*',
                            'questionsindex',
                            'questionscreate',
                            'questionsedit',
                        ]),
                    ]) aria-controls="dropdown-example"
                        data-collapse-toggle="dropdown-example"
                        aria-expanded="{{ request()->routeIs(['instrumentindex*', 'instrumentcreate*', 'instrumentedit*', 'questionsindex', 'questionscreate', 'questionsedit']) ? 'true' : 'false' }}">
                        <i class="fas fa-tasks-alt"></i>
                        <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Manajemen Kuisioner</span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    <ul id="dropdown-example" wire:navigate @class([
                        'py-2 space-y-2',
                        'hidden' => !request()->routeIs([
                            'instrumentindex*',
                            'instrumentcreate*',
                            'instrumentedit*',
                            'questionsindex',
                            'questionscreate',
                            'questionsedit',
                        ]),
                    ])>
                        <li>
                            <a href="{{ route('instrumentindex') }}" wire:navigate @class([
                                'flex pl-10 items-center p-2',
                                'text-blue-500 bg-gray-50' => request()->routeIs([
                                    'instrumentindex*',
                                    'instrumentcreate*',
                                    'instrumentedit*',
                                ]),
                                'text-gray-700 hover:bg-gray-50' => !request()->routeIs([
                                    'instrumentindex*',
                                    'instrumentcreate*',
                                    'instrumentedit*',
                                ]),
                            ])>Instrumen</a>
                        </li>
                        <li>
                            <a href="{{ route('questionsindex') }}" wire:navigate @class([
                                'flex pl-10 items-center p-2',
                                'text-blue-500 bg-gray-50' => request()->routeIs([
                                    'questionsindex*',
                                    'questionscreate*',
                                    'questionsedit*',
                                ]),
                                'text-gray-700 hover:bg-gray-50' => !request()->routeIs([
                                    'questionsindex*',
                                    'questionscreate*',
                                    'questionsedit*',
                                ]),
                            ])>Pertanyaan</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('recommendationsindex') }}" wire:navigate @class([
                        'flex items-center p-2 rounded-lg group',
                        'text-blue-500 bg-gray-50' => request()->routeIs([
                            'recommendationsindex*',
                            'recommendationscreate*',
                            'recommendationsedit*',
                        ]),
                        'text-gray-700 hover:bg-gray-50' => !request()->routeIs([
                            'recommendationsindex*',
                            'recommendationscreate*',
                            'recommendationsedit*',
                        ]),
                    ])>
                        <i class="fas fa-diagnoses"></i>
                        <span class="ms-3">Manajemen Rekomendasi</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('adminusers') }}" wire:navigate @class([
                        'flex items-center p-2 rounded-lg group',
                        'text-blue-500 bg-gray-50' => request()->routeIs([
                            'adminusers*',
                            'userscreate*',
                            'recommendationsedit*',
                        ]),
                        'text-gray-700 hover:bg-gray-50' => !request()->routeIs([
                            'adminusers*',
                            'userscreate*',
                            'recommendationsedit*',
                        ]),
                    ])>
                        <i class="fas fa-users-cog"></i>
                        <span class="ms-3">Manajemen Pengguna</span>
                    </a>
                </li>
            </ul>
            <h3 class="text-sm font-semibold text-slate-500 my-4 ml-2">PELAPORAN</h3>
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="{{ route('admin.report') }}" wire:navigate @class([
                        'flex items-center p-2 rounded-lg group',
                        'text-blue-500 bg-gray-50' => request()->routeIs('admin.report*'),
                        'text-gray-700 hover:bg-gray-50' => !request()->routeIs('admin.report*'),
                    ])>
                        <i class="fas fa-file-export"></i>
                        <span class="ms-3">Cetak Laporan</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
</div>
