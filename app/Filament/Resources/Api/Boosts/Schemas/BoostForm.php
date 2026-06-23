<?php

namespace App\Filament\Resources\Api\Boosts\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;
use Leandrocfe\FilamentPtbrFormFields\Money;

class BoostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->columnSpanFull()
                    ->columns()
                    ->schema([
                        TextInput::make('name')->label('Name')->required(),
                        TextArea::make('description')->label('Description')->required()->autosize()->columnSpanFull(),
                        TextInput::make('duration_in_hours')->label('Duration (in hours)')->required(),
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
                        Toggle::make('is_active')
                            ->label('Is Active')
                    ]),
                Fieldset::make('information')
                    ->hiddenOn('create')
                    ->label('Information')
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('users_active_count')
                            ->label('Users using this boost')
                            ->formatStateUsing(fn ($record) => $record?->usersActive?->count())
                            ->disabled()
                            ->dehydrated(false),
                    ])
            ]);
    }
}
