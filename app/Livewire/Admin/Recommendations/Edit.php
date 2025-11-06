<?php

namespace App\Livewire\Admin\Recommendations;

use App\Models\Recommendation;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;

#[Layout('layouts.admin')]
class Edit extends Component
{
    public $recommendationId;

    #[Rule('required', message: 'Nama/Judul wajib diisi.')]
    #[Rule('string', message: 'Nama/Judul harus berupa teks.')]
    #[Rule('min:5', message: 'Nama/Judul minimal 5 karakter.')]
    public $title = '';

    #[Rule('required', message: 'Deskripsi wajib diisi.')]
    #[Rule('string', message: 'Deskripsi harus berupa teks.')]
    #[Rule('min:10', message: 'Deskripsi minimal 10 karakter.')]
    public $description = '';

    #[Rule('nullable|integer', message: 'Skor minimal harus berupa angka.')]
    public $min_score = '';

    #[Rule('nullable|integer|gt:min_score', message: 'Skor maksimal harus lebih besar dari skor minimal.')]
    public $max_score = '';

    public function mount($id)
    {
        $recommendation = Recommendation::findOrFail($id);
    
        $this->recommendationId = $recommendation->id;
        $this->title            = $recommendation->title;
        $this->description      = $recommendation->description;
        $this->min_score        = $recommendation->min_score;
        $this->max_score        = $recommendation->max_score;
    }

    public function update()
    {
        // 1. Validasi data (Request #6)
        $validatedData = $this->validate();

        // 2. Cari rekomendasi dan update
        $recommendation = Recommendation::findOrFail($this->recommendationId);
        $recommendation->update($validatedData);

        // 3. Beri notifikasi
        session()->flash('success', 'Rekomendasi berhasil diperbarui.');

        // 4. Redirect kembali ke halaman index
        return $this->redirectRoute('recommendationsindex', navigate: true);
    }

    public function cancel()
    {
        return $this->redirectRoute('recommendationsindex', navigate: true);
    }

    public function delete()
    {
        Recommendation::findOrFail($this->recommendationId)->delete();
        
        session()->flash('success', 'Rekomendasi berhasil dihapus.');
        
        return $this->redirectRoute('recommendationsindex', navigate: true);
    }
    public function render()
    {
        return view('livewire.admin.recommendations.edit');
    }
}
