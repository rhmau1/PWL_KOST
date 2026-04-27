<?php

namespace App\Filament\Pages\Auth;

use App\Models\Kamar;
use App\Models\Kos;
use App\Models\Pembayaran;
use App\Models\Penghuni;
use Filament\Auth\Http\Responses\Contracts\RegistrationResponse;
use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Facades\Filament;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;

class Register extends BaseRegister
{
    public function getMaxWidth(): Width|string|null
    {
        return Width::FourExtraLarge;
    }

    public function form(Schema $schema): Schema
    {
        $panelId = Filament::getCurrentPanel()->getId();

        if ($panelId === 'admin') {
            return $schema->components([
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
        }

        return $schema->components([
            Wizard::make([
                Step::make('Data Pribadi')
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        TextInput::make('no_hp')
                            ->label('No. Handphone')
                            ->tel()
                            ->required()
                            ->maxLength(255),
                        TextInput::make('no_hp_wali')
                            ->label('No. HP Wali/Darurat')
                            ->tel()
                            ->required()
                            ->maxLength(255),
                        TextInput::make('nama_wali')
                            ->label('Nama Wali/Darurat')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('alamat')
                            ->label('Alamat Asal')
                            ->required(),
                    ]),
                Step::make('Pilih Kos & Kamar')
                    ->schema([
                        Select::make('kos_id')
                            ->label('Pilih Kos')
                            ->options(Kos::pluck('nama_kos', 'id'))
                            ->required()
                            ->live(),
                        Select::make('kamar_id')
                            ->label('Pilih Kamar')
                            ->options(function (Get $get) {
                                $kosId = $get('kos_id');
                                if (! $kosId) {
                                    return [];
                                }

                                return Kamar::where('kos_id', $kosId)->pluck('nomor', 'id');
                            })
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
                                if (! $kamarId) {
                                    return 'Silakan pilih kamar pada tahap sebelumnya.';
                                }
                                $kamar = Kamar::find($kamarId);
                                if (! $kamar) {
                                    return '-';
                                }

                                return 'Kamar Nomor: '.$kamar->nomor.' | Harga (1 Bulan): Rp '.number_format($kamar->harga, 0, ',', '.');
                            }),
                        FileUpload::make('bukti_pembayaran')
                            ->label('Upload Bukti Transfer')
                            ->image()
                            ->disk('public')
                            ->directory('bukti-pembayaran')
                            ->required(),
                    ]),
            ])->submitAction(new HtmlString(Blade::render('<x-filament::button type="submit" size="sm">Register</x-filament::button>'))),
        ]);
    }

    protected function handleRegistration(array $data): Model
    {
        $panelId = Filament::getCurrentPanel()->getId();

        return DB::transaction(function () use ($data, $panelId) {

            if ($panelId === 'admin') {
                return $this->getUserModel()::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => $data['password'],
                    'role' => 'admin',
                ]);
            }

            // 1. Create User
            $user = $this->getUserModel()::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'role' => 'penghuni',
            ]);

            // 2. User::booted() will automatically create a Penghuni entry. We just update it.
            $penghuni = Penghuni::where('user_id', $user->id)->first();
            if ($penghuni) {
                $penghuni->update([
                    'no_hp' => $data['no_hp'] ?? null,
                    'no_hp_wali' => $data['no_hp_wali'] ?? null,
                    'nama_wali' => $data['nama_wali'] ?? null,
                    'alamat' => $data['alamat'] ?? null,
                    // Note: kos_id is left null, admin will populate this upon verification.
                ]);
            }

            // 3. Create Pending Pembayaran
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
                'catatan' => 'Pendaftaran akun & bukti transfer. Menunggu verifikasi admin.',
            ]);

            return $user;
        });
    }

    public function register(): ?RegistrationResponse
    {
        $response = parent::register();

        $panelId = Filament::getCurrentPanel()->getId();
        if ($panelId === 'penghuni') {
            $this->redirect(route('filament.penghuni.pages.waiting-approval'));

            return null;
        }

        return $response;
    }

    protected function getFormActions(): array
    {
        $panelId = Filament::getCurrentPanel()->getId();

        if ($panelId === 'admin') {
            return parent::getFormActions();
        }

        return [];
    }
}
