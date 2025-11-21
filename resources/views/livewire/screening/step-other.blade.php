<div>
    <form wire:submit="save">
        <section id="form" class="w-full max-w-6xl mx-auto my-24 border border-white shadow-xl rounded-2xl">

            <div class="bg-blue-500 p-8 text-white relative rounded-t-2xl">
                <h2 class="text-3xl font-bold mb-2">Jawablah sesuai kondisi Anda saat ini</h2>
                <p class="opacity-90">
                    Pernyataan di bawah ini berkaitan dengan relasi Anda dengan <strong>Keluarga Lain dan Diri
                        Sendiri</strong>.
                    <br>
                    Mohon isi <strong>{{ count($questions) }} butir pernyataan</strong> dengan jujur.
                </p>
            </div>

            {{-- Daftar Pertanyaan --}}
            <div class="h-auto p-8 bg-white rounded-b-2xl space-y-12">
                @foreach ($questions as $index => $question)
                    @php
                        $labels = $this->getLabels($question->question_text);
                    @endphp
                    <div class="mb-12">
                        <h5 class="text-xl font-semibold text-slate-800 mb-6 leading-relaxed">
                            <span class="text-blue-600 mr-1">{{ $loop->iteration }}.</span>
                            {{ $question->question_text }}
                            <span class="text-red-500">*</span>
                        </h5>

                        <div class="relative w-full mb-2">

                            {{-- Label Dinamis Kiri/Kanan --}}
                            <div class="flex justify-between mb-2 text-sm font-bold text-slate-700">
                                <span class="text-blue-500">{{ $labels['min'] }}</span>
                                <span class="text-blue-500">{{ $labels['max'] }}</span>
                            </div>

                            {{-- Input Range --}}
                            <input type="range" wire:model.live="answers.{{ $question->id }}" min="1"
                                max="10" step="1"
                                class="w-full h-3 bg-gray-200 rounded-lg appearance-none cursor-pointer range-lg focus:outline-none focus:ring-2 focus:ring-blue-500 accent-blue-500">

                            <div class="flex justify-between text-xs text-gray-400 mt-2 px-1 font-mono">
                                @for ($i = 1; $i <= 10; $i++)
                                    <span class="flex flex-col items-center">
                                        <span>|</span>
                                        <span>{{ $i }}</span>
                                    </span>
                                @endfor
                            </div>

                            {{-- Feedback Visual
                                <div class="text-center mt-2">
                                    @if (isset($answers[$question->id]))
                                        <span class="inline-block px-3 py-1 text-sm font-bold text-blue-600 bg-blue-100 rounded-full">
                                            Nilai: {{ $answers[$question->id] }}
                                        </span>
                                    @else
                                        <span class="text-sm text-gray-400 italic">Geser untuk memilih</span>
                                    @endif
                                </div> --}}

                        </div>

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
                <div
                    class="flex flex-col-reverse sm:flex-row justify-between items-center mt-12 pt-6 border-t border-blue-200 gap-4">

                    <button type="button" wire:click="back"
                        class="gap-2 w-full sm:w-auto inline-flex justify-center items-center px-5 py-3 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 hover:text-slate-900 transition-all">
                        <i class="fas fa-arrow-left"></i>
                        Kembali ke Kuisioner Ibu
                    </button>

                    <button type="submit"
                        class="gap-2 w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-md hover:shadow-lg transition-all">
                        Simpan & Lihat Hasil
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

        </section>
    </form>

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
