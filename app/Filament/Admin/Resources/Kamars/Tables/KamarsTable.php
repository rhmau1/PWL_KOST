<?php

namespace App\Filament\Admin\Resources\Kamars\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class KamarsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nomor')->label('Room')->searchable()->sortable(),
                BadgeColumn::make('jenis')->label('Type')
                    ->colors(['primary' => 'reguler', 'warning' => 'premium', 'danger' => 'vip']),
                TextColumn::make('harga')->label('Price')->money('IDR')->sortable(),
                TextColumn::make('ukuran')->label('Size')->suffix(' m²'),
                ImageColumn::make('images')->label('Images')->circular()->stacked()->limit(3),
                BadgeColumn::make('tipe_penghuni')->label('For')
                    ->colors(['info' => 'Putra', 'danger' => 'Putri', 'success' => 'Campur']),
                TextColumn::make('kapasitas')->label('Capacity')->suffix(' Orang')->toggleable(isToggledHiddenByDefault: true),
                TagsColumn::make('fasilitas')->label('Facilities'),
                BadgeColumn::make('status')->label('Status')
                    ->formatStateUsing(fn ($state) => $state ? 'Available' : 'Occupied')
                    ->colors(['success' => true, 'danger' => false]),
                IconColumn::make('is_furnished')->label('Furnished')->boolean()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')->label('Deleted')->dateTime()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
