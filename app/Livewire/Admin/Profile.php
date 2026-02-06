<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class Profile extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $avatar; // File upload sementara
    public $existingAvatar; // Data foto dari DB

    public $current_password;
    public $password;
    public $password_confirmation;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->existingAvatar = $user->avatar;
    }

    // 🔥 FUNGSI BARU: Jalan otomatis saat pilih gambar
    public function updatedAvatar()
    {
        $this->validate([
            'avatar' => 'image|max:1024', // Validasi 1MB
        ]);

        try {
            // 1. Proses Gambar jadi Base64
            $imagePath = $this->avatar->getRealPath();
            $imageData = file_get_contents($imagePath);
            $base64 = 'data:' . $this->avatar->getMimeType() . ';base64,' . base64_encode($imageData);

            // 2. Simpan Langsung ke Database
            $user = Auth::user();
            $user->update([
                'avatar' => $base64
            ]);

            // 3. Update Tampilan
            $this->existingAvatar = $base64;
            
            // 4. Reset input file biar bersih
            $this->reset('avatar');

            session()->flash('status', 'Foto profil berhasil diganti!');

        } catch (\Exception $e) {
            session()->flash('error', 'Gagal upload: ' . $e->getMessage());
        }
    }

    public function updateProfile()
    {
        // Fungsi ini sekarang cuma buat ganti Nama & Email
        $user = Auth::user();

        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        session()->flash('status', 'Profil berhasil diperbarui!');
    }

    public function updatePassword()
    {
        // (Biarkan sama seperti sebelumnya)
        try {
            $this->validate([
                'current_password' => ['required', 'current_password'],
                'password' => ['required', 'confirmed', Password::defaults()],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($this->password),
        ]);

        $this->reset(['current_password', 'password', 'password_confirmation']);
        session()->flash('password-status', 'Password berhasil diubah!');
    }

    public function render()
    {
        return view('livewire.admin.profile');
    }
}