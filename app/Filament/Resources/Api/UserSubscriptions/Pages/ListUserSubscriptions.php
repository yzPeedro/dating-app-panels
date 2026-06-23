<?php

namespace App\Filament\Resources\Api\UserSubscriptions\Pages;

use App\Filament\Resources\Api\UserSubscriptions\UserSubscriptionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUserSubscriptions extends ListRecords
{
    protected static string $resource = UserSubscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
