<div>
    <form wire:submit="save">
        <section id="form" class="flex justify-center items-center h-screen py-24">
            <div
                class="w-full max-w-5xl h-auto p-4 md:p-12 lg:p-12 mx-8 bg-blue-500/30 backdrop-blur-sm border border-gray-200 rounded-lg shadow-lg">
                <div class="space-y-6">
                    <div class="bg-slate-100/90 p-6 rounded-lg shadow-md mb-8 text-center border border-slate-200">
                    <h5 class="mb-4 text-2xl font-bold tracking-tight text-slate-800">
                        Isi dengan benar dan sesuai😊
                    </h5>
                    <p class="text-lg text-gray-700">
                        Lengkapi Formulir dibawah ini
                    </p>
                    </div>

                    <div class="mt-6">
                        <label for="lokasi" class="block mb-2 text-lg font-medium text-gray-900">Lokasi
                            Pengisian</label>
                        <input wire:model.live="lokasi" type="text" id="lokasi"
                            class="bg-slate-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-none focus:border-blue-500 block w-full p-2.5"
                            placeholder="Contoh: Rumah" />
                        @error('lokasi')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="tanggal" class="block mb-2 text-lg font-medium text-gray-900">Tanggal
                            Pengisian</label>
                        <input wire:model="tanggal" type="date" id="tanggal"
                            class="bg-slate-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-none focus:border-blue-500 block w-full p-2.5" />
                        @error('tanggal')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300">
                            Lanjut ke Kuisioner Ayah
                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </form>
</div>

{{-- <div>
    <h3>Tes Komponen Livewire</h3>
    <livewire:location-dropdowns />
</div> --}}
