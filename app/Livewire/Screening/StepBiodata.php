<?php

namespace App\Livewire\Screening;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Carbon\Carbon;
use Livewire\Attributes\Session;

class StepBiodata extends Component
{
    // 1. Definisikan properti yang akan di-bind (wire:model)
    
    #[Rule('required|string|min:3', message: 'Lokasi wajib diisi.')]
    #[Session]
    public $lokasi = '';

    #[Session]
    #[Rule('required|date', message: 'Tanggal wajib diisi.')]
    public $tanggal = '';

    // 2. 'mount()' adalah constructor, bagus untuk set nilai default
    public function mount()
    {
        if (empty($this->tanggal)) {
            $this->tanggal = Carbon::today()->format('Y-m-d');
        }
    }

    // 3. Method 'save' yang dipanggil oleh wire:submit="save"
    public function save()
    {
        // 4. Validasi data berdasarkan Rules di atas
        $validated = $this->validate();
        
        $this->dispatch('biodataCompleted', biodata: $validated);

        $this->reset('lokasi', 'tanggal');
    }

    public function render()
    {
        return view('livewire.screening.step-biodata');
    }
}