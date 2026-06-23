<?php

namespace App\Filament\Resources\Api\UserBlocks\Pages;

use App\Filament\Resources\Api\UserBlocks\UserBlockResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUserBlock extends EditRecord
{
    protected static string $resource = UserBlockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
