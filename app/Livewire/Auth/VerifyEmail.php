<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

#[Layout('layouts.guest')]
class VerifyEmail extends Component
{
    public function mount()
    {
        View::share('bgImage', 'images/bgauth.svg');
        View::share('centered', true);
        // Jika user sudah verified, lempar langsung
        if (Auth::user()?->hasVerifiedEmail()) {
            $this->redirect(route('screening.wizard', absolute: false) . '?verified=1', navigate: true);
        }
    }

    // Fungsi kirim ulang email
    public function sendVerification()
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirect(route('screening.wizard', absolute: false), navigate: true);
            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    // Fungsi Logout
    public function logout()
    {
        Auth::guard('web')->logout();
        Session::invalidate();
        Session::regenerateToken();
        $this->redirect('/', navigate: true);
    }

    // --- FUNGSI BARU: PENGGANTI CONTROLLER ---
    // Method statis/biasa untuk menangani route verify/{id}/{hash}
    public function verify(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('screening.wizard', absolute: false).'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(route('screening.wizard', absolute: false).'?verified=1');
    }

    public function render()
    {
        return view('livewire.auth.verify-email');
    }
}