<div>
    <form wire:submit="save">
        <section id="form" class="flex flex-col items-center min-h-screen py-24">
            
            <div class="w-full max-w-6xl h-auto p-4 md:p-12 bg-blue-500/30 backdrop-blur-sm border border-gray-200 rounded-lg shadow-lg">
                
                {{-- Header --}}
                <div class="bg-slate-100/90 p-6 rounded-lg shadow-md mb-8 text-center border border-slate-200">
                    <h5 class="mb-4 text-2xl font-bold tracking-tight text-slate-800">
                        Jawablah sesuai kondisi Anda saat ini 😊
                    </h5>
                    <p class="text-lg text-gray-700">
                        Pernyataan di bawah ini berkaitan dengan relasi Anda dengan <strong>Anggota Keluarga Lain</strong> dan keadaan <strong>Pribadi</strong>.
                        <br>
                        Mohon isi  <strong>{{ count($questions) }} butir pernyataan</strong> dengan jujur.
                        <br>
                        Perhatikan label di kiri dan kanan karena <strong>bisa berbeda</strong> di setiap pertanyaan.
                    </p>
                </div>

                {{-- Daftar Pertanyaan --}}
                <div class="space-y-16 bg-slate-100/90 p-6 rounded-lg shadow-md mb-8 border border-slate-200">
                    @foreach($questions as $index => $question)
                        
                        {{-- Panggil fungsi helper untuk dapat label --}}
                        @php
                            $labels = $this->getLabels($question->question_text);
                        @endphp

                        <div class="">
                            
                            <h5 class="text-xl font-semibold text-slate-800 mb-6 leading-relaxed">
                                <span class="text-blue-600 mr-1">{{ $loop->iteration }}.</span> 
                                {{ $question->question_text }} 
                                <span class="text-red-500">*</span>
                            </h5>
                            
                            {{-- SLIDER --}}
                            <div class="relative w-full mb-2">
                                
                                {{-- Label Dinamis Kiri/Kanan --}}
                                <div class="flex justify-between mb-2 text-sm font-bold text-slate-700">
                                    <span class="text-blue-600">{{ $labels['min'] }}</span>
                                    <span class="text-blue-600">{{ $labels['max'] }}</span>
                                </div>

                                {{-- Input Range --}}
                                <input type="range" 
                                       wire:model.live="answers.{{ $question->id }}" 
                                       min="1" 
                                       max="9" 
                                       step="1" 
                                       class="w-full h-3 bg-gray-200 rounded-lg appearance-none cursor-pointer range-lg focus:outline-none focus:ring-2 focus:ring-blue-500 accent-blue-500">
                                
                                {{-- Angka Indikator --}}
                                <div class="flex justify-between text-xs text-gray-400 mt-2 px-1 font-mono">
                                    @for($i = 1; $i <= 9; $i++)
                                        <span class="flex flex-col items-center">
                                            <span>|</span>
                                            <span>{{ $i }}</span>
                                        </span>
                                    @endfor
                                </div>

                                {{-- Feedback Visual
                                <div class="text-center mt-2">
                                    @if(isset($answers[$question->id]))
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
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $message }}
                                </p> 
                            @enderror
                        </div>
                    @endforeach
                </div>

                {{-- Footer Navigasi --}}
                <div class="flex flex-col-reverse sm:flex-row justify-between items-center mt-12 pt-6 border-t border-blue-200 gap-4">
                    
                    <button type="button" wire:click="back"
                        class="w-full sm:w-auto inline-flex justify-center items-center px-5 py-3 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 hover:text-slate-900 transition-all">
                        <svg class="w-3.5 h-3.5 mr-2 transform rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                        Kembali ke Kuisioner Ibu
                    </button>

                    <button type="submit"
                        class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-md hover:shadow-lg transition-all">
                        Simpan & Lihat Hasil
                        <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
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
            background: #3b82f6; /* Tailwind blue-500 */
            cursor: pointer;
            margin-top: -8px; /* Sejajarkan tengah */
            box-shadow: 0 0 2px rgba(0,0,0,0.2);
        }
        input[type=range]::-webkit-slider-runnable-track {
            width: 100%;
            height: 8px;
            cursor: pointer;
            background: #e2e8f0; /* Tailwind gray-200 */
            border-radius: 10px;
        }
    </style>
</div>