<?php

namespace App\Filament\Resources\Api\UserBlocks\Pages;

use App\Filament\Resources\Api\UserBlocks\UserBlockResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUserBlocks extends ListRecords
{
    protected static string $resource = UserBlockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
