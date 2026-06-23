<?php

namespace App\Filament\Resources\Api\UserLikes\Pages;

use App\Filament\Resources\Api\UserLikes\UserLikeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUserLike extends CreateRecord
{
    protected static string $resource = UserLikeResource::class;
}
