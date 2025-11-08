<div>
    {{-- Request #1 (Koreksi) & #2 (Breadcrumb) --}}
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a href="{{ route('adminusers') }}" wire:navigate
                    class="inline-flex items-center text-sm font-normal text-slate-400 hover:text-blue-600">
                    Manajemen Pengguna
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    <span class="pl-2 inline-flex items-center text-sm font-normal text-slate-600">
                        Baru
                    </span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="flex items-start justify-between">
        <h1 class="text-2xl font-bold mb-6">Buat Pengguna</h1>
    </div>

    {{-- Bungkus semua form dengan tag <form> --}}
    <form wire:submit="save">
        <div class="rounded-2xl mb-6 shadow-sm border border-gray-200 bg-white p-5">
            <div class="grid grid-cols-2 gap-12">
                {{-- Kolom Kiri --}}
                <div>
                    {{-- Request #3: Input Nama Fungsional --}}
                    <div class="mb-6">
                        <label for="name" class="block mb-2 font-semibold text-base text-gray-900">Nama</label>
                        <input wire:model="name" type="text" id="name"
                            class="bg-white border text-gray-900 text-sm rounded-lg focus:outline-none block w-full p-2.5
                                      @error('name') border-red-500 @else border-gray-400 @enderror">
                        {{-- Request #5: Pesan Error --}}
                        @error('name')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Request #3: Input Email Fungsional --}}
                    <div class="mb-6">
                        <label for="email" class="block mb-2 font-semibold text-base text-gray-900">Email</label>
                        <input wire:model="email" type="email" id="email"
                            class="bg-white border text-gray-900 text-sm rounded-lg focus:outline-none block w-full p-2.5
                                      @error('email') border-red-500 @else border-gray-400 @enderror">
                        @error('email')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Request #3 & #4: Input Peran Superior (KONDISIONAL) --}}
                    {{-- Ini hanya akan muncul JIKA $role == 'masyarakat' --}}
                    @if ($role == 'masyarakat')
                        <div class="mb-3">
                            <label for="superiority_role" class="block mb-2 font-semibold text-base text-gray-900">Peran
                                Superior</label>
                            <select wire:model="superiority_role" id="superiority_role"
                                class="block w-full rounded-lg border bg-white p-2.5 text-sm text-gray-900 focus:outline-none
                                           @error('superiority_role') border-red-500 @else border-gray-400 @enderror">
                                <option value="">Pilih Peran Superior</option>
                                <option value="Ayah">Ayah</option>
                                <option value="Ibu">Ibu</option>
                                <option value="Anggota Keluarga lain">Anggota Keluarga lain</option>
                            </select>
                            @error('superiority_role')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                </div>

                {{-- Kolom Kanan --}}
                <div>
                    {{-- Request #3: Input Password Fungsional --}}
                    <div class="mb-6">
                        <label for="password" class="block mb-2 font-semibold text-base text-gray-900">Password</label>
                        <input wire:model="password" type="password" id="password"
                            class="bg-white border text-gray-900 text-sm rounded-lg focus:outline-none block w-full p-2.5
                                      @error('password') border-red-500 @else border-gray-400 @enderror">
                        @error('password')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Request #3 & #4: Input Peran Fungsional --}}
                    <div class="">
                        <label for="role" class="block mb-2 font-semibold text-base text-gray-900">Peran</S< /label>
                            {{-- 'wire:model.live' SANGAT PENTING di sini untuk memicu logika kondisional --}}
                            <select wire:model.live="role" id="role"
                                class="block w-full rounded-lg border bg-white p-2.5 text-sm text-gray-900 focus:outline-none
                                       @error('role') border-red-500 @else border-gray-400 @enderror">
                                <option value="">Pilih Peran</option>
                                <option value="admin">Admin</option>
                                <option value="masyarakat">Masyarakat</option> {{-- Sesuai ENUM database --}}
                            </select>
                            @error('role')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-start space-x-4 pb-4">
            {{-- Request #6: Tombol "Simpan" fungsional --}}
            <button type="submit"
                class="items-center rounded-lg border border-blue-300 bg-blue-500 p-2 font-semibold text-white hover:bg-blue-500/90">
                <span>Simpan</span>
            </button>
            {{-- Request #7: Tombol "Batal" fungsional --}}
            <button wire:click="cancel" type="button"
                class="items-center rounded-lg border border-gray-300 bg-white p-2 font-semibold text-gray-900 hover:bg-gray-100">
                <span>Batal</span>
            </button>
        </div>
    </form>
</div>
