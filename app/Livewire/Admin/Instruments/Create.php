<?php

namespace App\Livewire\Admin\Instruments;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Instrument;
use Livewire\Attributes\Rule;

#[Layout('layouts.admin')]
class Create extends Component
{
    #[Rule('required', message: 'Kode instrumen wajib diisi.')]
    public $code = '';

    #[Rule('required', message: 'Nama instrumen wajib diisi.')]
    public $name = '';

    #[Rule('nullable|string')] // Boleh kosong
    public $descriptions = '';

    public function save()
    {
        // 1. Validasi data berdasarkan atribut #[Rule] di atas
        $validatedData = $this->validate();

        // 2. Simpan data ke database
        Instrument::create($validatedData);

        // 3. Beri notifikasi (opsional, tapi bagus)
        session()->flash('success', 'Instrumen baru berhasil dibuat.');

        // 4. Redirect kembali ke halaman index
        return $this->redirectRoute('instrumentindex', navigate: true);
    }

    public function cancel()
    {
        // Redirect kembali ke halaman index
        return $this->redirectRoute('instrumentindex', navigate: true);
    }
    
    public function render()
    {
        return view('livewire.admin.instruments.create');
    }
}
