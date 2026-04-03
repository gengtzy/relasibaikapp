<?php

namespace App\Livewire\Screening;

use App\Models\Question;
use App\Services\ScreeningService;
use Livewire\Component;
use Livewire\Attributes\Session;

class StepMother extends Component
{
    public $questions = [];

    #[Session]
    public $answers = []; // Menyimpan nilai 1-9 (Visual Slider)

    public function mount($defaultAnswers = [])
    {
        // 1. Ambil pertanyaan MCIQ
        $this->questions = Question::whereHas('instrument', function($query) {
            $query->where('code', 'MCIQ');
        })->get();

        // 2. Cek data session/parent (Logic Back Button)
        // Gunakan prioritas: Session Internal -> Data Parent -> Null
        if (empty($this->answers) && !empty($defaultAnswers)) {
            $this->answers = $defaultAnswers;
        }

        // 3. Inisialisasi array agar tidak error di view
        foreach ($this->questions as $question) {
            if (!array_key_exists($question->id, $this->answers)) {
                // Kita set null dulu, nanti validasi yang memaksa user menggeser/memilih
                $this->answers[$question->id] = null; 
            }
        }
    }

    public function save(ScreeningService $screeningService)
    {
        // A. Validasi
        $rules = [];
        $messages = [];
        
        foreach ($this->questions as $question) {
            $rules["answers.{$question->id}"] = 'required|integer|min:0|max:4';
            $messages["answers.{$question->id}.required"] = "Butir ini wajib diisi.";
        }

        $this->validate($rules, $messages);

        // B. Hitung Skor via Service (Service yang handle Favorable/Unfavorable)
        $totalScore = $screeningService->calculateMotherScore(
            $this->answers, 
            auth()->user()
        );

        // dd([
        // 'Status' => 'Berhasil masuk fungsi save',
        // 'Data User' => auth()->user()->name . ' (' . auth()->user()->superiority_role . ')',
        // 'Semua Jawaban (Array)' => $this->answers,
        // 'Total Skor (Int)' => $totalScore
        // ]);

        // C. Kirim ke Parent
        $this->dispatch('motherAnswersCompleted', 
            answers: $this->answers,
            score: $totalScore
        );
    }

    public function back()
    {
        // Kembali ke Step 2 (Ayah)
        $this->dispatch('goToStep', step: 2);
    }

    public function render()
    {
        return view('livewire.screening.step-mother');
    }
}