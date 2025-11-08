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
                    {{-- Judul dinamis (dipotong agar tidak terlalu panjang) --}}
                    <span class="pl-2 inline-flex items-center text-sm font-normal text-slate-600 truncate max-w-xs">
                        {{ $name }}
                    </span>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    <span class="pl-2 inline-flex items-center text-sm font-normal text-slate-600">
                        Edit
                    </span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="flex items-start justify-between">
        <h1 class="text-2xl font-bold mb-6 truncate max-w-3xl">{{ $name }}</h1>
        
        {{-- Request #3: Tombol "Hapus" fungsional --}}
        <button wire:click="delete" 
                wire:confirm="Anda yakin ingin menghapus '{{ $name }}'?" 
                type="button"
                class="items-center rounded-lg border border-red-300 bg-red-500 p-2 font-semibold text-white hover:bg-red-500/90">
            <span>Hapus</span>
        </button>
    </div>

    {{-- Request #5, #6, #7: Form fungsional --}}
    <form wire:submit="update">
        <div class="rounded-2xl mb-6 shadow-sm border border-gray-200 bg-white p-5">
            <div class="grid grid-cols-2 gap-12">
                {{-- Kolom Kiri --}}
                <div>
                    {{-- Input Nama --}}
                    <div class="mb-6">
                        <label for="name" class="block mb-2 font-semibold text-base text-gray-900">Nama</label>
                        <input wire:model="name" type="text" id="name"
                               class="bg-white border text-gray-900 text-sm rounded-lg focus:outline-none block w-full p-2.5
                                      @error('name') border-red-500 @else border-gray-400 @enderror">
                        @error('name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Input Email --}}
                    <div class="mb-6">
                        <label for="email" class="block mb-2 font-semibold text-base text-gray-900">Email</label>
                        <input wire:model="email" type="email" id="email"
                               class="bg-white border text-gray-900 text-sm rounded-lg focus:outline-none block w-full p-2.5
                                      @error('email') border-red-500 @else border-gray-400 @enderror">
                        @error('email') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Request #4: Input Peran Superior (KONDISIONAL) --}}
                    @if ($role == 'masyarakat')
                        <div class="mb-3">
                            <label for="superiority_role" class="block mb-2 font-semibold text-base text-gray-900">Peran Superior</label>
                            <select wire:model="superiority_role" id="superiority_role" 
                                    class="block w-full rounded-lg border bg-white p-2.5 text-sm text-gray-900 focus:outline-none
                                           @error('superiority_role') border-red-500 @else border-gray-400 @enderror">
                                <option value="">Pilih Peran Superior</option>
                                <option value="Ayah">Ayah</option>
                                <option value="Ibu">Ibu</option>
                                <option value="Anggota Keluarga lain">Anggota Keluarga lain</option>
                            </select>
                            @error('superiority_role') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    @endif
                </div>

                {{-- Kolom Kanan --}}
                <div>
                    {{-- Input Password --}}
                    <div class="mb-6">
                        <label for="password" class="block mb-2 font-semibold text-base text-gray-900">Password Baru (Opsional)</label>
                        <input wire:model="password" type="password" id="password"
                               placeholder="Kosongkan jika tidak ingin diubah"
                               class="bg-white border text-gray-900 text-sm rounded-lg focus:outline-none block w-full p-2.5
                                      @error('password') border-red-500 @else border-gray-400 @enderror">
                        @error('password') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    {{-- Konfirmasi Password --}}
                    <div class="mb-6">
                        <label for="password_confirmation" class="block mb-2 font-semibold text-base text-gray-900">Konfirmasi Password</label>
                        <input wire:model="password_confirmation" type="password" id="password_confirmation"
                               placeholder="Ulangi password baru"
                               class="bg-white border border-gray-400 text-gray-900 text-sm rounded-lg focus:outline-none block w-full p-2.5">
                    </div>
                    
                    {{-- Input Peran --}}
                    <div class="">
                        <label for="role" class="block mb-2 font-semibold text-base text-gray-900">Peran</S</label>
                        <select wire:model.live="role" id="role" 
                                class="block w-full rounded-lg border bg-white p-2.5 text-sm text-gray-900 focus:outline-none
                                       @error('role') border-red-500 @else border-gray-400 @enderror">
                            <option value="">Pilih Peran</option>
                            <option value="admin">Admin</option>
                            <option value="masyarakat">Masyarakat</option>
                        </select>
                        @error('role') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-start space-x-4 pb-4">
            {{-- Request #7: Tombol "Simpan" --}}
            <button type="submit"
                    class="items-center rounded-lg border border-blue-300 bg-blue-500 p-2 font-semibold text-white hover:bg-blue-500/90">
                <span>Simpan</span>
            </button>
            {{-- Request #8: Tombol "Batal" --}}
            <button wire:click="cancel" type="button"
                    class="items-center rounded-lg border border-gray-300 bg-white p-2 font-semibold text-gray-900 hover:bg-gray-100">
                <span>Batal</span>
            </button>
        </div>
    </form>
</div>