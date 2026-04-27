<?php

namespace App\Filament\Admin\Resources\Koses;

use App\Filament\Admin\Resources\Koses\Pages;
use App\Filament\Admin\Resources\Koses\Schemas\KosForm;
use App\Filament\Admin\Resources\Koses\Tables\KosesTable;
use App\Models\Kos;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class KosResource extends Resource
{
    protected static ?string $model = Kos::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice;

    protected static ?string $navigationLabel = 'Kelola Kost';

    protected static ?string $modelLabel = 'Kost';

    protected static ?string $pluralModelLabel = 'Kost';

    public static function form(Schema $schema): Schema
    {
        return KosForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KosesTable::configure($table);
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
            'index' => Pages\ListKoses::route('/'),
            'create' => Pages\CreateKos::route('/create'),
            'edit' => Pages\EditKos::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', Auth::id());
    }
}
