<?php

namespace App\Filament\Resources\Api\UserMatches\Pages;

use App\Filament\Resources\Api\UserMatches\UserMatchResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUserMatches extends ListRecords
{
    protected static string $resource = UserMatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
