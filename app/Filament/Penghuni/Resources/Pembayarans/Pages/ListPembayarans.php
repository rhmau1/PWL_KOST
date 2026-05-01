<?php

namespace App\Filament\Penghuni\Resources\Pembayarans\Pages;

use App\Filament\Penghuni\Resources\Pembayarans\PembayaranResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPembayarans extends ListRecords
{
    protected static string $resource = PembayaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
