<?php

namespace App\Filament\Resources\Api\UserLikes\Pages;

use App\Filament\Resources\Api\UserLikes\UserLikeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUserLike extends EditRecord
{
    protected static string $resource = UserLikeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
