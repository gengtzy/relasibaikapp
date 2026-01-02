<?php

namespace App\Livewire\Admin\ScreeningResult;

use App\Models\Screening;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class View extends Component
{
    public $screening;
    public $showModal = false;

    public function mount($id)
    {
        // Eager Load user, result, recommendation, DAN responses+question
        $this->screening = Screening::with([
            'user', 
            'result', 
            'recommendation',
            'responses.question.instrument'
        ])->findOrFail($id);
    }

    public function delete()
    {
        if ($this->screening) {
            $formattedId = 'SCR-' . $this->screening->created_at->format('Ymd') . '-' . str_pad($this->screening->id, 5, '0', STR_PAD_LEFT);
            
            $this->screening->delete();
            
            session()->flash('success', "Data screening {$formattedId} berhasil dihapus.");
            return redirect()->route('screeningresult');
        }
    }

    public function render()
    {
        return view('livewire.admin.screening-result.view');
    }
}