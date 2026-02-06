<div>
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <span class="inline-flex items-center text-sm font-normal text-slate-400">
                    Profil Akun
                </span>
            </li>
        </ol>
    </nav>

    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
        <h1 class="text-2xl font-bold text-slate-800">Profil Akun</h1>
    </div>
    <div class="max-w-6xl">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 text-center items-center relative overflow-hidden">
                    <div class="relative inline-block">
                        {{-- Logic Preview Foto --}}
                        @if ($avatar)
                            {{-- Preview saat mau upload (Temporary Url) --}}
                            <img src="{{ $avatar->temporaryUrl() }}"
                                class="w-32 h-32 rounded-full object-cover border-4 border-slate-100 shadow-md mx-auto">
                        @elseif ($existingAvatar)
                            {{-- Foto dari Database (Base64 atau Storage Lama) --}}
                            @if (str_contains($existingAvatar, 'data:image'))
                                {{-- Tampilkan Base64 langsung --}}
                                <img src="{{ $existingAvatar }}"
                                    class="w-32 h-32 rounded-full object-cover border-4 border-slate-100 shadow-md mx-auto">
                            @else
                                {{-- Fallback untuk gambar lama yg mungkin masih di storage --}}
                                <img src="{{ asset('storage/' . $existingAvatar) }}"
                                    class="w-32 h-32 rounded-full object-cover border-4 border-slate-100 shadow-md mx-auto">
                            @endif
                        @else
                            {{-- Default Avatar UI --}}
                            <div class="w-32 h-32 rounded-full bg-slate-200 flex items-center justify-center text-slate-400 mx-auto border-4 border-slate-100 shadow-md">
                                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        @endif

                        {{-- Tombol Kamera Kecil --}}
                        <label for="avatar-upload"
                            class="absolute bottom-0 right-0 bg-blue-600 text-white p-2 rounded-full shadow-lg cursor-pointer hover:bg-blue-700 transition-colors"
                            title="Ganti Foto">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </label>
                        <input wire:model="avatar" id="avatar-upload" type="file" class="hidden" accept="image/*">
                    </div>

                    <div wire:loading wire:target="avatar" class="text-xs text-blue-600 mt-2 font-medium animate-pulse">
                        Mengunggah foto...
                    </div>
                    @error('avatar')
                        <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                    @enderror

                    <h2 class="mt-4 text-xl font-bold text-slate-800">{{ Auth::user()->name }}</h2>
                    <p class="text-slate-500 text-sm">{{ Auth::user()->email }}</p>

                    <div class="mt-4 inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                        Administrator
                    </div>
                    <p class="text-xs text-slate-400 mt-4">Bergabung sejak
                        {{ Auth::user()->created_at->format('d M Y') }}</p>
                </div>
            </div>

            {{-- KOLOM KANAN: FORM EDIT --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- 1. Edit Info Dasar --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                    <h3 class="text-lg font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100">Informasi Dasar
                    </h3>

                    <form wire:submit="updateProfile" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                                <input wire:model="name" type="text"
                                    class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 text-sm">
                                @error('name')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                                <input wire:model="email" type="email"
                                    class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 text-sm">
                                @error('email')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end pt-2">
                            <button type="submit"
                                class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors flex items-center">
                                <svg wire:loading.remove wire:target="updateProfile" class="w-4 h-4 mr-2" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <svg wire:loading wire:target="updateProfile"
                                    class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Simpan Profil
                            </button>
                        </div>

                        @if (session('status'))
                            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                                class="text-sm text-green-600 bg-green-50 p-2 rounded border border-green-200 text-center">
                                {{ session('status') }}
                            </div>
                        @endif
                    </form>
                </div>

                {{-- 2. Update Password --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                    <h3 class="text-lg font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100">Ganti Password</h3>

                    <form wire:submit="updatePassword" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Password Saat Ini</label>
                            <input wire:model="current_password" type="password"
                                class="w-full rounded-lg border-slate-300 focus:border-slate-500 focus:ring-slate-500 text-sm">
                            @error('current_password')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Password Baru</label>
                                <input wire:model="password" type="password"
                                    class="w-full rounded-lg border-slate-300 focus:border-slate-500 focus:ring-slate-500 text-sm">
                                @error('password')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi
                                    Password</label>
                                <input wire:model="password_confirmation" type="password"
                                    class="w-full rounded-lg border-slate-300 focus:border-slate-500 focus:ring-slate-500 text-sm">
                            </div>
                        </div>

                        <div class="flex justify-end pt-2">
                            <button type="submit"
                                class="bg-slate-800 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-slate-900 transition-colors">
                                Update Password
                            </button>
                        </div>

                        @if (session('password-status'))
                            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                                class="text-sm text-green-600 bg-green-50 p-2 rounded border border-green-200 text-center">
                                {{ session('password-status') }}
                            </div>
                        @endif
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
