<div>
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a href="{{ route('instrumentindex') }}" wire:navigate
                    class="inline-flex items-center text-sm font-normal text-slate-400 hover:text-blue-600">
                    Instrumen
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
    <h1 class="text-2xl font-bold mb-6">Buat Instrumen</h1>

    <form wire:submit="save">
        <div class="rounded-2xl mb-6 shadow-sm border border-gray-200 bg-white p-5">
            <div class="grid grid-cols-2 mb-4">
                <div class="mb-6 mr-6">
                    <label for="code" class="block mb-2 font-semibold text-base text-gray-900">Kode</label>
                    <input wire:model="code" type="text" id="code"
                        class="bg-white border text-gray-900 text-sm rounded-lg focus:outline-none block w-full p-2.5 
                        @error('code')
                            border-red-500 focus:ring-red-500 focus:border-red-500
                        @else
                            border-gray-400 focus:ring-blue-500 focus:border-blue-500
                        @enderror
                        ">
                    @error('code')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="">
                    <label for="name" class="block mb-2 font-semibold text-base text-gray-900">Nama</label>
                    <input wire:model="name" type="text" id="name"
                        class="bg-white border text-gray-900 text-sm rounded-lg focus:outline-none block w-full p-2.5 
                        @error('code')
                            border-red-500 focus:ring-red-500 focus:border-red-500
                        @else
                            border-gray-400 focus:ring-blue-500 focus:border-blue-500
                        @enderror
                        ">
                    @error('name')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-2">
                    <label for="descriptions" class="block mb-2 font-semibold text-base text-gray-900">Deskripsi</label>
                    <textarea wire:model="descriptions" id="descriptions" rows="4"
                        class="bg-white border border-gray-400 text-gray-900 text-sm rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"></textarea>
                    @error('descriptions')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="flex justify-start space-x-4 pb-4">
            <button type="submit"
                class="items-center rounded-lg border border-blue-300 bg-blue-500 p-2 font-semibold text-white hover:bg-blue-500/90">
                <span>Buat</span>
            </button>
            <button wire:click="cancel" type="button"
                class="items-center rounded-lg border border-gray-300 bg-white p-2 font-semibold text-gray-900 hover:bg-gray-100">
                <span>Batal</span>
            </button>
        </div>
    </form>
</div>
