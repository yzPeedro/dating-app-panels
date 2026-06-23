<?php

namespace App\Filament\Resources\Api\UserSubscriptions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;

class UserSubscriptionForm
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
                        Select::make('subscription_id')
                            ->relationship(name: 'subscription', titleAttribute: 'name')
                            ->searchable()
                            ->required()
                            ->preload(),
                        DateTimePicker::make('started_at')
                            ->label('Started at')
                            ->required(),
                        DateTimePicker::make('expires_at')
                            ->label('Expires at')
                            ->after('started_at')
                            ->required(),
                    ])
            ]);
    }
}
