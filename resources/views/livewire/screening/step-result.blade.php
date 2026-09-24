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
                                Diagnosa
                            </span>
                        </div>
                        <h3
                            class="text-3xl font-bold text-gray-900 mb-2 dark:text-slate-50 transition-colors duration-500 ease-in-out">
                            {{ $screeningData->result->recommendation->title ?? 'Data Tidak Ditemukan' }}
                        </h3>
                        <p
                            class="text-lg text-gray-700 leading-relaxed dark:text-slate-200 transition-colors duration-500 ease-in-out">
                            {{ $screeningData->result->recommendation->description }}
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

                {{-- Tombol Kanan: Langsung Cetak PDF --}}
                <button onclick="window.print()"
                    class="w-full sm:w-auto gap-2 inline-flex justify-center items-center px-6 py-3 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 transition-all shadow-lg transform hover:scale-[1.02] active:scale-95">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                        </path>
                    </svg>
                    Cetak Hasil (PDF)
                </button>
                
            </div>
            {{-- END FOOTER --}}

        </div>

    </div>
</section>
