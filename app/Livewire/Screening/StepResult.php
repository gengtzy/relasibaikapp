<?php

namespace App\Livewire\Screening;

use App\Models\Screening;
use App\Services\ScreeningService;
use Livewire\Component;

class StepResult extends Component
{
    public $resultId;
    public $screeningData;
    
    // Variabel Kategori
    public $catFather;
    public $catMother;
    public $catOther;

    public function mount($resultId)
    {
        // Ambil data screening lengkap
        $this->screeningData = Screening::with(['result', 'recommendation'])
                                        ->findOrFail($resultId);

        $this->catFather = $this->screeningData->result->fpq_category;
        $this->catMother = $this->screeningData->result->mciq_category;
        $this->catOther  = $this->screeningData->result->fmwb_category;
    }

    public function render()
    {
        return view('livewire.screening.step-result');
    }
}
