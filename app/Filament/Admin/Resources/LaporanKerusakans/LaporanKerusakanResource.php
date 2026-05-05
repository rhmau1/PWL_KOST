<?php

namespace App\Filament\Admin\Resources\LaporanKerusakans;

use App\Filament\Admin\Resources\LaporanKerusakans\Pages\CreateLaporanKerusakan;
use App\Filament\Admin\Resources\LaporanKerusakans\Pages\EditLaporanKerusakan;
use App\Filament\Admin\Resources\LaporanKerusakans\Pages\ListLaporanKerusakans;
use App\Filament\Admin\Resources\LaporanKerusakans\Schemas\LaporanKerusakanForm;
use App\Filament\Admin\Resources\LaporanKerusakans\Tables\LaporanKerusakansTable;
use App\Models\LaporanKerusakan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LaporanKerusakanResource extends Resource
{
    protected static ?string $model = LaporanKerusakan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return LaporanKerusakanForm::configure($schema);
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
            'edit' => EditLaporanKerusakan::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
