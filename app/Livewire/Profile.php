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

        // Masukkan data baru ke dalam object model, TAPI JANGAN DISIMPAN DULU
        $user->name = $this->name;
        $user->email = $this->email;

        // CEK LOGIKA RE-VERIFIKASI EMAIL
        // isDirty('email') adalah bawaan Laravel untuk mengecek apakah data email diubah oleh user
        if ($user->isDirty('email')) {
            // 1. Cabut status verifikasinya (kembalikan jadi NULL)
            $user->email_verified_at = null;
            
            // 2. Simpan perubahannya ke database
            $user->save();

            // 3. Kirim ulang link verifikasi ke alamat email yang baru
            $user->sendEmailVerificationNotification();

            // 4. Kasih notifikasi ke user bahwa dia harus cek email baru
            session()->flash('status', 'Profil berhasil diperbarui. Silakan periksa kotak masuk email baru Anda untuk verifikasi ulang.');
            
            // 5. Tendang (redirect) agar sistem menangkap bahwa user ini belum terverifikasi
            $this->redirectRoute('verification.notice', navigate: true);
            return;
        }

        // JIKA EMAIL TIDAK BERUBAH (cuma ganti nama aja)
        $user->save();

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