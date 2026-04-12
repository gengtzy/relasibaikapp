<?php

namespace App\Livewire\Screening;

use App\Models\Screening;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class StepResult extends Component
{
    public $resultId;
    
    // Variabel Kategori
    public $catFather;
    public $catMother;
    public $catOther;

    public function mount($resultId)
    {
        $this->resultId = $resultId;

        // Ambil data secukupnya saja saat mount untuk mengisi text kategori
        $data = Screening::with('result')->findOrFail($resultId);

        $this->catFather = $data->result->fpq_category;
        $this->catMother = $data->result->mciq_category;
        $this->catOther  = $data->result->fmwb_category;
    }

    public function markAsSaved()
    {
        // Panggil datanya cukup berdasarkan ID, lalu update statusnya
        $screening = Screening::findOrFail($this->resultId);
        $screening->update([
            'status' => 'saved'
        ]);

        session()->flash('message', 'Hasil berhasil disimpan ke riwayat!');
    }

    public function render()
    {
        // PENTING: Perhatikan perubahan 'result.recommendation' di bawah ini
        $screeningData = Screening::with(['result.recommendation', 'responses.question.instrument'])
                                  ->findOrFail($this->resultId);

        return view('livewire.screening.step-result', [
            'screeningData' => $screeningData
        ]);
    }
}