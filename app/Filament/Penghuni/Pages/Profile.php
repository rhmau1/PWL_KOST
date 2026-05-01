<?php

namespace App\Filament\Penghuni\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class Profile extends Page
{
    protected string $view = 'filament.penghuni.pages.profile';
    protected static ?string $title = 'Profil Saya';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Profil Saya';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::User;
}

