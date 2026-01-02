<div>
    {{-- Breadcrumb --}}
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <span class="inline-flex items-center text-sm font-normal text-slate-400">
                    Hasil Skrining
                </span>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    <span class="pl-2 inline-flex items-center text-sm font-normal text-slate-600">
                        List
                    </span>
                </div>
            </li>
        </ol>
    </nav>

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
        <h1 class="text-2xl font-bold text-slate-800">Hasil Skrining</h1>
    </div>

    @if ($filterType === 'risk')
        <div
            class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4 flex items-center justify-between animate-fade-in">
            <div class="flex items-center gap-3">
                <div class="bg-red-100 p-2 rounded-full text-red-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-red-800 text-sm">Mode Filter: Indikasi Masalah</h4>
                    <p class="text-red-600 text-xs">Menampilkan data skrining yang memerlukan perhatian (Kategori
                        Rendah/Disharmonis).</p>
                </div>
            </div>
            <a href="{{ route('screeningresult') }}" wire:navigate
                class="text-sm text-red-600 hover:text-red-800 font-medium underline">
                Reset Filter
            </a>
        </div>
    @endif

    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">

        {{-- PERUBAHAN UTAMA DI SINI: Tambahkan $watch pada x-init --}}
        <div x-data="{
            showModal: false,
            deleteId: null,
            deleteCode: '',
            isBulk: false,
            bulkCount: 0
        }" x-init="$watch('showModal', value => {
            if (value) {
                document.body.classList.add('overflow-hidden');
            } else {
                document.body.classList.remove('overflow-hidden');
            }
        })" @close-modal.window="showModal = false"
            class="flex flex-col">

            <div class="flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0 p-4">

                @if (count($selectedIds) > 0)
                    <div class="w-full md:w-auto">
                        <button
                            @click="
                                isBulk = true;
                                bulkCount = {{ count($selectedIds) }};
                                showModal = true;
                                $wire.set('isBulkDelete', true, false); 
                            "
                            type="button"
                            class="btn-danger w-full px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-lg hover:bg-red-700 transition-colors">
                            Hapus Pilihan ({{ count($selectedIds) }})
                        </button>
                    </div>
                @else
                    <div></div>
                @endif

                <div class="flex space-x-4">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                            <i class="fas fa-search text-gray-500"></i>
                        </div>
                        <input wire:model.live.debounce.300ms="search" type="text" id="table-search"
                            class="block h-10 p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:outline-none focus:border-blue-500"
                            placeholder="Cari nama, email, peran...">
                    </div>
                    <button type="button"
                        class="text-theme-sm shadow-theme-xs inline-flex h-10 items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 font-medium text-gray-700 hover:bg-gray-200">
                        <i class="fa-solid fa-filter"></i>
                    </button>
                </div>
            </div>

            <div class="space-y-4">

                @if (session()->has('success'))
                    <div wire:key="alert-{{ rand() }}" x-data="{ show: true }" x-show="show"
                        x-transition:enter="transform ease-out duration-300 transition"
                        x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                        x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" x-init="setTimeout(() => show = false, 4000)"
                        class="fixed top-24 right-5 z-[60] flex items-center w-full max-w-sm p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-lg border-l-4 border-green-500 dark:text-gray-400 dark:bg-gray-800"
                        role="alert">

                        <div
                            class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                            </svg>
                            <span class="sr-only">Check icon</span>
                        </div>
                        <div class="ms-3 text-sm font-normal text-slate-800">{{ session('success') }}</div>
                        <button type="button" @click="show = false"
                            class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700">
                            <span class="sr-only">Close</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th scope="col" class="p-4 w-4">
                                    <div class="flex items-center">
                                        <input wire:model.live="selectAll" type="checkbox"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 font-bold">ID Sesi</th>
                                <th scope="col" class="px-6 py-3 font-bold">Nama User</th>
                                <th scope="col" class="px-6 py-3 font-bold">Waktu Selesai</th>
                                <th scope="col" class="px-6 py-3 font-bold text-center">Total Skor</th>
                                <th scope="col" class="px-6 py-3 font-bold">Hasil Diagnosa</th>
                                <th scope="col" class="px-6 py-3 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($screenings as $item)
                                <tr class="bg-white hover:bg-slate-50 transition-colors">
                                    <td class="w-4 p-4">
                                        <div class="flex items-center">
                                            <input wire:model.live="selectedIds" type="checkbox"
                                                value="{{ $item->id }}"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                        </div>
                                    </td>
                                    <td wire:click="viewResult({{ $item->id }})"
                                        class="px-6 py-4 font-medium whitespace-nowrap cursor-pointer">
                                        SCR-{{ $item->created_at->format('Ymd') }}-{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td wire:click="viewResult({{ $item->id }})" class="px-6 py-4 cursor-pointer">
                                        {{ $item->user->name }}
                                    </td>
                                    <td wire:click="viewResult({{ $item->id }})"
                                        class="px-6 py-4 whitespace-nowrap cursor-pointer">
                                        {{ $item->created_at->translatedFormat('d F Y') }}
                                        <br>
                                        <span class="text-xs text-slate-400">{{ $item->created_at->format('H:i') }}
                                            WIB</span>
                                    </td>
                                    <td wire:click="viewResult({{ $item->id }})"
                                        class="px-6 py-4 text-center cursor-pointer">
                                        <span
                                            class="bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-0.5 rounded border border-blue-200">
                                            {{ $item->result->total_score ?? 0 }}
                                        </span>
                                    </td>
                                    <td wire:click="viewResult({{ $item->id }})"
                                        class="px-6 py-4 cursor-pointer">
                                        @if ($item->recommendation)
                                            @php
                                                $isGood =
                                                    $item->recommendation->code === 'TTT' ||
                                                    $item->recommendation->code === 'TTS';
                                                $bgClass = $isGood
                                                    ? 'bg-green-50 text-green-700 border-green-200'
                                                    : 'bg-orange-50 text-orange-700 border-orange-200';
                                                if (str_contains($item->recommendation->code, 'R')) {
                                                    $bgClass = 'bg-red-50 text-red-700 border-red-200';
                                                }
                                            @endphp
                                            <span
                                                class="{{ $bgClass }} border px-2 py-1 font-medium text-xs rounded-lg inline-block">
                                                {{ Str::limit($item->recommendation->title, 30) }}
                                            </span>
                                        @else
                                            <span class="text-slate-400 text-xs italic">Belum ada hasil</span>
                                        @endif
                                    </td>
                                    <td class="flex gap-2 px-6 py-4">
                                        <button wire:click="viewResult({{ $item->id }})" type="button"
                                            class="flex gap-1 items-center font-medium text-slate-600 hover:underline">
                                            <i class="fas fa-eye"></i>
                                            Lihat
                                        </button>
                                        @php
                                            $scrCode =
                                                'SCR-' .
                                                $item->created_at->format('Ymd') .
                                                '-' .
                                                str_pad($item->id, 5, '0', STR_PAD_LEFT);
                                        @endphp
                                        <button type="button"
                                            @click="
                                                isBulk = false;
                                                showModal = true; 
                                                deleteId = {{ $item->id }}; 
                                                deleteCode = '{{ $scrCode }}';
                                                $wire.set('deleteId', {{ $item->id }}, false);
                                                $wire.set('isBulkDelete', false, false);
                                            "
                                            class="flex items-center gap-1 font-medium text-red-600 hover:text-red-800 hover:underline text-sm transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                        Tidak ada data screening ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <nav class="flex pb-4 items-center flex-col md:flex-row justify-between pt-4 px-4"
                    aria-label="Table navigation">
                    <span class="text-sm font-normal text-slate-500 mb-4 md:mb-0 block w-full md:inline md:w-auto">
                        Showing
                        <span
                            class="font-semibold text-slate-700">{{ $screenings->firstItem() ?? 0 }}-{{ $screenings->lastItem() ?? 0 }}</span>
                        of
                        <span class="font-semibold text-slate-700">{{ $screenings->total() }}</span>
                    </span>
                    {{ $screenings->links() }}
                </nav>

                <div x-show="showModal" style="display: none;" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="!m-0 fixed inset-0 z-[9999] flex items-center justify-center w-full bg-gray-900/60 backdrop-blur-sm p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-screen">

                    <div @click.outside="showModal = false" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                        class="relative w-full max-w-md max-h-full">

                        <div class="relative bg-white border border-gray-200 rounded-xl shadow-2xl p-4 md:p-6">

                            <button type="button" @click="showModal = false"
                                class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center transition-colors">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>

                            <div class="p-4 md:p-5 text-center">
                                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>

                                <h3 class="mb-2 text-lg font-normal text-gray-500"
                                    x-text="isBulk ? 'Hapus ' + bulkCount + ' data terpilih?' : 'Apakah Anda yakin ingin menghapus data ini?'">
                                </h3>

                                <div class="mb-6 py-2 px-3 bg-gray-50 rounded-lg border border-gray-100 inline-block">
                                    <span class="font-mono text-sm font-bold text-gray-800"
                                        x-text="isBulk ? 'Tindakan ini tidak dapat dibatalkan.' : 'ID: ' + deleteCode"></span>
                                </div>

                                <div class="flex items-center justify-center gap-3">
                                    <button wire:click="executeDelete" wire:loading.attr="disabled" type="button"
                                        class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center transition-all shadow-md hover:shadow-lg disabled:opacity-50">
                                        <span wire:loading.remove>Ya, Hapus Data</span>
                                        <span wire:loading>Menghapus...</span>
                                    </button>

                                    <button @click="showModal = false" type="button"
                                        class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 transition-all shadow-sm">
                                        Batal
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
