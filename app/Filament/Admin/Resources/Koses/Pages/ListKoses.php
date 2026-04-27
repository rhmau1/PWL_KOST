<?php

namespace App\Filament\Admin\Resources\Koses\Pages;

use App\Filament\Admin\Resources\Koses\KosResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKoses extends ListRecords
{
    protected static string $resource = KosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
