<?php

namespace App\Livewire\Screening;

use App\Models\Question;
use App\Services\ScreeningService;
use Livewire\Attributes\Session;
use Livewire\Component;

class StepFather extends Component
{
    public $questions = [];

    #[Session]
    public $answers = [];

    public function mount($defaultAnswers = [])
    {
        $this->questions = Question::whereHas('instrument', function($query) {
            $query->where('code', 'FPQ');
        })->get();

        if (empty($this->answers) && !empty($defaultAnswers)) {
            $this->answers = $defaultAnswers;
        }

        foreach ($this->questions as $question) {
            if (!array_key_exists($question->id, $this->answers)) {
                $this->answers[$question->id] = null; 
            }
        }
    }

    public function save(ScreeningService $screeningService)
    {
        $rules = [];
        $messages = [];
        
        foreach ($this->questions as $question) {
            $rules["answers.{$question->id}"] = 'required|integer|min:0|max:4';
            $messages["answers.{$question->id}.required"] = "Butir ini wajib diisi.";
        }

        try {
            $this->validate($rules, $messages);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Jika validasi gagal, kirim sinyal ke frontend untuk mematikan loading
            $this->dispatch('validation-failed');
            throw $e; // Lempar kembali errornya agar pesan merah muda tetap muncul di layar
        }

        $totalScore = $screeningService->calculateFatherScore(
            $this->answers, 
            auth()->user()
        );

        // dd([
        // 'Status' => 'Berhasil masuk fungsi save',
        // 'Data User' => auth()->user()->name . ' (' . auth()->user()->superiority_role . ')',
        // 'Semua Jawaban (Array)' => $this->answers,
        // 'Total Skor (Int)' => $totalScore
        // ]);

        $this->dispatch('fatherAnswersCompleted', 
            answers: $this->answers,
            score: $totalScore
        );
    }

    public function back()
    {
        $this->dispatch('goToStep', step: 1);
    }

    public function render()
    {
        return view('livewire.screening.step-father');
    }
}
