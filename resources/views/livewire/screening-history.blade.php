{{-- BUNGKUS DENGAN X-DATA --}}
<div x-data="{ 
        showModal: @entangle('showModal'),
        deleteId: null,
        deleteLabel: '' 
     }" 
     x-init="$watch('showModal', value => {
         if (value) document.body.classList.add('overflow-hidden');
         else document.body.classList.remove('overflow-hidden');
     })"
     class="my-24 min-h-screen">

    <div class="max-w-6xl mx-auto space-y-6">
        {{-- Header Halaman --}}
        <div class="mb-8 px-4 sm:px-0 text-white">
            <h2 class="font-bold text-3xl leading-tight">
                Riwayat Pengisian
            </h2>
            <p class="opacity-90">Daftar hasil diagnosis keluarga yang telah Anda simpan.</p>
        </div>

        {{-- Flash Message --}}
        @if (session()->has('message'))
            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                class="mb-4 mx-4 sm:mx-0 p-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200 flex items-center shadow-sm"
                role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="font-medium">{{ session('message') }}</span>
            </div>
        @endif

        <div class="border border-slate-300 shadow-sm rounded-2xl bg-white dark:bg-slate-800 dark:border-slate-700 transition-colors duration-500 ease-in-out">
            <div class="p-4 flex justify-end">
                <div class="relative w-full sm:w-64">
                    <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                        <i class="fas fa-search text-gray-500 dark:text-slate-400 transition-colors duration-500 ease-in-out"></i>
                    </div>
                    <input wire:model.live.debounce.300ms="search" type="text"
                        class="block w-full p-2.5 pl-10 text-sm text-slate-900 border border-slate-300 rounded-xl bg-gray-50 focus:ring-blue-500 focus:border-blue-500 shadow-sm dark:bg-slate-700 dark:text-slate-100 dark:border-slate-600 dark:placeholder:text-slate-400 transition-colors duration-500 ease-in-out"
                        placeholder="Cari lokasi atau tanggal...">
                </div>
            </div>

            {{-- Tabel Data --}}
            <div class="bg-white dark:bg-slate-800 overflow-hidden rounded-b-2xl transition-colors duration-500 ease-in-out">
                @if ($screenings->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-slate-500 dark:text-slate-300 transition-colors duration-500 ease-in-out">
                            <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-200 dark:text-slate-200 dark:bg-slate-700 dark:border-slate-600 transition-colors duration-500 ease-in-out">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-bold w-16 text-center">No</th>
                                    <th scope="col" class="px-6 py-4 font-bold">Tanggal Pengisian</th>
                                    <th scope="col" class="px-6 py-4 font-bold">Lokasi</th>
                                    <th scope="col" class="px-6 py-4 font-bold">Hasil Diagnosa</th>
                                    <th scope="col" class="px-6 py-4 font-bold text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($screenings as $index => $item)
                                    <tr onclick="window.location='{{ route('screening.result', $item->id) }}'"
                                        class="bg-white border-b hover:bg-blue-50/50 transition-colors group cursor-pointer dark:bg-slate-800 dark:border-slate-700 dark:hover:bg-slate-700/50 duration-500 ease-in-out">
                                        
                                        <td class="px-6 py-4 text-center">
                                            {{ $screenings->firstItem() + $index }}
                                        </td>
                                        <td class="px-6 py-4 font-medium text-slate-900 whitespace-nowrap dark:text-slate-100 transition-colors duration-500 ease-in-out" >
                                            {{ \Carbon\Carbon::parse($item->tanggal_pengisian)->format('d F Y') }}
                                            <br>
                                            <span class="text-xs text-slate-400 font-normal">
                                                {{ $item->created_at->format('H:i') }} WIB
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <svg class="w-3.5 h-3.5 text-slate-400 mr-2 dark:text-slate-400 transition-colors duration-500 ease-in-out" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                {{ $item->lokasi ?? '-' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($item->recommendation)
                                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full border border-blue-200 dark:bg-blue-900/30 dark:text-blue-200 dark:border-blue-800 transition-colors duration-500 ease-in-out">
                                                    {{ $item->recommendation->title }}
                                                </span>
                                            @else
                                                <span class="text-slate-400 italic">Tidak ada data</span>
                                            @endif
                                        </td>
                                        
                                        {{-- AKSI --}}
                                        <td class="px-6 py-4 text-center">
                                            {{-- @click.stop Wajib ada agar tidak memicu onclick baris tabel --}}
                                            <div class="flex justify-center items-center gap-3" @click.stop>
                                                
                                                {{-- Tombol Print --}}
                                                <a href="{{ route('screening.result', ['resultId' => $item->id, 'action' => 'print']) }}"
                                                    target="_blank"
                                                    class="text-slate-400 hover:text-blue-500 transition-colors p-2 hover:bg-blue-50 rounded-full dark:hover:bg-slate-600 dark:hover:text-blue-400 transition-colors duration-500 ease-in-out"
                                                    title="Cetak PDF">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                                    </svg>
                                                </a>

                                                {{-- Tombol Delete (Trigger Modal) --}}
                                                @php
                                                    $label = \Carbon\Carbon::parse($item->tanggal_pengisian)->format('d F Y');
                                                @endphp
                                                <button type="button"
                                                    @click="
                                                        showModal = true;
                                                        deleteId = {{ $item->id }};
                                                        deleteLabel = '{{ $label }}';
                                                        $wire.set('deleteId', {{ $item->id }}, false);
                                                    "
                                                    class="text-slate-400 hover:text-red-500 transition-colors p-2 hover:bg-red-50 rounded-full dark:hover:bg-slate-600 dark:hover:text-red-400 transition-colors duration-500 ease-in-out"
                                                    title="Hapus">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    {{-- Empty State --}}
                    <div class="flex flex-col items-center justify-center py-16 text-center">
                        <div class="p-4 rounded-full bg-slate-50 mb-4 dark:bg-slate-700/50 transition-colors duration-500 ease-in-out">
                            <svg class="w-10 h-10 text-slate-300 dark:text-slate-500 transition-colors duration-500 ease-in-out" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-slate-900 dark:text-slate-200 transition-colors duration-500 ease-in-out">Belum ada riwayat</h3>
                        <p class="text-slate-500 mt-2 max-w-sm dark:text-slate-400 transition-colors duration-500 ease-in-out">
                            @if (!empty($search))
                                Tidak ditemukan data dengan kata kunci "{{ $search }}".
                            @else
                                Riwayat diagnosis keluarga Anda akan muncul di sini setelah Anda menyelesaikan skrining.
                            @endif
                        </p>
                        @if (empty($search))
                            <a href="{{ route('screening.wizard') }}" class="mt-6 px-6 py-2.5 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-colors text-sm font-semibold shadow-lg shadow-blue-500/30">
                                Mulai Skrining Baru
                            </a>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Pagination --}}
            <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700 transition-colors duration-500 ease-in-out">
                {{ $screenings->links() }}
            </div>
        </div>
    </div>

    {{-- MODAL DELETE "USER FRIENDLY" STYLE --}}
    <div x-show="showModal" style="display: none;" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[9999] flex items-center justify-center w-full h-screen bg-slate-900/60 backdrop-blur-sm p-4">

        {{-- Content Modal --}}
        <div @click.outside="showModal = false" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 scale-95"
            class="relative w-full max-w-sm bg-white dark:bg-slate-800 rounded-3xl shadow-2xl p-8 text-center border border-slate-100 dark:border-slate-700 transition-colors duration-500 ease-in-out">

            {{-- Icon Visual --}}
            <div class="w-16 h-16 bg-red-100 dark:bg-red-900/30 text-red-500 dark:text-red-400 rounded-full flex items-center justify-center mx-auto mb-6 transition-colors duration-500 ease-in-out">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </div>

            <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2">Hapus Riwayat?</h3>
            
            <p class="text-slate-500 dark:text-slate-400 text-sm mb-6 leading-relaxed transition-colors duration-500 ease-in-out">
                Anda akan menghapus data skrining tanggal <br>
                <span class="font-bold text-slate-800 dark:text-slate-200" x-text="deleteLabel"></span>. 
                <br>Tindakan ini tidak dapat dibatalkan.
            </p>

            <div class="flex flex-col gap-3">
                <button wire:click="delete" wire:loading.attr="disabled"
                    class="w-full py-3 px-4 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg shadow-lg shadow-red-500/30 transition-all transform hover:scale-[1.02] active:scale-95 disabled:opacity-50">
                    <span wire:loading.remove>Ya, Hapus Data</span>
                    <span wire:loading>Sedang Menghapus...</span>
                </button>

                <button @click="showModal = false"
                    class="w-full py-3 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors duration-500 ease-in-out dark:bg-slate-700 dark:text-slate-300 dark:hover:bg-slate-600 font-semibold rounded-lg transition-colors">
                    Batal
                </button>
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('action') === 'print') {
            setTimeout(() => {
                window.print();
            }, 800);
        }
    });
</script>