<?php

namespace App\Livewire\Admin\Instruments;

use App\Models\Instrument;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $selectAll = false;
    public $selectedInstruments = [];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            // Jika "Select All" dicentang, ambil semua ID
            $this->selectedInstruments = Instrument::pluck('id')->map(fn ($id) => (string) $id);
        } else {
            // Jika tidak, kosongkan
            $this->selectedInstruments = [];
        }
    }

    // Fungsi untuk tombol "Instrumen Baru" (Request #2)
    public function createNewInstrument()
    {
        // Arahkan ke route. Ganti '/admin/instrument/new' jika path Anda berbeda
        // navigate: true membuatnya terasa seperti SPA
        return $this->redirect('instrumentnew', navigate: true);
    }

    // Fungsi untuk tombol "Edit" (Request #6 & #7)
    public function editInstrument($id)
    {
        // Arahkan ke halaman edit. Ganti path-nya sesuai kebutuhan
        return $this->redirect("instrument/{$id}/edit", navigate: true);
    }

    // Fungsi untuk tombol "Hapus"
    public function deleteInstrument($id)
    {
        Instrument::find($id)->delete();
        session()->flash('success', 'Instrumen berhasil dihapus.');
        $this->reset('selectAll', 'selectedInstruments'); // Reset pilihan
    }

    // Fungsi untuk "Hapus Pilihan" (Request #5)
    public function deleteSelected()
    {
        Instrument::whereIn('id', $this->selectedInstruments)->delete();
        session()->flash('success', 'Instrumen yang dipilih berhasil dihapus.');
        $this->reset('selectAll', 'selectedInstruments'); // Reset pilihan
    }

    public function render()
    {
        $instruments = Instrument::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('code', 'like', '%' . $this->search . '%')
            ->paginate($this->perPage);

        return view('livewire.admin.instruments.index', [
            'instruments' => $instruments,
        ]);
    }
}
