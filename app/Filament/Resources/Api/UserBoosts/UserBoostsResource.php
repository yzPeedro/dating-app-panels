<?php

namespace App\Filament\Resources\Api\UserBoosts;

use App\Filament\Resources\Api\UserBoosts\Pages\CreateUserBoosts;
use App\Filament\Resources\Api\UserBoosts\Pages\EditUserBoosts;
use App\Filament\Resources\Api\UserBoosts\Pages\ListUserBoosts;
use App\Filament\Resources\Api\UserBoosts\Schemas\UserBoostsForm;
use App\Filament\Resources\Api\UserBoosts\Tables\UserBoostsTable;
use App\Models\Api\UserBoost;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class UserBoostsResource extends Resource
{
    protected static ?string $model = UserBoost::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Users;

    protected static string | UnitEnum | null $navigationGroup = 'Api';

    public static function form(Schema $schema): Schema
    {
        return UserBoostsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserBoostsTable::configure($table);
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
            'index' => ListUserBoosts::route('/'),
            'create' => CreateUserBoosts::route('/create'),
            'edit' => EditUserBoosts::route('/{record}/edit'),
        ];
    }
}
