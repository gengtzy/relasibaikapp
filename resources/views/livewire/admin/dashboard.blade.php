<div>
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a href="#" class="inline-flex items-center text-sm font-normal text-slate-600">Dasbor Utama</a>
            </li>
        </ol>
    </nav>
    <h1 class="text-2xl font-bold mb-6">Dasbor Utama</h1>

    {{-- <div class="lg:grid lg:grid-cols-4 space-y-4 lg:space-y-0 gap-4 mb-4">
        <div class="rounded-2xl grid grid-cols-6 gap-12 border border-gray-200 bg-white p-5 hover:shadow-md">
            <div class="text-green-600 text-4xl">
                <i class="ri-user-follow-fill"></i>
            </div>
            <div class="col-span-5 space-y-1">
                <p class="text-base/4 text-gray-900">Pengguna Aktif</p>
                <h4 class="text-2xl font-bold text-gray-800">261</h4>
                <div class="font-medium text-green-600">
                    <span>+20 increase</span>
                    <i class="ri-arrow-right-up-line"></i>
                </div>
            </div>
        </div>
        <div class="rounded-2xl grid grid-cols-6 gap-12 border border-gray-200 bg-white p-5 hover:shadow-md">
            <div class="text-blue-500 text-4xl">
                <i class="ri-survey-fill"></i>
            </div>
            <div class="col-span-5 space-y-1">
                <p class="text-base/4 text-gray-900">Screening Selesai</p>
                <h4 class="text-2xl font-bold text-gray-800">261</h4>
                <div class="font-medium text-green-600">
                    <span>+20 increase</span>
                    <i class="ri-arrow-right-up-line"></i>
                </div>
            </div>
        </div>
        <div class="rounded-2xl grid grid-cols-6 gap-12 border border-gray-200 bg-white p-5 hover:shadow-md">
            <div class="text-red-400 text-4xl">
                <i class="ri-numbers-fill"></i>
            </div>
            <div class="col-span-5 space-y-1">
                <p class="text-base/4 text-gray-900">Rata-rata Skor Total</p>
                <h4 class="text-2xl font-bold text-gray-800">80/100</h4>
                <div class="font-medium text-red-600">
                    <span>-5 decrease</span>
                    <i class="ri-arrow-right-down-line"></i>
                </div>
            </div>
        </div>
        <div class="rounded-2xl grid grid-cols-6 gap-12 border border-gray-200 bg-white p-5 hover:shadow-md">
            <div class="text-orange-400 text-4xl">
                <i class="ri-user-received-2-fill"></i>
            </div>
            <div class="col-span-5 space-y-1">
                <p class="text-base/4 text-gray-900">Menunggu Verifikasi</p>
                <h4 class="text-2xl font-bold text-gray-800">20</h4>
                <div class="font-medium text-orange-600">
                    <span>Perlu Diverifikasi</span>
                </div>
            </div>
        </div>
    </div>

    <div class="lg:grid lg:grid-cols-3 space-y-4 lg:space-y-0 gap-4 mb-4">
        <div class="col-span-2 w-full bg-white rounded-lg p-4 md:p-6 border border-gray-200 hover:shadow-md">
            <div class="flex items-center gap-3 pb-4 mb-4 border-b border-gray-200">

                <div class="text-blue-500 text-4xl">
                    <i class="ri-bar-chart-fill"></i>
                </div>

                <div>
                    <h5 class="text-xl font-bold leading-none text-gray-900">Rata-rata Skor Berdasarkan Instrumen</h5>
                    <p class="text-sm font-normal text-gray-500">Rata-rata skor screening tiap instrumen (FPQ, MCIQ,
                        FMWB) 7 hari terakhir</p>
                </div>

            </div>
            <div id="column-chart"></div>
        </div>
        <div class="w-full bg-white rounded-lg border border-gray-200 p-4 md:p-6 hover:shadow-md">
            <div class="flex justify-between items-start w-full">
                <div class="flex-col items-center">
                    <div class="flex items-center gap-4 mb-1">

                        <div class="text-blue-500 text-4xl">
                            <i class="ri-user-location-fill"></i>
                        </div>
                        <div>
                            <h5 class="text-xl font-bold leading-none text-gray-900 me-1">Lokasi Screening</h5>
                            <p class="text-sm font-normal text-gray-500">Jumlah lokasi screening minggu ini</p>
                        </div>

                    </div>
                </div>
            </div>

            <div class="py-6" id="pie-chart"></div>

        </div>
    </div>

    <div class="lg:grid lg:grid-cols-3 space-y-4 lg:space-y-0 gap-4 mb-4">
        <div class="lg:col-span-1 rounded-2xl border border-gray-200 bg-white p-5 hover:shadow-md">
            <div class="flex items-start justify-between">
                <h3 class="text-lg font-semibold text-gray-800">Skor Tertinggi Pengguna</h3>
            </div>

            <div class="my-6">
                <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                    <span class="text-theme-xs text-gray-400">Nama Pengguna</span>
                    <span class="text-right text-theme-xs text-gray-400">Skor</span>
                </div>
                <div class="flex items-center justify-between border-b border-gray-100 py-3">
                    <span class="text-theme-sm text-gray-500">Agus</span>
                    <span class="text-right text-theme-sm text-gray-500">125</span>
                </div>
                <div class="flex items-center justify-between border-b border-gray-100 py-3">
                    <span class="text-theme-sm text-gray-500">Agus</span>
                    <span class="text-right text-theme-sm text-gray-500">121</span>
                </div>
                <div class="flex items-center justify-between border-b border-gray-100 py-3">
                    <span class="text-theme-sm text-gray-500">Agus</span>
                    <span class="text-right text-theme-sm text-gray-500">112</span>
                </div>
                <div class="flex items-center justify-between border-b border-gray-100 py-3">
                    <span class="text-theme-sm text-gray-500">Agus</span>
                    <span class="text-right text-theme-sm text-gray-500">111</span>
                </div>
            </div>
        </div>
        <div class="lg:col-span-2 rounded-2xl border border-gray-200 bg-white p-5 hover:shadow-md">
            <div class="flex items-start justify-between">
                <h3 class="text-lg font-semibold text-gray-800">Aktifitas Terbaru</h3>
            </div>

            <div class="my-6">
                <div class="flex items-center justify-between border-b border-gray-100 py-3">
                    <h2 class="text-theme-sm text-gray-500"><span class="font-bold">Budi</span> baru saja menyelesaikan
                        screening</h2>
                    <h2 class="text-theme-sm text-gray-500">2 Menit yang lalu</h2>
                </div>
                <div class="flex items-center justify-between border-b border-gray-100 py-3">
                    <h2 class="text-theme-sm text-gray-500"><span class="font-bold">Rendi</span> baru saja mendaftar
                    </h2>
                    <h2 class="text-theme-sm text-gray-500">4 Menit yang lalu</h2>
                </div>
            </div>
        </div>
    </div> --}}
</div>
