<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;

// Menggunakan Attribute #[Layout] untuk mendefinisikan layout
#[Layout('layouts.guest')]
class Login extends Component
{
    // 'state' sekarang menjadi public property
    // Attribute #[Rule] menggantikan fungsi rules()
    #[Rule('required|email')]
    public string $email = '';

    #[Rule('required')]
    public string $password = '';

    public bool $remember = false;

    // Fungsi mount() tetap sama, tapi sekarang menjadi method di dalam class
    public function mount(): void
    {
        View::share('bgImage', 'images/bgauth.svg');
        View::share('centered', true);
    }

    // Fungsi $login sekarang menjadi method public login()
    public function login(): void
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            Session::regenerate();

            $user = Auth::user();

            if ($user->role === 'admin') {
                $this->redirect(route('admin.dashboard'), navigate: true); // Anda menamainya admin.home.index, pastikan nama rute ini benar
            } else {
                $this->redirect(route('screening.wizard'), navigate: true);
            }

            return;
        }

        $this->addError('email', 'Email atau password yang Anda masukkan salah.');
    }

    // Method render() memberitahu Livewire file view mana yang harus ditampilkan
    public function render()
    {
        return view('livewire.auth.login');
    }
}