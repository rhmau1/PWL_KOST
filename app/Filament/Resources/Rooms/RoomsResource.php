<?php

namespace App\Filament\Resources\Rooms;

use App\Filament\Resources\Rooms\Pages\CreateRooms;
use App\Filament\Resources\Rooms\Pages\EditRooms;
use App\Filament\Resources\Rooms\Pages\ListRooms;
use App\Filament\Resources\Rooms\Schemas\RoomsForm;
use App\Filament\Resources\Rooms\Tables\RoomsTable;
use App\Models\Kamar;
use App\Models\Rooms;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoomsResource extends Resource
{
    protected static ?string $model = Kamar::class;
    protected static ?string $navigationLabel = 'Kamar';
    protected static ?string $modelLabel = 'Kamar';
    protected static ?string $pluralModelLabel = 'Kamar';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::RectangleStack;

    protected static ?string $recordTitleAttribute = 'nomor';

    public static function form(Schema $schema): Schema
    {
        return RoomsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RoomsTable::configure($table);
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
            'index' => ListRooms::route('/'),
            'create' => CreateRooms::route('/create'),
            'edit' => EditRooms::route('/{record}/edit'),
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
