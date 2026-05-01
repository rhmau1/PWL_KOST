<?php

namespace App\Filament\Penghuni\Resources\Pembayarans\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PembayaranInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('kos_id')
                    ->numeric(),
                TextEntry::make('kamar_id')
                    ->numeric(),
                TextEntry::make('tipe')
                    ->badge(),
                TextEntry::make('jumlah')
                    ->numeric(),
                TextEntry::make('bukti_pembayaran'),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('tanggal_bayar')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('catatan')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
