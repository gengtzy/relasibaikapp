<?php

namespace App\Livewire\Admin\Recommendations;

use App\Models\Recommendation;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;

#[Layout('layouts.admin')]
class Create extends Component
{
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

    public function save()
    {
        // 1. Validasi data
        $validatedData = $this->validate();

        // 2. Simpan data ke database
        Recommendation::create($validatedData);

        // 3. Beri notifikasi
        session()->flash('success', 'Rekomendasi baru berhasil dibuat.');

        // 4. Redirect kembali ke halaman index
        return $this->redirectRoute('recommendationsindex', navigate: true);
    }

    public function cancel()
    {
        // Redirect kembali ke halaman index
        return $this->redirectRoute('recommendationsindex', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.recommendations.create');
    }
}
