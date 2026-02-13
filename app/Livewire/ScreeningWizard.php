<?php

namespace App\Livewire;

use App\Services\ScreeningService;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Session;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\Log;


#[Layout('layouts.app')]
class ScreeningWizard extends Component
{
    #[Url(keep: true)]
    public $currentStep = 1;

    #[Session]
    public $biodata = [];
    #[Session]
    public $fatherAnswers = [];
    #[Session]
    public $fatherScore = 0;
    #[Session]
    public $motherAnswers = [];
    #[Session]
    public $motherScore =0;
    #[Session]
    public $otherAnswers = [];
    #[Session]
    public $otherScore = 0;
    #[Session]
    public $finalResultId = null;

    public $isProcessing = false; 
    public $isFinished = false;

    public function mount()
    {

        if (request()->query('reset') == 'true') {
            session()->forget([
                'last_screening_id', 
                'biodata', 
                'fatherAnswers', 'fatherScore',
                'motherAnswers', 'motherScore',
                'otherAnswers', 'otherScore'
            ]);
            $this->reset();
            $this->currentStep = 1;
        }
        elseif (session()->has('last_screening_id')) {
            $this->finalResultId = session('last_screening_id');
            if ($this->currentStep == 5 && $this->finalResultId) {
                $this->isFinished = true;
            }
            elseif ($this->currentStep == 5 && !$this->finalResultId) {
                $this->currentStep = 1;
            }
        }
    }

    #[On('biodataCompleted')]
    public function onBiodataCompleted($biodata)
    {

        $this->biodata = $biodata;

        $this->currentStep = 2;
        $this->dispatch('scroll-to-top');
    }

    #[On('goToStep')]
    public function onGoToStep($step)
    {
        $this->currentStep = $step;
    }

    #[On('fatherAnswersCompleted')]
    public function onFatherAnswersCompleted($answers, $score)
    {
        $this->fatherAnswers = $answers;
        $this->fatherScore = $score;

        $this->currentStep = 3;
        $this->dispatch('scroll-to-top');
    }

    #[On('motherAnswersCompleted')]
    public function onMotherAnswersCompleted($answers, $score)
    {
        $this->motherAnswers = $answers;
        $this->motherScore = $score;

        // dd($this->motherAnswers, $this->motherScore);

        $this->currentStep = 4;
        $this->dispatch('scroll-to-top');
    }

    #[On('otherAnswersCompleted')]
    public function onOtherAnswersCompleted($answers, $score)
    {
        $this->otherAnswers = $answers;
        $this->otherScore = $score;

        $this->submitAllData();
    }

    public function submitAllData()
    {
        $this->isProcessing = true; 

        try {
            $service = app(ScreeningService::class);
            
            // Validasi data session sebelum kirim (Mencegah data kosong)
            if(empty($this->fatherAnswers) || empty($this->motherAnswers)) {
                throw new \Exception("Data jawaban tidak lengkap. Silakan ulangi pengisian.");
            }

            $result = $service->calculateAndSave(
                $this->biodata,
                $this->fatherAnswers,
                $this->motherAnswers,
                $this->otherAnswers
            );

            if ($result) {
                $this->finalResultId = $result->id;
                $this->isProcessing = false; 
                $this->isFinished = true; // TRIGER MODAL SUKSES
            }

        } catch (\Exception $e) {
            $this->isProcessing = false;
            $this->isFinished = false;

            Log::error('Screening Error: ' . $e->getMessage());
            
            session()->flash('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function goToResult()
    {
        $this->isFinished = false;
        $this->currentStep = 5;
        $this->dispatch('scroll-to-top');
    }

    public function render()
    {
        return view('livewire.screening-wizard');
    }
}