<?php

namespace App\Filament\Resources\Api\UserLikes;

use App\Filament\Resources\Api\UserLikes\Pages\CreateUserLike;
use App\Filament\Resources\Api\UserLikes\Pages\EditUserLike;
use App\Filament\Resources\Api\UserLikes\Pages\ListUserLikes;
use App\Filament\Resources\Api\UserLikes\Schemas\UserLikeForm;
use App\Filament\Resources\Api\UserLikes\Tables\UserLikesTable;
use App\Models\Api\UserLike;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class UserLikeResource extends Resource
{
    protected static ?string $model = UserLike::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Users;

    protected static string | UnitEnum | null $navigationGroup = 'Api';

    protected static ?string $label = 'User Interactions';

    public static function form(Schema $schema): Schema
    {
        return UserLikeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserLikesTable::configure($table);
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
            'index' => ListUserLikes::route('/'),
        ];
    }
}
