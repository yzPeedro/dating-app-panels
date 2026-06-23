<?php

namespace App\Filament\Resources\Api\UserBoosts\Pages;

use App\Filament\Resources\Api\UserBoosts\UserBoostsResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUserBoosts extends EditRecord
{
    protected static string $resource = UserBoostsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
