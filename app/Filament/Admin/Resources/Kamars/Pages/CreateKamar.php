<?php

namespace App\Filament\Admin\Resources\Kamars\Pages;

use App\Filament\Admin\Resources\Kamars\KamarResource;
use Filament\Resources\Pages\CreateRecord;

class CreateKamar extends CreateRecord
{
    protected static string $resource = KamarResource::class;

    protected function getFormActions(): array
    {
        return [];
    }
}
