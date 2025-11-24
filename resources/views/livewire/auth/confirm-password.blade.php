<div class="flex justify-center items-center min-h-screen">
    <div class="w-full max-w-sm px-6 pb-6 bg-white border border-white rounded-lg shadow-lg">

        <h5 class="text-2xl font-bold text-gray-900 pt-6 mb-2">Konfirmasi Akses</h5>
        <div class="mb-6 text-sm text-gray-600">
            {{ __('Ini adalah area aman. Harap konfirmasi kata sandi Anda sebelum melanjutkan.') }}
        </div>

        <form wire:submit="confirm" class="space-y-6">
            <!-- Password -->
            <div x-data="{ showPassword: false }">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                <div class="relative">
                    <input id="password" :type="showPassword ? 'text' : 'password'" wire:model="password" required
                        autocomplete="current-password"
                        class="bg-white border border-gray-400 text-gray-900 text-base rounded-lg focus:outline-none focus:border-blue-500 block w-full p-2.5"
                        placeholder="Masukan kata sandi Anda" />
                    <div @click="showPassword = !showPassword"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer text-gray-500">
                        <i class="far" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <button type="submit"
                class="w-full text-white bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-md font-semibold px-5 py-2.5 text-center hover:bg-blue-600 transition-colors">
                {{ __('Konfirmasi') }}
            </button>
        </form>
    </div>
</div>