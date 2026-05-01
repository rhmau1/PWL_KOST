<?php

namespace App\Filament\Penghuni\Resources\LaporanKerusakans\Pages;

use App\Filament\Penghuni\Resources\LaporanKerusakans\LaporanKerusakanResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditLaporanKerusakan extends EditRecord
{
    protected static string $resource = LaporanKerusakanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
