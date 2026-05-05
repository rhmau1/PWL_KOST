<?php

namespace App\Filament\Admin\Resources\LaporanKerusakans\Pages;

use App\Filament\Admin\Resources\LaporanKerusakans\LaporanKerusakanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLaporanKerusakans extends ListRecords
{
    protected static string $resource = LaporanKerusakanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
