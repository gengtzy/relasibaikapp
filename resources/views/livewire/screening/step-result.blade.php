<section class="min-h-screen my-24 flex justify-center items-center print:p-0 print:bg-white">
    <div
        class="mx-5 md:w-full md:max-w-6xl md:mx-auto bg-white rounded-2xl shadow-xl overflow-hidden print:shadow-none print:max-w-none dark:bg-slate-700 transition-colors duration-500 ease-in-out">

        <div
            class="bg-blue-500 p-8 text-white relative rounded-t-2xl print:text-center print:bg-white print:text-black print:p-0 print:mb-4 print:border-b-2 print:border-black">
            <h2 class="text-3xl font-bold mb-2 print:text-black">
                Hasil Skrining
            </h2>
            <p class="opacity-90 print:text-gray-600">
                Nama: {{ Auth::user()->name }} |
                Superior: {{ Auth::user()->superiority_role ?? '-' }} |
                Tanggal: {{ \Carbon\Carbon::parse($screeningData->tanggal_pengisian)->format('d M Y') }}
            </p>
        </div>

        <div class="p-8 print:p-0">

            {{-- KOTAK DIAGNOSA --}}
            <div
                class="bg-blue-50 border-l-4 border-blue-600 p-6 rounded-l-lg mb-10 shadow-sm print:bg-white print:border print:border-black dark:bg-slate-500 transition-colors duration-500 ease-in-out">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="mb-2">
                            <span
                                class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                                Diagnosa / Rekomendasi
                            </span>
                        </div>
                        <h3
                            class="text-3xl font-bold text-gray-900 mb-2 dark:text-slate-50 transition-colors duration-500 ease-in-out">
                            {{ $screeningData->recommendation->title ?? 'Data Tidak Ditemukan' }}
                        </h3>
                        <p
                            class="text-lg text-gray-700 leading-relaxed dark:text-slate-200 transition-colors duration-500 ease-in-out">
                            {{ $screeningData->recommendation->description }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- DETAIL SKOR (Grid Layout) --}}
            <h4
                class="text-xl font-bold text-gray-800 mb-6 border-b pb-2 print:mt-6 dark:text-slate-50 transition-colors duration-500 ease-in-out">
                Ringkasan Skor</h4>

            @php
                // Ambil peran superior user saat ini
                $superiorRole = Auth::user()->superiority_role; 
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 print:grid-cols-3 print:gap-4 mt-6">
                
                {{-- Kartu Ayah --}}
                @php
                    $isFatherSuperior = $superiorRole === 'Ayah';
                    // Jika superior: Border Biru Tebal & Relative positioning. Jika tidak: Border biasa.
                    $cardClasses = $isFatherSuperior 
                        ? 'border-2 border-blue-500 relative shadow-blue-100 shadow-lg transform scale-105 md:scale-100' 
                        : 'border border-gray-200';
                @endphp
                <div class="{{ $cardClasses }} bg-white rounded-xl p-5 text-center print:border-black dark:bg-slate-600 dark:border-slate-500 transition-all duration-300 ease-in-out">
                    
                    @if($isFatherSuperior)
                        <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 bg-blue-500 text-white text-[10px] uppercase font-bold px-3 py-1 rounded-full shadow-sm">
                            Peran Superior
                        </div>
                    @endif

                    <h5 class="text-lg font-semibold text-gray-700 mb-1 dark:text-slate-100 transition-colors duration-500 ease-in-out mt-1">
                        Relasi Ayah
                    </h5>
                    <div class="text-3xl font-bold text-blue-600 mb-1 print:text-black">
                        {{ $catFather }}
                    </div>
                    <p class="text-sm text-gray-500 dark:text-slate-200 transition-colors duration-500 ease-in-out">
                        Skor: {{ $screeningData->result->fpq_score }}
                    </p>
                </div>

                {{-- Kartu Ibu --}}
                @php
                    $isMotherSuperior = $superiorRole === 'Ibu';
                    // Jika superior: Border Pink Tebal
                    $cardClasses = $isMotherSuperior 
                        ? 'border-2 border-pink-500 relative shadow-pink-100 shadow-lg transform scale-105 md:scale-100' 
                        : 'border border-gray-200';
                @endphp
                <div class="{{ $cardClasses }} bg-white rounded-xl p-5 text-center print:border-black dark:bg-slate-600 dark:border-slate-500 transition-all duration-300 ease-in-out">
                    
                    @if($isMotherSuperior)
                        <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 bg-pink-500 text-white text-[10px] uppercase font-bold px-3 py-1 rounded-full shadow-sm">
                            Peran Superior
                        </div>
                    @endif

                    <h5 class="text-lg font-semibold text-gray-700 mb-1 dark:text-slate-100 transition-colors duration-500 ease-in-out">
                        Relasi Ibu
                    </h5>
                    <div class="text-3xl font-bold text-pink-500 mb-1 print:text-black">
                        {{ $catMother }}
                    </div>
                    <p class="text-sm text-gray-500 dark:text-slate-200 transition-colors duration-500 ease-in-out">
                        Skor: {{ $screeningData->result->mciq_score }}
                    </p>
                </div>

                {{-- Kartu Lain --}}
                @php
                    // Pastikan stringnya sama persis dengan yang ada di database/input select
                    $isOtherSuperior = $superiorRole === 'Anggota Keluarga lain'; 
                    // Jika superior: Border Hijau Tebal
                    $cardClasses = $isOtherSuperior 
                        ? 'border-2 border-green-500 relative shadow-green-100 shadow-lg transform scale-105 md:scale-100' 
                        : 'border border-gray-200';
                @endphp
                <div class="{{ $cardClasses }} bg-white rounded-xl p-5 text-center print:border-black dark:bg-slate-600 dark:border-slate-500 transition-all duration-300 ease-in-out">
                    
                    @if($isOtherSuperior)
                        <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 bg-green-500 text-white text-[10px] uppercase font-bold px-3 py-1 rounded-full shadow-sm">
                            Peran Superior
                        </div>
                    @endif

                    <h5 class="text-lg font-semibold text-gray-700 mb-1 dark:text-slate-100 transition-colors duration-500 ease-in-out">
                        Keluarga Lain
                    </h5>
                    <div class="text-3xl font-bold text-green-500 mb-1 print:text-black">
                        {{ $catOther }}
                    </div>
                    <p class="text-sm text-gray-500 dark:text-slate-200 transition-colors duration-500 ease-in-out">
                        Skor: {{ $screeningData->result->fmwb_score }}
                    </p>
                </div>

            </div>


            <div class="mt-12 break-before-page">
                <h4
                    class="text-xl font-bold text-gray-800 mb-4 border-b pb-2 dark:text-slate-50 transition-colors duration-500 ease-in-out">
                    Lampiran: Detail Jawaban</h4>

                <div class="relative overflow-x-auto">
                    <table
                        class="w-full text-sm text-left rtl:text-right text-gray-500 border border-gray-200 print:border-black print:text-black dark:text-slate-200 dark:border-slate-500 transition-colors duration-500 ease-in-out">
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50 print:bg-gray-200 dark:bg-slate-600 dark:text-slate-50 transition-colors duration-500 ease-in-out">
                            <tr>
                                <th scope="col"
                                    class="px-4 py-3 border-b dark:border-slate-500 transition-colors duration-500 ease-in-out">
                                    No</th>
                                <th scope="col"
                                    class="px-4 py-3 border-b dark:border-slate-500 transition-colors duration-500 ease-in-out">
                                    Instrumen</th>
                                <th scope="col"
                                    class="px-4 py-3 border-b dark:border-slate-500 transition-colors duration-500 ease-in-out">
                                    Pertanyaan</th>
                                <th scope="col"
                                    class="px-4 py-3 border-b dark:border-slate-500 transition-colors duration-500 ease-in-out text-center">
                                    Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($screeningData->responses as $index => $response)
                                <tr
                                    class="bg-white border-b hover:bg-gray-50 print:border-black dark:bg-slate-600 dark:border-slate-500 transition-colors duration-500 ease-in-out">
                                    <td
                                        class="px-4 py-2 font-medium text-gray-900 text-center dark:text-slate-50 transition-colors duration-500 ease-in-out">
                                        {{ $index + 1 }}
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
                                        @php
                                            $rawVal = (int) $response->answer_value;
                                            $scoringType = $response->question->scoring_type ?? 'Favorable';
                                            $instrumentCode = $response->question->instrument->code ?? '';
    
                                            $finalScore = $rawVal;
    
                                            // 1. INSTRUMEN IBU (MCIQ)
                                            if ($instrumentCode === 'MCIQ') {
                                                if ($scoringType === 'Favorable') {
                                                    $finalScore = $rawVal;
                                                } else {
                                                    $finalScore = 4 - $rawVal;
                                                }
                                            }
                                            // 2. INSTRUMEN LAIN (FMWB)
                                            elseif ($instrumentCode === 'FMWB') {
                                                if ($scoringType === 'Favorable') {
                                                    $finalScore = $rawVal - 1;
                                                } else {
                                                    $finalScore = 10 - $rawVal;
                                                }
                                            }
                                            // 3. INSTRUMEN AYAH (FPQ) atau Default
                                            else {
                                                $finalScore = $rawVal;
                                            }
                                        @endphp
    
                                        {{ $finalScore }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- FOOTER TOMBOL (HILANG SAAT PRINT) --}}
            {{-- Perhatikan class: 'print:hidden' --}}
            <div
                class="print:hidden flex flex-col-reverse sm:flex-row justify-between items-center mt-10 pt-6 border-t border-blue-200 gap-4 relative">
                @if (!request()->routeIs('screening.result'))
                    <a href="/"
                        class="w-full sm:w-auto gap-2 inline-flex justify-center items-center px-5 py-3 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 hover:text-slate-900 focus:ring-1 focus:outline-none dark:bg-slate-600 dark:border-slate-500 dark:text-slate-50 transition-colors duration-500 ease-in-out">
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
                        class="w-full sm:w-auto gap-2 inline-flex justify-center items-center px-6 py-3 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-1 focus:outline-none focus:ring-blue-300 transition-all shadow-lg">
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
                        class="absolute bottom-full right-0 mb-2 w-48 bg-white rounded-lg shadow-xl border border-gray-100 z-50 overflow-hidden dark:bg-slate-700 dark:border-slate-600 transition-colors duration-500 ease-in-out">

                        <ul class="text-sm text-gray-700 dark:text-slate-50 transition-colors duration-500 ease-in-out">

                            {{-- Opsi 1: Simpan ke Riwayat --}}
                            <li>
                                @if ($screeningData->status !== 'saved')
                                    <button wire:click="markAsSaved" wire:loading.attr="disabled"
                                        class="w-full text-left px-4 py-3 hover:bg-blue-50 flex items-center gap-2 transition-colors dark:hover:bg-slate-600 duration-500 ease-in-out">
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
                                        class="w-full text-left px-4 py-3 bg-green-50 text-green-700 flex items-center gap-2 cursor-default dark:bg-slate-700 transition-colors duration-500 ease-in-out">
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
                                        class="w-full text-left px-4 py-3 hover:bg-blue-50 flex items-center gap-2 transition-colors border-t border-gray-100 dark:border-slate-600 dark:hover:bg-slate-700 duration-500 ease-in-out">
                                        <svg class="w-4 h-4 text-gray-600 dark:text-slate-200 transition-colors duration-500 ease-in-out"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                                            </path>
                                        </svg>
                                        Cetak Hasil (PDF)
                                    </a>
                                @else
                                    <button disabled
                                        class="w-full text-left px-4 py-3 text-gray-400 flex items-center gap-2 cursor-not-allowed border-t border-gray-100 dark:text-slate-600 dark:border-slate-600 dark:bg-slate-800 transition-colors duration-500 ease-in-out"
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
