<?php

namespace App\Filament\Admin\Resources\Kamars;

use App\Filament\Admin\Resources\Kamars\Pages\CreateKamar;
use App\Filament\Admin\Resources\Kamars\Pages\EditKamar;
use App\Filament\Admin\Resources\Kamars\Pages\ListKamars;
use App\Filament\Admin\Resources\Kamars\Pages\ViewKamar;
use App\Filament\Admin\Resources\Kamars\Schemas\KamarForm;
use App\Filament\Admin\Resources\Kamars\Schemas\KamarInfolist;
use App\Filament\Admin\Resources\Kamars\Tables\KamarsTable;
use App\Models\Kamar;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KamarResource extends Resource
{
    protected static ?string $model = Kamar::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nomor';

    public static function form(Schema $schema): Schema
    {
        return KamarForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return KamarInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KamarsTable::configure($table);
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
            'index' => ListKamars::route('/'),
            'create' => CreateKamar::route('/create'),
            'view' => ViewKamar::route('/{record}'),
            'edit' => EditKamar::route('/{record}/edit'),
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
