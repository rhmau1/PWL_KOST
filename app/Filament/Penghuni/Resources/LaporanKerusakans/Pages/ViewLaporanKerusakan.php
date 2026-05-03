<?php

namespace App\Filament\Penghuni\Resources\LaporanKerusakans\Pages;

use App\Filament\Penghuni\Resources\LaporanKerusakans\LaporanKerusakanResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLaporanKerusakan extends ViewRecord
{
    protected static string $resource = LaporanKerusakanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
