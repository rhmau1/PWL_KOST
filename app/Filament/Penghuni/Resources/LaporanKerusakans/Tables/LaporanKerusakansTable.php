<?php

namespace App\Filament\Penghuni\Resources\LaporanKerusakans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;

class LaporanKerusakansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kamar.nomor')->label('Kamar')->searchable(),
                TextColumn::make('jenis_kerusakan')->searchable(),
                TextColumn::make('detail_kerusakan')->limit(50),
                ImageColumn::make('foto_bukti')->label('Foto'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'diproses' => 'info',
                        'selesai' => 'success',
                        default => 'secondary',
                    }),
                TextColumn::make('created_at')
                    ->label('Tanggal Lapor')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
