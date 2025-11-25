<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $meta['title'] }}</title>
    {{-- Gunakan Tailwind CSS CDN untuk styling cetak --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }

            .no-print {
                display: none;
            }

            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>

<body class="bg-white text-black p-8 font-sans" onload="window.print()">

    {{-- KOP LAPORAN --}}
    <div class="border-b-2 border-black pb-4 mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold uppercase tracking-wide">RelasiBaik.</h1>
            <p class="text-sm text-gray-600">Sistem Pakar Diagnosa Relasi Keluarga</p>
        </div>
        <div class="text-right">
            <h2 class="text-xl font-bold">{{ $meta['title'] }}</h2>
            <p class="text-sm">{{ $meta['subtitle'] }}</p>
        </div>
    </div>

    {{-- KONTEN BERDASARKAN TIPE --}}

    {{-- 1. REKAPITULASI --}}
    @if ($type === 'recap')
        <div class="mb-4 text-sm">
            <strong>Filter:</strong> {{ $meta['filter'] }} |
            <strong>Total Data:</strong> {{ count($data) }}
        </div>
        <table class="w-full border-collapse border border-black text-sm">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-black px-2 py-1">No</th>
                    <th class="border border-black px-2 py-1">Tanggal</th>
                    <th class="border border-black px-2 py-1">Nama User</th>
                    <th class="border border-black px-2 py-1">ID Sesi</th>
                    <th class="border border-black px-2 py-1">Total Skor</th>
                    <th class="border border-black px-2 py-1">Hasil Diagnosa</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $index => $item)
                    <tr>
                        <td class="border border-black px-2 py-1 text-center">{{ $index + 1 }}</td>
                        <td class="border border-black px-2 py-1">{{ $item->created_at->format('d/m/Y') }}</td>
                        <td class="border border-black px-2 py-1">{{ $item->user->name ?? '-' }}</td>
                        <td class="border border-black px-2 py-1 font-mono text-xs">
                            SCR-{{ $item->created_at->format('Ymd') }}-{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="border border-black px-2 py-1 text-center">{{ $item->result->total_score ?? 0 }}
                        </td>
                        <td class="border border-black px-2 py-1">
                            {{ $item->recommendation->title ?? '-' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- 2. USER INDIVIDUAL --}}
    @if ($type === 'user')
        <div class="mb-6 border p-4 rounded">
            <h3 class="font-bold border-b pb-2 mb-2">Profil Pengguna</h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <p><strong>Nama:</strong> {{ $meta['user_profile']->name }}</p>
                <p><strong>Email:</strong> {{ $meta['user_profile']->email }}</p>
                <p><strong>Peran:</strong> {{ $meta['user_profile']->superiority_role ?? '-' }}</p>
                <p><strong>Total Skrining:</strong> {{ count($data) }} kali</p>
            </div>
        </div>

        <h3 class="font-bold mb-2">Riwayat Hasil</h3>
        <table class="w-full border-collapse border border-black text-sm">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-black px-2 py-1">Tanggal</th>
                    <th class="border border-black px-2 py-1">Lokasi</th>
                    <th class="border border-black px-2 py-1 text-center">Skor Ayah</th>
                    <th class="border border-black px-2 py-1 text-center">Skor Ibu</th>
                    <th class="border border-black px-2 py-1 text-center">Skor Lain</th>
                    <th class="border border-black px-2 py-1">Kesimpulan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td class="border border-black px-2 py-1">{{ $item->created_at->format('d M Y H:i') }}</td>
                        <td class="border border-black px-2 py-1">{{ $item->lokasi ?? '-' }}</td>
                        <td class="border border-black px-2 py-1 text-center">{{ $item->result->fpq_score }}</td>
                        <td class="border border-black px-2 py-1 text-center">{{ $item->result->mciq_score }}</td>
                        <td class="border border-black px-2 py-1 text-center">{{ $item->result->fmwb_score }}</td>
                        <td class="border border-black px-2 py-1 font-bold">{{ $item->recommendation->title ?? '-' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- 3. STATISTIK --}}
    @if ($type === 'stats')
        <table class="w-full border-collapse border border-black text-sm mt-4">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-black px-2 py-2">Bulan</th>
                    <th class="border border-black px-2 py-2">Jumlah Partisipan</th>
                    <th class="border border-black px-2 py-2">Rata-rata Ayah</th>
                    <th class="border border-black px-2 py-2">Rata-rata Ibu</th>
                    <th class="border border-black px-2 py-2">Rata-rata Lain</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $stat)
                    <tr>
                        <td class="border border-black px-2 py-2 text-center font-bold">
                            {{ DateTime::createFromFormat('!m', $stat->month)->format('F') }}
                        </td>
                        <td class="border border-black px-2 py-2 text-center">{{ $stat->total_count }}</td>
                        <td class="border border-black px-2 py-2 text-center">{{ number_format($stat->avg_father, 1) }}
                        </td>
                        <td class="border border-black px-2 py-2 text-center">{{ number_format($stat->avg_mother, 1) }}
                        </td>
                        <td class="border border-black px-2 py-2 text-center">{{ number_format($stat->avg_other, 1) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p class="mt-4 text-xs text-gray-500">* Data merupakan nilai rata-rata (mean) dari seluruh populasi pengguna di
            bulan tersebut.</p>
    @endif

    {{-- FOOTER CETAK --}}
    <div class="mt-12 text-right text-sm">
        <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }}</p>
        <p class="mt-8">Administrator</p>
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 800); // Jeda dikit biar loading CSS selesai
        }
    </script>
</body>

</html>
