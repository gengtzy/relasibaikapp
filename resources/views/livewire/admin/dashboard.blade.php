<div class="">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <span class="inline-flex items-center text-sm font-normal text-slate-400">
                    Dashboard Utama
                </span>
            </li>
        </ol>
    </nav>

    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
        <h1 class="text-2xl font-bold text-slate-800">Dashboard Utama</h1>
    </div>

    <div class="max-w-6xl">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-slate-500 font-medium">Total Pengguna</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $totalUsers }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex items-center">
                <div class="p-3 rounded-full bg-indigo-100 text-indigo-600 mr-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-slate-500 font-medium">Skrining Selesai</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $totalScreenings }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-slate-500 font-medium">Rata-rata Skor</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $avgTotalScore }}</p>
                </div>
            </div>

            <a href="{{ route('screeningresult', ['filter' => 'risk']) }}" wire:navigate 
               class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex items-center cursor-pointer hover:bg-red-50/50 hover:border-red-200 transition-all group">
                
                <div class="p-3 rounded-full bg-red-100 text-red-600 mr-4 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm text-slate-500 font-medium group-hover:text-red-600 transition-colors">Indikasi Masalah</p>
                            <p class="text-2xl font-bold text-red-600">{{ $riskCount }} <span class="text-sm font-normal text-slate-400">Kasus</span></p>
                        </div>
                        
                        {{-- Ikon Panah Kecil (Indikator Klik) --}}
                        <div class="text-slate-300 group-hover:text-red-400 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <h3 class="text-lg font-bold text-slate-800 mb-6">Distribusi Diagnosis</h3>
                <div class="relative h-[350px] w-full flex justify-center items-center">
                    <div id="chart-pie" class="w-full"></div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <h3 class="text-lg font-bold text-slate-800 mb-6">Analisis Skor Per Aspek</h3>
                <div class="relative h-[350px] w-full">
                    <div id="chart-bar" class="w-full h-full"></div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-slate-800">Aktivitas Skrining Terbaru</h3>
                <a href="{{ route('screeningresult') }}" wire:navigate
                    class="text-sm text-blue-600 hover:underline font-medium">Lihat Semua</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-500">
                    <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                        <tr>
                            <th class="px-6 py-3">User</th>
                            <th class="px-6 py-3">Waktu</th>
                            <th class="px-6 py-3">Hasil Diagnosa</th>
                            <th class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentScreenings as $item)
                            <tr class="bg-white border-b hover:bg-slate-50">
                                <td class="px-6 py-4 font-medium text-slate-900">
                                    {{ $item->user->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $item->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($item->recommendation)
                                        @php
                                            $color = str_contains($item->recommendation->code, 'R') ? 'red' : 'green';
                                        @endphp
                                        <span
                                            class="bg-{{ $color }}-100 text-{{ $color }}-700 text-xs font-bold px-2 py-1 rounded">
                                            {{ Str::limit($item->recommendation->title, 25) }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('screeningresultshow', $item->id) }}" wire:navigate
                                        class="text-blue-600 hover:underline">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center">Belum ada aktivitas terbaru.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        function initCharts() {
            // --- LANGKAH 1: BERSIHKAN WADAH SEBELUM RENDER (SOLUSI DUPLIKAT) ---
            const pieContainer = document.querySelector("#chart-pie");
            const barContainer = document.querySelector("#chart-bar");

            if (pieContainer) pieContainer.innerHTML = ""; // Hapus chart lama
            if (barContainer) barContainer.innerHTML = ""; // Hapus chart lama

            // --- LANGKAH 2: PIE CHART CONFIG ---
            var pieOptions = {
                series: @json($chartPieSeries),
                labels: @json($chartPieLabels),
                chart: {
                    type: 'donut',
                    height: 320, // Tinggi pas dalam container 350px
                    width: '100%',
                    fontFamily: 'Inter, sans-serif',
                },
                colors: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total',
                                    fontSize: '16px',
                                    fontWeight: 600
                                }
                            }
                        }
                    }
                },
                dataLabels: {
                    enabled: false
                },
                legend: {
                    position: 'bottom'
                },
                stroke: {
                    show: false
                }
            };

            var chartPie = new ApexCharts(pieContainer, pieOptions);
            chartPie.render();


            // --- LANGKAH 3: BAR CHART CONFIG ---
            var barOptions = {
                series: [{
                    name: 'Skor (%)',
                    data: [
                        {{ $chartBarData['ayah'] }},
                        {{ $chartBarData['ibu'] }},
                        {{ $chartBarData['lain'] }}
                    ]
                }],
                chart: {
                    type: 'bar',
                    height: 320, // Tinggi pas
                    width: '100%',
                    fontFamily: 'Inter, sans-serif',
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        columnWidth: '50%',
                        distributed: true,
                    }
                },
                colors: ['#3b82f6', '#ec4899', '#10b981'],
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return val + "%";
                    },
                    offsetY: -20,
                    style: {
                        fontSize: '12px',
                        colors: ["#304758"]
                    }
                },
                xaxis: {
                    categories: ['Relasi Ayah', 'Relasi Ibu', 'Keluarga Lain'],
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        style: {
                            fontSize: '12px'
                        }
                    }
                },
                yaxis: {
                    max: 100,
                    tickAmount: 5,
                },
                grid: {
                    padding: {
                        top: 10
                    },
                    strokeDashArray: 4,
                },
                legend: {
                    show: false
                }
            };

            var chartBar = new ApexCharts(barContainer, barOptions);
            chartBar.render();
        }

        // Event Listener agar jalan saat navigasi Livewire (SPA)
        document.addEventListener('livewire:navigated', () => {
            setTimeout(initCharts, 100);
        });

        // Event Listener saat load pertama (Refresh Browser)
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(initCharts, 100);
        });
    </script>
</div>
