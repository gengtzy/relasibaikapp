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
            // PENTING: Max 1MB (1024) agar database Clever Cloud tidak cepat penuh & tidak timeout
            'avatar' => ['nullable', 'image', 'max:1024'], 
        ]);

        if ($this->avatar) {
            $imagePath = $this->avatar->getRealPath();
            
            $imageData = file_get_contents($imagePath);
            
            $base64 = 'data:' . $this->avatar->getMimeType() . ';base64,' . base64_encode($imageData);
            
            $user->avatar = $base64;
        }

        $user->name = $this->name;
        $user->email = $this->email;
        $user->save();

        // Reset input file
        $this->avatar = null;
        $this->existingAvatar = $user->avatar;

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