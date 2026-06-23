<?php

namespace App\Filament\Resources\Api\UserMatches;

use App\Filament\Resources\Api\UserMatches\Pages\ListUserMatches;
use App\Filament\Resources\Api\UserMatches\Schemas\UserMatchForm;
use App\Filament\Resources\Api\UserMatches\Tables\UserMatchesTable;
use App\Models\Api\UserMatch;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class UserMatchResource extends Resource
{
    protected static ?string $model = UserMatch::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Users;

    protected static string | UnitEnum | null $navigationGroup = 'Api';

    public static function form(Schema $schema): Schema
    {
        return UserMatchForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserMatchesTable::configure($table);
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
            'index' => ListUserMatches::route('/'),
        ];
    }
}
