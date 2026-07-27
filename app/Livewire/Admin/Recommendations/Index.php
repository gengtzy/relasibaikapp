<?php

namespace App\Livewire\Admin\Recommendations;

use App\Models\Recommendation; 
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    public $showModal = false;
    public $deleteId = null;
    public $deleteCode = ''; // Untuk menyimpan Judul Rekomendasi
    public $isBulkDelete = false;
    public $bulkCount = 0;

    public $selectAll = false;
    public $selectedRecommendations = []; 

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedRecommendations = Recommendation::pluck('id')->map(fn ($id) => (string) $id);
        } else {
            $this->selectedRecommendations = [];
        }
    }

    public function resetSelection()
    {
        $this->selectAll = false;
        $this->selectedRecommendations = [];
    }

    public function createNewRecommendation()
    {
        return $this->redirect('recommendationsnew', navigate: true);
    }

    public function editRecommendation($id)
    {
        return $this->redirect("/admin/recommendations/{$id}/edit", navigate: true);
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
            $recommendation = Recommendation::find($this->deleteId);
            if ($recommendation) {
                $title = \Illuminate\Support\Str::limit($recommendation->title, 30);
                $recommendation->delete();
                session()->flash('success', "Rekomendasi '{$title}' berhasil dihapus.");
            }
        }
        $this->resetDeleteState();
    }

    public function deleteSelected()
    {
        if (empty($this->selectedRecommendations)) return;

        $count = count($this->selectedRecommendations);
        Recommendation::whereIn('id', $this->selectedRecommendations)->delete();
        
        session()->flash('success', "{$count} rekomendasi berhasil dihapus.");
        $this->resetDeleteState();
    }

    private function resetDeleteState()
    {
        $this->deleteId = null;
        $this->isBulkDelete = false;
        $this->resetSelection();
        $this->dispatch('close-modal');
    }

    public function render()
    {
        $recommendations = Recommendation::query()
            ->where('title', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->paginate($this->perPage);

        return view('livewire.admin.recommendations.index', [
            'recommendations' => $recommendations,
        ]);
    }
}