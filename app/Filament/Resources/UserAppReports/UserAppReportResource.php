<?php

namespace App\Filament\Resources\UserAppReports;

use App\Filament\Resources\UserAppReports\Pages\CreateUserAppReport;
use App\Filament\Resources\UserAppReports\Pages\EditUserAppReport;
use App\Filament\Resources\UserAppReports\Pages\ListUserAppReports;
use App\Filament\Resources\UserAppReports\Schemas\UserAppReportForm;
use App\Filament\Resources\UserAppReports\Tables\UserAppReportsTable;
use App\Models\Api\UserAppReport;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class UserAppReportResource extends Resource
{
    protected static ?string $model = UserAppReport::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Flag;

    protected static string | UnitEnum | null $navigationGroup = 'Api';

    public static function form(Schema $schema): Schema
    {
        return UserAppReportForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserAppReportsTable::configure($table);
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
            'index' => ListUserAppReports::route('/'),
            'edit' => EditUserAppReport::route('/{record}/edit'),
        ];
    }
}
