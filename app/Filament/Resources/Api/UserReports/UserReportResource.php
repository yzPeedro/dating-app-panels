<?php

namespace App\Filament\Resources\Api\UserReports;

use App\Filament\Resources\Api\UserReports\Pages\CreateUserReport;
use App\Filament\Resources\Api\UserReports\Pages\EditUserReport;
use App\Filament\Resources\Api\UserReports\Pages\ListUserReports;
use App\Filament\Resources\Api\UserReports\Schemas\UserReportForm;
use App\Filament\Resources\Api\UserReports\Tables\UserReportsTable;
use App\Models\Api\UserReport;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class UserReportResource extends Resource
{
    protected static ?string $model = UserReport::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Users;

    protected static string | UnitEnum | null $navigationGroup = 'Api';

    public static function table(Table $table): Table
    {
        return UserReportsTable::configure($table);
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
            'index' => ListUserReports::route('/'),
        ];
    }
}
