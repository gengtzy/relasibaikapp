<div class="flex justify-center items-center min-h-screen">
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="w-full max-w-sm px-6 pb-6 bg-blue-500/15 backdrop-blur-sm border border-gray-200 rounded-lg shadow-lg">
        <form wire:submit="login" class="space-y-4">
            <h5 class="text-2xl font-medium text-gray-900 pt-6">Masuk ke Relasibaik.</h5>

            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email Kamu</label>
                <input id="email" type="email" wire:model="email" required autofocus autocomplete="username"
                    class="bg-slate-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-none focus:border-blue-500 block w-full p-2.5"
                    placeholder="name@company.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div x-data="{ showPassword: false }">

                <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Kata Sandi Kamu</label>

                <div class="relative">

                    <input id="password" :type="showPassword ? 'text' : 'password'" wire:model="password" required
                        autocomplete="current-password" placeholder=""
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-none focus:border-blue-500 block w-full p-2.5 pr-10" />

                    <div @click="showPassword = !showPassword"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer">

                        <i class="far text-gray-500" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </div>
                </div>

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Kata Sandi Kamu</label>
                <input id="password" type="password" wire:model="password" required autocomplete="current-password"
                    placeholder=""
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-none focus:border-blue-500 block w-full p-2.5" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div> --}}

            <div class="flex items-center justify-between">
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="remember_me" type="checkbox" wire:model="remember"
                            class="w-4 h-4 border border-gray-300 rounded-sm bg-gray-50 focus:ring-1 focus:ring-blue-300 accent-blue-500" />
                    </div>
                    <label for="remember_me" class="ms-2 text-sm font-medium">Ingat saya</label>
                </div>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-blue-700 hover:underline"
                        wire:navigate>Lupa
                        Sandi?</a>
                @endif
            </div>

            <button type="submit"
                class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-md font-semibold px-5 py-2.5 text-center">Masuk
                ke Akun Kamu</button>

            <div class="text-sm font-medium text-center">
                Belum punya akun? <a href="{{ route('register') }}" class="text-blue-700 hover:underline"
                    wire:navigate>Daftar</a>
            </div>
        </form>
    </div>
</div>