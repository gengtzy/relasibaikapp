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

    public $showModal = false;
    public $deleteId = null;
    public $deleteCode = ''; // Untuk menyimpan cuplikan teks pertanyaan
    public $isBulkDelete = false;
    public $bulkCount = 0;

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

    public function resetSelection()
    {
        $this->selectAll = false;
        $this->selectedQuestions = [];
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
            $question = Question::find($this->deleteId);
            if ($question) {
                // Potong teks pertanyaan agar pesan sukses tidak kepanjangan
                $text = \Illuminate\Support\Str::limit($question->question_text, 30);
                $question->delete();
                session()->flash('success', "Pertanyaan '{$text}' berhasil dihapus.");
            }
        }
        $this->resetDeleteState();
    }

    public function deleteSelected()
    {
        if (empty($this->selectedQuestions)) return;

        $count = count($this->selectedQuestions);
        Question::whereIn('id', $this->selectedQuestions)->delete();
        
        session()->flash('success', "{$count} pertanyaan berhasil dihapus.");
        $this->resetDeleteState();
    }

    private function resetDeleteState()
    {
        $this->deleteId = null;
        $this->isBulkDelete = false;
        $this->resetSelection();
        $this->dispatch('close-modal'); // Tutup modal via event listener
    }

    public function render()
    {
        $questions = Question::with('instrument') // Eager load relasi 'instrument'
            ->where(function ($query) {
                // Cari di kolom 'question_text' atau 'scoring_type'
                $query->where('question_text', 'ilike', '%' . $this->search . '%')
                      ->orWhere('scoring_type', 'ilike', '%' . $this->search . '%')
                      // ATAU cari di relasi instrument (berdasarkan code atau name)
                      ->orWhereHas('instrument', function ($subQuery) {
                          $subQuery->where('code', 'ilike', '%' . $this->search . '%')
                                   ->orWhere('name', 'ilike', '%' . $this->search . '%');
                      });
            })
            ->paginate($this->perPage);

        return view('livewire.admin.questions.index', [
            'questions' => $questions,
        ]);
    }
}
