<?php

namespace App\Livewire\Admin\Questions;

use App\Models\Instrument;
use App\Models\Question;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Illuminate\Validation\Rule as ValidationRule;

#[Layout('layouts.admin')]
class Create extends Component
{
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

    public function mount()
    {
        $this->instruments = Instrument::all(['id', 'name', 'code']);
    }

    public function save()
    {
        // 1. Validasi data
        $validatedData = $this->validate();

        // 2. Simpan data ke database
        Question::create($validatedData);

        // 3. Beri notifikasi
        session()->flash('success', 'Pertanyaan baru berhasil dibuat.');

        // 4. Redirect kembali ke halaman index
        return $this->redirectRoute('questionsindex', navigate: true);
    }

    public function cancel()
    {
        return $this->redirectRoute('questionsindex', navigate: true);
    }
    public function render()
    {
        return view('livewire.admin.questions.create');
    }
}
