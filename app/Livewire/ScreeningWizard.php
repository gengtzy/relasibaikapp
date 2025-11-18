<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Session;
use Livewire\Attributes\Url;

#[Layout('layouts.app')]
class ScreeningWizard extends Component
{
    #[Url]
    public $currentStep = 1;

    #[Session]
    public $biodata = [];
    #[Session]
    public $fatherAnswers = [];
    #[Session]
    public $fatherScore = 0;
    public $motherAnswers = [];
    public $otherAnswers = [];
    
    public $finalResultId = null;

    #[On('biodataCompleted')]
    public function onBiodataCompleted($biodata)
    {

        $this->biodata = $biodata;

        // 5. Pindahkan ke langkah berikutnya
        $this->currentStep = 2;
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
    }

    public function render()
    {
        return view('livewire.screening-wizard');
    }
}