<?php

namespace App\Filament\Resources\Api\UserSubscriptions\Pages;

use App\Filament\Resources\Api\UserSubscriptions\UserSubscriptionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUserSubscription extends CreateRecord
{
    protected static string $resource = UserSubscriptionResource::class;
}
