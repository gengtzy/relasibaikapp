<div class="flex justify-center items-center min-h-screen">
    <div class="w-full max-w-md px-6 pb-6 bg-white border border-white rounded-lg shadow-lg text-center">
        
        <div class="pt-6 pb-4">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <h5 class="text-xl font-bold text-gray-900 mt-4">Verifikasi Email Anda</h5>
        </div>

        <div class="mb-6 text-sm text-gray-600 text-left">
            {{ __('Terima kasih telah mendaftar! Sebelum memulai, bisakah Anda memverifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan ke email Anda? Jika Anda tidak menerima email tersebut, kami akan dengan senang hati mengirimkan yang baru.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-6 font-medium text-sm text-green-600 bg-green-50 p-3 rounded-lg">
                {{ __('Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.') }}
            </div>
        @endif

        <div class="space-y-4">
            <button wire:click="sendVerification"
                class="w-full text-white bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-md font-semibold px-5 py-2.5 text-center hover:bg-blue-600 transition-colors">
                {{ __('Kirim Ulang Email Verifikasi') }}
            </button>

            <button wire:click="logout" 
                class="text-sm text-gray-600 hover:text-gray-900 underline decoration-dotted hover:decoration-solid">
                {{ __('Keluar (Logout)') }}
            </button>
        </div>
    </div>
</div>