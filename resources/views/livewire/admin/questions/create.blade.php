<div>
    {{-- Request #1 & #2: Struktur HTML Rapi & Breadcrumb Fungsional --}}
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
                    <span class="pl-2 inline-flex items-center text-sm font-normal text-slate-600">
                        Baru
                    </span>
                </div>
            </li>
        </ol>
    </nav>
    <h1 class="text-2xl font-bold mb-6">Buat Pertanyaan</h1>

    {{-- Bungkus semua form dengan tag <form> --}}
    <form wire:submit="save">
        <div class="rounded-2xl mb-6 shadow-sm border border-gray-200 bg-white p-5">
            <div class="grid grid-cols-2 mb-4">
                
                {{-- Request #3: Input Instrumen Fungsional --}}
                <div class="mb-6 mr-6">
                    <label for="id_instrument" class="block mb-2 font-semibold text-base text-gray-900">Instrumen</label>
                    <select wire:model="id_instrument" id="id_instrument" 
                            class="block w-full rounded-lg border bg-white p-2.5 text-sm text-gray-900 focus:outline-none
                                   {{-- Logika border merah saat error --}}
                                   @error('id_instrument')
                                       border-red-500 focus:ring-red-500 focus:border-red-500
                                   @else
                                       border-gray-400 focus:ring-blue-500 focus:border-blue-500
                                   @enderror
                                  ">
                        <option value="">Pilih Instrumen</option>
                        {{-- Loop data instrumen dari database --}}
                        @foreach($instruments as $instrument)
                            <option value="{{ $instrument->id }}">{{ $instrument->code }} - {{ $instrument->name }}</option>
                        @endforeach
                    </select>
                    {{-- Request #4: Pesan Error --}}
                    @error('id_instrument') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Request #3: Input Tipe Skoring Fungsional --}}
                <div class="">
                    <label for="scoring_type" class="block mb-2 font-semibold text-base text-gray-900">Tipe Skoring</label>
                    <select wire:model="scoring_type" id="scoring_type" 
                            class="block w-full rounded-lg border bg-white p-2.5 text-sm text-gray-900 focus:outline-none
                                   @error('scoring_type')
                                       border-red-500 focus:ring-red-500 focus:border-red-500
                                   @else
                                       border-gray-400 focus:ring-blue-500 focus:border-blue-500
                                   @enderror
                                  ">
                        <option value="">Pilih Tipe</option>
                        <option value="Favorable">Favorable</option>
                        <option value="Unfavorable">Unfavorable</option>
                    </select>
                    {{-- Request #4: Pesan Error --}}
                    @error('scoring_type') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Request #3: Input Pertanyaan Fungsional --}}
                <div class="col-span-2">
                    <label for="question_text" class="block mb-2 font-semibold text-base text-gray-900">Pertanyaan</label>
                    <textarea wire:model="question_text" id="question_text" rows="4" 
                              class="bg-white border text-gray-900 text-sm rounded-lg focus:outline-none block w-full p-2.5
                                     @error('question_text')
                                         border-red-500 focus:ring-red-500 focus:border-red-500
                                     @else
                                         border-gray-400 focus:ring-blue-500 focus:border-blue-500
                                     @enderror
                                    "></textarea>
                    {{-- Request #4: Pesan Error --}}
                    @error('question_text') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="flex justify-start space-x-4 pb-4">
            {{-- Request #5: Tombol "Buat" fungsional --}}
            <button type="submit"
                    class="items-center rounded-lg border border-blue-300 bg-blue-500 p-2 font-semibold text-white hover:bg-blue-500/90">
                <span>Buat</span>
            </button>
            {{-- Request #6: Tombol "Batal" fungsional --}}
            <button wire:click="cancel" type="button"
                    class="items-center rounded-lg border border-gray-300 bg-white p-2 font-semibold text-gray-900 hover:bg-gray-100">
                <span>Batal</span>
            </button>
        </div>
    </form>
</div>