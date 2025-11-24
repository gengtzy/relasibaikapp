<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\View;

#[Layout('layouts.guest')]
class ForgotPassword extends Component
{
    public $email = '';
    public $status = null;

    public function mount(): void
    {
        View::share('bgImage', 'images/bgauth.svg');
        View::share('centered', true);
    }

    public function sendPasswordResetLink()
    {
        $this->validate([
            'email' => ['required', 'email'],
        ]);

        $response = Password::sendResetLink(['email' => $this->email]);

        if ($response == Password::RESET_LINK_SENT) {
            $this->status = trans($response);
            $this->reset('email');
        } else {
            $this->addError('email', trans($response));
        }
    }

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}