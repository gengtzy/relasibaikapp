<?php

namespace App\Livewire\Admin\ScreeningResult;

use App\Models\Screening;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class View extends Component
{
    public $screening;

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
        $this->screening->delete();
        session()->flash('success', 'Data screening berhasil dihapus.');
        return redirect()->route('admin.screening-result.index');
    }

    public function render()
    {
        return view('livewire.admin.screening-result.view');
    }
}