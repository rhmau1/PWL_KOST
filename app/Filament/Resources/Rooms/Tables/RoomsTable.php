<?php

namespace App\Filament\Resources\Rooms\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;

class RoomsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nomor')
                    ->label('Room')
                    ->searchable()
                    ->sortable(),

                BadgeColumn::make('jenis')
                    ->label('Type')
                    ->colors([
                        'primary' => 'reguler',
                        'warning' => 'premium',
                        'danger' => 'vip',
                    ])
                    ->sortable(),

                TextColumn::make('harga')
                    ->label('Price')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('ukuran')
                    ->label('Size')
                    ->suffix(' m²')
                    ->sortable(),

                TagsColumn::make('fasilitas')
                    ->label('Facilities'),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => $state ? 'Available' : 'Occupied')
                    ->colors([
                        'success' => true,
                        'danger' => false,
                    ]),

                TextColumn::make('deleted_at')
                    ->label('Deleted')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([
                TrashedFilter::make(),

                SelectFilter::make('jenis')
                    ->label('Type')
                    ->options([
                        'reguler' => 'Reguler',
                        'premium' => 'Premium',
                        'vip' => 'VIP',
                    ]),

                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        1 => 'Available',
                        0 => 'Occupied',
                    ]),
            ])

            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
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