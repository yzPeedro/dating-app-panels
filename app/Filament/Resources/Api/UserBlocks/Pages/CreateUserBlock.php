<?php

namespace App\Filament\Resources\Api\UserBlocks\Pages;

use App\Filament\Resources\Api\UserBlocks\UserBlockResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUserBlock extends CreateRecord
{
    protected static string $resource = UserBlockResource::class;
}
