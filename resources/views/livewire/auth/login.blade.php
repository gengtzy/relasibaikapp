<div class="flex justify-center items-center min-h-screen">
    <div class="w-full max-w-sm px-6 pb-6 bg-white border border-white rounded-lg shadow-lg">
        @if (session('status'))
            <div class="mt-6 mb-4 text-sm font-medium text-green-600 bg-green-50 p-3 rounded-lg text-center border border-green-200">
                {{ session('status') }}
            </div>
        @endif
        <form wire:submit="login" class="space-y-6">
            <h5 class="text-2xl font-bold text-gray-900 pt-6">Masuk ke Relasibaik.</h5>

            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                <input id="email" type="email" wire:model="email" required autofocus autocomplete="username"
                    class="bg-white border border-gray-400 text-gray-900 text-base rounded-lg focus:outline-none focus:border-blue-500 block w-full p-2.5"
                    placeholder="Masukan email kamu" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div x-data="{ showPassword: false }">

                <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>

                <div class="relative">

                    <input id="password" :type="showPassword ? 'text' : 'password'" wire:model="password" required
                        autocomplete="current-password" placeholder="Masukan kata sandi kamu"
                        class="bg-white border border-gray-400 text-gray-900 text-base rounded-lg focus:outline-none focus:border-blue-500 block w-full p-2.5" />

                    <div @click="showPassword = !showPassword"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer">

                        <i class="far text-gray-500" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </div>
                </div>

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="remember_me" type="checkbox" wire:model="remember"
                            class="w-4 h-4 border border-gray-300 rounded-sm bg-gray-50 focus:ring-1 focus:ring-blue-300 accent-blue-500" />
                    </div>
                    <label for="remember_me" class="ms-2 text-sm font-medium">Ingat saya</label>
                </div>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-blue-500 hover:underline"
                        wire:navigate>Lupa
                        Sandi?</a>
                @endif
            </div>

            <button type="submit"
                class="w-full text-white bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-md font-semibold px-5 py-2.5 text-center">Masuk</button>

            <div class="text-sm font-medium text-center">
                Belum punya akun? <a href="{{ route('register') }}" class="text-blue-500 hover:underline"
                    wire:navigate>Daftar</a>
            </div>
        </form>
    </div>
</div>
