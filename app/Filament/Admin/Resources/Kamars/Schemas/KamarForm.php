<?php

namespace App\Filament\Admin\Resources\Kamars\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;

class KamarForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Room Information')
                    ->schema([
                        TextInput::make('nomor')->required()->numeric(),
                        Select::make('jenis')->options(['reguler' => 'Reguler', 'premium' => 'Premium', 'vip' => 'VIP'])->required(),
                        TextInput::make('harga')->numeric()->prefix('Rp')->required(),
                        TextInput::make('ukuran')->numeric()->suffix('m²')->required(),
                        Select::make('tipe_penghuni')->options(['Putra' => 'Putra', 'Putri' => 'Putri', 'Campur' => 'Campur'])->default('Campur')->required(),
                        TextInput::make('kapasitas')->numeric()->default(1)->required(),
                    ])->columns(2),
                
                Section::make('Details & Facilities')
                    ->schema([
                        TagsInput::make('fasilitas')->required(),
                        Toggle::make('status')->label('Available')->default(true),
                        Toggle::make('is_furnished')->label('Furnished')->default(false),
                    ])->columns(2),

                Section::make('Media & Extra Information')
                    ->schema([
                        FileUpload::make('images')->image()->multiple()->directory('room-images')->columnSpanFull(),
                        RichEditor::make('keterangan')->columnSpanFull(),
                        Textarea::make('aturan_khusus')->columnSpanFull(),
                    ])
            ]);
    }
}
