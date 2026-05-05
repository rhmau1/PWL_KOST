<?php

namespace App\Filament\Admin\Resources\LaporanKerusakans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Tables\Table;

class LaporanKerusakansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('penghuni.nama')->label('Penghuni')->searchable(),
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
                TrashedFilter::make(),
            ])
            ->recordActions([
                Action::make('updateStatus')
                    ->label('Ubah Status')
                    ->icon('heroicon-o-arrow-path')
                    ->color('info')
                    ->modalHeading('Update Status Laporan')
                    ->modalDescription('Silakan pilih status terbaru untuk laporan kerusakan ini.')
                    ->form([
                        Select::make('status')
                            ->label('Status Laporan')
                            ->options([
                                'pending' => 'Pending',
                                'diproses' => 'Diproses',
                                'selesai' => 'Selesai',
                            ])
                            ->required()
                            ->default(fn ($record) => $record->status),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update(['status' => $data['status']]);
                        
                        Notification::make()
                            ->title('Status laporan berhasil diperbarui.')
                            ->success()
                            ->send();
                    }),
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
