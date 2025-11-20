<div class="min-h-screen py-12 flex justify-center items-center">
    <div class="w-full max-w-5xl bg-white rounded-2xl shadow-xl overflow-hidden mx-4 border border-gray-100">
        
        {{-- Header --}}
        <div class="bg-blue-600 p-8 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
            <h2 class="text-3xl font-bold mb-2">Hasil Pengisian</h2>
            <p class="opacity-90">
                Halo, {{ Auth::user()->name }}! Berikut adalah diagnosa relasi keluarga Anda.
            </p>
        </div>

        <div class="p-8 space-y-6">
            
            {{-- Card Diagnosa Utama --}}
            <div class="bg-slate-50 rounded-xl p-6 border-l-4 border-green-500 shadow-sm bg-gradient-to-r from-white to-slate-50">
                <div class="mb-2">
                    <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                        Diagnosa / Rekomendasi
                    </span>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 mb-3">
                    {{ $screeningData->recommendation->title }}
                </h3>
                <p class="text-slate-600 leading-relaxed text-justify">
                    {{ $screeningData->recommendation->description }}
                </p>
            </div>

            {{-- Detail Skor per Aspek --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                
                {{-- Ayah --}}
                <div class="p-5 rounded-xl border border-gray-200 bg-white hover:shadow-md transition-all text-center group">
                    <div class="text-sm text-gray-500 mb-2 uppercase tracking-wide font-semibold">Relasi Ayah</div>
                    <div class="text-3xl font-extrabold text-blue-600 mb-2 group-hover:scale-110 transition-transform">
                        {{ $screeningData->result->fpq_score }}
                    </div>
                    <span class="inline-block px-3 py-1 text-xs font-bold rounded-full uppercase
                        {{ $catFather == 'Tinggi' ? 'bg-green-100 text-green-700' : ($catFather == 'Sedang' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                        {{ $catFather }}
                    </span>
                </div>

                {{-- Ibu --}}
                <div class="p-5 rounded-xl border border-gray-200 bg-white hover:shadow-md transition-all text-center group">
                    <div class="text-sm text-gray-500 mb-2 uppercase tracking-wide font-semibold">Relasi Ibu</div>
                    <div class="text-3xl font-extrabold text-pink-600 mb-2 group-hover:scale-110 transition-transform">
                        {{ $screeningData->result->mciq_score }}
                    </div>
                    <span class="inline-block px-3 py-1 text-xs font-bold rounded-full uppercase
                        {{ $catMother == 'Tinggi' ? 'bg-green-100 text-green-700' : ($catMother == 'Sedang' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                        {{ $catMother }}
                    </span>
                </div>

                {{-- Keluarga Lain --}}
                <div class="p-5 rounded-xl border border-gray-200 bg-white hover:shadow-md transition-all text-center group">
                    <div class="text-sm text-gray-500 mb-2 uppercase tracking-wide font-semibold">Keluarga Lain</div>
                    <div class="text-3xl font-extrabold text-purple-600 mb-2 group-hover:scale-110 transition-transform">
                        {{ $screeningData->result->fmwb_score }}
                    </div>
                    <span class="inline-block px-3 py-1 text-xs font-bold rounded-full uppercase
                        {{ $catOther == 'Tinggi' ? 'bg-green-100 text-green-700' : ($catOther == 'Sedang' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                        {{ $catOther }}
                    </span>
                </div>
            </div>

            {{-- Tombol Kembali --}}
            <div class="flex justify-between items-center pt-8 border-t border-gray-200">
                <a href="/" class="inline-flex items-center px-4 py-2 text-sm font-medium text-slate-600 bg-gray-100 rounded-lg hover:bg-gray-200 hover:text-slate-900 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Beranda
                </a>
            </div>

        </div>
    </div>
</div>