<section class="min-h-screen my-24 flex justify-center items-center print:p-0 print:bg-white">
    <div class="max-w-6xl w-full bg-white rounded-2xl shadow-xl overflow-hidden print:shadow-none print:max-w-none">

        <div
            class="bg-blue-500 p-8 text-white relative rounded-t-2xl print:text-center print:bg-white print:text-black print:p-0 print:mb-4 print:border-b-2 print:border-black">
            <h2 class="text-3xl font-bold mb-2 print:text-black">
                Hasil Skrining
            </h2>
            <p class="opacity-90 print:text-gray-600">
                Nama: {{ Auth::user()->name }} | Tanggal:
                {{ \Carbon\Carbon::parse($screeningData->tanggal_pengisian)->format('d M Y') }}
            </p>
        </div>

        <div class="p-8 print:p-0">

            {{-- KOTAK DIAGNOSA --}}
            <div
                class="bg-blue-50 border-l-4 border-blue-600 p-6 rounded-l-lg mb-10 shadow-sm print:bg-white print:border border-black">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="mb-2">
                            <span
                                class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                                Diagnosa / Rekomendasi
                            </span>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900 mb-2">
                            {{ $screeningData->recommendation->title ?? 'Data Tidak Ditemukan' }}
                        </h3>
                        <p class="text-lg text-gray-700 leading-relaxed">
                            {{ $screeningData->recommendation->description }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- DETAIL SKOR (Grid Layout) --}}
            <h4 class="text-xl font-bold text-gray-800 mb-6 border-b pb-2 print:mt-6">Ringkasan Skor</h4>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 print:grid-cols-3 print:gap-4">
                {{-- Kartu Ayah --}}
                <div class="bg-white border rounded-xl p-5 text-center print:border-black">
                    <h5 class="text-lg font-semibold text-gray-700 mb-1">Relasi Ayah</h5>
                    <div class="text-3xl font-bold text-blue-600 mb-1 print:text-black">{{ $catFather }}
                    </div>
                    <p class="text-sm text-gray-500">Skor: {{ $screeningData->result->fpq_score }}</p>
                </div>
                {{-- Kartu Ibu --}}
                <div class="bg-white border rounded-xl p-5 text-center print:border-black">
                    <h5 class="text-lg font-semibold text-gray-700 mb-1">Relasi Ibu</h5>
                    <div class="text-3xl font-bold text-pink-500 mb-1 print:text-black">{{ $catMother }}
                    </div>
                    <p class="text-sm text-gray-500">Skor: {{ $screeningData->result->mciq_score }}</p>
                </div>
                {{-- Kartu Lain --}}
                <div class="bg-white border rounded-xl p-5 text-center print:border-black">
                    <h5 class="text-lg font-semibold text-gray-700 mb-1">Keluarga Lain</h5>
                    <div class="text-3xl font-bold text-green-500 mb-1 print:text-black">{{ $catOther }}
                    </div>
                    <p class="text-sm text-gray-500">Skor: {{ $screeningData->result->fmwb_score }}</p>
                </div>
            </div>


            <div class="mt-12 break-before-page">
                <h4 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Lampiran: Detail Jawaban</h4>

                <table
                    class="w-full text-sm text-left text-gray-500 border border-gray-200 print:border-black print:text-black">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 print:bg-gray-200">
                        <tr>
                            <th scope="col" class="px-4 py-3 border-b">No</th>
                            <th scope="col" class="px-4 py-3 border-b">Instrumen</th>
                            <th scope="col" class="px-4 py-3 border-b">Pertanyaan</th>
                            <th scope="col" class="px-4 py-3 border-b text-center">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($screeningData->responses as $index => $response)
                            <tr class="bg-white border-b hover:bg-gray-50 print:border-black">
                                <td class="px-4 py-2 font-medium text-gray-900 text-center">{{ $index + 1 }}
                                </td>
                                <td class="px-4 py-2">
                                    <span
                                        class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded print:border print:border-black print:bg-white print:text-black">
                                        {{ $response->question->instrument->code ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">
                                    {{ $response->question->question_text }}
                                </td>
                                <td class="px-4 py-2 text-center font-bold">
                                    {{ $response->answer_value }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- FOOTER TOMBOL (HILANG SAAT PRINT) --}}
            {{-- Perhatikan class: 'print:hidden' --}}
            <div
                class="print:hidden flex flex-col-reverse sm:flex-row justify-between items-center mt-10 pt-6 border-t border-blue-200 gap-4 relative">
                @if (!request()->routeIs('screening.result'))
                <a href="/"
                    class="w-full sm:w-auto gap-2 inline-flex justify-center items-center px-5 py-3 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 hover:text-slate-900 focus:ring-4 focus:outline-none focus:ring-slate-100 transition-all">
                    <svg class="w-4 h-4 mr-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 5H1m0 0 4 4M1 5l4-4" />
                    </svg>
                    Kembali ke Beranda
                </a>
                @else
                <div></div>
                @endif

                {{-- Tombol Kanan: Dropup Menu (Simpan & Cetak) --}}
                <div x-data="{ open: false }" class="relative w-full sm:w-auto">

                    {{-- Trigger Button --}}
                    <button @click="open = !open"
                        class="w-full sm:w-auto gap-2 inline-flex justify-center items-center px-6 py-3 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 transition-all shadow-lg">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z">
                            </path>
                        </svg>
                        Opsi Lainnya
                        <svg class="w-3 h-3 ml-2 transition-transform duration-200" :class="{ 'rotate-180': open }"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>

                    {{-- Dropup Content --}}
                    <div x-show="open" @click.outside="open = false"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95 translate-y-2"
                        x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="transform opacity-0 scale-95 translate-y-2"
                        class="absolute bottom-full right-0 mb-2 w-48 bg-white rounded-lg shadow-xl border border-gray-100 z-50 overflow-hidden">

                        <ul class="text-sm text-gray-700">

                            {{-- Opsi 1: Simpan ke Riwayat --}}
                            <li>
                                @if ($screeningData->status !== 'saved')
                                    <button wire:click="markAsSaved" wire:loading.attr="disabled"
                                        class="w-full text-left px-4 py-3 hover:bg-blue-50 flex items-center gap-2 transition-colors">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                                            </path>
                                        </svg>
                                        Simpan ke Riwayat
                                    </button>
                                @else
                                    <span
                                        class="w-full text-left px-4 py-3 bg-green-50 text-green-700 flex items-center gap-2 cursor-default">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Tersimpan
                                    </span>
                                @endif
                            </li>

                            {{-- Opsi 2: Cetak PDF (Hanya aktif jika status == saved) --}}
                            <li>
                                @if ($screeningData->status === 'saved')
                                    {{-- Arahkan ke Route Cetak PDF (Nanti dibuat controllernya) --}}
                                    <a href="#" onclick="window.print()"
                                        class="w-full text-left px-4 py-3 hover:bg-blue-50 flex items-center gap-2 transition-colors border-t border-gray-100">
                                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                                            </path>
                                        </svg>
                                        Cetak Hasil (PDF)
                                    </a>
                                @else
                                    <button disabled
                                        class="w-full text-left px-4 py-3 text-gray-400 flex items-center gap-2 cursor-not-allowed border-t border-gray-100"
                                        title="Simpan terlebih dahulu">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                            </path>
                                        </svg>
                                        Cetak (Simpan Dulu)
                                    </button>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            {{-- END FOOTER --}}

        </div>

    </div>
</section>
