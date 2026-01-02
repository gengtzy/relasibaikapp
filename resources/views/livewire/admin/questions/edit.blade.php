<div x-data="{ showModal: @entangle('showModal') }" 
     x-init="$watch('showModal', value => {
         if (value) {
             document.body.classList.add('overflow-hidden');
         } else {
             document.body.classList.remove('overflow-hidden');
         }
     })">

    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a href="{{ route('questionsindex') }}" wire:navigate
                    class="inline-flex items-center text-sm font-normal text-slate-400 hover:text-blue-600">
                    Pertanyaan
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    <span class="pl-2 inline-flex items-center text-sm font-normal text-slate-600 truncate max-w-xs">
                        {{ $question_text }}
                    </span>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    <span class="pl-2 inline-flex items-center text-sm font-normal text-slate-600">
                        Edit
                    </span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="flex items-start justify-between">
        <h1 class="text-2xl font-bold mb-6 truncate max-w-3xl">{{ $question_text }}</h1>

        {{-- UPDATE TOMBOL HAPUS: Trigger Modal --}}
        <button @click="showModal = true" type="button"
            class="items-center rounded-lg border border-red-300 bg-red-600 p-2 font-semibold text-white hover:bg-red-700">
            <span>Hapus</span>
        </button>
    </div>

    <form wire:submit="update">
        <div class="rounded-2xl mb-6 shadow-sm border border-gray-200 bg-white p-5">
            <div class="grid grid-cols-2 mb-4">

                <div class="mb-6 mr-6">
                    <label for="id_instrument" class="block mb-2 font-semibold text-base text-gray-900">Instrumen</label>
                    <select wire:model="id_instrument" id="id_instrument"
                        class="block w-full rounded-lg border bg-white p-2.5 text-sm text-gray-900 focus:outline-none
                               @error('id_instrument') border-red-500 @else border-gray-400 @enderror">
                        <option value="">Pilih Instrumen</option>
                        @foreach ($instruments as $instrument)
                            <option value="{{ $instrument->id }}">{{ $instrument->code }} - {{ $instrument->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_instrument')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="">
                    <label for="scoring_type" class="block mb-2 font-semibold text-base text-gray-900">Tipe Skoring</label>
                    <select wire:model="scoring_type" id="scoring_type"
                        class="block w-full rounded-lg border bg-white p-2.5 text-sm text-gray-900 focus:outline-none
                               @error('scoring_type') border-red-500 @else border-gray-400 @enderror">
                        <option value="">Pilih Tipe</option>
                        <option value="Favorable">Favorable</option>
                        <option value="Unfavorable">Unfavorable</option>
                    </select>
                    @error('scoring_type')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-2">
                    <label for="question_text" class="block mb-2 font-semibold text-base text-gray-900">Pertanyaan</label>
                    <textarea wire:model="question_text" id="question_text" rows="4"
                        class="bg-white border text-gray-900 text-sm rounded-lg focus:outline-none block w-full p-2.5
                               @error('question_text') border-red-500 @else border-gray-400 @enderror"></textarea>
                    @error('question_text')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="flex justify-start space-x-4 pb-4">
            <button type="submit"
                class="items-center rounded-lg border border-blue-300 bg-blue-500 p-2 font-semibold text-white hover:bg-blue-500/90">
                <span>Simpan</span>
            </button>
            <button wire:click="cancel" type="button"
                class="items-center rounded-lg border border-gray-300 bg-white p-2 font-semibold text-gray-900 hover:bg-gray-100">
                <span>Batal</span>
            </button>
        </div>
    </form>

    {{-- MODAL HAPUS FIX --}}
    <div x-show="showModal" style="display: none;" 
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="!m-0 fixed inset-0 z-[9999] flex items-center justify-center w-full bg-gray-900/60 backdrop-blur-sm p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-screen">

        <div @click.outside="showModal = false" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
            class="relative w-full max-w-md max-h-full">

            <div class="relative bg-white border border-gray-200 rounded-xl shadow-2xl p-4 md:p-6">

                <button type="button" @click="showModal = false"
                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center transition-colors">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>

                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>

                    <h3 class="mb-2 text-lg font-normal text-gray-500">
                        Hapus Pertanyaan ini?
                    </h3>

                    {{-- Detail Pertanyaan --}}
                    <div class="mb-6 py-2 px-3 bg-gray-50 rounded-lg border border-gray-100 inline-block w-full">
                        <p class="font-mono text-sm font-bold text-gray-800 text-left line-clamp-3">
                            "{{ $question_text }}"
                        </p>
                    </div>

                    <div class="flex items-center justify-center gap-3">
                        <button wire:click="delete" wire:loading.attr="disabled" type="button"
                            class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center transition-all shadow-md hover:shadow-lg disabled:opacity-50">
                            <span wire:loading.remove>Ya, Hapus Data</span>
                            <span wire:loading>Menghapus...</span>
                        </button>

                        <button @click="showModal = false" type="button"
                            class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 transition-all shadow-sm">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>