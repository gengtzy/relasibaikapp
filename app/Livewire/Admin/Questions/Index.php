<?php

namespace App\Livewire\Admin\Questions;

use App\Models\Question;
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
    public $selectedQuestions = [];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedQuestions = Question::pluck('id')->map(fn ($id) => (string) $id);
        } else {
            $this->selectedQuestions = [];
        }
    }

    public function createNewQuestion()
    {
        // Ganti '/admin/questions/new' jika path Anda berbeda
        return $this->redirect('questionsnew', navigate: true);
    }

    public function editQuestion($id)
    {
        // Ganti path-nya sesuai kebutuhan
        return $this->redirect("/admin/questions/{$id}/edit", navigate: true);
    }

    public function deleteQuestion($id)
    {
        Question::find($id)->delete();
        session()->flash('success', 'Pertanyaan berhasil dihapus.');
        $this->reset('selectAll', 'selectedQuestions');
    }

    public function deleteSelected()
    {
        Question::whereIn('id', $this->selectedQuestions)->delete();
        session()->flash('success', 'Pertanyaan yang dipilih berhasil dihapus.');
        $this->reset('selectAll', 'selectedQuestions');
    }

    public function render()
    {
        $questions = Question::with('instrument') // Eager load relasi 'instrument'
            ->where(function ($query) {
                // Cari di kolom 'question_text' atau 'scoring_type'
                $query->where('question_text', 'like', '%' . $this->search . '%')
                      ->orWhere('scoring_type', 'like', '%' . $this->search . '%')
                      // ATAU cari di relasi instrument (berdasarkan code atau name)
                      ->orWhereHas('instrument', function ($subQuery) {
                          $subQuery->where('code', 'like', '%' . $this->search . '%')
                                   ->orWhere('name', 'like', '%' . $this->search . '%');
                      });
            })
            ->paginate($this->perPage);

        return view('livewire.admin.questions.index', [
            'questions' => $questions,
        ]);
    }
}
