<x-guest-layout :bgImage="'images/bgall3.png'">

    @push('styles')
        <style>
            html {
                scroll-behavior: smooth;
            }

            @keyframes float {
                0% {
                    transform: translateY(0px);
                }

                50% {
                    transform: translateY(-20px);
                }

                100% {
                    transform: translateY(0px);
                }
            }

            .animate-float {
                animation: float 6s ease-in-out infinite;
            }

                {
                animation: float 7s ease-in-out infinite;
                animation-delay: 1s;
            }
        </style>
    @endpush
    <livewire:layout.navigation />

    <main>

        <section id="beranda" class="py-24 lg:py-44">
            <div class="container mx-auto px-6 lg:px-24">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="text-center lg:text-left" data-aos="fade-right" data-aos-duration="1000">
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
                            <!-- <a href="{{ route('screening.wizard', ['reset' => 'true']) }}"
                                class="inline-block mt-8 bg-green-500 text-white px-8 py-3 rounded-full font-bold shadow-lg hover:bg-green-600 transition-transform hover:scale-105">
                                Mulai Sekarang
                            </a> -->
                        @else
                            <a href="{{ route('login') }}"
                                class="inline-block mt-8 bg-blue-500 text-white px-8 py-3 rounded-full font-bold shadow-lg hover:bg-blue-500 transition-transform hover:scale-105">
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

                <div class="text-center mb-20" data-aos="fade-up">
                    <span class="text-blue-500 font-bold tracking-wider uppercase text-sm">Proses Kami</span>
                    <h2
                        class="text-3xl md:text-4xl font-bold text-slate-900 mt-2 dark:text-slate-50 transition-colors duration-500 ease-in-out">
                        Alur Kerja yang Mudah</h2>
                    <p
                        class="text-lg text-slate-500 mt-4 max-w-2xl mx-auto dark:text-slate-200 transition-colors duration-500 ease-in-out">
                        Hanya butuh beberapa langkah sederhana untuk mendapatkan hasil analisis psikologi yang akurat.
                    </p>
                </div>

                <div class="grid-card">
                    <div class="flex justify-center" data-aos="zoom-in-right">
                        <img src="{{ asset('images/Section2.svg') }}" alt="Ilustrasi login" class="w-full max-w-md">
                    </div>
                    <div class="space-y-8" data-aos="fade-left">
                        <h3
                            class="text-3xl font-bold text-slate-900 border-l-4 border-blue-500 pl-4 dark:text-slate-50 transition-colors duration-500 ease-in-out">
                            <span>1. Mulai</span><span class="text-blue-500"> Screening</span>
                        </h3>

                        {{-- Card Item --}}
                        <div
                            class="group p-6 rounded-2xl hover:shadow-xl hover:border-blue-200 cursor-default dark:hover:bg-slate-800 dark:hover:shadow-slate-50 transition-colors duration-500 ease-in-out">
                            <div class="flex items-start gap-4">
                                <div
                                    class="bg-blue-100 p-3 rounded-lg text-blue-500 group-hover:bg-blue-500 group-hover:text-white transition-colors">
                                    <i class="fas fa-user-circle text-2xl"></i>
                                </div>
                                <div>
                                    <h4
                                        class="text-xl font-bold text-slate-800 mb-2 dark:text-slate-50 transition-colors duration-500 ease-in-out">
                                        Buat akun / Masuk</h4>
                                    <p
                                        class="text-slate-600 leading-relaxed dark:text-slate-200 transition-colors duration-500 ease-in-out">
                                        Masuk ke sistem menggunakan akun Anda
                                        untuk menjamin kerahasiaan dan menyimpan riwayat data.</p>
                                </div>
                            </div>
                        </div>

                        {{-- Card Item --}}
                        <div
                            class="group p-6 rounded-2xl hover:shadow-xl hover:border-blue-200 cursor-default dark:hover:bg-slate-800 dark:hover:shadow-slate-50 transition-colors duration-500 ease-in-out">
                            <div class="flex items-start gap-4">
                                <div
                                    class="bg-blue-100 p-3 rounded-lg text-blue-500 group-hover:bg-blue-500 group-hover:text-white transition-colors">
                                    <i class="fas fa-clipboard-list text-2xl"></i>
                                </div>
                                <div>
                                    <h4
                                        class="text-xl font-bold text-slate-800 mb-2 dark:text-slate-50 transition-colors duration-500 ease-in-out">
                                        Isi Kuisioner</h4>
                                    <p
                                        class="text-slate-600 text-sm mb-2 dark:text-slate-200 transition-colors duration-500 ease-in-out">
                                        Jawab pertanyaan dari tiga instrumen
                                        psikologi terpercaya:</p>
                                    <ul
                                        class="space-y-1 text-sm text-slate-500 dark:text-slate-300 transition-colors duration-500 ease-in-out">
                                        <li class="flex items-center gap-2"><i class="fas fa-check text-green-500"></i>
                                            FPQ (Keterlibatan Ayah)</li>
                                        <li class="flex items-center gap-2"><i class="fas fa-check text-green-500"></i>
                                            MCIQ (Interaksi Ibu-Anak)</li>
                                        <li class="flex items-center gap-2"><i class="fas fa-check text-green-500"></i>
                                            FMWB (Relasi Keluarga)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid-card">
                    <div class="space-y-8 order-2 lg:order-1" data-aos="fade-right">
                        <h3
                            class="text-3xl font-bold text-slate-900 border-l-4 border-purple-500 pl-4 dark:text-slate-50 transition-colors duration-500 ease-in-out">
                            <span>2. Proses</span><span class="text-purple-600"> Penilaian</span>
                        </h3>

                        <div
                            class="group p-6 rounded-2xl hover:bg-white hover:shadow-xl hover:border-purple-200 dark:hover:bg-slate-800 dark:hover:shadow-slate-50 transition-colors duration-500 ease-in-out">
                            <div class="flex items-start gap-4">
                                <div
                                    class="bg-purple-100 p-3 rounded-lg text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                                    <i class="fas fa-calculator text-2xl"></i>
                                </div>
                                <div>
                                    <h4
                                        class="text-xl font-bold text-slate-800 mb-2 dark:text-slate-50 transition-colors duration-500 ease-in-out">
                                        Kalkulasi Otomatis</h4>
                                    <p
                                        class="text-slate-600 dark:text-slate-200 transition-colors duration-500 ease-in-out">
                                        Sistem pakar menghitung skor secara real-time menggunakan
                                        algoritma rule-based reasoning.</p>
                                </div>
                            </div>
                        </div>

                        <div
                            class="group p-6 rounded-2xl hover:bg-white hover:shadow-xl hover:border-purple-200 dark:hover:bg-slate-800 dark:hover:shadow-slate-50 transition-colors duration-500 ease-in-out">
                            <div class="flex items-start gap-4">
                                <div
                                    class="bg-purple-100 p-3 rounded-lg text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                                    <i class="fas fa-chart-pie text-2xl"></i>
                                </div>
                                <div>
                                    <h4
                                        class="text-xl font-bold text-slate-800 mb-2 dark:text-slate-50 transition-colors duration-500 ease-in-out">
                                        Analisis Kategori</h4>
                                    <p
                                        class="text-slate-600 dark:text-slate-200 transition-colors duration-500 ease-in-out">
                                        Skor dikategorikan (Baik, Sedang, Buruk) sesuai pedoman
                                        psikologi untuk gambaran yang jelas.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-center order-1 lg:order-2" data-aos="zoom-in-left">
                        <img src="{{ asset('images/Section3.svg') }}" alt="Ilustrasi proses penilaian"
                            class="w-full max-w-md">
                    </div>
                </div>

                <!-- rename -->

                <div class="grid-card -mb-12">
                    <div class="flex justify-center" data-aos="zoom-in-right">
                        <img src="{{ asset('images/section4.svg') }}" alt="Ilustrasi hasil" class="w-full max-w-md">
                    </div>
                    <div class="space-y-8" data-aos="fade-left">
                        <h3
                            class="text-3xl font-bold text-slate-900 border-l-4 border-green-500 pl-4 dark:text-slate-50 transition-colors duration-500 ease-in-out">
                            <span>3. Hasil &</span><span class="text-green-600"> Rekomendasi</span>
                        </h3>

                        <div
                            class="group p-6 rounded-2xl hover:bg-white hover:shadow-xl hover:border-green-200 dark:hover:bg-slate-800 dark:hover:shadow-slate-50 transition-colors duration-500 ease-in-out">
                            <div class="flex items-start gap-4">
                                <div
                                    class="bg-green-100 p-3 rounded-lg text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors">
                                    <i class="fas fa-file-medical-alt text-2xl"></i>
                                </div>
                                <div>
                                    <h4
                                        class="text-xl font-bold text-slate-800 mb-2 dark:text-slate-50 transition-colors duration-500 ease-in-out">
                                        Laporan Komprehensif</h4>
                                    <p
                                        class="text-slate-600 dark:text-slate-200 transition-colors duration-500 ease-in-out">
                                        Dapatkan ringkasan hasil visual yang mudah dipahami
                                        mencerminkan kualitas relasi keluarga.</p>
                                </div>
                            </div>
                        </div>

                        <div
                            class="group p-6 rounded-2xl hover:bg-white hover:shadow-xl hover:border-green-200 dark:hover:bg-slate-800 dark:hover:shadow-slate-50 transition-colors duration-500 ease-in-out">
                            <div class="flex items-start gap-4">
                                <div
                                    class="bg-green-100 p-3 rounded-lg text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors">
                                    <i class="fas fa-lightbulb text-2xl"></i>
                                </div>
                                <div>
                                    <h4
                                        class="text-xl font-bold text-slate-800 mb-2 dark:text-slate-50 transition-colors duration-500 ease-in-out">
                                        Saran Perbaikan</h4>
                                    <p
                                        class="text-slate-600 dark:text-slate-200 transition-colors duration-500 ease-in-out">
                                        Jika terdeteksi masalah, sistem memberikan rekomendasi
                                        praktis untuk memperbaiki hubungan.</p>
                                </div>
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
                    <p class="text-lg font-bold">Link Cepat</p>
                    <div class="flex flex-wrap justify-center md:justify-end gap-6 text-slate-300 text-sm">
                        <a href="#beranda" class="hover:text-white hover:underline transition-all">Beranda</a>
                        <a href="#alur" class="hover:text-white hover:underline transition-all">Alur Kerja</a>
                        <a href="{{ route('login') }}"
                            class="hover:text-white hover:underline transition-all">Masuk</a>
                        <a href="{{ route('register') }}"
                            class="hover:text-white hover:underline transition-all">Daftar</a>
                    </div>
                    <a href="https://edtechnology.id/"
                            class="hover:text-white hover:underline transition-all text-slate-300 text-sm">Kembali Ke Portal</a>
                </div>

            </div>
        </div>

    </footer>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</x-guest-layout>
