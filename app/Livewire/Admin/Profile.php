<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Livewire\WithFileUploads; // Wajib untuk upload
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class Profile extends Component
{
    use WithFileUploads;

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

    public function updateProfile()
    {
        $user = Auth::user();

        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'avatar' => ['nullable', 'image', 'max:2048'], // Max 2MB
        ]);

        // Logic Upload Foto
        if ($this->avatar) {
            // Hapus foto lama jika ada (dan bukan foto default/placeholder eksternal)
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Simpan foto baru
            $path = $this->avatar->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->name = $this->name;
        $user->email = $this->email;
        $user->save();

        // Reset input file
        $this->avatar = null;
        $this->existingAvatar = $user->avatar;

        // Trigger event browser untuk notifikasi (opsional) atau flash message
        session()->flash('status', 'Profil berhasil diperbarui!');
        
        // Refresh halaman agar foto di Navbar ikut berubah
        return redirect()->route('profileadmin');
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
