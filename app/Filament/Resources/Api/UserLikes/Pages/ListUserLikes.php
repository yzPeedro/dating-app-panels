<?php

namespace App\Filament\Resources\Api\UserLikes\Pages;

use App\Filament\Resources\Api\UserLikes\UserLikeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUserLikes extends ListRecords
{
    protected static string $resource = UserLikeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
