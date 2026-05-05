<?php

namespace App\Filament\Penghuni\Resources\LaporanKerusakans\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class LaporanKerusakanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('id_penghuni')
                    ->default(fn () => Auth::user()->penghuni->id ?? null),
                
                Hidden::make('status')
                    ->default('pending'),

                Select::make('id_kamar')
                    ->label('Kamar')
                    ->relationship('kamar', 'nomor', function ($query) {
                        $kosId = Auth::user()->penghuni->kos_id ?? null;
                        if ($kosId) {
                            return $query->where('kos_id', $kosId);
                        }
                        return $query;
                    })
                    ->required()
                    ->searchable()
                    ->preload(),

                TextInput::make('jenis_kerusakan')
                    ->label('Jenis Kerusakan')
                    ->required()
                    ->maxLength(255),

                Textarea::make('detail_kerusakan')
                    ->label('Detail Kerusakan')
                    ->required()
                    ->rows(4),

                FileUpload::make('foto_bukti')
                    ->label('Foto Bukti')
                    ->image()
                    ->directory('laporan-kerusakan')
                    ->maxSize(5120)
                    ->required(),
            ]);
    }
}
