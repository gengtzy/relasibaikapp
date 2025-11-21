<?php

namespace App\Livewire\Screening;

use App\Models\Question;
use App\Services\ScreeningService;
use Livewire\Component;
use Livewire\Attributes\Session;
use Illuminate\Support\Str; // Helper string

class StepOther extends Component
{
    public $questions = [];

    #[Session]
    public $answers = [];

    public function mount($defaultAnswers = [])
    {
        // 1. Ambil pertanyaan FMWB
        $this->questions = Question::whereHas('instrument', function($query) {
            $query->where('code', 'FMWB'); // Pastikan kode di DB adalah FMWB
        })->get();

        // 2. Cek data session/parent
        if (empty($this->answers) && !empty($defaultAnswers)) {
            $this->answers = $defaultAnswers;
        }

        // 3. Inisialisasi
        foreach ($this->questions as $question) {
            if (!array_key_exists($question->id, $this->answers)) {
                $this->answers[$question->id] = null; 
            }
        }
    }

    /**
     * LOGIKA PENENTUAN LABEL (Jangkar)
     * Mengembalikan array ['min' => 'Teks Kiri', 'max' => 'Teks Kanan']
     */
    public function getLabels($questionText)
    {
        $text = Str::lower($questionText);

        if (Str::contains($text, ['energi', 'semangat'])) {
            return [
                'min' => 'Tidak Ada Energi Sama Sekali',
                'max' => 'Sangat Energik'
            ];
        }

        if (Str::contains($text, ['mengkhawatirkannya', 'khawatir', 'kesehatan'])) {
            return [
                'min' => 'Tidak Mengkhawatirkan',
                'max' => 'Sangat Mengkhawatirkan'
            ];
        }

        if (Str::contains($text, ['rileks', 'tegang'])) {
            return [
                'min' => 'Sangat Rileks',
                'max' => 'Sangat Tegang'
            ];
        }
        
        if (Str::contains($text, ['tertekan', 'ceria'])) {
            return [
                'min' => 'Sangat Tertekan',
                'max' => 'Sangat Ceria'
            ];
        }
        
        if (Str::contains($text, ['sedih'])) {
            return [
                'min' => 'Tidak Sedih Sama Sekali',
                'max' => 'Sangat Sedih'
            ];
        }
        
        if (Str::contains($text, ['takut'])) {
            return [
                'min' => 'Sangat Takut',
                'max' => 'Sangat Tidak Takut'
            ];
        }
        if (Str::contains($text, ['marah'])) {
            return [
                'min' => 'Tidak Marah Sama Sekali',
                'max' => 'Sangat Marah'
            ];
        }

        // Default (Jika tidak ada kata kunci di atas)
        return [
            'min' => 'Sangat Tidak Sesuai',
            'max' => 'Sangat Sesuai'
        ];
    }

    public function save(ScreeningService $screeningService)
    {
        // A. Validasi (1-9)
        $rules = [];
        $messages = [];
        
        foreach ($this->questions as $question) {
            $rules["answers.{$question->id}"] = 'required|integer|min:1|max:10';
            $messages["answers.{$question->id}.required"] = "Pertanyaan ini wajib diisi.";
        }

        $this->validate($rules, $messages);

        // B. Hitung Skor
        $totalScore = $screeningService->calculateOtherScore($this->answers, auth()->user());

        // dd([
        // 'Status' => 'Berhasil masuk fungsi save',
        // 'Data User' => auth()->user()->name . ' (' . auth()->user()->superiority_role . ')',
        // 'Semua Jawaban (Array)' => $this->answers,
        // 'Total Skor (Int)' => $totalScore
        // ]);

        // C. Kirim ke Parent (Event baru: otherAnswersCompleted)
        $this->dispatch('otherAnswersCompleted', 
            answers: $this->answers,
            score: $totalScore
        );
    }

    public function back()
    {
        // Kembali ke Step 3 (Ibu)
        $this->dispatch('goToStep', step: 3);
    }

    public function render()
    {
        return view('livewire.screening.step-other');
    }
}