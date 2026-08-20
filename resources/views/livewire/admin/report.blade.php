<div class="" x-data @open-new-tab.window="window.open($event.detail.url, '_blank')">
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <span class="inline-flex items-center text-sm font-normal text-slate-400">
                    Cetak Laporan
                </span>
            </li>
        </ol>
    </nav>

    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
        <h1 class="text-2xl font-bold text-slate-800">Cetak Laporan</h1>
    </div>

    <div class="max-w-6xl">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- KARTU A: REKAPITULASI --}}
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden flex flex-col">
                <div class="p-5 border-b border-slate-100 bg-slate-50">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                            <i class="fas fa-calendar-alt text-xl"></i>
                        </div>
                        <h3 class="font-bold text-slate-800">Laporan Periodik</h3>
                    </div>
                </div>
                <div class="p-6 flex-1 flex flex-col gap-4">
                    <div>
                        <label class="text-xs font-bold text-slate-500 uppercase mb-1 block">Dari Tanggal</label>
                        <input wire:model="recapStart" type="date"
                            class="w-full border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-500 uppercase mb-1 block">Sampai Tanggal</label>
                        <input wire:model="recapEnd" type="date"
                            class="w-full border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-500 uppercase mb-1 block">Filter Status</label>
                        <select wire:model="recapStatus"
                            class="w-full border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="all">Semua Data</option>
                            <option value="problem">Hanya Indikasi Masalah (Risk)</option>
                        </select>
                    </div>

                    <div class="mt-auto pt-4">
                        <button wire:click="printRecap"
                            class="w-full flex justify-center items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-4 rounded-lg transition-all">
                            <i class="fas fa-print"></i> Cetak Rekapitulasi
                        </button>
                    </div>
                </div>
            </div>

            {{-- KARTU B: INDIVIDUAL --}}
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden flex flex-col">
                <div class="p-5 border-b border-slate-100 bg-slate-50">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-indigo-100 text-indigo-600 rounded-lg">
                            <i class="fas fa-user-clock text-xl"></i>
                        </div>
                        <h3 class="font-bold text-slate-800">Riwayat Pengguna</h3>
                    </div>
                </div>
                <div class="p-6 flex-1 flex flex-col gap-4 relative">

                    {{-- User Selector --}}
                    <div>
                        <label class="text-xs font-bold text-slate-500 uppercase mb-1 block">Cari Pengguna</label>
                        <div class="relative">
                            <input wire:model.live.debounce.300ms="userSearch" type="text"
                                placeholder="Ketik nama pengguna..."
                                class="w-full border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm pl-9">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-slate-400"></i>
                            </div>

                            {{-- Dropdown Hasil Search --}}
                            @if (!empty($usersList))
                                <div
                                    class="absolute z-10 w-full bg-white border border-slate-200 rounded-lg shadow-lg mt-1 max-h-40 overflow-y-auto">
                                    @foreach ($usersList as $u)
                                        <button wire:click="selectUser({{ $u->id }}, '{{ $u->name }}')"
                                            class="w-full text-left px-4 py-2 text-sm hover:bg-indigo-50 text-slate-700 border-b border-slate-100 last:border-0">
                                            {{ $u->name }} <span
                                                class="text-xs text-slate-400 block">{{ $u->email }}</span>
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Selected User Display --}}
                    @if ($selectedUserId)
                        <div
                            class="bg-indigo-50 border border-indigo-100 rounded-lg p-3 flex items-center justify-between">
                            <div>
                                <span class="text-xs text-indigo-500 font-bold uppercase">Terpilih</span>
                                <p class="font-semibold text-indigo-900 text-sm">{{ $selectedUserName }}</p>
                            </div>
                            <button wire:click="$set('selectedUserId', null)"
                                class="text-indigo-400 hover:text-indigo-600">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>
                    @else
                        <div class="bg-slate-50 border border-slate-100 rounded-lg p-3 text-center">
                            <p class="text-xs text-slate-400 italic">Belum ada pengguna dipilih</p>
                        </div>
                    @endif
                    @error('selectedUserId')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror

                    <div class="mt-auto pt-4">
                        <button wire:click="printUser"
                            class="cursor-pointer w-full flex justify-center items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-4 rounded-lg transition-all"
                            {{ !$selectedUserId ? 'disabled class=opacity-50 cursor-not-allowed' : '' }}>
                            <i class="fas fa-file-user"></i> Cetak Portofolio
                        </button>
                    </div>
                </div>
            </div>

            {{-- KARTU C: STATISTIK --}}
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden flex flex-col">
                <div class="p-5 border-b border-slate-100 bg-slate-50">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-green-100 text-green-600 rounded-lg">
                            <i class="fas fa-chart-line text-xl"></i>
                        </div>
                        <h3 class="font-bold text-slate-800">Analisis Statistik</h3>
                    </div>
                </div>
                <div class="p-6 flex-1 flex flex-col gap-4">
                    <div>
                        <label class="text-xs font-bold text-slate-500 uppercase mb-1 block">Pilih Tahun</label>
                        <select wire:model="statsYear"
                            class="w-full border-slate-300 rounded-lg focus:ring-green-500 focus:border-green-500 text-sm">
                            @for ($y = date('Y'); $y >= 2024; $y--)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="bg-green-50 p-4 rounded-lg text-green-800 text-xs leading-relaxed">
                        Laporan ini berisi komparasi rata-rata skor per bulan untuk aspek Ayah, Ibu, dan Keluarga Lain.
                        Berguna untuk melihat tren kesehatan keluarga tahunan.
                    </div>

                    <div class="mt-auto pt-4">
                        <button wire:click="printStats"
                            class="w-full flex justify-center items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 px-4 rounded-lg transition-all">
                            <i class="fas fa-chart-pie"></i> Cetak Analisis
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
