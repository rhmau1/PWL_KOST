<?php

namespace App\Filament\Admin\Resources\LaporanKerusakans\Pages;

use App\Filament\Admin\Resources\LaporanKerusakans\LaporanKerusakanResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditLaporanKerusakan extends EditRecord
{
    protected static string $resource = LaporanKerusakanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
