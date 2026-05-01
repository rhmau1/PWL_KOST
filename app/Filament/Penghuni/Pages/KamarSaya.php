<?php

namespace App\Filament\Penghuni\Pages;

use Filament\Pages\Page;
use BackedEnum;
use Filament\Support\Icons\Heroicon;

class KamarSaya extends Page
{
    protected string $view = 'filament.penghuni.pages.kamar-saya';
    protected static ?int $navigationSort = 2;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::CubeTransparent;
}
