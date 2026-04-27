<div class="space-y-6">
    @if(!$showUpdateForm)
        <div class="text-center">
            @if($status === 'pending')
                <div class="flex flex-col items-center justify-center py-6">
                    <div class="p-4 bg-orange-100 dark:bg-orange-900/30 rounded-full mb-4">
                        <x-heroicon-o-clock class="w-12 h-12 text-orange-500" />
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Menunggu Verifikasi</h2>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Terima kasih telah mendaftar. Data dan bukti pembayaran Anda sedang dalam antrian verifikasi admin. Silakan cek kembali secara berkala.
                    </p>
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-6">
                    <div class="p-4 bg-red-100 dark:bg-red-900/30 rounded-full mb-4">
                        <x-heroicon-o-x-circle class="w-12 h-12 text-red-500" />
                    </div>
                    <h2 class="text-xl font-bold text-red-600 dark:text-red-400">Pendaftaran Ditolak</h2>
                    <div class="mt-4 p-4 bg-red-50 dark:bg-red-900/20 rounded-xl border border-red-100 dark:border-red-800 text-sm">
                        <p class="font-medium text-red-800 dark:text-red-300">Alasan Penolakan:</p>
                        <p class="mt-1 text-red-700 dark:text-red-400 italic">"{{ $catatan ?: 'Hubungi admin untuk informasi lebih lanjut.' }}"</p>
                    </div>
                </div>
            @endif

            <div class="mt-8 space-y-3">
                @if($status === 'rejected')
                    <x-filament::button wire:click="toggleUpdateForm" color="primary" class="w-full" size="lg">
                        Update & Kirim Ulang
                    </x-filament::button>
                @endif

                <form method="POST" action="{{ route('logout.pending') }}">
                    @csrf
                    <x-filament::button type="submit" color="gray" class="w-full" size="lg" variant="ghost">
                        Keluar / Kembali ke Login
                    </x-filament::button>
                </form>
            </div>
        </div>
    @else
        <div class="animate-fade-in">
            <form wire:submit="create">
                {{ $this->form }}
            </form>
        </div>
    @endif
</div>
