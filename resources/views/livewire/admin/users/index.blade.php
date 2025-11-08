<div>
    {{-- Request #1: Struktur HTML Rapi & Semantik --}}
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <span class="inline-flex items-center text-sm font-normal text-slate-400">
                    Manajemen Pengguna
                </span>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    <span class="pl-2 inline-flex items-center text-sm font-normal text-slate-600">
                        List
                    </span>
                </div>
            </li>
        </ol>
    </nav>

    {{-- Header --}}
    <div class="flex items-start justify-between">
        <h1 class="text-2xl font-bold mb-6">Manajemen Pengguna</h1>

        {{-- Request #2: Tombol "Pengguna Baru" difungsikan --}}
        <button wire:click="createNewUser" type="button"
            class="items-center rounded-lg border border-blue-300 bg-blue-500 p-2 font-semibold text-white hover:bg-blue-500/90">
            <span>Pengguna Baru</span>
        </button>
    </div>

    {{-- Kontainer Tabel --}}
    <div class="border border-slate-300 shadow-sm rounded-2xl bg-white">

        {{-- Area Filter dan Aksi --}}
        <div class="flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0 p-4">

            {{-- Request #5: Tampilkan "Hapus Pilihan" jika ada yang dipilih --}}
            @if (count($selectedUsers) > 0)
                <div class="w-full md:w-auto">
                    <button wire:click="deleteSelected" wire:confirm="Anda yakin ingin menghapus data yang dipilih?"
                        class="btn-danger w-full px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-lg hover:bg-red-700">
                        Hapus Pilihan ({{ count($selectedUsers) }})
                    </button>
                </div>
            @else
                <div></div>
            @endif

            <div class="flex space-x-4">
                {{-- Request #3: Search difungsikan --}}
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                        <i class="fas fa-search text-gray-500"></i>
                    </div>
                    <input wire:model.live="search" type="text" id="table-search"
                        class="block h-10 p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:outline-none focus:border-blue-500"
                        placeholder="Cari nama, email, peran...">
                </div>
                <button type="button"
                    class="text-theme-sm shadow-theme-xs inline-flex h-10 items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 font-medium text-gray-700 hover:bg-gray-200">
                    <i class="fa-solid fa-filter"></i>
                </button>
            </div>
        </div>

        {{-- Tabel --}}
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th scope="col" class="p-4">
                            {{-- Request #4: Checkbox "Select All" --}}
                            <div class="flex items-center">
                                <input wire:model.live="selectAll" type="checkbox"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm accent-blue-500">
                                <label class="sr-only">checkbox</label>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Peran</th>
                        <th scope="col" class="px-6 py-3">Tanggal Registrasi</th>
                        <th scope="col" class="px-6 py-3">Status Verifikasi</th>
                        <th scope="col" class="px-6 py-3">Peran Superior</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Loop data dari database --}}
                    @forelse($users as $user)
                        <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                            {{-- Checkbox --}}
                            <td class="w-4 p-4">
                                <div class="flex items-center">
                                    <input wire:model.live="selectedUsers" type="checkbox" value="{{ $user->id }}"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm accent-blue-500">
                                    <label class="sr-only">checkbox</label>
                                </div>
                            </td>

                            {{-- Request #6: TD bisa diklik untuk edit --}}
                            <td wire:click="editUser({{ $user->id }})" class="px-6 py-4 cursor-pointer">
                                {{ $user->name }}
                            </td>
                            <td wire:click="editUser({{ $user->id }})" class="px-6 py-4 cursor-pointer">
                                {{ $user->email }}
                            </td>
                            <td wire:click="editUser({{ $user->id }})" class="px-6 py-4 cursor-pointer">
                                @if ($user->role == 'admin')
                                    <span
                                        class="bg-orange-500/20 border px-2 border-orange-300 text-orange-500 p-1 font-bold text-sm rounded-lg">
                                        Admin
                                    </span>
                                @else
                                    <span
                                        class="bg-green-500/20 border px-2 border-green-300 text-green-500 p-1 font-bold text-sm rounded-lg">
                                        Masyarakat
                                    </span>
                                @endif
                            </td>
                            <td wire:click="editUser({{ $user->id }})" class="px-6 py-4 cursor-pointer">
                                {{ $user->created_at->format('d M, Y H:i') }}
                            </td>

                            {{-- Request #9: Kolom Status Verifikasi (Turunan) --}}
                            <td wire:click="editUser({{ $user->id }})" class="px-6 py-4 cursor-pointer">
                                @if ($user->superiority_role)
                                    <span
                                        class="bg-green-500/20 border px-2 border-green-300 text-green-500 p-1 font-bold text-sm rounded-2xl">
                                        <i class="fas fa-check"></i>
                                    </span>
                                @elseif ($user->role == 'admin')
                                        -
                                @else
                                    <span
                                        class="bg-red-500/20 border px-2 border-red-300 text-red-500 p-1 font-bold text-sm rounded-2xl">
                                        <i class="fas fa-times"></i>
                                    </span>
                                @endif
                            </td>

                            <td wire:click="editUser({{ $user->id }})" class="px-6 py-4 cursor-pointer">
                                @if ($user->superiority_role)
                                    <span
                                        class="bg-blue-500/20 border px-2 border-blue-300 text-blue-500 p-1 font-bold text-sm rounded-lg">
                                        {{ $user->superiority_role }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>

                            {{-- Request #7: Aksi Edit dan Hapus difungsikan --}}
                            <td class="flex gap-2 px-6 py-4">
                                <button wire:click="editUser({{ $user->id }})" type="button"
                                    class="flex gap-1 items-center font-medium text-blue-600 hover:underline">
                                    <i class="fas fa-edit"></i>
                                    Edit
                                </button>
                                <button wire:click="deleteUser({{ $user->id }})"
                                    wire:confirm="Anda yakin ingin menghapus '{{ $user->name }}'?" type="button"
                                    class="flex gap-1 items-center font-medium text-red-600 hover:underline">
                                    <i class="fas fa-trash-alt"></i>
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr class="bg-white border-b border-gray-200">
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada data pengguna ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Request #8: Paginasi dinamis --}}
        <nav class="flex pb-4 items-center flex-col md:flex-row justify-between pt-4 px-4"
            aria-label="Table navigation">
            <span class="text-sm font-normal text-slate-500 mb-4 md:mb-0 block w-full md:inline md:w-auto">
                Showing
                <span
                    class="font-semibold text-slate-700">{{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }}</span>
                of
                <span class="font-semibold text-slate-700">{{ $users->total() }}</span>
            </span>

            {{ $users->links() }}
        </nav>

    </div>
</div>
