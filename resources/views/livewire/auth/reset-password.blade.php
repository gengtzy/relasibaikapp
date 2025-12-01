<div class="flex justify-center items-center min-h-screen">
    <div class="w-full max-w-sm px-6 pb-6 bg-white border border-white rounded-lg shadow-lg dark:bg-slate-700 dark:border-slate-500 transition-colors duration-500 ease-in-out">
        
        <h5 class="text-2xl font-bold text-gray-900 pt-6 mb-6 dark:text-slate-100 transition-colors duration-500 ease-in-out">Buat Kata Sandi Baru</h5>

        <form wire:submit="resetPassword" class="space-y-6">
            
            <!-- Email (Hidden/Readonly agar user yakin akunnya benar) -->
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-slate-100 transition-colors duration-500 ease-in-out">Email</label>
                <input wire:model="email" id="email" type="email" required readonly
                    class="bg-gray-100 border border-gray-300 text-gray-500 text-base rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-slate-700 dark:border-slate-600 dark:text-slate-500 dark:placeholder:text-slate-400 transition-colors duration-500 ease-in-out" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password Baru -->
            <div x-data="{ showPassword: false }">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-slate-100 transition-colors duration-500 ease-in-out">New Password</label>
                <div class="relative">
                    <input id="password" :type="showPassword ? 'text' : 'password'" wire:model="password" required autocomplete="new-password"
                        class="bg-white border border-gray-400 text-gray-900 text-base rounded-lg focus:outline-none focus:border-blue-500 block w-full p-2.5 dark:bg-slate-600 dark:border-slate-500 dark:text-slate-100 dark:placeholder:text-slate-400 transition-colors duration-500 ease-in-out"
                        placeholder="Minimal 8 karakter" />
                    <div @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer text-gray-500">
                        <i class="far" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-slate-100 transition-colors duration-500 ease-in-out">Confirm New Password</label>
                <input id="password_confirmation" type="password" wire:model="password_confirmation" required autocomplete="new-password"
                    class="bg-white border border-gray-400 text-gray-900 text-base rounded-lg focus:outline-none focus:border-blue-500 block w-full p-2.5 dark:bg-slate-600 dark:border-slate-500 dark:text-slate-100 dark:placeholder:text-slate-400 transition-colors duration-500 ease-in-out"
                    placeholder="Ulangi kata sandi baru" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <button type="submit"
                class="w-full text-white bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-md font-semibold px-5 py-2.5 text-center hover:bg-blue-600 transition-colors">
                {{ __('Reset Password') }}
            </button>
        </form>
    </div>
</div>