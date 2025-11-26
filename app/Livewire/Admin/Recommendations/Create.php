<?php

namespace App\Livewire\Admin\Recommendations;

use App\Models\Recommendation;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;

#[Layout('layouts.admin')]
class Create extends Component
{

    #[Rule('required', message: 'Rule wajib diisi.')]
    #[Rule('string', message: 'Rule harus berupa teks.')]
    #[Rule('min:3', message: 'Rule minimal 3 karakter.')]
    #[Rule('max:3', message: 'Rule maksimal 3 karakter.')]
    #[Rule('regex:/^[TSR]+$/', message: 'Rule hanya boleh menggunakan huruf T, S, atau R.')]
    #[Rule('unique:recommendations,code,', message: 'Code ini sudah terdaftar, gunakan kombinasi lain.')]
    public $code = '';

    #[Rule('required', message: 'Nama/Judul wajib diisi.')]
    #[Rule('string', message: 'Nama/Judul harus berupa teks.')]
    #[Rule('min:5', message: 'Nama/Judul minimal 5 karakter.')]
    public $title = '';

    #[Rule('required', message: 'Deskripsi wajib diisi.')]
    #[Rule('string', message: 'Deskripsi harus berupa teks.')]
    #[Rule('min:10', message: 'Deskripsi minimal 10 karakter.')]
    public $description = '';

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
