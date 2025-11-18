<?php

namespace App\Livewire\Screening;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Carbon\Carbon;
use Livewire\Attributes\Session;

class StepBiodata extends Component
{

    #[Rule('required|string|min:3', message: 'Lokasi wajib diisi.')]
    #[Session]
    public $lokasi = '';

    #[Session]
    #[Rule('required|date', message: 'Tanggal wajib diisi.')]
    public $tanggal = '';

    public function mount($defaultData = []) 
    {
        if (!empty($defaultData)) {
            // Gunakan null coalescing operator (??) untuk menjaga data session jika defaultData kosong
            $this->lokasi = $defaultData['lokasi_name'] ?? $this->lokasi; 
            $this->tanggal = $defaultData['tanggal'] ?? $this->tanggal;
        }

        if (empty($this->tanggal)) {
            $this->tanggal = Carbon::today()->format('Y-m-d');
        }
    }

    public function save()
    {
        $validated = $this->validate();
        
        // Kirim ke Parent
        $this->dispatch('biodataCompleted', biodata: [
            'lokasi_name' => $this->lokasi,
            'tanggal' => $this->tanggal
        ]);
    }

    public function render()
    {
        return view('livewire.screening.step-biodata');
    }
}