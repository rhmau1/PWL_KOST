<?php

namespace App\Filament\Penghuni\Resources\Pembayarans\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PembayaranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('kos_id')
                    ->required()
                    ->numeric(),
                TextInput::make('kamar_id')
                    ->required()
                    ->numeric(),
                Select::make('tipe')
                    ->options(['booking' => 'Booking', 'sewa' => 'Sewa'])
                    ->required(),
                TextInput::make('jumlah')
                    ->required()
                    ->numeric(),
                TextInput::make('bukti_pembayaran')
                    ->required(),
                Select::make('status')
                    ->options(['pending' => 'Pending', 'verified' => 'Verified', 'rejected' => 'Rejected'])
                    ->default('pending')
                    ->required(),
                DatePicker::make('tanggal_bayar'),
                Textarea::make('catatan')
                    ->columnSpanFull(),
            ]);
    }
}
