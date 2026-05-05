<?php

namespace App\Filament\Admin\Resources\Koses\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KosForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kost')
                    ->description('Detail informasi tentang properti kost Anda')
                    ->icon('heroicon-o-home-modern')
                    ->schema([
                        TextInput::make('nama_kos')
                            ->label('Nama Kost')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Kost Putri Melati'),

                        Textarea::make('alamat')
                            ->label('Alamat Lengkap')
                            ->required()
                            ->rows(3)
                            ->placeholder("Masukkan alamat lengkap properti kost...\nLink Gmaps: https://maps.app.goo.gl/...")
                            ->helperText('Wajib menyertakan link Google Maps dari lokasi kost.')
                            ->rules([
                                fn (): \Closure => function (string $attribute, $value, \Closure $fail) {
                                    if (! preg_match('/(maps\.app\.goo\.gl|goo\.gl\/maps|maps\.google\.com|google\.com\/maps)/i', (string) $value)) {
                                        $fail('Alamat wajib menyertakan link Google Maps (contoh: https://maps.app.goo.gl/...).');
                                    }
                                },
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
