<?php

namespace App\Filament\Penghuni\Resources\Pembayarans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PembayaransTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('kos_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('kamar_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('tipe')
                    ->badge(),
                TextColumn::make('jumlah')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('bukti_pembayaran')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('tanggal_bayar')
                    ->date()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
