<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Carbon\Carbon;

#[Layout('layouts.admin')]
class Create extends Component
{
    #[Rule('required', message: 'Nama wajib diisi.')]
    #[Rule('string', message: 'Nama harus berupa teks.')]
    #[Rule('min:3', message: 'Nama minimal 3 karakter.')]
    public $name = '';

    #[Rule('required', message: 'Email wajib diisi.')]
    #[Rule('email', message: 'Format email tidak valid.')]
    #[Rule('unique:users,email', message: 'Email ini sudah terdaftar.')]
    public $email = '';

    #[Rule('required', message: 'Password wajib diisi.')]
    #[Rule('min:8', message: 'Password minimal 8 karakter.')]
    public $password = '';

    #[Rule('required', message: 'Peran wajib dipilih.')]
    #[Rule('in:admin,masyarakat', message: 'Peran tidak valid.')]
    public $role = '';

    // #[Rule('required_if:role,masyarakat', message: 'Peran superior wajib dipilih untuk masyarakat.')]
    #[Rule('nullable')] 
    public $superiority_role = '';

    public function save()
    {
        // 1. Validasi data
        $validatedData = $this->validate();

        // 2. Hash password sebelum disimpan
        $validatedData['password'] = Hash::make($validatedData['password']);

        // 3. TAMBAHKAN INI: Set verifikasi email otomatis
        $validatedData['email_verified_at'] = Carbon::now();

        // 4. Pastikan superiority_role adalah null jika peran adalah admin
        if ($validatedData['role'] == 'admin') {
            $validatedData['superiority_role'] = null;
        }

        // 5. Simpan data ke database
        User::create($validatedData);

        // 6. Beri notifikasi
        session()->flash('success', 'Pengguna baru berhasil dibuat.');

        // 7. Redirect kembali ke halaman index
        return $this->redirectRoute('adminusers', navigate: true);
    }

    public function cancel()
    {
        // Redirect kembali ke halaman index
        return $this->redirectRoute('adminusers', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.users.create');
    }
}
