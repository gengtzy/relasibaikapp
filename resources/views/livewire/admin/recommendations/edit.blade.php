<div>
    {{-- Request #1 (Koreksi) & #2 (Breadcrumb) --}}
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
                    {{-- Judul dinamis (dipotong agar tidak terlalu panjang) --}}
                    <span class="pl-2 inline-flex items-center text-sm font-normal text-slate-600 truncate max-w-xs">
                        {{ $title }}
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
        <h1 class="text-2xl font-bold mb-6 truncate max-w-3xl">{{ $title }}</h1>

        {{-- Request #3: Tombol "Hapus" fungsional --}}
        <button wire:click="delete" wire:confirm="Anda yakin ingin menghapus '{{ $title }}'?" type="button"
            class="items-center rounded-lg border border-red-300 bg-red-500 p-2 font-semibold text-white hover:bg-red-500/90">
            <span>Hapus</span>
        </button>
    </div>

    {{-- Request #5, #6, #7: Form fungsional --}}
    <form wire:submit="update">
        <div class="rounded-2xl mb-6 shadow-sm border border-gray-200 bg-white p-5">
            <div class="grid grid-cols-2 gap-10 mb-4">
                {{-- Kolom Kiri --}}
                <div>
                    {{-- Input Nama --}}
                    <div class="mb-6">
                        <label for="code" class="block mb-2 font-semibold text-base text-gray-900">Kode Rules</label>
                        <input wire:model="code" type="text" id="code"
                            class="bg-white border text-gray-900 text-sm rounded-lg focus:outline-none block w-full p-2.5
                                      @error('code') border-red-500 @else border-gray-400 @enderror
                                     ">
                        {{-- Request #6: Pesan Error --}}
                        @error('code')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="mb-6">
                        <label for="title" class="block mb-2 font-semibold text-base text-gray-900">Nama</label>
                        <input wire:model="title" type="text" id="title"
                            class="bg-white border text-gray-900 text-sm rounded-lg focus:outline-none block w-full p-2.5
                                      @error('title') border-red-500 @else border-gray-400 @enderror
                                     ">
                        {{-- Request #6: Pesan Error --}}
                        @error('title')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                {{-- Kolom Kanan --}}
                <div class="">
                    <label for="description" class="block mb-2 font-semibold text-base text-gray-900">Deskripsi</label>
                    <textarea wire:model="description" id="description" rows="10"
                        class="bg-white border text-gray-900 text-sm rounded-lg focus:outline-none block w-full p-2.5
                                     @error('description') border-red-500 @else border-gray-400 @enderror
                                    "></textarea>
                    {{-- Request #6: Pesan Error --}}
                    @error('description')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="flex justify-start space-x-4 pb-4">
            {{-- Request #7: Tombol "Simpan" --}}
            <button type="submit"
                class="items-center rounded-lg border border-blue-300 bg-blue-500 p-2 font-semibold text-white hover:bg-blue-500/90">
                <span>Simpan</span>
            </button>
            {{-- Request #8: Tombol "Batal" --}}
            <button wire:click="cancel" type="button"
                class="items-center rounded-lg border border-gray-300 bg-white p-2 font-semibold text-gray-900 hover:bg-gray-100">
                <span>Batal</span>
            </button>
        </div>
    </form>
</div>
