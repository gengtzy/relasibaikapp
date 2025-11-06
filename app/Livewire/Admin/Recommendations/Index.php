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

    public function createNewRecommendation()
    {
        return $this->redirect('recommendationsnew', navigate: true);
    }

    public function editRecommendation($id)
    {
        return $this->redirect("/admin/recommendations/{$id}/edit", navigate: true);
    }

    public function deleteRecommendation($id)
    {
        Recommendation::find($id)->delete();
        session()->flash('success', 'Rekomendasi berhasil dihapus.');
        $this->reset('selectAll', 'selectedRecommendations');
    }

    public function deleteSelected()
    {
        Recommendation::whereIn('id', $this->selectedRecommendations)->delete();
        session()->flash('success', 'Rekomendasi yang dipilih berhasil dihapus.');
        $this->reset('selectAll', 'selectedRecommendations');
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