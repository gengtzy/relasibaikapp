<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Validation\Rule;

#[Layout('layouts.admin')]
class Edit extends Component
{
    public $userId;

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

    public $showModal = false;

    // #[Rule('required_if:role,masyarakat', message: 'Peran superior wajib dipilih untuk masyarakat.')]
    #[Rule('nullable')] 
    public $superiority_role = '';

    public $password_confirmation = '';

    public function mount($id)
    {
        $user = User::findOrFail($id);
        
        $this->userId           = $user->id;
        $this->name             = $user->name;
        $this->email            = $user->email;
        $this->role             = $user->role;
        $this->superiority_role = $user->superiority_role;
    }

    public function rules()
    {
        return [
            // Request #6: Validasi
            'name'  => 'required|string|min:3',
            'email' => [
                'required',
                'email',
                // Pastikan 'email' unik, KECUALI untuk ID user ini sendiri
                Rule::unique('users')->ignore($this->userId),
            ],
            'role' => 'required|in:admin,masyarakat',
            'superiority_role' => 'nullable',
            
            // Password bersifat opsional, tapi jika diisi, harus min 8 & terkonfirmasi
            'password' => 'nullable|min:8|confirmed',
        ];
    }

    public function update()
    {
        // 1. Validasi data
        $validatedData = $this->validate();

        // 2. Cari user
        $user = User::findOrFail($this->userId);

        // 3. (Request #4) Pastikan superiority_role adalah null jika peran adalah admin
        if ($validatedData['role'] == 'admin') {
            $validatedData['superiority_role'] = null;
        }

        // 4. (Request #5) Handle password: HANYA update jika diisi
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            // Jika kosong, hapus dari array agar tidak menimpa password lama
            unset($validatedData['password']);
        }

        // 5. Update user
        $user->update($validatedData);

        // 6. Beri notifikasi
        session()->flash('success', 'Pengguna berhasil diperbarui.');

        // 7. Redirect kembali ke halaman index
        return $this->redirectRoute('adminusers', navigate: true);
    }

    public function cancel()
    {
        return $this->redirectRoute('adminusers', navigate: true);
    }

    public function delete()
    {
        if (auth()->id() == $this->userId) {
            session()->flash('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
            return;
        }
        
        $user = User::findOrFail($this->userId);
        $name = $user->name; // Simpan nama untuk pesan sukses

        $user->delete();
        
        session()->flash('success', "Pengguna '{$name}' berhasil dihapus.");
        
        return $this->redirectRoute('adminusers', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.users.edit');
    }
}
