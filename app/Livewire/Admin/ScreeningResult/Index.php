<?php

namespace App\Livewire\Admin\ScreeningResult;

use App\Models\Screening;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    public $filterType = '';
    public $deleteId = null;
    public ?Screening $deletingScreening = null;
    
    // Bulk Action
    public $selectAll = false;
    public $selectedIds = [];

    public function mount()
    {
        $this->filterType = request()->query('filter');
    }

    public function updatedSearch()
    {
        $this->resetPage();
        $this->resetSelection();
    }

    // Logic Checkbox "Pilih Semua"
    public function updatedSelectAll($value)
    {
        if ($value) {
            // Ambil semua ID dari halaman/query saat ini
            $this->selectedIds = $this->getScreeningQuery()
                ->pluck('id')
                ->map(fn ($id) => (string) $id)
                ->toArray();
        } else {
            $this->selectedIds = [];
        }
    }

    public function resetSelection()
    {
        $this->selectAll = false;
        $this->selectedIds = [];
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->deletingScreening = Screening::find($id);
    }

    public function cancelDelete()
    {
        $this->deleteId = null;
        $this->deletingScreening = null;
    }

    public function delete()
    {
        if ($this->deletingScreening) {
            $formattedId = 'SCR-' . $this->deletingScreening->created_at->format('Ymd') . '-' . str_pad($this->deletingScreening->id, 5, '0', STR_PAD_LEFT);

            $this->deletingScreening->delete();

            session()->flash('success', "Data skrining {$formattedId} berhasil dihapus.");
        }
        
        $this->deleteId = null;
        $this->deletingScreening = null;
        $this->resetSelection();
    }

    // Hapus Banyak Data
    public function deleteSelected()
    {
        if (empty($this->selectedIds)) return;

        Screening::whereIn('id', $this->selectedIds)->delete();
        
        session()->flash('success', count($this->selectedIds) . ' data screening berhasil dihapus.');
        $this->resetSelection();
    }

    public function viewResult($id)
    {
        return $this->redirect(route('screeningresultshow', $id), navigate: true);
    }

    protected function getScreeningQuery()
    {
        $query = Screening::with(['user', 'result', 'recommendation'])
            ->where('status', 'saved');

        if ($this->filterType === 'risk') {
            // Filter: Cari yang kode rekomendasinya mengandung huruf 'R'
            $query->whereHas('recommendation', function($q) {
                $q->where('code', 'like', '%R%'); 
            });
        }

        return $query->where(function($q) {
                $q->whereHas('user', function($u) {
                    $u->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhere('id', 'like', '%' . $this->search . '%')
                ->orWhereDate('created_at', 'like', '%' . $this->search . '%');
            })
            ->latest();
    }

    public function render()
    {
        $screenings = $this->getScreeningQuery()->paginate($this->perPage);

        return view('livewire.admin.screening-result.index', [
            'screenings' => $screenings
        ]);
    }
}