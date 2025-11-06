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
    public $fatherAnswers = [];
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

    // ... (Nanti kita akan tambahkan listener lain di sini)
    // #[On('fatherAnswersCompleted')]
    // ...

    public function render()
    {
        // Render view-nya seperti biasa
        // (View ini akan berisi @if($currentStep == 1) ... dst)
        return view('livewire.screening-wizard');
    }
}