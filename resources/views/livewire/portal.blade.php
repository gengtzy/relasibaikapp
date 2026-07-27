{{-- x-data ini adalah state Alpine.js untuk mengontrol pop-up --}}
<div x-data="{ showPublikasi: false, showMember: false }" 
     class="min-h-screen bg-gradient-to-br from-blue-200 via-white to-blue-100 flex items-center justify-center p-4">

    <div class="max-w-5xl w-full">
        
        {{-- Judul Minimalis --}}
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-slate-800 tracking-tight mb-3">RelasiBaik.</h1>
            <p class="text-slate-500 text-lg">Sistem Pakar & Portal Grup Riset Keluarga Indonesia</p>
        </div>

        {{-- 3 Kartu Interaktif --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            {{-- Kartu 1: Aplikasi --}}
            {{-- Karena ini aplikasi, kita langsung arahkan href ke route login/register --}}
            <a href="{{ route('app') }}" 
               class="group bg-white rounded-2xl p-8 shadow-sm border border-slate-200 hover:shadow-xl hover:border-blue-500 hover:-translate-y-1 transition-all duration-300 text-center flex flex-col items-center">
                <div class="w-20 h-20 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-rocket text-3xl"></i>
                </div>
                <h2 class="text-xl font-bold text-slate-800 mb-2">Aplikasi</h2>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Masuk ke dalam sistem skrining untuk mendiagnosa kualitas relasi keluarga Anda secara akurat.
                </p>
            </a>

            {{-- Kartu 2: Publikasi --}}
            {{-- Saat diklik, ubah showPublikasi menjadi true --}}
            <button @click="showPublikasi = true" 
               class="group bg-white rounded-2xl p-8 shadow-sm border border-slate-200 hover:shadow-xl hover:border-green-500 hover:-translate-y-1 transition-all duration-300 text-center flex flex-col items-center cursor-pointer">
                <div class="w-20 h-20 bg-green-50 text-green-600 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-book-open text-3xl"></i>
                </div>
                <h2 class="text-xl font-bold text-slate-800 mb-2">Publikasi</h2>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Jelajahi berbagai literatur, jurnal, dan karya ilmiah hasil riset pengembangan sistem ini.
                </p>
            </button>

            {{-- Kartu 3: Member --}}
            {{-- Saat diklik, ubah showMember menjadi true --}}
            <button @click="showMember = true" 
               class="group bg-white rounded-2xl p-8 shadow-sm border border-slate-200 hover:shadow-xl hover:border-purple-500 hover:-translate-y-1 transition-all duration-300 text-center flex flex-col items-center cursor-pointer">
                <div class="w-20 h-20 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-users text-3xl"></i>
                </div>
                <h2 class="text-xl font-bold text-slate-800 mb-2">Member</h2>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Kenali lebih dekat profil dosen pembimbing dan tim peneliti di balik pengembangan RelasiBaik.
                </p>
            </button>

        </div>
    </div>

    {{-- ========================================== --}}
    {{-- MODAL 1: PUBLIKASI (Google Scholar Style)  --}}
    {{-- ========================================== --}}
    <div x-show="showPublikasi" style="display: none;" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        {{-- Background Overlay --}}
        <div x-show="showPublikasi" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                {{-- Panel Modal --}}
                <div x-show="showPublikasi" @click.outside="showPublikasi = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-4xl">
                    
                    {{-- Header Modal --}}
                    <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between items-center">
                        <h3 class="text-xl font-bold text-slate-800" id="modal-title">Publikasi Grup Riset</h3>
                        <button @click="showPublikasi = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    {{-- Isi Publikasi --}}
                    <div class="px-6 py-4 max-h-[70vh] overflow-y-auto">
                        <div class="space-y-6">
                            @forelse ($publikasiData as $pub)
                                <div class="pb-6 border-b border-slate-100 last:border-0 last:pb-0">
                                    <a href="{{ $pub['link'] }}" target="_blank" class="text-lg font-bold text-blue-600 hover:text-blue-800 hover:underline transition-colors block mb-1 leading-snug">
                                        {{ $pub['judul'] }}
                                    </a>
                                    <p class="text-sm font-medium text-green-700 mb-2">
                                        {{ $pub['penulis'] }}
                                    </p>
                                    <p class="text-sm text-slate-600 leading-relaxed mb-3">
                                        {{ $pub['deskripsi'] }}
                                    </p>
                                    <a href="{{ $pub['link'] }}" target="_blank" class="inline-flex items-center text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 px-3 py-1.5 rounded-md transition-colors">
                                        <i class="fas fa-external-link-alt mr-2"></i> Buka Jurnal
                                    </a>
                                </div>
                            @empty
                                <div class="text-center py-8 text-slate-500 italic">Belum ada data publikasi.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- MODAL 2: MEMBER (Dengan Efek Akordeon)     --}}
    {{-- ========================================== --}}
    <div x-show="showMember" style="display: none;" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        {{-- Background Overlay --}}
        <div x-show="showMember" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                {{-- Panel Modal --}}
                <div x-show="showMember" @click.outside="showMember = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-3xl">
                    
                    {{-- Header Modal --}}
                    <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between items-center">
                        <h3 class="text-xl font-bold text-slate-800" id="modal-title">Tim Peneliti & Member</h3>
                        <button @click="showMember = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    {{-- Isi Member (Layout 1 Kolom) --}}
                    <div class="px-6 py-6 max-h-[70vh] overflow-y-auto bg-slate-50">
                        {{-- PERBAIKAN: Hapus lg:grid-cols-2 agar otomatis jadi 1 kolom --}}
                        <div class="grid grid-cols-1 gap-6">
                            @foreach ($memberData as $index => $member)
                                <div x-data="{ openAccord: false }" wire:key="member-{{ $index }}" class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm h-fit">
                                    {{-- Info Utama Member --}}
                                    <div class="flex items-start gap-4">
                                        <img src="{{ $member['foto'] }}" alt="{{ $member['nama'] }}" class="w-16 h-16 rounded-full object-cover border-2 border-slate-100 shadow-sm">
                                        <div class="flex-1">
                                            <h4 class="font-bold text-slate-800 text-lg leading-tight">{{ $member['nama'] }}</h4>
                                            <div class="mt-1 flex flex-wrap items-center gap-y-1 gap-x-3 text-xs text-slate-500 font-medium">
                                                <span class="flex items-center gap-1"><i class="fas fa-id-card"></i> NIDN: {{ $member['nidn'] }}</span>
                                                <span class="flex items-center gap-1"><i class="fas fa-university"></i> {{ $member['kampus'] }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Akordeon Jurnal --}}
                                    @if (count($member['jurnal']) > 0)
                                        <div class="mt-5 border-t border-slate-100 pt-3">
                                            <button @click="openAccord = !openAccord" class="flex justify-between items-center w-full text-left text-sm font-bold text-blue-600 hover:text-blue-800 transition-colors">
                                                <span>Lihat {{ count($member['jurnal']) }} Publikasi Terbaru</span>
                                                <i class="fas fa-chevron-down transition-transform duration-300" :class="{'rotate-180': openAccord}"></i>
                                            </button>
                                            
                                            {{-- Isi Akordeon --}}
                                            <div x-show="openAccord" x-collapse class="mt-3 space-y-3">
                                                @foreach ($member['jurnal'] as $jurnal)
                                                    <div class="bg-slate-50 p-3 rounded-lg border border-slate-100">
                                                        <h5 class="text-sm font-bold text-slate-800 mb-1 leading-snug">{{ $jurnal['judul'] }}</h5>
                                                        <p class="text-xs text-slate-600 mb-2 line-clamp-2">{{ $jurnal['desc'] }}</p>
                                                        <a href="https://doi.org/{{ $jurnal['doi'] }}" target="_blank" class="text-xs font-semibold text-blue-600 hover:underline">
                                                            DOI: {{ $jurnal['doi'] }}
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>