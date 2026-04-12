<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;

#[Layout('layouts.guest')]
class Login extends Component
{
    #[Rule('required|email')]
    public string $email = '';

    #[Rule('required')]
    public string $password = '';

    public bool $remember = false;

    public function mount(): void
    {
        View::share('bgImage', 'images/bgauth.svg');
        View::share('centered', true);
    }

    public function login(): void
    {
        $this->resetErrorBag();

        $this->validate();

        $this->ensureIsNotRateLimited();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::clear($this->throttleKey());
            Session::regenerate();

            $user = Auth::user();

            if ($user->role === 'admin') {
                $this->redirect(route('admin.dashboard'), navigate: true);
            } else {
                $this->redirect(route('screening.wizard'), navigate: true);
            }
            return;
        }

        RateLimiter::hit($this->throttleKey(), 120);

        if (RateLimiter::tooManyAttempts($this->throttleKey(), 3)) {
            $this->ensureIsNotRateLimited();
        }

        $this->addError('email', 'Email atau password yang Anda masukkan salah.');
    }

    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 3)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey());

        $this->dispatch('lockout-started', seconds: $seconds);

        throw ValidationException::withMessages([
            'rate_limit' => 'locked',
        ]);
    }

    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}