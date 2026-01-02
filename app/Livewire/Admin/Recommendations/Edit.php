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

    #[Rule('required', message: 'Rule wajib diisi.')]
    #[Rule('string', message: 'Rule harus berupa teks.')]
    #[Rule('min:3', message: 'Rule minimal 3 karakter.')]
    #[Rule('max:3', message: 'Rule maksimal 3 karakter.')]
    #[Rule('regex:/^[TSR]+$/', message: 'Rule hanya boleh menggunakan huruf T, S, atau R.')]
    public $code = '';
    
    #[Rule('required', message: 'Nama/Judul wajib diisi.')]
    #[Rule('string', message: 'Nama/Judul harus berupa teks.')]
    #[Rule('min:5', message: 'Nama/Judul minimal 5 karakter.')]
    public $title = '';

    #[Rule('required', message: 'Deskripsi wajib diisi.')]
    #[Rule('string', message: 'Deskripsi harus berupa teks.')]
    #[Rule('min:10', message: 'Deskripsi minimal 10 karakter.')]
    public $description = '';

    public $showModal = false;

    public function mount($id)
    {
        $recommendation = Recommendation::findOrFail($id);
    
        $this->recommendationId = $recommendation->id;
        $this->code            = $recommendation->code;
        $this->title            = $recommendation->title;
        $this->description      = $recommendation->description;
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
        $recommendation = Recommendation::findOrFail($this->recommendationId);
        
        $title = \Illuminate\Support\Str::limit($recommendation->title, 30);

        $recommendation->delete();
        
        session()->flash('success', "Rekomendasi '{$title}' berhasil dihapus.");
        
        return $this->redirectRoute('recommendationsindex', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.recommendations.edit');
    }
}
