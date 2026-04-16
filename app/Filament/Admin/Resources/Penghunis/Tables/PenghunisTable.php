<?php

namespace App\Filament\Admin\Resources\Penghunis\Tables;

use App\Models\Pembayaran;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Placeholder;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class PenghunisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')->searchable(),
                TextColumn::make('no_hp'),
                TextColumn::make('tanggal_masuk')->date(),
                IconColumn::make('is_verified')
                    ->label('Status')
                    ->getStateUsing(fn ($record) => $record->kos_id !== null)
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-clock')
                    ->trueColor('success')
                    ->falseColor('warning'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('verifikasi')
                    ->label('Verifikasi')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => is_null($record->kos_id))
                    ->modalHeading('Verifikasi Pembayaran Penghuni')
                    ->modalDescription('Silakan cek detail kamar dan bukti transfer di bawah ini sebelum menyetujui akun penghuni.')
                    ->form([
                        Placeholder::make('detail')
                            ->label('Detail Booking')
                            ->content(function ($record) {
                                $pembayaran = Pembayaran::with('kamar')->where('user_id', $record->user_id)->where('status', 'pending')->first();
                                if (! $pembayaran) {
                                    return 'Tidak ada data.';
                                }
                                $kamarNomor = $pembayaran->kamar ? $pembayaran->kamar->nomor : '-';

                                return new HtmlString("Kamar: <strong>{$kamarNomor}</strong><br>Tipe: <strong>{$pembayaran->tipe}</strong><br>Jumlah: <strong>Rp ".number_format($pembayaran->jumlah, 0, ',', '.').'</strong>');
                            }),
                        Placeholder::make('bukti_pembayaran')
                            ->label('Bukti Pembayaran')
                            ->content(function ($record) {
                                $pembayaran = Pembayaran::where('user_id', $record->user_id)->where('status', 'pending')->first();
                                if ($pembayaran && $pembayaran->bukti_pembayaran) {
                                    $url = asset('storage/'.$pembayaran->bukti_pembayaran);

                                    return new HtmlString('<img src="'.$url.'" alt="Bukti Transfer" style="width: 100%; max-width: 400px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);" />');
                                }

                                return 'Tidak ada bukti pembayaran.';
                            }),
                    ])
                    ->action(function ($record) {
                        $pembayaran = Pembayaran::where('user_id', $record->user_id)
                            ->where('status', 'pending')
                            ->first();

                        if ($pembayaran) {
                            $record->update([
                                'kos_id' => $pembayaran->kos_id,
                                'tanggal_masuk' => now(),
                            ]);

                            $pembayaran->update([
                                'status' => 'verified',
                            ]);

                            Notification::make()
                                ->title('Penghuni berhasil diverifikasi.')
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Data pembayaran tidak ditemukan.')
                                ->danger()
                                ->send();
                        }
                    }),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
