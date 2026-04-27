<?php

namespace App\Filament\Admin\Resources\Penghunis\Tables;

use App\Models\Kamar;
use App\Models\Pembayaran;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
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
                TextColumn::make('user.email')->label('Email'),
                // TextColumn::make('user.pembayarans.status')->label('Status'),
                IconColumn::make('payment_status')
                    ->label('Status')
                    ->getStateUsing(fn ($record) => match(true) {
                        $record->kos_id !== null => 'verified',
                        $record->user->pembayarans->where('status', 'rejected')->isNotEmpty() => 'rejected',
                        default => 'pending',
                    })
                    ->icon(fn ($state) => match($state) {
                        'verified' => 'heroicon-o-check-badge',
                        'rejected' => 'heroicon-o-x-circle',
                        default => 'heroicon-o-clock',
                    })
                    ->color(fn ($state) => match($state) {
                        'verified' => 'success',
                        'rejected' => 'danger',
                        default => 'warning',
                    }),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('verifikasi')
                    ->label('Verifikasi')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => is_null($record->kos_id) && $record->user->pembayarans->where('status', 'pending')->isNotEmpty())
                    ->modalHeading('Verifikasi Pembayaran Penghuni')
                    ->modalDescription('Silakan cek detail kamar dan bukti transfer di bawah ini sebelum menyetujui akun penghuni.')
                    ->form([
                        Placeholder::make('detail')
                            ->label('Detail Booking')
                            ->content(function ($record) {
                                $pembayaran = $record->user->pembayarans->where('status', 'pending')->first();
                                if (! $pembayaran) {
                                    return 'Tidak ada data.';
                                }
                                $kamarNomor = $pembayaran->kamar ? $pembayaran->kamar->nomor : '-';

                                return new HtmlString("Kamar: <strong>{$kamarNomor}</strong><br>Tipe: <strong>{$pembayaran->tipe}</strong><br>Jumlah: <strong>Rp ".number_format($pembayaran->jumlah, 0, ',', '.').'</strong>');
                            }),
                        Placeholder::make('bukti_pembayaran')
                            ->label('Bukti Pembayaran')
                            ->content(function ($record) {
                                $pembayaran = $record->user->pembayarans->where('status', 'pending')->first();
                                if ($pembayaran && $pembayaran->bukti_pembayaran) {
                                    $url = asset('storage/'.$pembayaran->bukti_pembayaran);

                                    return new HtmlString('<img src="'.$url.'" alt="Bukti Transfer" style="width: 100%; max-width: 400px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);" />');
                                }

                                return 'Tidak ada bukti pembayaran.';
                            }),
                        Textarea::make('catatan')
                            ->label('Catatan (Opsional)')
                            ->placeholder('Alasan penolakan atau catatan tambahan...')
                            ->rows(3),
                    ])
                    ->extraModalActions([
                        Action::make('tolak')
                            ->label('Tolak')
                            ->color('danger')
                            ->icon('heroicon-o-x-circle')
                            ->requiresConfirmation()
                            ->modalHeading('Tolak Pembayaran')
                            ->modalDescription('Apakah Anda yakin ingin menolak pembayaran ini? Status pembayaran akan berubah menjadi Rejected.')
                            ->action(function ($record, array $data) {
                                $pembayaran = Pembayaran::where('user_id', $record->user_id)
                                    ->where('status', 'pending')
                                    ->first();

                                if ($pembayaran) {
                                    $pembayaran->update([
                                        'status' => 'rejected',
                                        'catatan' => $data['catatan'] ?? 'Pembayaran ditolak oleh admin.',
                                    ]);

                                    Notification::make()
                                        ->title('Pembayaran berhasil ditolak.')
                                        ->danger()
                                        ->send();
                                }
                            }),
                    ])
                    ->action(function ($record, array $data) {
                        $pembayaran = $record->user->pembayarans->where('status', 'pending')->first();

                        if ($pembayaran) {
                            $record->update([
                                'kos_id' => $pembayaran->kos_id,
                                'tanggal_masuk' => now(),
                            ]);

                            $pembayaran->update([
                                'status' => 'verified',
                                'catatan' => $data['catatan'] ?? $pembayaran->catatan,
                            ]);

                            // Update kamar status to occupied
                            Kamar::where('id', $pembayaran->kamar_id)->update(['is_available' => false]);

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
