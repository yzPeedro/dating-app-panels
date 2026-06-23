<?php

namespace App\Filament\Resources\Api\UserBoosts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;

class UserBoostsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->columnSpanFull()
                    ->columns()
                    ->schema([
                        Select::make('user_id')
                            ->relationship(name: 'user', titleAttribute: 'name')
                            ->searchable()
                            ->required(),
                        Select::make('boost_id')
                            ->relationship(name: 'boost', titleAttribute: 'name')
                            ->searchable()
                            ->required()
                            ->preload(),
                        DateTimePicker::make('created_at')
                            ->label('Started at')
                            ->required(),
                        DateTimePicker::make('expires_at')
                            ->label('Expires at')
                            ->after('created_at')
                            ->required(),
                    ])
            ]);
    }
}
