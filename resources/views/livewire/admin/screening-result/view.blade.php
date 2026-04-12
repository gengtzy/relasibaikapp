<div x-data="{ showModal: @entangle('showModal') }" x-init="$watch('showModal', value => {
    if (value) {
        document.body.classList.add('overflow-hidden');
    } else {
        document.body.classList.remove('overflow-hidden');
    }
})">

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

        {{-- UPDATE TOMBOL HAPUS: Panggil Modal, bukan confirm browser --}}
        <button @click="showModal = true" type="button"
            class="inline-flex items-center justify-center rounded-lg border border-red-300 bg-red-500 px-4 py-2 text-sm font-semibold text-white hover:bg-red-600 shadow-sm transition-colors">
            Hapus
        </button>
    </div>

    {{-- ... (BAGIAN KONTEN INTI TETAP SAMA, TIDAK ADA PERUBAHAN) ... --}}

    <div class="rounded-2xl mb-8 shadow-sm border border-gray-200 bg-white p-6">
        {{-- ... Isi ringkasan hasil ... --}}
        <h2 class="font-bold text-xl text-slate-800 mb-6 border-b border-slate-100 pb-4">Ringkasan Hasil</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-6">
            {{-- ... Isi grid ... --}}
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
                    <h3 class="font-semibold text-base">Peran Superior</h3>
                    @if ($screening->user->superiority_role)
                        <p class="text-base text-gray-800">{{ $screening->user->superiority_role }}</p>
                    @else
                        <span class="text-slate-400 text-sm italic">-</span>
                    @endif
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <h3 class="font-semibold text-base">ID Sesi</h3>
                    <p class="text-base text-gray-800">
                        SCR-{{ $screening->created_at->format('Ymd') }}-{{ str_pad($screening->id, 5, '0', STR_PAD_LEFT) }}
                    </p>
                </div>
                <div>
                    <h3 class="font-semibold text-base">Waktu Selesai</h3>
                    <p class="text-base text-gray-800">{{ $screening->created_at->format('d F Y H:i:s') }}</p>
                </div>
                <div>
                    <h3 class="font-semibold text-base">Skor Total</h3>
                    <p class="text-base text-gray-800">{{ $screening->result->total_score ?? 0 }}</p>
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <h3 class="font-semibold text-base">Skor Ayah (FPQ)</h3>
                    <div class="flex items-baseline gap-2">
                        <p class="text-base text-gray-800">{{ $screening->result->fpq_score ?? 0 }}</p>
                        <span
                            class="text-xs font-medium text-slate-500">({{ $screening->result->fpq_category ?? '-' }})</span>
                    </div>
                </div>
                <div>
                    <h3 class="font-semibold text-base">Skor Ibu (MCIQ)</h3>
                    <div class="flex items-baseline gap-2">
                        <p class="text-base text-gray-800">{{ $screening->result->mciq_score ?? 0 }}</p>
                        <span
                            class="text-xs font-medium text-slate-500">({{ $screening->result->mciq_category ?? '-' }})</span>
                    </div>
                </div>
                <div>
                    <h3 class="font-semibold text-base">Keluarga Lain (FMWB)</h3>
                    <div class="flex items-baseline gap-2">
                        <p class="text-base text-gray-800">{{ $screening->result->fmwb_score ?? 0 }}</p>
                        <span
                            class="text-xs font-medium text-slate-500">({{ $screening->result->fmwb_category ?? '-' }})</span>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="font-semibold text-base">Diagnosa & Rekomendasi</h3>
                {{-- PERBAIKAN DI SINI --}}
                @if ($screening->result && $screening->result->recommendation)
                    @php
                        $bgClass = str_contains($screening->result->recommendation->code, 'R')
                            ? 'bg-red-50 text-red-700 border-red-200'
                            : 'bg-orange-50 text-orange-700 border-orange-200';
                        if ($screening->result->recommendation->code === 'TTT') {
                            $bgClass = 'bg-green-50 text-green-700 border-green-200';
                        }
                    @endphp
                    <span
                        class="{{ $bgClass }} border px-3 py-1.5 font-bold text-sm rounded-lg inline-block mb-2">
                        {{ $screening->result->recommendation->title }}
                    </span>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        {{ $screening->result->recommendation->description }}
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
                                $finalScore = $response->answer_value;
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
                                    {{-- ... KODE LOGIKA SKOR (Anda sudah punya kode ini yang benar) ... --}}
                                    @php
                                        $rawVal = (int) $response->answer_value;
                                        $scoringType = $response->question->scoring_type ?? 'Favorable';
                                        $instrumentCode = $response->question->instrument->code ?? '';
                                        $finalScore = $rawVal;

                                        if ($instrumentCode === 'MCIQ') {
                                            if ($scoringType === 'Unfavorable') {
                                                $finalScore = 4 - $rawVal;
                                            } else {
                                                $finalScore = $rawVal;
                                            }
                                        } elseif ($instrumentCode === 'FMWB') {
                                            if ($scoringType === 'Favorable') {
                                                $finalScore = $rawVal - 1;
                                            } else {
                                                $finalScore = 10 - $rawVal;
                                            }
                                        } else {
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

    {{-- MODAL DELETE (Copy-Paste dari index.blade.php dengan sedikit penyesuaian) --}}
    <div x-show="showModal" style="display: none;" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="!m-0 fixed inset-0 z-[9999] flex items-center justify-center w-full bg-gray-900/60 backdrop-blur-sm p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-screen">

        <div @click.outside="showModal = false" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90" class="relative w-full max-w-md max-h-full">

            <div class="relative bg-white border border-gray-200 rounded-xl shadow-2xl p-4 md:p-6">

                <button type="button" @click="showModal = false"
                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center transition-colors">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>

                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>

                    <h3 class="mb-2 text-lg font-normal text-gray-500">
                        Apakah Anda yakin ingin menghapus data ini?
                    </h3>

                    {{-- ID Sesi Dinamis --}}
                    <div class="mb-6 py-2 px-3 bg-gray-50 rounded-lg border border-gray-100 inline-block">
                        <span class="font-mono text-sm font-bold text-gray-800">
                            ID:
                            SCR-{{ $screening->created_at->format('Ymd') }}-{{ str_pad($screening->id, 5, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>

                    <div class="flex items-center justify-center gap-3">
                        <button wire:click="delete" wire:loading.attr="disabled" type="button"
                            class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center transition-all shadow-md hover:shadow-lg disabled:opacity-50">
                            <span wire:loading.remove>Ya, Hapus Data</span>
                            <span wire:loading>Menghapus...</span>
                        </button>

                        <button @click="showModal = false" type="button"
                            class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 transition-all shadow-sm">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
