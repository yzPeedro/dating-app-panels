<?php

namespace App\Filament\Resources\Api\UserMatches\Pages;

use App\Filament\Resources\Api\UserMatches\UserMatchResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUserMatch extends EditRecord
{
    protected static string $resource = UserMatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
