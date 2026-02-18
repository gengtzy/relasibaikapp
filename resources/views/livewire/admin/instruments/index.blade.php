<div x-data="{
    showModal: false,
    deleteId: null,
    deleteCode: '',
    isBulk: false,
    bulkCount: 0
}" 
x-init="$watch('showModal', value => {
    if (value) {
        document.body.classList.add('overflow-hidden');
    } else {
        document.body.classList.remove('overflow-hidden');
    }
})"
@close-modal.window="showModal = false">

    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <span class="inline-flex items-center text-sm font-normal text-slate-400">
                    Instrumen
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
    <div class="flex items-start justify-between">
        <h1 class="text-2xl font-bold mb-6">Instrumen</h1>

        <button wire:click="createNewInstrument" type="button"
            class="items-center rounded-lg border border-blue-300 bg-blue-500 p-2 font-semibold text-white hover:bg-blue-500/90">
            <span>Instrumen Baru</span>
        </button>
    </div>

    {{-- Kontainer Tabel --}}
    <div class="border border-slate-300 shadow-sm rounded-2xl bg-white">

        <div class="flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0 p-4">

            {{-- TOMBOL HAPUS PILIHAN (BULK) --}}
            @if (count($selectedInstruments) > 0)
                <div class="w-full md:w-auto">
                    <button 
                        @click="
                            isBulk = true;
                            bulkCount = {{ count($selectedInstruments) }};
                            showModal = true;
                            $wire.set('isBulkDelete', true, false);
                        "
                        type="button"
                        class="btn-danger w-full px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-lg hover:bg-red-700 transition-colors">
                        Hapus Pilihan ({{ count($selectedInstruments) }})
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
                        class="block h-10 p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-50 md:w-80 bg-gray-50 focus:outline-none focus:border-blue-500"
                        placeholder="Cari berdasarkan nama atau kode">
                </div>
                <button type="button"
                    class="text-theme-sm shadow-theme-xs inline-flex h-10 items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 font-medium text-gray-700 hover:bg-gray-200">
                    <i class="fa-solid fa-filter"></i>
                </button>
            </div>
        </div>

        {{-- Toast Notification --}}
        @if (session()->has('success'))
            <div wire:key="alert-{{ rand() }}" x-data="{ show: true }" x-show="show"
                x-transition:enter="transform ease-out duration-300 transition"
                x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" x-init="setTimeout(() => show = false, 4000)"
                class="fixed top-24 right-5 z-[60] flex items-center w-full max-w-sm p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-lg border-l-4 border-green-500 dark:text-gray-400 dark:bg-gray-800"
                role="alert">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <span class="sr-only">Check icon</span>
                </div>
                <div class="ms-3 text-sm font-normal text-slate-800">{{ session('success') }}</div>
                <button type="button" @click="show = false"
                    class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        @endif

        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th scope="col" class="p-4">
                            <div class="flex items-center">
                                <input wire:model.live="selectAll" type="checkbox"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm accent-blue-500">
                                <label for="checkbox-all-search" class="sr-only">checkbox</label>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">Kode</th>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">Deskripsi</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($instruments as $instrument)
                        <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                            <td class="w-4 p-4">
                                <div class="flex items-center">
                                    <input wire:model.live="selectedInstruments" type="checkbox"
                                        value="{{ $instrument->id }}"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm accent-blue-500">
                                    <label class="sr-only">checkbox</label>
                                </div>
                            </td>

                            <td wire:click="editInstrument({{ $instrument->id }})" class="px-6 py-4 cursor-pointer">
                                {{ $instrument->code }}
                            </td>
                            <td wire:click="editInstrument({{ $instrument->id }})" class="px-6 py-4 cursor-pointer">
                                {{ $instrument->name }}
                            </td>
                            <td wire:click="editInstrument({{ $instrument->id }})" class="px-6 py-4 cursor-pointer">
                                {{ $instrument->descriptions ?? '-' }}
                            </td>

                            <td class="flex gap-2 px-6 py-4">
                                <button wire:click="editInstrument({{ $instrument->id }})" type="button"
                                    class="flex gap-1 items-center font-medium text-blue-600 hover:underline">
                                    <i class="fas fa-edit"></i> Edit
                                </button>

                                {{-- TOMBOL HAPUS SINGLE (MODAL TRIGGER) --}}
                                <button type="button"
                                    @click="
                                        isBulk = false;
                                        showModal = true; 
                                        deleteId = {{ $instrument->id }}; 
                                        deleteCode = '{{ $instrument->name }}'; {{-- Kirim Nama Instrumen --}}
                                        $wire.set('deleteId', {{ $instrument->id }}, false);
                                        $wire.set('isBulkDelete', false, false);
                                    "
                                    class="flex gap-1 items-center font-medium text-red-600 hover:underline">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr class="bg-white border-b border-gray-200">
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada data ditemukan.
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
                <span class="font-semibold text-slate-700">{{ $instruments->firstItem() ?? 0 }}-{{ $instruments->lastItem() ?? 0 }}</span>
                of
                <span class="font-semibold text-slate-700">{{ $instruments->total() }}</span>
            </span>
            {{ $instruments->links() }}
        </nav>

        {{-- MODAL HAPUS FIX --}}
        <div x-show="showModal" style="display: none;" 
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="!m-0 fixed inset-0 z-[9999] flex items-center justify-center w-full bg-gray-900/60 backdrop-blur-sm p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-screen">

            <div @click.outside="showModal = false" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                class="relative w-full max-w-md max-h-full">

                <div class="relative bg-white border border-gray-200 rounded-xl shadow-2xl p-4 md:p-6">

                    <button type="button" @click="showModal = false"
                        class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center transition-colors">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>

                    <div class="p-4 md:p-5 text-center">
                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>

                        <h3 class="mb-2 text-lg font-normal text-gray-500"
                            x-text="isBulk ? 'Hapus ' + bulkCount + ' instrumen terpilih?' : 'Hapus Instrumen ini?'">
                        </h3>

                        {{-- PERINGATAN KHUSUS INSTRUMEN --}}
                        <div class="mb-4 p-3 bg-red-50 text-red-700 text-sm rounded-lg text-left">
                            <strong>PERHATIAN:</strong> Menghapus instrumen juga akan <strong>MENGHAPUS SEMUA PERTANYAAN</strong> yang ada di dalamnya secara permanen.
                        </div>

                        <div class="mb-6 py-2 px-3 bg-gray-50 rounded-lg border border-gray-100 inline-block">
                            <span class="font-mono text-sm font-bold text-gray-800"
                                x-text="isBulk ? 'Tindakan ini tidak dapat dibatalkan.' : deleteCode"></span>
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