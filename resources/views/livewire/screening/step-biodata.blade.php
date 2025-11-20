<div class="overflow-hidden">
    <form wire:submit="save">
        <section id="form" class="w-full max-w-5xl mx-auto my-24 border border-white shadow-xl rounded-2xl">
            <div class="bg-blue-500 p-8 text-white relative rounded-t-2xl">
                <h2 class="text-3xl font-bold mb-2">Isi dengan benar dan sesuai</h2>
                <p class="opacity-90">
                    Lengkapi formulir dibawah ini
                </p>
            </div>
            <div class="h-auto p-8 bg-white rounded-b-2xl space-y-8">

                <div class="">
                    <label for="lokasi" class="block mb-2 text-lg font-medium text-gray-900">Lokasi
                        Pengisian</label>
                    <input wire:model.live="lokasi" type="text" id="lokasi"
                        class="bg-white border border-gray-400 text-gray-900 text-base rounded-lg focus:outline-none focus:border-blue-500 block w-full p-4"
                        placeholder="Contoh: Sidoarjo" />
                    @error('lokasi')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="tanggal" class="block mb-2 text-lg font-medium text-gray-900">Tanggal
                        Pengisian</label>
                    <input wire:model="tanggal" type="date" id="tanggal"
                        class="bg-white border border-gray-400 text-gray-900 text-base rounded-lg focus:outline-none focus:border-blue-500 block w-full p-4" />
                    @error('tanggal')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 shadow-md hover:shadow-lg transition-all">
                        Lanjut ke Kuisioner Ayah
                        <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </button>
                </div>
            </div>
        </section>
    </form>
</div>
