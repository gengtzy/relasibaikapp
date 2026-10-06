<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Models\Payment; // Import model Payment
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\View;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;

#[Layout('layouts.guest')]
class Register extends Component
{
    #[Rule(['required', 'string', 'max:255'])]
    public string $name = '';

    #[Rule(['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class])]
    public string $email = '';

    // Rule baru untuk Nomor HP (Wajib unik di tabel payments)
    #[Rule(['required', 'string', 'max:20', 'unique:payments,no_hp'])]
    public string $no_hp = '';

    // Rule baru untuk E-Wallet
    #[Rule(['required', 'string', 'in:DANA,GoPay,OVO,ShopeePay,LinkAja'])]
    public string $jenis_ewallet = '';

    #[Rule(['required', 'string', 'confirmed', 'min:8'])]
    public string $password = '';

    public string $password_confirmation = '';

    public function mount(): void
    {
        View::share('bgImage', 'images/bgauth.svg');
        View::share('centered', true);
    }

    public function register(): void
    {
        $validated = $this->validate();

        $validated['password'] = Hash::make($validated['password']);

        // 1. Buat Data User
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => 'masyarakat',
        ]);

        // 2. Buat Data Payment Otomatis
        Payment::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'no_hp' => $this->no_hp,
            'jenis_ewallet' => $this->jenis_ewallet,
            // tanggal, id_sesi, dan skor dibiarkan kosong (null)
        ]);

        event(new Registered($user));

        Auth::login($user);

        $this->redirect(route('verification.notice'), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}