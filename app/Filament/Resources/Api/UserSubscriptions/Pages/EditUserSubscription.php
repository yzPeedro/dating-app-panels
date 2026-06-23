<?php

namespace App\Filament\Resources\Api\UserSubscriptions\Pages;

use App\Filament\Resources\Api\UserSubscriptions\UserSubscriptionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUserSubscription extends EditRecord
{
    protected static string $resource = UserSubscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
