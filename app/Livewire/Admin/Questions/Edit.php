<?php

namespace App\Livewire\Admin\Questions;

use App\Models\Instrument;
use App\Models\Question;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Illuminate\Validation\Rule as ValidationRule;

#[Layout('layouts.admin')]
class Edit extends Component
{
    public $questionId;

    public $instruments = [];

    #[Rule('required', message: 'Instrumen wajib dipilih.')]
    #[Rule('exists:instruments,id', message: 'Instrumen tidak valid.')]
    public $id_instrument = '';

    #[Rule('required', message: 'Tipe skoring wajib dipilih.')]
    #[ValidationRule('in:Favorable,Unfavorable', message: 'Tipe skoring tidak valid.')]
    public $scoring_type = '';

    #[Rule('required', message: 'Teks pertanyaan wajib diisi.')]
    #[Rule('min:5', message: 'Pertanyaan minimal 5 karakter.')]
    public $question_text = '';

    public $showModal = false;

    public function mount($id)
    {
        // 1. Cari pertanyaan berdasarkan ID
        $question = Question::findOrFail($id);
        
        // 2. Isi properti form dengan data dari database (Request #2 & #5)
        $this->questionId    = $question->id;
        $this->id_instrument = $question->id_instrument;
        $this->scoring_type  = $question->scoring_type;
        $this->question_text = $question->question_text;

        // 3. Muat daftar instrumen untuk dropdown
        $this->instruments = Instrument::all(['id', 'name', 'code']);
    }

    public function update()
    {
        // 1. Validasi data (Request #6)
        $validatedData = $this->validate();

        // 2. Cari pertanyaan dan update
        $question = Question::findOrFail($this->questionId);
        $question->update($validatedData);

        // 3. Beri notifikasi
        session()->flash('success', 'Pertanyaan berhasil diperbarui.');

        // 4. Redirect kembali ke halaman index
        return $this->redirectRoute('questionsindex', navigate: true);
    }

    public function cancel()
    {
        return $this->redirectRoute('questionsindex', navigate: true);
    }

    public function delete()
    {
        $question = Question::findOrFail($this->questionId);
        
        // Simpan text sebentar untuk pesan sukses (opsional)
        $text = \Illuminate\Support\Str::limit($question->question_text, 30);

        $question->delete();
        
        session()->flash('success', "Pertanyaan '{$text}' berhasil dihapus.");

        return $this->redirectRoute('questionsindex', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.questions.edit');
    }
}
