<x-guest-layout :bgImage="'images/bgall3.png'">

    <livewire:layout.navigation />

    <main>

        <section id="beranda" class="py-24 lg:py-44">
            <div class="container mx-auto px-6 lg:px-24">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="text-center lg:text-left">
                        <h1 class="text-3xl lg:text-5xl font-bold text-slate-100 leading-tight">
                            Ukur & Pahami Kualitas Hubungan Keluarga Anda.
                        </h1>
                        <p class="text-lg text-slate-100 mt-4">
                            Dengan sistem screening berbasis psikologi, <strong>RelasiBaik</strong> membantu menilai
                            keterlibatan ayah, interaksi ibu-anak, dan kesejahteraan keluarga secara objektif.
                        </p>
                        @auth
                            <a href="{{ route('screening.wizard') }}"
                                class="inline-block mt-8 bg-green-500 text-white px-8 py-3 rounded-full font-bold shadow-lg hover:bg-green-600 transition-transform hover:scale-105">
                                Mulai Sekarang
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="inline-block mt-8 bg-blue-500 text-white px-8 py-3 rounded-full font-bold shadow-lg hover:bg-blue-600 transition-transform hover:scale-105">
                                Mulai Screening Gratis
                            </a>
                        @endguest

                    </div>

                    <div class="flex justify-center items-center">
                        <img src="{{ asset('images/section1.svg') }}" alt="Ilustrasi keluarga harmonis"
                            class="w-full max-w-lg">
                    </div>
                </div>
            </div>
        </section>

        <section id="alur" class="py-24">
            <div class="container mx-auto px-6 lg:px-24">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-slate-900">Alur Kerja yang Mudah</h2>
                    <p class="text-lg text-slate-900 mt-2">Hanya butuh beberapa langkah untuk mendapatkan hasil
                        analisis.</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-8">
                    <div class="flex justify-center">
                        <img src="{{ asset('images/section2.svg') }}" alt="Ilustrasi mengisi kuisioner"
                            class="w-full max-w-lg">
                    </div>
                    <div class="space-y-8 text-center lg:text-left">
                        <h3 class="text-3xl font-bold text-slate-900">
                            <span>Mulai</span><span class="text-blue-500"> Screening</span>
                        </h3>
                        <div class="flex items-start text-left gap-4">
                            <div class="text-3xl pt-1">📧</div>
                            <div>
                                <h4 class="text-xl font-semibold text-slate-800">Login dengan Gmail</h4>
                                <p class="text-base text-slate-600">Masuk ke sistem menggunakan akun Gmail Anda untuk
                                    memulai proses.</p>
                            </div>
                        </div>
                        <div class="flex items-start text-left gap-4">
                            <div class="text-3xl pt-1">📄</div>
                            <div>
                                <h4 class="text-xl font-semibold text-slate-800">Isi Kuisioner</h4>
                                <p class="text-base text-slate-600">
                                    Jawab pertanyaan dari tiga instrumen psikologi:
                                    <span class="block mt-1"><b class="text-slate-700">FPQ</b> (Keterlibatan
                                        Ayah)</span>
                                    <span class="block"><b class="text-slate-700">MCIQ</b> (Interaksi
                                        Ibu-Anak)</span>
                                    <span class="block"><b class="text-slate-700">FMWB</b> (Relasi Keluarga)</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-20">
                    <div class="flex justify-center lg:order-last">
                        <img src="{{ asset('images/section3.svg') }}" alt="Ilustrasi proses penilaian"
                            class="w-full max-w-lg">
                    </div>
                    <div class="space-y-8 text-center lg:text-left">
                        <h3 class="text-3xl font-bold text-slate-900">
                            <span class="text-blue-500">Proses</span> Penilaian
                        </h3>
                        <div class="flex items-start text-left gap-4">
                            <div class="text-3xl">⚙️</div>
                            <div>
                                <h4 class="text-xl font-semibold text-slate-800">Pengolahan Jawaban</h4>
                                <p class="text-base text-slate-600">Sistem akan menghitung total skor secara otomatis
                                    berdasarkan jawaban yang Anda berikan.</p>
                            </div>
                        </div>
                        <div class="flex items-start text-left gap-4">
                            <div class="text-3xl">📊</div>
                            <div>
                                <h4 class="text-xl font-semibold text-slate-800">Analisis & Hasil</h4>
                                <p class="text-base text-slate-600">Setiap skor dikategorikan menjadi Baik, Sedang,
                                    atau Buruk sesuai pedoman psikologi untuk memberikan gambaran yang jelas.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="flex justify-center">
                        <img src="{{ asset('images/section4.svg') }}" alt="Ilustrasi mengisi kuisioner"
                            class="w-full max-w-lg">
                    </div>
                    <div class="space-y-8 text-center lg:text-left">
                        <h3 class="text-3xl font-bold text-slate-900">
                            <span>Hasil &</span><span class="text-blue-500"> Rekomendasi</span>
                        </h3>
                        <div class="flex items-start text-left gap-4">
                            <div class="text-3xl pt-1">📧</div>
                            <div>
                                <h4 class="text-xl font-semibold text-slate-800">Tampilkan Hasil Screening</h4>
                                <p class="text-base text-slate-600">Pengguna akan melihat ringkasan hasil yang
                                    mencerminkan kualitas relasi keluarga.</p>
                            </div>
                        </div>
                        <div class="flex items-start text-left gap-4">
                            <div class="text-3xl pt-1">📄</div>
                            <div>
                                <h4 class="text-xl font-semibold text-slate-800">Saran & Rekomendasi</h4>
                                <p class="text-base text-slate-600">
                                    Jika relasi terdeteksi sedang atau buruk, sistem akan memberikan rekomendasi singkat
                                    untuk perbaikan hubungan keluarga.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <footer style="background-image: url('{{ asset('images/bgfooter.svg') }}')"
        class="max-w-lg py-24 bg-cover bg-right lg:w-full lg:max-w-none lg:bg-center md:w-full md:max-w-none md:bg-center">
        <div class="container mx-auto px-6 lg:px-24">
            <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-y-8 md:gap-x-8">

                <div class="flex flex-col items-center gap-3 text-sm text-gray-300 md:items-start">
                    <img src="images/Logorelasibaik.svg" alt="Logo RelasiBaik" class="w-16 h-16 object-contain">
                    <p class="text-base text-center md:text-left">
                        Dibuat oleh Ageng Puji Pangestu
                        <br>
                        &copy; 2025 RelasiBaik. Hak Cipta Dilindungi.
                    </p>
                </div>

                <div class="flex flex-col items-center gap-2 text-white md:items-end">
                    <p class="text-2xl font-bold">RelasiBaik.</p>
                    <p class="text-base text-gray-300 mt-1">Beri kami rating!</p>

                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-yellow-300 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 22 20">
                            <path
                                d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                        </svg>
                        <svg class="w-4 h-4 text-yellow-300 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 22 20">
                            <path
                                d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                        </svg>
                        <svg class="w-4 h-4 text-yellow-300 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 22 20">
                            <path
                                d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                        </svg>
                        <svg class="w-4 h-4 text-yellow-300 me-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                            <path
                                d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                        </svg>
                        <svg class="w-4 h-4 text-gray-300 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 22 20">
                            <path
                                d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                        </svg>
                        <p class="ms-1 text-sm font-medium text-slate-100">4.95</p>
                        <p class="ms-1 text-sm font-medium text-slate-100">out of</p>
                        <p class="ms-1 text-sm font-medium text-slate-100">5</p>
                    </div>
                </div>

            </div>
        </div>
    </footer>
</x-guest-layout>