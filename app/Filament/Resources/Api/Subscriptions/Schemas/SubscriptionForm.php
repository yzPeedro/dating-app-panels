<?php

namespace App\Filament\Resources\Api\Subscriptions\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;
use Leandrocfe\FilamentPtbrFormFields\Money;

class SubscriptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->columnSpanFull()
                            ->required()
                            ->maxLength(255),
                        TextArea::make('description')
                            ->columnSpanFull()
                            ->required()
                            ->autosize(),
                        Money::make('price_in_cents')
                            ->label('Price')
                            ->default(0.00)
                            ->prefix('R$')
                            ->formatStateUsing(fn (?int $state): ?string => $state ? number_format($state / 100, 2, ',', '') : null)
                            ->dehydrateStateUsing(function (?string $state): ?int {
                                if (!$state) return null;

                                $cleanNumber = str_replace(['.', ','], ['', '.'], $state);
                                return (int) round((float) $cleanNumber * 100);
                            }),
                        TextInput::make('duration_in_months')
                            ->label('Duration in months')
                            ->numeric()
                            ->minValue(1)
                            ->required(),
                        Toggle::make('is_active')
                            ->label('Active'),
                        KeyValue::make('features')
                            ->required(),
                        TextInput::make('provider')
                            ->columnSpanFull()
                            ->required()
                            ->maxLength(255),
                        TextInput::make('provider_product_id')
                            ->columnSpanFull()
                            ->required()
                            ->maxLength(255),
                    ]),
                Fieldset::make('information')
                    ->columnSpanFull()
                    ->label('Information')
                    ->schema([
                        TextInput::make('users_active_count')
                            ->label('Users using this subscription')
                            ->formatStateUsing(fn ($record) => $record->usersActive->count())
                            ->disabled()
                            ->dehydrated(false),
                    ])
            ]);
    }
}
