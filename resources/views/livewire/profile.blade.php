<div class="my-24 min-h-screen">
    <div class="max-w-6xl mx-auto space-y-6">

        {{-- Header Halaman --}}
        <div class="mb-8 px-4 sm:px-0 text-white">
            <h2 class="font-bold text-3xl leading-tight">
                Pengaturan Akun
            </h2>
            <p class="opacity-90">Kelola identitas diri dan keamanan akun Anda.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 px-4 sm:px-0">

            <div class="lg:col-span-2 space-y-6">
                <div class="p-6 sm:p-8 bg-white shadow-sm sm:rounded-lg border border-slate-200 dark:bg-slate-700 dark:border-slate-500 transition-colors duration-500 ease-in-out">
                    <header class="mb-6 pb-4 border-b border-slate-100 dark:border-slate-600 transition-colors duration-500 ease-in-out">
                        <h2 class="text-lg font-bold text-slate-800 dark:text-slate-100 transition-colors duration-500 ease-in-out">
                            Informasi Dasar
                        </h2>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-200 transition-colors duration-500 ease-in-out">
                            Perbarui nama profil dan alamat email Anda di sini.
                        </p>
                    </header>

                    <form wire:submit="updateProfile" class="space-y-6">
                        {{-- Nama --}}
                        <div>
                            <label for="name" class="block text-sm font-semibold text-slate-700 mb-1 dark:text-slate-100 transition-colors duration-500 ease-in-out">Nama
                                Lengkap</label>
                            <input wire:model="name" id="name" type="text"
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors p-2.5 dark:border-slate-500 dark:bg-slate-600 dark:text-slate-100 duration-500 ease-in-out">
                            @error('name')
                                <span class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700 mb-1 dark:text-slate-100 transition-colors duration-500 ease-in-out">Alamat
                                Email</label>
                            <input wire:model="email" id="email" type="email"
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2.5 dark:border-slate-500 dark:bg-slate-600 dark:text-slate-100 duration-500 ease-in-out transition-colors">
                            @error('email')
                                <span class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="role_display" class="block text-sm font-semibold text-slate-700 mb-1 dark:text-slate-100 transition-colors duration-500 ease-in-out">
                                Peran Superior
                            </label>
                            <div class="relative">
                                {{-- Input Disabled --}}
                                <input type="text" value="{{ $superiority_role }}" disabled
                                    class="w-full border-slate-200 bg-slate-100 text-slate-500 rounded-lg shadow-sm cursor-not-allowed focus:ring-0 p-2.5 dark:bg-slate-700 dark:border-slate-500 dark:text-slate-300 transition-colors duration-500 ease-in-out">

                                {{-- Ikon Gembok --}}
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-slate-500 flex items-center gap-1 dark:text-slate-200 transition-colors duration-500 ease-in-out">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Peran tidak dapat diubah. Hubungi Admin jika ada kesalahan data.
                            </p>
                        </div>

                        <div class="flex items-center gap-4 pt-2">
                            <button type="submit"
                                class="px-5 py-2.5 bg-blue-500 text-white text-sm font-semibold rounded-lg  transition-all ">
                                Simpan Perubahan
                            </button>

                            @if (session('status'))
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                                    class="text-sm text-green-600 font-medium flex items-center bg-green-50 px-3 py-1 rounded-md border border-green-200">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    {{ session('status') }}
                                </p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="p-6 bg-white shadow-sm sm:rounded-xl border border-slate-200 dark:bg-slate-700 dark:border-slate-500 transition-colors duration-500 ease-in-out">
                    <header class="mb-8 pb-4 border-b border-slate-100 dark:border-slate-600 transition-colors duration-500 ease-in-out">
                        <h2 class="text-lg font-bold text-slate-800 dark:text-slate-100 transition-colors duration-500 ease-in-out">
                            Keamanan
                        </h2>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-200 transition-colors duration-500 ease-in-out">
                            Update password Anda secara berkala.
                        </p>
                    </header>

                    <form wire:submit="updatePassword" class="space-y-8">
                        {{-- Password Lama --}}
                        <div>
                            <label for="current_password"
                                class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1 dark:text-slate-100 transition-colors duration-500 ease-in-out">Password
                                Lama</label>
                            <input wire:model="current_password" id="current_password" type="password"
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:border-slate-800 focus:ring-slate-800 text-sm p-2.5 dark:text-slate-100 dark:border-slate-500 dark:bg-slate-600 transition-colors duration-500 ease-in-out">
                            @error('current_password')
                                <span class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Password Baru --}}
                        <div>
                            <label for="password"
                                class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1 dark:text-slate-100 transition-colors duration-500 ease-in-out">Password
                                Baru</label>
                            <input wire:model="password" id="password" type="password"
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:border-slate-800 focus:ring-slate-800 text-sm p-2.5 dark:text-slate-100 dark:border-slate-500 dark:bg-slate-600 transition-colors duration-500 ease-in-out">
                            @error('password')
                                <span class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div>
                            <label for="password_confirmation"
                                class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1 dark:text-slate-100 transition-colors duration-500 ease-in-out">Konfirmasi
                                Baru</label>
                            <input wire:model="password_confirmation" id="password_confirmation" type="password"
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:border-slate-800 focus:ring-slate-800 text-sm p-2.5 dark:text-slate-100 dark:border-slate-500 dark:bg-slate-600 transition-colors duration-500 ease-in-out">
                        </div>

                        <div class="pt-2">
                            <button type="submit"
                                class="w-full px-4 py-2.5 bg-slate-800 text-white text-sm font-semibold rounded-lg transition-all shadow-md">
                                Update Password
                            </button>

                            @if (session('password-status'))
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                                    class="mt-3 text-sm text-center text-green-600 font-medium">
                                    {{ session('password-status') }}
                                </p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
