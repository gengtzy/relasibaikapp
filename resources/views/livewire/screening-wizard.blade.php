<div>
    @if ($currentStep == 1)
        <livewire:screening.step-biodata :default-data="$biodata" />
    @elseif ($currentStep == 2)
        <livewire:screening.step-father :default-answers="$fatherAnswers" />
    @elseif ($currentStep == 3)
        <livewire:screening.step-mother :default-answers="$motherAnswers" />
    @elseif ($currentStep == 4)
        <livewire:screening.step-other :default-answers="$otherAnswers" />
    @elseif ($currentStep == 5)
        <livewire:screening.step-result :resultId="$finalResultId" />
    @endif

    @if ($isProcessing || $isFinished)
        <div
            {{-- Tambahkan wire:transition agar modal munculnya halus (fade in) --}}
            wire:transition.opacity.duration.300ms
            x-data 
            x-init="
                document.body.classList.add('overflow-hidden');
                $cleanup(() => document.body.classList.remove('overflow-hidden'));
            "
            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/60 backdrop-blur-sm transition-opacity overscroll-none">
            
            <div
                class="bg-white mx-5 md:mx-auto overflow-x-hidden overflow-y-auto rounded-3xl shadow-2xl p-8 max-w-sm w-full text-center transform scale-100 dark:bg-slate-600 transition-colors duration-500 ease-in-out">

                {{-- Loading State (Hanya untuk jaga-jaga kalau dipanggil terpisah) --}}
                @if ($isProcessing && !$isFinished)
                    <div class="animate-pulse">
                        <h3 class="text-xl font-bold text-gray-800 mb-2 dark:text-slate-50">Tunggu sebentar yaa...</h3>
                        <p class="text-gray-500 mb-6 dark:text-slate-100">Sistem sedang menghitung hasil skrining kamu 🧐</p>
                        <div class="flex justify-center">
                            <svg class="animate-spin h-12 w-12 text-blue-500" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </div>
                    </div>
                @endif

                {{-- Success State --}}
                @if ($isFinished)
                    {{-- Kita pakai Alpine.js untuk mentrigger animasi checkmark setelah modal terbuka --}}
                    <div x-data="{ showCheck: false }" x-init="setTimeout(() => showCheck = true, 100)">
                        
                        <h3 class="text-xl font-bold text-gray-800 mb-2 dark:text-slate-50 transition-colors duration-500 ease-in-out">Perhitungan Selesai!</h3>
                        <p class="text-gray-500 mb-6 dark:text-slate-100 transition-colors duration-500 ease-in-out">Hasil skrining kamu sudah siap.</p>

                        <div class="flex justify-center mb-6 h-20 items-center">
                            {{-- Animasi Ikon Checklist (Membesar dan berputar sedikit) --}}
                            <div x-show="showCheck" 
                                 x-transition:enter="transition ease-out duration-500"
                                 x-transition:enter-start="opacity-0 scale-50 rotate-[-45deg]"
                                 x-transition:enter-end="opacity-100 scale-100 rotate-0"
                                 class="rounded-full bg-blue-100 p-4 shadow-inner" style="display: none;">
                                <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>

                        <button wire:click="goToResult"
                            {{-- BUKA GEMBOK SCROLL SECARA MANUAL SAAT DIKLIK --}}
                            @click="document.body.classList.remove('overflow-hidden')"
                            wire:loading.attr="disabled"
                            wire:target="goToResult"
                            class="gap-2 w-full inline-flex justify-center items-center px-5 py-3 text-base font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition-all shadow-lg transform hover:scale-[1.02] active:scale-95 disabled:opacity-70 disabled:cursor-not-allowed">
                            
                            {{-- State Normal --}}
                            <span wire:loading.remove wire:target="goToResult" class="flex items-center gap-2">
                                Cek Hasil
                                <i class="fas fa-arrow-right"></i>
                            </span>

                            {{-- State Loading --}}
                            <span wire:loading wire:target="goToResult" class="flex items-center gap-2" style="display: none;">
                                <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Memproses..
                            </span>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    @endif
    @if (session()->has('error'))
        <div x-data="{ show: true }" 
             x-show="show"
             x-init="
                document.body.classList.add('overflow-hidden');
                $watch('show', value => {
                    if (!value) document.body.classList.remove('overflow-hidden');
                });
             "
             class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/60 backdrop-blur-sm transition-opacity overscroll-none">
            
            {{-- Kotak Error --}}
            <div class="bg-red-50 border border-red-400 text-red-700 px-6 py-5 rounded-2xl shadow-2xl relative max-w-sm w-full mx-5 text-center"
                role="alert">
                
                <div class="mb-4">
                    <svg class="w-12 h-12 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>

                <strong class="font-bold text-lg block mb-1">Terjadi Kesalahan!</strong>
                <span class="block mb-6">{{ session('error') }}</span>
                
                {{-- Tombol untuk menutup dan mengembalikan scroll --}}
                <button @click="show = false" 
                        class="w-full bg-red-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-red-700 transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    @endif
</div>

@script
<script>
    Livewire.on('scroll-to-top', () => {
        window.scrollTo({
            top: 0,
            left: 0,
            behavior: 'smooth'
        });
    });
</script>
@endscript
