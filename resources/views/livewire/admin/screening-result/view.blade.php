<div>
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a href="{{ route('screeningresult') }}" wire:navigate
                    class="inline-flex items-center text-sm font-normal text-slate-400 hover:text-blue-500">
                    Hasil Screening
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                    <span class="inline-flex items-center text-sm font-normal text-slate-600">
                        {{ $screening->user->name }} - {{ $screening->created_at->format('d M Y H:i:s') }}
                    </span>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                    <span class="inline-flex items-center text-sm font-medium text-slate-800">
                        Detail
                    </span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="flex flex-col md:flex-row md:items-start justify-between mb-6 gap-4">
        <h1 class="text-2xl font-bold text-slate-800 leading-tight">
            {{ $screening->user->name }} - {{ $screening->created_at->format('d F Y H:i') }}
        </h1>

        <button wire:click="delete" wire:confirm="Yakin ingin menghapus data screening ini?"
            class="inline-flex items-center justify-center rounded-lg border border-red-300 bg-red-500 px-4 py-2 text-sm font-semibold text-white hover:bg-red-600 shadow-sm transition-colors">
            Hapus
        </button>
    </div>

    <div class="rounded-2xl mb-8 shadow-sm border border-gray-200 bg-white p-6">
        <h2 class="font-bold text-xl text-slate-800 mb-6 border-b border-slate-100 pb-4">Ringkasan Hasil</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-6">

            <div class="space-y-6">
                <div>
                    <h3 class="font-semibold text-base">Nama</h3>
                    <p class="text-base text-gray-800">{{ $screening->user->name }}</p>
                </div>
                <div>
                    <h3 class="font-semibold text-base">Email</h3>
                    <p class="text-base text-gray-800">{{ $screening->user->email }}</p>
                </div>
                <div>
                    <h3 class="font-semibold text-base">Peran Superior
                    </h3>
                    @if ($screening->user->superiority_role)
                        <p class="text-base text-gray-800">
                            {{ $screening->user->superiority_role }}
                        </p>
                    @else
                        <span class="text-slate-400 text-sm italic">-</span>
                    @endif
                </div>
            </div>

            {{-- Kolom 2: Metadata Sesi --}}
            <div class="space-y-6">
                <div>
                    <h3 class="font-semibold text-base">ID Sesi</h3>
                    <p class="text-base text-gray-800">
                        SCR-{{ $screening->created_at->format('Ymd') }}-{{ str_pad($screening->id, 5, '0', STR_PAD_LEFT) }}
                    </p>
                </div>
                <div>
                    <h3 class="font-semibold text-base">Waktu Selesai
                    </h3>
                    <p class="text-base text-gray-800">
                        {{ $screening->created_at->format('d F Y H:i:s') }}</p>
                </div>
                <div>
                    <h3 class="font-semibold text-base">Skor Total</h3>
                    <p class="text-base text-gray-800">{{ $screening->result->total_score ?? 0 }}</p>
                </div>
            </div>

            {{-- Kolom 3: Rincian Skor --}}
            <div class="space-y-6">
                <div>
                    <h3 class="font-semibold text-base">Skor Ayah (FPQ)
                    </h3>
                    <div class="flex items-baseline gap-2">
                        <p class="text-base text-gray-800">{{ $screening->result->fpq_score ?? 0 }}</p>
                        <span
                            class="text-xs font-medium text-slate-500">({{ $screening->result->fpq_category ?? '-' }})</span>
                    </div>
                </div>
                <div>
                    <h3 class="font-semibold text-base">Skor Ibu (MCIQ)
                    </h3>
                    <div class="flex items-baseline gap-2">
                        <p class="text-base text-gray-800">{{ $screening->result->mciq_score ?? 0 }}</p>
                        <span
                            class="text-xs font-medium text-slate-500">({{ $screening->result->mciq_category ?? '-' }})</span>
                    </div>
                </div>
                <div>
                    <h3 class="font-semibold text-base">Keluarga Lain
                        (FMWB)</h3>
                    <div class="flex items-baseline gap-2">
                        <p class="text-base text-gray-800">{{ $screening->result->fmwb_score ?? 0 }}</p>
                        <span
                            class="text-xs font-medium text-slate-500">({{ $screening->result->fmwb_category ?? '-' }})</span>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="font-semibold text-base">Diagnosa & Rekomendasi
                </h3>
                @if ($screening->recommendation)
                    @php
                        $bgClass = str_contains($screening->recommendation->code, 'R')
                            ? 'bg-red-50 text-red-700 border-red-200'
                            : 'bg-orange-50 text-orange-700 border-orange-200';
                        if ($screening->recommendation->code === 'TTT') {
                            $bgClass = 'bg-green-50 text-green-700 border-green-200';
                        }
                    @endphp
                    <span
                        class="{{ $bgClass }} border px-3 py-1.5 font-bold text-sm rounded-lg inline-block mb-2">
                        {{ $screening->recommendation->title }}
                    </span>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        {{ $screening->recommendation->description }}
                    </p>
                @else
                    <span class="text-slate-400 italic text-sm">Belum ada data</span>
                @endif
            </div>

        </div>
    </div>

    @php
        $groupedResponses = $screening->responses->groupBy(function ($item) {
            return $item->question->instrument->name ?? 'Instrumen Lain';
        });
    @endphp

    @foreach ($groupedResponses as $instrumentName => $responses)
        <div class="rounded-2xl mb-8 shadow-sm border border-gray-200 bg-white p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-bold text-xl text-slate-800">
                    Instrumen: {{ $instrumentName }}
                </h2>
                <span
                    class="bg-slate-100 text-slate-600 text-xs font-medium px-2.5 py-0.5 rounded border border-slate-200">
                    {{ $responses->count() }} Pertanyaan
                </span>
            </div>

            <div class="relative overflow-x-auto rounded-lg border border-slate-200">
                <table class="w-full text-sm text-left text-slate-500">
                    <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th scope="col" class="px-6 py-3 w-12 text-center">No</th>
                            <th scope="col" class="px-6 py-3">Teks Pertanyaan</th>
                            <th scope="col" class="px-6 py-3 w-32 text-center">Tipe</th>
                            <th scope="col" class="px-6 py-3 w-40 text-center">Skor Akhir</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($responses as $index => $response)
                            @php
                                $finalScore = $response->answer_value; // Default Favorable
                                $isUnfavorable = $response->question->scoring_type === 'Unfavorable';
                            @endphp
                            <tr class="bg-white hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 text-center font-medium text-slate-900">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 text-slate-800">
                                    {{ $response->question->question_text }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if ($isUnfavorable)
                                        <span
                                            class="text-xs font-medium text-red-600 bg-red-50 px-2 py-1 rounded border border-red-100">Unfavorable</span>
                                    @else
                                        <span
                                            class="text-xs font-medium text-green-600 bg-green-50 px-2 py-1 rounded border border-green-100">Favorable</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center font-bold text-slate-700">
                                    @php
                                        $rawVal = (int) $response->answer_value;
                                        $scoringType = $response->question->scoring_type ?? 'Favorable';
                                        $instrumentCode = $response->question->instrument->code ?? '';

                                        $finalScore = $rawVal;

                                        // 1. INSTRUMEN IBU (MCIQ)
                                        if ($instrumentCode === 'MCIQ') {
                                            if ($scoringType === 'Unfavorable') {
                                                $finalScore = 4 - $rawVal;
                                            } else {
                                                $finalScore = $rawVal;
                                            }
                                        }
                                        // 2. INSTRUMEN LAIN (FMWB)
                                        elseif ($instrumentCode === 'FMWB') {
                                            if ($scoringType === 'Favorable') {
                                                $finalScore = $rawVal - 1;
                                            } else {
                                                $finalScore = 10 - $rawVal;
                                            }
                                        }
                                        // 3. INSTRUMEN AYAH (FPQ)
                                        else {
                                            $finalScore = $rawVal;
                                        }
                                    @endphp

                                    {{ $finalScore }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach

    <div class="flex justify-start pb-8">
        <a href="{{ route('screeningresult') }}" wire:navigate
            class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 hover:text-slate-900 shadow-sm transition-all">
            Batal
        </a>
    </div>
</div>
