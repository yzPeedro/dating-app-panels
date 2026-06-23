<?php

namespace App\Filament\Resources\Api\UserMatches\Pages;

use App\Filament\Resources\Api\UserMatches\UserMatchResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUserMatch extends CreateRecord
{
    protected static string $resource = UserMatchResource::class;
}
