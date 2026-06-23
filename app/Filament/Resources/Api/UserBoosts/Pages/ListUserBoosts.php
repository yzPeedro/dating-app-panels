<?php

namespace App\Filament\Resources\Api\UserBoosts\Pages;

use App\Filament\Resources\Api\UserBoosts\UserBoostsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUserBoosts extends ListRecords
{
    protected static string $resource = UserBoostsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
