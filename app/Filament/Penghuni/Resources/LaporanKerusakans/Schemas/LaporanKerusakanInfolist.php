<?php

namespace App\Filament\Penghuni\Resources\LaporanKerusakans\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class LaporanKerusakanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('kamar.nomor')
                    ->label('Kamar'),
                TextEntry::make('jenis_kerusakan')
                    ->label('Jenis Kerusakan'),
                TextEntry::make('detail_kerusakan')
                    ->label('Detail Kerusakan'),
                ImageEntry::make('foto_bukti')
                    ->label('Foto Bukti'),
                TextEntry::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'diproses' => 'info',
                        'selesai' => 'success',
                        default => 'secondary',
                    }),
                TextEntry::make('created_at')
                    ->label('Tanggal Lapor')
                    ->dateTime(),
            ]);
    }
}
