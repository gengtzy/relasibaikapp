<div class="flex justify-center items-center min-h-screen">
    <div class="w-full mx-5 md:max-w-sm px-6 pb-6 bg-white border border-white rounded-lg shadow-lg dark:bg-slate-700 dark:border-slate-500 transition-colors duration-500 ease-in-out">
        
        <h5 class="text-2xl font-bold text-gray-900 pt-6 mb-2 dark:text-slate-100 transition-colors duration-500 ease-in-out">Lupa Kata Sandi?</h5>
        <div class="mb-6 text-sm text-gray-600 dark:text-slate-200 transition-colors duration-500 ease-in-out">
            {{ __('Jangan khawatir. Cukup beri tahu kami alamat email Anda dan kami akan mengirimkan tautan reset kata sandi.') }}
        </div>

        <!-- Status Session -->
        @if ($status)
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $status }}
            </div>
        @endif

        <form wire:submit="sendPasswordResetLink" class="space-y-6">
            <!-- Email Address -->
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-slate-100 transition-colors duration-500 ease-in-out">Email</label>
                <input wire:model="email" id="email" type="email" required autofocus
                    class="bg-white border border-gray-400 text-gray-900 text-base rounded-lg focus:outline-none focus:border-blue-500 block w-full p-2.5 dark:bg-slate-600 dark:border-slate-500 dark:text-slate-100 dark:placeholder:text-slate-400 transition-colors duration-500 ease-in-out"
                    placeholder="Masukan email terdaftar" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <button type="submit"
                class="w-full text-white bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-md font-semibold px-5 py-2.5 text-center hover:bg-blue-600 transition-colors">
                {{ __('Kirim Tautan Reset') }}
            </button>

            <div class="text-sm font-medium text-center">
                <a href="{{ route('login') }}" class="text-blue-500 hover:underline" wire:navigate>
                    Kembali ke Login
                </a>
            </div>
        </form>
    </div>
</div>