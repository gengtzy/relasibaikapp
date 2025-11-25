<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Screening;
use App\Models\User;
use App\Models\ScreeningResult;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function print(Request $request)
    {
        $type = $request->query('type');
        $data = [];
        $meta = [];

        // 1. LOGIKA LAPORAN REKAPITULASI (PERIODIK)
        if ($type === 'recap') {
            $startDate = Carbon::parse($request->query('start'));
            $endDate   = Carbon::parse($request->query('end'))->endOfDay();
            $status    = $request->query('status');

            $query = Screening::with(['user', 'result', 'recommendation'])
                ->whereBetween('created_at', [$startDate, $endDate])
                ->where('status', 'saved'); // Hanya yang sudah disimpan

            // Filter Status Diagnosa (Opsional)
            if ($status === 'problem') {
                $query->whereHas('recommendation', function($q) {
                    $q->where('code', 'like', '%R%'); // Cari yang bermasalah
                });
            }

            $data = $query->latest()->get();
            $meta = [
                'title' => 'Laporan Rekapitulasi Skrining',
                'subtitle' => 'Periode: ' . $startDate->format('d M Y') . ' - ' . $endDate->format('d M Y'),
                'filter' => $status === 'problem' ? 'Hanya Kasus Terindikasi Masalah' : 'Semua Data'
            ];
        }

        // 2. LOGIKA LAPORAN INDIVIDUAL (USER)
        elseif ($type === 'user') {
            $userId = $request->query('user_id');
            $user = User::findOrFail($userId);

            $data = Screening::with(['result', 'recommendation'])
                ->where('user_id', $userId)
                ->where('status', 'saved')
                ->latest()
                ->get();

            $meta = [
                'title' => 'Laporan Riwayat Individual',
                'subtitle' => 'Pengguna: ' . $user->name . ' (' . $user->email . ')',
                'user_profile' => $user
            ];
        }

        // 3. LOGIKA LAPORAN STATISTIK (TAHUNAN)
        elseif ($type === 'stats') {
            $year = $request->query('year', date('Y'));

            // Ambil rata-rata per bulan
            $monthlyStats = ScreeningResult::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('AVG(fpq_score) as avg_father'),
                DB::raw('AVG(mciq_score) as avg_mother'),
                DB::raw('AVG(fmwb_score) as avg_other'),
                DB::raw('COUNT(*) as total_count')
            )
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

            $data = $monthlyStats;
            $meta = [
                'title' => 'Laporan Analisis Statistik',
                'subtitle' => 'Tahun: ' . $year,
                'year' => $year
            ];
        }

        return view('livewire.admin.reports.print', compact('data', 'meta', 'type'));
    }
}