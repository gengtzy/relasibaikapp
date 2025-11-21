<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Profile extends Component
{
    public $name;
    public $email;
    public $superiority_role; 

    public $current_password;
    public $password;
    public $password_confirmation;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->superiority_role = $user->superiority_role;
    }

    public function updateProfile()
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        // UPDATE: Hanya Nama dan Email yang diupdate
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            // Role tidak diupdate disini demi keamanan
        ]);

        $this->dispatch('profile-updated'); 
        session()->flash('status', 'Informasi akun berhasil diperbarui.');
    }

    public function updatePassword()
    {
        try {
            $validated = $this->validate([
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

        session()->flash('password-status', 'Password berhasil diamankan.');
    }

    public function render()
    {
        return view('livewire.profile');
    }
}