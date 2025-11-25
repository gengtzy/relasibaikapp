<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Screening;
use App\Models\ScreeningResult;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.admin')]
class Dashboard extends Component
{
    public function render()
    {
        $totalUsers = User::where('role', 'masyarakat')->count();

        $totalScreenings = Screening::where('status', 'saved')->count();

        $avgTotalScore = ScreeningResult::avg('total_score');

        $riskCount = Screening::where('status', 'saved')
            ->whereHas('recommendation', function($q) {
                $q->where('code', 'like', '%R%'); // Asumsi kode RRR, TTR, dsb mengandung indikasi masalah
            })->count();

        //barchart
        $avgFather = ScreeningResult::avg('fpq_score') ?? 0;
        $avgMother = ScreeningResult::avg('mciq_score') ?? 0;
        $avgOther  = ScreeningResult::avg('fmwb_score') ?? 0;

        $chartBarData = [
            'ayah' => round(($avgFather / 56) * 100, 1),
            'ibu'  => round(($avgMother / 112) * 100, 1),
            'lain' => round(($avgOther / 72) * 100, 1),
        ];

        //piechart
        $pieDataRaw = Screening::where('status', 'saved')
            ->join('recommendations', 'screenings.id_recommendation', '=', 'recommendations.id')
            ->select('recommendations.title', DB::raw('count(*) as total'))
            ->groupBy('recommendations.title')
            ->get();

        $chartPieLabels = $pieDataRaw->pluck('title')->toArray();
        $chartPieSeries = $pieDataRaw->pluck('total')->toArray();

        $recentScreenings = Screening::with(['user', 'recommendation'])
            ->where('status', 'saved')
            ->latest()
            ->take(5)
            ->get();

        
        return view('livewire.admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalScreenings' => $totalScreenings,
            'avgTotalScore' => round($avgTotalScore, 1),
            'riskCount' => $riskCount,
            'chartBarData' => $chartBarData,
            'chartPieLabels' => $chartPieLabels,
            'chartPieSeries' => $chartPieSeries,
            'recentScreenings' => $recentScreenings
        ]);
    }
}
