<?php

namespace App\Filament\Resources\UserAppReports\Pages;

use App\Filament\Resources\UserAppReports\UserAppReportResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUserAppReports extends ListRecords
{
    protected static string $resource = UserAppReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
