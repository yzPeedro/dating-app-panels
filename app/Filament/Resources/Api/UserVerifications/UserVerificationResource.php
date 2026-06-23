<?php

namespace App\Filament\Resources\Api\UserVerifications;

use App\Filament\Resources\Api\UserVerifications\Pages\ListUserVerifications;
use App\Filament\Resources\Api\UserVerifications\Schemas\UserVerificationForm;
use App\Filament\Resources\Api\UserVerifications\Tables\UserVerificationsTable;
use App\Models\Api\UserVerification;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class UserVerificationResource extends Resource
{
    protected static ?string $model = UserVerification::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Users;

    protected static ?string $label = 'Users Verifications';

    protected static ?string $recordTitleAttribute = 'user_id';

    protected static string | UnitEnum | null $navigationGroup = 'Api';

    public static function form(Schema $schema): Schema
    {
        return UserVerificationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserVerificationsTable::configure($table);
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
            'index' => ListUserVerifications::route('/'),
        ];
    }
}
