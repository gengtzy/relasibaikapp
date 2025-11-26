<div class="overflow-hidden">
    <form wire:submit="save">
        <section id="form" class="w-full max-w-6xl mx-auto my-24 space-y-4">
            <div>
                @auth
                    @if (Auth::User()->superiority_role)
                        <span class="text-sm line-clamp-2 bg-green-100 text-green-600 font-medium p-2.5 rounded-md">
                            Akun Anda telah berhasil diverifikasi. Peran <span
                                class="font-bold text-base">{{ Auth::User()->superiority_role }}</span> telah ditetapkan
                            sebagai superior dalam keluarga
                            Anda. Setiap perhitungan diagnosis akan secara otomatis menyertakan penambahan bobot untuk item
                            yang
                            terkait dengan peran {{ Auth::User()->superiority_role }}.
                        </span>
                    @else
                        <span class="text-sm line-clamp-2 bg-orange-100 text-orange-600 font-medium p-2.5 rounded-md">
                            Akun Anda belum diverifikasi. Anda tetap dapat melakukan pengisian diagnosis, namun
                            perhitungan belum menyertakan bobot khusus karena peran superior (Ayah, Ibu, atau Anggota
                            Lain) di dalam keluarga Anda belum ditentukan.
                        </span>
                    @endif
                @endauth
            </div>
            <div class="border border-white shadow-xl rounded-2xl">
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
    
                    <div
                        class="flex flex-col-reverse sm:flex-row justify-between items-center mt-10 pt-6 border-t border-blue-200 gap-4">
                        <a href="/"
                            class="w-full sm:w-auto gap-2 inline-flex justify-center items-center px-5 py-3 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 hover:text-slate-900 focus:ring-4 focus:outline-none focus:ring-slate-100 transition-all">
                            <i class="fas fa-arrow-left"></i>
                            Kembali ke Beranda
                        </a>
                        <button type="submit"
                            class="gap-2 w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 shadow-md hover:shadow-lg transition-all">
                            Lanjut ke Kuisioner Ayah
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </form>
</div>
