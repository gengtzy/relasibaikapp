<div class="my-24 min-h-screen">
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
                class="mb-4 mx-4 sm:mx-0 p-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200 flex items-center"
                role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="font-medium">{{ session('message') }}</span>
            </div>
        @endif

        <div class="border border-slate-300 shadow-sm rounded-2xl bg-white">
            <div class="p-4 flex justify-end">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                        <i class="fas fa-search text-gray-500"></i>
                    </div>
                    <input wire:model.live.debounce.300ms="search" type="text"
                        class="block w-full p-2.5 pl-10 text-sm text-slate-900 border border-slate-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                        placeholder="Cari lokasi atau tanggal...">
                </div>
            </div>

            {{-- Tabel Data --}}
            <div class="bg-white overflow-hidden">
                @if ($screenings->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-slate-500">
                            <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-200">
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
                                    <tr
                                        class="bg-white border-b hover:bg-blue-50 transition-colors group cursor-pointer">

                                        {{-- Kolom No (Klik Baris -> Detail) --}}
                                        <td onclick="window.location='{{ route('screening.result', $item->id) }}'"
                                            class="px-6 py-4 text-center">
                                            {{ $screenings->firstItem() + $index }}
                                        </td>

                                        {{-- Kolom Tanggal (Klik Baris -> Detail) --}}
                                        <td onclick="window.location='{{ route('screening.result', $item->id) }}'"
                                            class="px-6 py-4 font-medium text-slate-900 whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($item->tanggal_pengisian)->format('d F Y') }}
                                            <br>
                                            <span class="text-xs text-slate-400 font-normal">
                                                {{ $item->created_at->format('H:i') }} WIB
                                            </span>
                                        </td>

                                        {{-- Kolom Lokasi (Klik Baris -> Detail) --}}
                                        <td onclick="window.location='{{ route('screening.result', $item->id) }}'"
                                            class="px-6 py-4">
                                            <div class="flex items-center">
                                                <svg class="w-3.5 h-3.5 text-slate-400 mr-2" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                    </path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                {{ $item->lokasi ?? '-' }}
                                            </div>
                                        </td>

                                        {{-- Kolom Hasil (Klik Baris -> Detail) --}}
                                        <td onclick="window.location='{{ route('screening.result', $item->id) }}'"
                                            class="px-6 py-4">
                                            @if ($item->recommendation)
                                                <span
                                                    class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded border border-blue-200">
                                                    {{ $item->recommendation->title }}
                                                </span>
                                            @else
                                                <span class="text-slate-400 italic">Tidak ada data</span>
                                            @endif
                                        </td>

                                        {{-- Kolom Aksi (STOP PROPAGATION agar tidak memicu klik baris) --}}
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex justify-center items-center gap-3">

                                                <a href="{{ route('screening.result', ['resultId' => $item->id, 'action' => 'print']) }}"
                                                    target="_blank"
                                                    class="text-slate-500 hover:text-blue-600 transition-colors tooltip"
                                                    title="Cetak PDF">

                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                                                        </path>
                                                    </svg>
                                                </a>

                                                {{-- Tombol Hapus --}}
                                                <button wire:click="delete({{ $item->id }})"
                                                    wire:confirm="Apakah Anda yakin ingin menghapus riwayat ini? Data tidak dapat dikembalikan."
                                                    class="text-slate-500 hover:text-red-600 transition-colors"
                                                    title="Hapus">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
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
                    <div class="flex flex-col items-center justify-center py-12 text-center">
                        <div class="p-4 rounded-full bg-slate-100 mb-4">
                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-slate-900">Belum ada riwayat</h3>
                        <p class="text-slate-500 mt-1 max-w-sm">
                            @if (!empty($search))
                                Tidak ditemukan data dengan kata kunci "{{ $search }}".
                            @else
                                Anda belum menyimpan hasil skrining apapun. Mulai skrining sekarang untuk melihat
                                hasilnya
                                disini.
                            @endif
                        </p>
                        @if (empty($search))
                            <a href="{{ route('screening.wizard') }}"
                                class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors text-sm font-medium">
                                Mulai Skrining Baru
                            </a>
                        @endif
                    </div>
                @endif
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
