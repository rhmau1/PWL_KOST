<?php

namespace App\Filament\Admin\Resources\Kamars\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KamarInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Room Information')
                    ->schema([
                        TextEntry::make('nomor')->label('Room Number')->badge(),
                        TextEntry::make('jenis')->label('Room Type')->badge(),
                        TextEntry::make('harga')->label('Price')->money('IDR'),
                        TextEntry::make('ukuran')->label('Size')->suffix(' m²'),
                        TextEntry::make('tipe_penghuni')->label('Occupant Type')->badge(),
                        TextEntry::make('kapasitas')->label('Capacity')->suffix(' Orang'),
                    ])->columns(2),

                Section::make('Details & Facilities')
                    ->schema([
                        TextEntry::make('fasilitas')->label('Facilities')->badge(),
                        IconEntry::make('status')->label('Available')->boolean(),
                        IconEntry::make('is_furnished')->label('Furnished')->boolean(),
                        TextEntry::make('keterangan')->label('Description')->html()->columnSpanFull(),
                        TextEntry::make('aturan_khusus')->label('Special Rules')->columnSpanFull(),
                    ])->columns(2),

                Section::make('Media')
                    ->schema([
                        ImageEntry::make('images')->label('Room Images')->columnSpanFull(),
                    ]),
            ]);
    }
}
