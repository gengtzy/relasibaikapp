<?php

namespace App\Livewire\Admin\Instruments;

use App\Models\Instrument;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Validation\Rule;

#[Layout('layouts.admin')]
class Edit extends Component
{
    public $instrumentId;

    public $code = '';
    public $name = '';
    public $descriptions = '';


    public function mount($id)
    {
        // 1. Cari instrumen berdasarkan ID
        $instrument = Instrument::findOrFail($id);
        
        // 2. Isi properti form dengan data dari database (Request #4)
        $this->instrumentId = $instrument->id;
        $this->code         = $instrument->code;
        $this->name         = $instrument->name;
        $this->descriptions = $instrument->descriptions;
    }

    public function rules()
    {
        return [
            'code' => 'required',
            'name' => 'required',
            'descriptions' => 'nullable|string',
        ];
    }

    protected $messages = [
        'code.required' => 'Kode instrumen wajib diisi.',
        'name.required' => 'Nama instrumen wajib diisi.',
    ];

    public function update()
    {
        // 1. Validasi data
        $validatedData = $this->validate();

        // 2. Cari instrumen dan update
        $instrument = Instrument::findOrFail($this->instrumentId);
        $instrument->update($validatedData);

        // 3. Beri notifikasi
        session()->flash('success', 'Instrumen berhasil diperbarui.');

        // 4. Redirect kembali ke halaman index
        return $this->redirectRoute('instrumentindex', navigate: true);
    }

    public function cancel()
    {
        return $this->redirectRoute('instrumentindex', navigate: true);
    }

    public function delete()
    {
        // 1. Cari dan hapus instrumen
        Instrument::findOrFail($this->instrumentId)->delete();
        
        // 2. Beri notifikasi
        session()->flash('success', 'Instrumen berhasil dihapus.');

        // 3. Redirect kembali ke halaman index
        return $this->redirectRoute('instrumentindex', navigate: true);
    }


    public function render()
    {
        return view('livewire.admin.instruments.edit');
    }
}
