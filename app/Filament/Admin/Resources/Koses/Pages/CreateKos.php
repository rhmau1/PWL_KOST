<?php

namespace App\Filament\Admin\Resources\Koses\Pages;

use App\Filament\Admin\Resources\Koses\KosResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateKos extends CreateRecord
{
    protected static string $resource = KosResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
