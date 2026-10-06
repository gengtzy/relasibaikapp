<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Screening;
use App\Models\User;
use App\Models\ScreeningResult;
use App\Models\Payment; // <-- TAMBAHAN WAJIB
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

            $query = Screening::with(['user', 'result.recommendation'])
                ->whereBetween('created_at', [$startDate, $endDate])
                ->where('status', 'saved');

            if ($status === 'problem') {
                $query->whereHas('result.recommendation', function($q) {
                    $q->where('code', 'like', '%R%');
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

            $data = Screening::with(['result.recommendation'])
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

            $monthlyStats = ScreeningResult::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('AVG(fpq_score) as avg_father'),
                DB::raw('AVG(mciq_score) as avg_mother'),
                DB::raw('AVG(fmwb_score) as avg_other'),
                DB::raw('COUNT(*) as total_count')
            )
            ->whereYear('created_at', $year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();

            $data = $monthlyStats;
            $meta = [
                'title' => 'Laporan Analisis Statistik',
                'subtitle' => 'Tahun: ' . $year,
                'year' => $year
            ];
        }
        
        // 4. LOGIKA LAPORAN PEMBAYARAN REWARD (BARU)
        elseif ($type === 'payment') {
            $startDate = Carbon::parse($request->query('start'))->startOfDay();
            $endDate   = Carbon::parse($request->query('end'))->endOfDay();

            // Hanya ambil data payment yang 'skor'-nya tidak null (artinya skrining sudah selesai)
            $data = Payment::whereNotNull('skor')
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->orderBy('tanggal', 'desc') // Urutkan dari yang terbaru
                ->get();

            $meta = [
                'title' => 'Laporan Rekapitulasi Pembayaran Reward',
                'subtitle' => 'Periode: ' . $startDate->format('d M Y') . ' - ' . $endDate->format('d M Y'),
            ];
        }

        return view('livewire.admin.reports.print', compact('data', 'meta', 'type'));
    }
}