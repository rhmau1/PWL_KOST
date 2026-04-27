<?php

namespace App\Filament\Penghuni\Pages;

use App\Models\Kamar;
use App\Models\Kos;
use App\Models\Pembayaran;
use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

class WaitingApproval extends Page
{
    protected string $view = 'filament.pages.auth.waiting-approval';

    protected static string $layout = 'filament-panels::components.layout.simple';

    protected static bool $shouldRegisterNavigation = false;

    public $status = 'pending';
    public $catatan = '';
    public $showUpdateForm = false;
    public ?array $data = [];

    public function mount()
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('filament.penghuni.auth.login');
        }

        $latestPayment = $user->pembayarans()->latest()->first();
        
        if ($latestPayment) {
            $this->status = $latestPayment->status;
            $this->catatan = $latestPayment->catatan;

            if ($this->status === 'verified' && $user->penghuni->kos_id) {
                return redirect()->route('filament.penghuni.pages.dashboard');
            }
        }

        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make('Pilih Kos & Kamar')
                        ->schema([
                            Select::make('kos_id')
                                ->label('Pilih Kos')
                                ->options(Kos::whereHas('kamars', fn ($q) => $q->where('is_available', true))->pluck('nama_kos', 'id'))
                                ->helperText(fn () => ! Kos::whereHas('kamars', fn ($q) => $q->where('is_available', true))->exists() 
                                    ? new \Illuminate\Support\HtmlString('<span class="text-danger-600 dark:text-danger-400 font-medium">Maaf, semua kost sudah penuh</span>') 
                                    : null)
                                ->disabled(fn () => ! Kos::whereHas('kamars', fn ($q) => $q->where('is_available', true))->exists())
                                ->required()
                                ->live(),
                            Select::make('kamar_id')
                                ->label('Pilih Kamar')
                                ->options(function (Get $get) {
                                    $kosId = $get('kos_id');
                                    if (!$kosId) return [];
                                    return Kamar::where('kos_id', $kosId)
                                        ->where('is_available', true)
                                        ->pluck('nomor', 'id');
                                })
                                ->disabled(fn (Get $get) => ! $get('kos_id'))
                                ->required()
                                ->live(),
                            Select::make('tipe_sewa')
                                ->label('Tipe Pembayaran/Sewa')
                                ->options([
                                    'booking' => 'Booking Kamar',
                                    'sewa' => 'Sewa 1 Bulan Langsung',
                                ])
                                ->required(),
                        ]),
                    Step::make('Pembayaran')
                        ->schema([
                            Placeholder::make('info_pembayaran')
                                ->label('Informasi Pembayaran')
                                ->content(function (Get $get) {
                                    $kamarId = $get('kamar_id');
                                    if (!$kamarId) return 'Silakan pilih kamar.';
                                    $kamar = Kamar::find($kamarId);
                                    if (!$kamar) return '-';
                                    return 'Kamar Nomor: ' . $kamar->nomor . ' | Harga: Rp ' . number_format($kamar->harga, 0, ',', '.');
                                }),
                            FileUpload::make('bukti_pembayaran')
                                ->label('Upload Bukti Transfer')
                                ->image()
                                ->disk('public')
                                ->directory('bukti-pembayaran')
                                ->required(),
                        ]),
                ])
                ->submitAction(new HtmlString(Blade::render('<x-filament::button type="submit" size="sm" class="mt-4">Kirim Ulang Verifikasi</x-filament::button>')))
            ])
            ->statePath('data');
    }

    public function create()
    {
        $data = $this->form->getState();
        /** @var User $user */
        $user = Auth::user();

        $kamar = Kamar::find($data['kamar_id']);
        $jumlah = $kamar ? $kamar->harga : 0;

        Pembayaran::create([
            'user_id' => $user->id,
            'kos_id' => $data['kos_id'],
            'kamar_id' => $data['kamar_id'],
            'tipe' => $data['tipe_sewa'],
            'jumlah' => $jumlah,
            'bukti_pembayaran' => $data['bukti_pembayaran'],
            'status' => 'pending',
            'tanggal_bayar' => now(),
            'catatan' => 'Update data pendaftaran & bukti transfer baru. Menunggu verifikasi ulang.',
        ]);

        $this->status = 'pending';
        $this->showUpdateForm = false;
        
        $this->dispatch('notify', [
            'status' => 'success',
            'message' => 'Data berhasil dikirim ulang. Silakan tunggu verifikasi admin.',
        ]);
    }

    public function toggleUpdateForm()
    {
        $this->showUpdateForm = !$this->showUpdateForm;
    }

    public function getHeading(): string
    {
        return $this->showUpdateForm ? 'Update Pembayaran' : 'Status Verifikasi';
    }

    public function getSubheading(): string|HtmlString|null
    {
        return $this->showUpdateForm ? 'Silakan pilih kembali unit kost dan upload bukti pembayaran baru.' : null;
    }
}
