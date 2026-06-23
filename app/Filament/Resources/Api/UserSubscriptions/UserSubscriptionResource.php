<?php

namespace App\Filament\Resources\Api\UserSubscriptions;

use App\Filament\Resources\Api\UserSubscriptions\Pages\CreateUserSubscription;
use App\Filament\Resources\Api\UserSubscriptions\Pages\EditUserSubscription;
use App\Filament\Resources\Api\UserSubscriptions\Pages\ListUserSubscriptions;
use App\Filament\Resources\Api\UserSubscriptions\Schemas\UserSubscriptionForm;
use App\Filament\Resources\Api\UserSubscriptions\Tables\UserSubscriptionsTable;
use App\Models\Api\UserSubscription;
use BackedEnum;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class UserSubscriptionResource extends Resource
{
    protected static ?string $model = UserSubscription::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Users;

    protected static string | UnitEnum | null $navigationGroup = 'Api';

    public static function form(Schema $schema): Schema
    {
        return UserSubscriptionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserSubscriptionsTable::configure($table);
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
            'index' => ListUserSubscriptions::route('/'),
            'create' => CreateUserSubscription::route('/create'),
            'edit' => EditUserSubscription::route('/{record}/edit'),
        ];
    }
}
