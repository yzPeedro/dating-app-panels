<?php

namespace App\Filament\Resources\Api\UserBlocks;

use App\Filament\Resources\Api\UserBlocks\Pages\CreateUserBlock;
use App\Filament\Resources\Api\UserBlocks\Pages\EditUserBlock;
use App\Filament\Resources\Api\UserBlocks\Pages\ListUserBlocks;
use App\Filament\Resources\Api\UserBlocks\Schemas\UserBlockForm;
use App\Filament\Resources\Api\UserBlocks\Tables\UserBlocksTable;
use App\Models\Api\UserBlock;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class UserBlockResource extends Resource
{
    protected static ?string $model = UserBlock::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Users;

    protected static string | UnitEnum | null $navigationGroup = 'Api';

    public static function form(Schema $schema): Schema
    {
        return UserBlockForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserBlocksTable::configure($table);
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
            'index' => ListUserBlocks::route('/'),
        ];
    }
}
