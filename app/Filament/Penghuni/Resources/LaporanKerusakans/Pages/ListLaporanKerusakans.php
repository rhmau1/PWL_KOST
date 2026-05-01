<?php

namespace App\Filament\Penghuni\Resources\LaporanKerusakans\Pages;

use App\Filament\Penghuni\Resources\LaporanKerusakans\LaporanKerusakanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLaporanKerusakans extends ListRecords
{
    protected static string $resource = LaporanKerusakanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
