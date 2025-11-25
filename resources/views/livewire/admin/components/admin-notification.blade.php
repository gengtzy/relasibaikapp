<div x-data="{ open: false }" class="relative mr-2">
    
    {{-- 1. Tombol Lonceng --}}
    <button @click="open = !open" type="button" class="relative p-2 text-gray-500 rounded-lg hover:text-gray-900">
        <span class="sr-only">View notifications</span>

        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
        
        @if($count > 0)
            <div class="absolute inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-1 -right-1">
                {{ $count > 9 ? '9+' : $count }}
            </div>
        @endif
    </button>

    <div x-show="open" 
         @click.outside="open = false"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         class="absolute right-0 z-50 mt-2 w-80 bg-white divide-y divide-gray-100 rounded-lg shadow-xl border border-gray-100"
         style="display: none;">
        
        <div class="px-4 py-3 bg-gray-50 rounded-t-lg border-b border-gray-100">
            <span class="block text-sm font-semibold text-gray-900">Notifikasi</span>
        </div>

        <div class="max-h-80 overflow-y-auto">
            @forelse($pendingUsers as $user)
                <a href="{{ route('usersedit', $user->id) }}" wire:navigate @click="open = false" class="flex px-4 py-3 hover:bg-gray-50 border-b border-gray-100 last:border-0 group">
                    
                    {{-- Icon Warning Kuning --}}
                    <div class="flex-shrink-0">
                        <div class="inline-flex items-center justify-center w-10 h-10 bg-yellow-100 rounded-full text-yellow-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                    </div>
                    
                    <div class="w-full ps-3">
                        <div class="text-gray-800 text-sm font-semibold mb-0.5 group-hover:text-blue-600 transition-colors">
                            Verifikasi Role Diperlukan
                        </div>
                        <div class="text-xs text-gray-500 mb-1">
                            User <span class="font-medium text-gray-700">{{ $user->name }}</span> belum memiliki peran keluarga.
                        </div>
                        <div class="text-xs text-blue-500 font-medium">
                            {{ $user->created_at->diffForHumans() }}
                        </div>
                    </div>
                </a>
            @empty
                <div class="px-4 py-6 text-center text-gray-500">
                    <p class="text-sm">Tidak ada notifikasi baru.</p>
                </div>
            @endforelse
        </div>

        {{-- Footer Dropdown --}}
        @if($count > 0)
            <a href="{{ route('adminusers', ['filter' => 'no_role']) }}" wire:navigate class="block py-2 text-sm font-medium text-center text-blue-600 bg-gray-50 hover:bg-gray-100 rounded-b-lg">
                Lihat semua ({{ $count }})
            </a>
        @endif
    </div>
</div>