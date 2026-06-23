<?php

namespace App\Filament\Resources\Api\UserBlocks\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserBlockForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('target_user_id')
                    ->label('Target User')
                    ->relationship(name: 'targetUser', titleAttribute: 'name')
                    ->searchable()
                    ->different('user_id')
                    ->required(),

                Select::make('user_id')
                    ->label('Blocked By')
                    ->relationship(name: 'user', titleAttribute: 'name')
                    ->searchable()
                    ->different('target_user_id')
                    ->required(),
            ]);
    }
}
