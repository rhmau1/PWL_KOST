<?php

namespace App\Filament\Penghuni\Resources\LaporanKerusakans;

use App\Filament\Penghuni\Resources\LaporanKerusakans\Pages\CreateLaporanKerusakan;
use App\Filament\Penghuni\Resources\LaporanKerusakans\Pages\EditLaporanKerusakan;
use App\Filament\Penghuni\Resources\LaporanKerusakans\Pages\ListLaporanKerusakans;
use App\Filament\Penghuni\Resources\LaporanKerusakans\Pages\ViewLaporanKerusakan;
use App\Filament\Penghuni\Resources\LaporanKerusakans\Schemas\LaporanKerusakanForm;
use App\Filament\Penghuni\Resources\LaporanKerusakans\Schemas\LaporanKerusakanInfolist;
use App\Filament\Penghuni\Resources\LaporanKerusakans\Tables\LaporanKerusakansTable;
use App\Models\LaporanKerusakan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LaporanKerusakanResource extends Resource
{
    protected static ?string $model = LaporanKerusakan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ExclamationTriangle;

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return LaporanKerusakanForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LaporanKerusakanInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LaporanKerusakansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLaporanKerusakans::route('/'),
            'create' => CreateLaporanKerusakan::route('/create'),
            'view' => ViewLaporanKerusakan::route('/{record}'),
            'edit' => EditLaporanKerusakan::route('/{record}/edit'),
        ];
    }
}
