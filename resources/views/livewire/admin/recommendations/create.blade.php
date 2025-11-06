<div>
    {{-- Request #1 & #2: Struktur HTML Rapi & Breadcrumb Fungsional --}}
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a href="{{ route('recommendationsindex') }}" wire:navigate
                    class="inline-flex items-center text-sm font-normal text-slate-400 hover:text-blue-600">
                    Rekomendasi
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
    <h1 class="text-2xl font-bold mb-6">Buat Rekomendasi</h1>

    {{-- Bungkus semua form dengan tag <form> --}}
    <form wire:submit="save">
        <div class="rounded-2xl mb-6 shadow-sm border border-gray-200 bg-white p-5">
            <div class="grid grid-cols-2 gap-10 mb-4">
                {{-- Kolom Kiri --}}
                <div>
                    {{-- Request #3: Input Nama Fungsional --}}
                    <div class="mb-6">
                        <label for="title" class="block mb-2 font-semibold text-base text-gray-900">Nama</label>
                        <input wire:model="title" type="text" id="title"
                            class="bg-white border text-gray-900 text-sm rounded-lg focus:outline-none block w-full p-2.5
                                      @error('title') border-red-500 @else border-gray-400 @enderror
                                     ">
                        {{-- Request #4: Pesan Error --}}
                        @error('title')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Request #3: Input Skor Minimal Fungsional --}}
                    <div class="mb-6">
                        <label for="min_score" class="block mb-2 font-semibold text-base text-gray-900">Minimal
                            Skor</label>
                        <input wire:model="min_score" type="number" id="min_score"
                            class="bg-white border text-gray-900 text-sm rounded-lg focus:outline-none block w-full p-2.5
                                      @error('min_score') border-red-500 @else border-gray-400 @enderror
                                     ">
                        @error('min_score')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Request #3: Input Skor Maksimal Fungsional --}}
                    <div class="">
                        <label for="max_score" class="block mb-2 font-semibold text-base text-gray-900">Maksimal
                            Skor</label>
                        <input wire:model="max_score" type="number" id="max_score"
                            class="bg-white border text-gray-900 text-sm rounded-lg focus:outline-none block w-full p-2.5
                                      @error('max_score') border-red-500 @else border-gray-400 @enderror
                                     ">
                        @error('max_score')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Kolom Kanan --}}
                <div class="">
                    {{-- Request #3: Input Deskripsi Fungsional --}}
                    <label for="description" class="block mb-2 font-semibold text-base text-gray-900">Deskripsi</label>
                    <textarea wire:model="description" id="description" rows="10" {{-- Dibuat lebih panjang agar seimbang --}}
                        class="bg-white border text-gray-900 text-sm rounded-lg focus:outline-none block w-full p-2.5
                                     @error('description') border-red-500 @else border-gray-400 @enderror
                                    "></textarea>
                    {{-- Request #4: Pesan Error --}}
                    @error('description')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
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
