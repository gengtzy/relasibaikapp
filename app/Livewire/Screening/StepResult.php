<?php

namespace App\Livewire\Screening;

use App\Models\Screening;
use App\Services\ScreeningService;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
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
        $this->screeningData = Screening::with(['result', 'recommendation', 'responses.question.instrument'])
                                        ->findOrFail($resultId);

        $this->catFather = $this->screeningData->result->fpq_category;
        $this->catMother = $this->screeningData->result->mciq_category;
        $this->catOther  = $this->screeningData->result->fmwb_category;
    }

    public function markAsSaved()
    {
        $this->screeningData->update([
            'status' => 'saved'
        ]);

        $this->screeningData->refresh();

        session()->flash('message', 'Hasil berhasil disimpan ke riwayat!');
    }

    public function render()
    {
        return view('livewire.screening.step-result');
    }
}
