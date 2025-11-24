<?php

namespace App\Livewire\Auth;

use App\Models\User;
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
    // 'state' sekarang menjadi public property
    // 'rules' sekarang menjadi Attribute #[Rule] di atas setiap property
    #[Rule(['required', 'string', 'max:255'])]
    public string $name = '';

    #[Rule(['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class])]
    public string $email = '';

    #[Rule(['required', 'string', 'confirmed', 'min:8'])]
    public string $password = '';

    public string $password_confirmation = '';

    // Fungsi mount() menjadi method
    public function mount(): void
    {
        View::share('bgImage', 'images/bgauth.svg');
        View::share('centered', true);
    }

    // Fungsi $register menjadi method public register()
    public function register(): void
    {
        $validated = $this->validate();

        $validated['password'] = Hash::make($validated['password']);

        // Menambahkan 'role' secara eksplisit saat membuat user
        $user = User::create(array_merge($validated, [
            'role' => 'user',
        ]));

        event(new Registered($user));

        Auth::login($user);

        $this->redirect(route('verification.notice'), navigate: true);
    }

    // Method render() memberitahu Livewire file view mana yang harus ditampilkan
    public function render()
    {
        return view('livewire.auth.register');
    }
}