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

    public $showModal = false; // Kontrol tampil modal
    public $deleteId = null;
    public $deleteCode = ''; // Untuk nama instrumen di modal
    public $isBulkDelete = false;
    public $bulkCount = 0;

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

    public function resetSelection()
    {
        $this->selectAll = false;
        $this->selectedInstruments = [];
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

    public function executeDelete()
    {
        if ($this->isBulkDelete) {
            $this->deleteSelected();
        } else {
            $this->delete();
        }
    }

    public function delete()
    {
        if ($this->deleteId) {
            $instrument = Instrument::find($this->deleteId);
            if ($instrument) {
                $name = $instrument->name;
                $instrument->delete();
                session()->flash('success', "Instrumen '{$name}' berhasil dihapus.");
            }
        }
        
        $this->resetDeleteState();
    }

    public function deleteSelected()
    {
        if (empty($this->selectedInstruments)) return;

        $count = count($this->selectedInstruments);
        Instrument::whereIn('id', $this->selectedInstruments)->delete();
        
        session()->flash('success', "{$count} instrumen berhasil dihapus.");
        $this->resetDeleteState();
    }

    private function resetDeleteState()
    {
        $this->deleteId = null;
        $this->isBulkDelete = false;
        $this->resetSelection();
        $this->dispatch('close-modal'); // Tutup modal via event listener di blade
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
