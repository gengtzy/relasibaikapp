<div>
    <form wire:submit="save">
        <section id="form" class="flex flex-col items-center min-h-screen py-24">
            <div
                class="w-full max-w-6xl h-auto p-4 md:p-12 bg-blue-500/30 backdrop-blur-sm border border-gray-200 rounded-lg shadow-lg">

                {{-- Header Instruksi --}}
                <div class="bg-slate-100/90 p-6 rounded-lg shadow-md mb-8 text-center border border-slate-200">
                    <h5 class="mb-4 text-2xl font-bold tracking-tight text-slate-800">
                        Jawablah sesuai kondisi Anda saat ini 😊
                    </h5>
                    <p class="text-lg text-gray-700">
                        Pernyataan di bawah ini berkaitan dengan relasi Anda dengan sosok <strong>Ayah</strong>.
                        <br>
                        Geser tombol di bawah ini untuk menggambarkan kondisi Anda.
                        <br>
                        Mohon isi <strong>{{ count($questions) }} butir pernyataan</strong> dengan jujur.
                    </p>
                </div>

                {{-- Daftar Pertanyaan --}}
                <div class="space-y-16 bg-slate-100/90 p-6 rounded-lg shadow-md mb-8 border border-slate-200">
                    @foreach ($questions as $index => $question)
                        <div class="">

                            {{-- Teks Pertanyaan --}}
                            <h5 class="text-xl font-semibold text-slate-800 mb-6 leading-relaxed">
                                <span class="text-blue-600 mr-1">{{ $loop->iteration }}.</span>
                                {{ $question->question_text }}
                                <span class="text-red-500" title="Wajib diisi">*</span>
                            </h5>

                            {{-- AREA SLIDER --}}
                            <div class="relative w-full mb-2">

                                {{-- Label Atas Slider --}}
                                <div class="flex justify-between mb-2 text-sm font-medium text-slate-600">
                                    <span>Sangat Tidak Sesuai</span>
                                    <span>Sangat Sesuai</span>
                                </div>

                                {{-- Input Range (The Slider) --}}
                                <input type="range" wire:model.live="answers.{{ $question->id }}" min="1"
                                    max="9" step="1"
                                    class="w-full h-3 bg-gray-200 rounded-lg appearance-none cursor-pointer range-lg focus:outline-none focus:ring-2 focus:ring-blue-500 accent-blue-500">

                                {{-- Angka Indikator di Bawah --}}
                                <div class="flex justify-between text-xs text-gray-400 mt-2 px-1 font-mono">
                                    @for ($i = 1; $i <= 9; $i++)
                                        <span class="flex flex-col items-center">
                                            <span>|</span>
                                            <span>{{ $i }}</span>
                                        </span>
                                    @endfor
                                </div>

                                {{-- Feedback Visual Nilai Terpilih (Opsional tapi UX bagus)
                                <div class="text-center mt-2">
                                    @if (isset($answers[$question->id]))
                                        <span class="inline-block px-3 py-1 text-sm font-bold text-blue-600 bg-blue-100 rounded-full">
                                            Pilihan Anda: {{ $answers[$question->id] }}
                                        </span>
                                    @else
                                        <span class="text-sm text-gray-400 italic">Belum dipilih</span>
                                    @endif
                                </div> --}}

                            </div>

                            {{-- Pesan Error --}}
                            @error("answers.{$question->id}")
                                <p class="mt-2 text-sm text-red-600 font-medium flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    @endforeach
                </div>

                {{-- Footer Navigasi --}}
                <div
                    class="flex flex-col-reverse sm:flex-row justify-between items-center mt-12 pt-6 border-t border-blue-200 gap-4">

                    {{-- Tombol Kembali --}}
                    <button type="button" wire:click="back"
                        class="w-full sm:w-auto inline-flex justify-center items-center px-5 py-3 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 hover:text-slate-900 focus:ring-4 focus:outline-none focus:ring-slate-100 transition-all">
                        <svg class="w-3.5 h-3.5 mr-2 transform rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                        Kembali ke Kuisioner Ayah
                    </button>

                    {{-- Tombol Lanjut --}}
                    <button type="submit"
                        class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 shadow-md hover:shadow-lg transition-all">
                        Lanjut ke Kuisioner Keluarga Lain
                        <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </button>
                </div>

            </div>
        </section>
    </form>

    {{-- Custom CSS untuk Slider agar lebih cantik (Opsional, bisa ditaruh di app.css) --}}
    <style>
        input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none;
            height: 24px;
            width: 24px;
            border-radius: 50%;
            background: #3b82f6;
            /* Tailwind blue-500 */
            cursor: pointer;
            margin-top: -8px;
            /* Sejajarkan tengah */
            box-shadow: 0 0 2px rgba(0, 0, 0, 0.2);
        }

        input[type=range]::-webkit-slider-runnable-track {
            width: 100%;
            height: 8px;
            cursor: pointer;
            background: #e2e8f0;
            /* Tailwind gray-200 */
            border-radius: 10px;
        }
    </style>
</div>
