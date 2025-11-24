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
            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/60 backdrop-blur-sm transition-opacity">
            <div
                class="bg-white rounded-xl shadow-2xl p-8 max-w-sm w-full text-center transform transition-all scale-100">

                {{-- Loading State --}}
                @if ($isProcessing)
                    <div class="animate-pulse">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Tunggu sebentar yaa...</h3>
                        <p class="text-gray-500 mb-6">Sistem sedang menghitung hasil skrining kamu 🧐</p>
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
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Perhitungan Selesai!</h3>
                        <p class="text-gray-500 mb-6">Hasil skrining kamu sudah siap.</p>

                        <div class="flex justify-center mb-6">
                            <div class="rounded-full bg-blue-100 p-4">
                                <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>

                        <button wire:click="goToResult"
                            class="gap-2 w-full inline-flex justify-center items-center px-5 py-3 text-base font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition-all shadow-lg">
                            Cek Hasil
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 mx-8 mt-4"
            role="alert">
            <strong class="font-bold">Terjadi Kesalahan!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif
</div>

@script
<script>
    // Mendengarkan event 'scroll-to-top' dari Livewire
    Livewire.on('scroll-to-top', () => {
        window.scrollTo({
            top: 0,
            left: 0,
            behavior: 'smooth'
        });
    });
</script>
@endscript
