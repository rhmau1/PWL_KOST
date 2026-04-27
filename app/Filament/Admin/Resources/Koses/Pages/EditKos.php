<?php

namespace App\Filament\Admin\Resources\Koses\Pages;

use App\Filament\Admin\Resources\Koses\KosResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKos extends EditRecord
{
    protected static string $resource = KosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
