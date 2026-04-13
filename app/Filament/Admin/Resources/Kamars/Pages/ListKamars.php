<?php

namespace App\Filament\Admin\Resources\Kamars\Pages;

use App\Filament\Admin\Resources\Kamars\KamarResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKamars extends ListRecords
{
    protected static string $resource = KamarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
