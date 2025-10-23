<div class="flex justify-center items-center min-h-screen">
    <div class="w-full max-w-xl p-6 mx-8 bg-blue-500/15 backdrop-blur-sm border border-gray-200 rounded-lg shadow-lg">
        <div class="space-y-6">
            <h5 class="text-base font-medium text-gray-900">
                Terima kasih telah mendaftar! Sebelum memulai, bisakah Anda memverifikasi alamat email Anda dengan
                mengklik tautan yang baru saja kami kirimkan? Jika Anda tidak menerima email tersebut, kami dengan
                senang hati akan mengirimkan yang baru.
            </h5>

            @if (session('status') == 'verification-link-sent')
                <div class="font-medium text-sm text-green-700">
                    Tautan verifikasi baru telah dikirimkan ke alamat email yang Anda berikan saat pendaftaran.
                </div>
            @endif

            <div class="mt-4 flex items-center justify-between">
                <button wire:click="sendVerification" type="button"
                    class="w-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-lg px-5 py-2.5 text-center">
                    Kirim Ulang Verifikasi Email
                </button>

                <button wire:click="logout" type="button"
                    class="text-lg text-gray-700 hover:text-gray-900 hover:underline">
                    Keluar
                </button>
            </div>
        </div>
    </div>
</div>
