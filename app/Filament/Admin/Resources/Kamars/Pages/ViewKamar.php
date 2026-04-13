<?php

namespace App\Filament\Admin\Resources\Kamars\Pages;

use App\Filament\Admin\Resources\Kamars\KamarResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewKamar extends ViewRecord
{
    protected static string $resource = KamarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
