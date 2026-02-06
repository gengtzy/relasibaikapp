<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class Profile extends Component
{

    public $name;
    public $email;
    public $avatar;
    public $existingAvatar;

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

    // Fungsi ini jalan otomatis saat JS mengirim data Base64
    public function updatedAvatar($value)
    {
        // $value adalah string panjang "data:image/png;base64,....."
        if (!$value) return;

        try {
            // Update Database Langsung
            $user = Auth::user();
            $user->update([
                'avatar' => $value // Simpan string base64 ke kolom LONGTEXT
            ]);

            // Update Tampilan agar user langsung lihat perubahannya
            $this->existingAvatar = $value;
            
            // Beri notifikasi
            session()->flash('status', 'Foto berhasil diperbarui!');

        } catch (\Exception $e) {
            session()->flash('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    public function updateProfile()
    {
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