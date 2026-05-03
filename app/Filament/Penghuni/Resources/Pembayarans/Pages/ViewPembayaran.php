<?php

namespace App\Filament\Penghuni\Resources\Pembayarans\Pages;

use App\Filament\Penghuni\Resources\Pembayarans\PembayaranResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPembayaran extends ViewRecord
{
    protected static string $resource = PembayaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
