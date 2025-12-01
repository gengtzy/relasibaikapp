<div>
    <form wire:submit="save">
        <section id="form" class="w-full max-w-6xl mx-auto my-24 border border-white shadow-xl rounded-2xl dark:border-slate-600 transition-colors duration-500 ease-in-out">

            <div class="bg-blue-500 p-8 text-white relative rounded-t-2xl">
                <h2 class="text-3xl font-bold mb-2">Jawablah sesuai kondisi Anda saat ini</h2>
                <p class="opacity-90">
                    Pernyataan di bawah ini berkaitan dengan relasi Anda dengan sosok <strong>Ibu</strong>.
                    <br>
                    Mohon isi <strong>{{ count($questions) }} butir pernyataan</strong> dengan jujur.
                </p>
            </div>

            {{-- Daftar Pertanyaan --}}
            <div class="h-auto p-8 bg-white rounded-b-2xl space-y-12 dark:bg-slate-700 transition-colors duration-500 ease-in-out">
                @foreach ($questions as $index => $question)
                    <div class="mb-12">
                        <h5 class="text-lg font-semibold text-slate-800 leading-relaxed mb-4 dark:text-slate-50 transition-colors duration-500 ease-in-out">
                            <span class="text-blue-600 mr-1">{{ $loop->iteration }}.</span>
                            {{ $question->question_text }}
                            <span class="text-red-500" title="Wajib diisi">*</span>
                        </h5>

                        <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-5 gap-3">

                            {{-- 0: Sangat Tidak Sesuai --}}
                            <label class="cursor-pointer group">
                                <input type="radio" wire:model.live="answers.{{ $question->id }}" value="0"
                                    class="peer sr-only">
                                <div
                                    class="p-3 text-center rounded-lg border border-gray-300 bg-gray-50 text-gray-600 peer-checked:bg-red-100 peer-checked:text-red-700 peer-checked:border-red-500 transition-all hover:bg-gray-100 dark:bg-slate-600 dark:text-slate-300 dark:border-slate-500 duration-500 ease-in-out">
                                    <div class="text-sm font-medium">Sangat Tidak Sesuai</div>
                                </div>
                            </label>

                            {{-- 1: Tidak Sesuai --}}
                            <label class="cursor-pointer group">
                                <input type="radio" wire:model.live="answers.{{ $question->id }}" value="1"
                                    class="peer sr-only">
                                <div
                                    class="p-3 text-center rounded-lg border border-gray-300 bg-gray-50 text-gray-600 peer-checked:bg-orange-100 peer-checked:text-orange-700 peer-checked:border-orange-500 transition-all hover:bg-gray-100 dark:bg-slate-600 dark:text-slate-300 dark:border-slate-500 duration-500 ease-in-out">
                                    <div class="text-sm font-medium">Tidak Sesuai</div>
                                </div>
                            </label>

                            {{-- 2: Netral --}}
                            <label class="cursor-pointer group">
                                <input type="radio" wire:model.live="answers.{{ $question->id }}" value="2"
                                    class="peer sr-only">
                                <div
                                    class="p-3 text-center rounded-lg border border-gray-300 bg-gray-50 text-gray-600 peer-checked:bg-gray-200 peer-checked:text-gray-800 peer-checked:border-gray-500 transition-all hover:bg-gray-100 dark:bg-slate-600 dark:text-slate-300 dark:border-slate-500 duration-500 ease-in-out">
                                    <div class="text-sm font-medium">Netral</div>
                                </div>
                            </label>

                            {{-- 3: Sesuai --}}
                            <label class="cursor-pointer group">
                                <input type="radio" wire:model.live="answers.{{ $question->id }}" value="3"
                                    class="peer sr-only">
                                <div
                                    class="p-3 text-center rounded-lg border border-gray-300 bg-gray-50 text-gray-600 peer-checked:bg-blue-100 peer-checked:text-blue-700 peer-checked:border-blue-500 transition-all hover:bg-gray-100 dark:bg-slate-600 dark:text-slate-300 dark:border-slate-500 duration-500 ease-in-out">
                                    <div class="text-sm font-medium">Sesuai</div>
                                </div>
                            </label>

                            {{-- 4: Sangat Sesuai --}}
                            <label class="cursor-pointer group">
                                <input type="radio" wire:model.live="answers.{{ $question->id }}" value="4"
                                    class="peer sr-only">
                                <div
                                    class="p-3 text-center rounded-lg border border-gray-300 bg-gray-50 text-gray-600 peer-checked:bg-green-100 peer-checked:text-green-700 peer-checked:border-green-500 transition-all hover:bg-gray-100 dark:bg-slate-600 dark:text-slate-300 dark:border-slate-500 duration-500 ease-in-out">
                                    <div class="text-sm font-medium">Sangat Sesuai</div>
                                </div>
                            </label>
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

                    {{-- Tombol Kembali --}}
                    <button type="button" wire:click="back"
                        class="w-full sm:w-auto gap-2 inline-flex justify-center items-center px-5 py-3 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 hover:text-slate-900 focus:ring-1 focus:outline-none dark:bg-slate-600 dark:border-slate-500 dark:text-slate-50 transition-colors duration-500 ease-in-out">
                        <i class="fas fa-arrow-left"></i>
                        Kembali ke Kuisioner Ayah
                    </button>

                    {{-- Tombol Lanjut --}}
                    <button type="submit"
                        class="gap-2 w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 shadow-md hover:shadow-lg transition-all">
                        Lanjut ke Kuisioner Keluarga Lain
                        <i class="fas fa-arrow-right"></i>
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
