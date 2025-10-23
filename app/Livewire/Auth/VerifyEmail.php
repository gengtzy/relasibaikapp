<?php

namespace App\Livewire\Auth;

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.guest')] // Mendefinisikan layout menggunakan Attribute
class VerifyEmail extends Component
{
    // Method mount() untuk mengirim data layout
    public function mount(): void
    {
        View::share('bgImage', 'images/bgauth.svg');
        View::share('centered', true);
    }

    // Fungsi $sendVerification menjadi method public sendVerification()
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            // RedirectIntended tidak tersedia secara langsung, gunakan redirect biasa
            $this->redirect(route('screening.start', absolute: false), navigate: true);
            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    // Fungsi $logout menjadi method public logout()
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }

    // Method render() memberitahu Livewire file view mana yang harus ditampilkan
    public function render()
    {
        return view('livewire.auth.verify-email');
    }
}