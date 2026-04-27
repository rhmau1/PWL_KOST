<?php

namespace App\Filament\Admin\Resources\Kamars\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class KamarsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nomor')
                    ->label('Room')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                ImageColumn::make('images')
                    ->label('Images')
                    ->circular()
                    ->stacked()
                    ->limit(3),

                BadgeColumn::make('jenis')
                    ->label('Type')
                    ->colors([
                        'primary' => 'reguler',
                        'warning' => 'premium',
                        'danger' => 'vip',
                    ]),

                TextColumn::make('harga')
                    ->label('Price')
                    ->money('IDR')
                    ->sortable(),

                BadgeColumn::make('tipe_penghuni')
                    ->label('For')
                    ->colors([
                        'info' => 'Putra',
                        'danger' => 'Putri',
                        'success' => 'Campur',
                    ]),

                BadgeColumn::make('is_available')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => $state ? 'Available' : 'Occupied')
                    ->colors([
                        'success' => true,
                        'danger' => false,
                    ]),
            ])
            ->filters([
                TrashedFilter::make(),

                SelectFilter::make('jenis')
                    ->options([
                        'reguler' => 'Reguler',
                        'premium' => 'Premium',
                        'vip' => 'VIP',
                    ]),

                SelectFilter::make('status')
                    ->options([
                        1 => 'Available',
                        0 => 'Occupied',
                    ]),
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
            ])
            ->defaultSort('nomor');
    }
}
