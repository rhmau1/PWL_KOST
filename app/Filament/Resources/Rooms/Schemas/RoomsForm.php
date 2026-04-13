<?php

namespace App\Filament\Resources\Rooms\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section as ComponentsSection;

class RoomsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([               
                        ComponentsSection::make('Room Information')
                            ->schema([
                                TextInput::make('nomor')
                                    ->label('Room Number')
                                    ->required()
                                    ->numeric(),

                                Select::make('jenis')
                                    ->label('Room Type')
                                    ->options([
                                        'reguler' => 'Reguler',
                                        'premium' => 'Premium',
                                        'vip' => 'VIP',
                                    ])
                                    ->required(),

                                TextInput::make('harga')
                                    ->label('Price')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->required(),

                                TextInput::make('ukuran')
                                    ->label('Size')
                                    ->numeric()
                                    ->suffix('m²')
                                    ->required(),
                            ]),

                        ComponentsSection::make('Details')
                            ->schema([
                                TagsInput::make('fasilitas')
                                    ->label('Facilities')
                                    ->required(),

                                Toggle::make('status')
                                    ->label('Available')
                                    ->default(true),

                                RichEditor::make('keterangan')
                                    ->label('Description')
                                    ->columnSpanFull(),
                            ])
                            ]);                   
    }
}