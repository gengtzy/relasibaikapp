<div class="flex justify-center items-center min-h-screen">
    <div class="w-full max-w-sm px-6 pb-6 bg-white border border-white rounded-lg shadow-lg">
        <form wire:submit="register" class="space-y-6">
            <h5 class="text-2xl font-bold text-gray-900 pt-6">Buat Akun Relasibaik.</h5>

            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Name</label>
                <input id="name" type="text" wire:model="name" required autofocus autocomplete="name"
                    class="bg-white border border-gray-400 text-gray-900 text-base rounded-lg focus:outline-none focus:border-blue-500 block w-full p-2.5"
                    placeholder="Masukan nama kamu" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                <input id="email" type="email" wire:model="email" required autocomplete="username"
                    class="bg-white border border-gray-400 text-gray-900 text-base rounded-lg focus:outline-none focus:border-blue-500 block w-full p-2.5"
                    placeholder="Masukan email kamu" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div x-data="{ showPasswords: false }">
                <!-- Input Kata Sandi Pertama -->
                <div class="mb-6">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                    <div class="relative">
                        <input id="password" :type="showPasswords ? 'text' : 'password'" wire:model="password" required
                            autocomplete="new-password"
                            class="bg-white border border-gray-400 text-gray-900 text-base rounded-lg focus:outline-none focus:border-blue-500 block w-full p-2.5" placeholder="Masukan kata sandi kamu" />
                        <div @click="showPasswords = !showPasswords"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer">
                            {{-- Menggunakan SVG agar tidak bergantung pada Font Awesome --}}
                            <svg x-show="!showPasswords" class="w-5 h-5 text-gray-500" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="showPasswords" class="w-5 h-5 text-gray-500" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.064-7 9.542-7 1.556 0 3.041.44 4.375 1.175M19.5 19.5L4.5 4.5" />
                            </svg>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Input Konfirmasi Kata Sandi -->
                <div>
                    <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">Confirm Password</label>
                    <div class="relative">
                        <input id="password_confirmation" :type="showPasswords ? 'text' : 'password'"
                            wire:model="password_confirmation" required autocomplete="new-password"
                            class="bg-white border border-gray-400 text-gray-900 text-base rounded-lg focus:outline-none focus:border-blue-500 block w-full p-2.5" placeholder="Konfirmasi kata sandi kamu" />
                        <div @click="showPasswords = !showPasswords"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer">
                            {{-- Menggunakan SVG agar tidak bergantung pada Font Awesome --}}
                            <svg x-show="!showPasswords" class="w-5 h-5 text-gray-500" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="showPasswords" class="w-5 h-5 text-gray-500" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.064-7 9.542-7 1.556 0 3.041.44 4.375 1.175M19.5 19.5L4.5 4.5" />
                            </svg>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
            </div>

            <button type="submit"
                class="w-full text-white bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Daftar
                Akun</button>

            <div class="text-sm font-medium text-center">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-500 hover:underline"
                    wire:navigate>Masuk</a>
            </div>
        </form>
    </div>
</div>
