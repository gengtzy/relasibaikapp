<?php

namespace App\Services;
use App\Models\User;
use App\Models\Question;
use App\Models\Screening;
use App\Models\ScreeningResult;
use App\Models\ScreeningResponse;
use App\Models\Recommendation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScreeningService
{
    /**
     * Menerima semua jawaban mentah, menghitung skor,
     * dan menerapkan rule-base.
     *
     * @param array $biodata
     * @param array $fatherAnswers
     * @param array $motherAnswers
     * @param array $otherAnswers
     * @return \App\Models\Screening  // Mengembalikan model hasil
     */
    public function calculateAndSave(
        array $biodata,
        array $fatherAnswers,
        array $motherAnswers,
        array $otherAnswers
    ) {
        $user = Auth::user();
        
        return DB::transaction(function () use ($user, $biodata, $fatherAnswers, $motherAnswers, $otherAnswers) {
            
            // 1. Hitung Skor
            $scoreFather = $this->calculateFatherScore($fatherAnswers, $user);
            $scoreMother = $this->calculateMotherScore($motherAnswers, $user);
            $scoreOther  = $this->calculateOtherScore($otherAnswers, $user);
            $totalScore  = $scoreFather + $scoreMother + $scoreOther;

            // 2. Tentukan Kategori (Fakta)
            $catFather = $this->getCategory($scoreFather, 14, 4, 0); // "Tinggi"/"Sedang"/"Rendah"
            $catMother = $this->getCategory($scoreMother, 28, 4, 0);
            $catOther  = $this->getCategory($scoreOther, 8, 9, 0);

            $ruleCode = substr($catFather, 0, 1) . substr($catMother, 0, 1) . substr($catOther, 0, 1);

            // 4. Cari Langsung di Database berdasarkan Kode "TTS" tadi
            // Inilah yang dimaksud pemanggilan langsung
            $recommendation = Recommendation::where('code', $ruleCode)->first();
            
            // Fallback jika rule tidak ditemukan (Jaga-jaga)
            if (!$recommendation) {
                // Bisa default ke RRR atau kode default lain
                $recommendation = Recommendation::where('code', 'RRR')->first(); 
            }

            // 5. Simpan Data (Sama seperti sebelumnya)
            $screening = Screening::create([
            'user_id' => $user->id,
            'lokasi'  => $biodata['lokasi_name'] ?? null,
            'tanggal_pengisian' => $biodata['tanggal'] ?? now(),
            'id_recommendation' => $recommendation ? $recommendation->id : null, // Simpan ID-nya
            'status' => 'preview'
            ]);

            ScreeningResult::create([
                'id_screening'  => $screening->id,
                'fpq_score'     => $scoreFather,
                'fpq_category'  => $catFather,
                'mciq_score'    => $scoreMother,
                'mciq_category' => $catMother,
                'fmwb_score'    => $scoreOther,
                'fmwb_category' => $catOther,
                'total_score'   => $totalScore,
            ]);

            // ... (Simpan response detail, kode sama) ...
            $responsesData = [];
            // Gabung semua jawaban jadi satu array
            $allAnswers = $fatherAnswers + $motherAnswers + $otherAnswers;

            foreach ($allAnswers as $qId => $val) {
                if ($val !== null) { 
                    $responsesData[] = [
                        'id_screening' => $screening->id,
                        'id_question'  => $qId,
                        'answer_value' => (int) $val,
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ];
                }
            }
            
            if (!empty($responsesData)) {
                ScreeningResponse::insert($responsesData);
            }
            
            return $screening;
        });
    }

    public function calculateFatherScore(array $answers, User $user): int
    {
        if (empty($answers)) {
            return 0;
        }

        $cleanAnswers = array_map(fn($val) => (int) $val, $answers);
        $baseScore = array_sum($cleanAnswers);

        $bonus = 0;
        if ($user->role === 'masyarakat' && 
            $user->superiority_role === 'Ayah' && 
            $user->hasVerifiedEmail()) {
            
            $bonus = 5;
        }

        return $baseScore + $bonus;
    }

    public function calculateMotherScore(array $answers, User $user): int
    {
        if (empty($answers)) {
            return 0;
        }

        // 1. Ambil Detail Pertanyaan (untuk tahu mana Favorable/Unfavorable)
        // Kita perlu query ulang berdasarkan keys dari jawaban untuk efisiensi
        $questionIds = array_keys($answers);
        $questions = Question::whereIn('id', $questionIds)->get();

        $totalScore = 0;

        foreach ($questions as $question) {
            // Pastikan ada jawaban untuk pertanyaan ini
            if (!isset($answers[$question->id])) continue;

            $userVal = (int) $answers[$question->id]; 

            if ($question->scoring_type === 'Favorable') {
                $score = $userVal;
            } else {
                $score = 4 - $userVal;
            }

            $totalScore += $score;
        }

        // 2. Logika Bonus (Role Masyarakat + Peran Superior Ibu + Terverifikasi)
        $bonus = 0;
        if ($user->role === 'masyarakat' && 
            $user->superiority_role === 'Ibu' && 
            $user->hasVerifiedEmail()) {
            
            $bonus = 5; // Sesuaikan poin bonus
        }

        return $totalScore + $bonus;
    }

    public function calculateOtherScore(array $answers, User $user): int
    {
        if (empty($answers)) {
            return 0;
        }

        $questionIds = array_keys($answers);
        $questions = Question::whereIn('id', $questionIds)->get();

        $totalScore = 0;

        foreach ($questions as $question) {
            if (!isset($answers[$question->id])) continue;

            $userVal = (int) $answers[$question->id];

            if ($question->scoring_type === 'Favorable') {
                // Rumus Favorable (Urut): Nilai - 1
                $score = $userVal - 1;
            } else {
                // Rumus Unfavorable (Terbalik): 9 - Nilai
                $score = 10 - $userVal;
            }

            $totalScore += $score;
        }

        $bonus = 0;
        if ($user->role === 'masyarakat' && 
            $user->superiority_role === 'Anggota Keluarga Lain' && 
            $user->hasVerifiedEmail()) {
            
            $bonus = 5; // Sesuaikan poin bonus
        }

        return $totalScore + $bonus;
    }

    public function getCategory(int $score, int $numberOfQuestions, int $maxScale, int $minScale): string
    {
        // Rumus Statistik Anda:
        $xMin = $minScale * $numberOfQuestions;
        $xMax = $maxScale * $numberOfQuestions; // Max Poin per butir * Jumlah Soal

        $range = $xMax - $xMin;
        $mean = ($xMax + $xMin) / 2;
        $sd = $range / 6;

        $cutoffLow = $mean - $sd;  // Batas Bawah (M - 1SD)
        $cutoffHigh = $mean + $sd; // Batas Atas (M + 1SD)

        if ($score < $cutoffLow) {
            return 'Rendah';
        } elseif ($score >= $cutoffLow && $score < $cutoffHigh) {
            return 'Sedang';
        } else {
            return 'Tinggi';
        }
    }

}