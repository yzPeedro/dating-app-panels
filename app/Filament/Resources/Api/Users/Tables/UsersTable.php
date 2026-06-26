<?php

namespace App\Filament\Resources\Api\Users\Tables;

use App\Filament\Resources\Api\Boosts\BoostResource;
use App\Filament\Resources\Api\Subscriptions\SubscriptionResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable()
                    ->copyable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('activeSubscription.name')
                    ->placeholder('N/A')
                    ->sortable(query: function (Builder $query) {
                        return $query->orWhereHas('subscriptions.subscription', function (Builder $sortableQuery) {
                            $sortableQuery->orderBy('name');
                        });
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->orWhereHas('subscriptions.subscription', function (Builder $subscriptionQuery) use ($search) {
                            $subscriptionQuery->where('name', 'like', "%$search%");
                        });
                    })
                    ->url(function ($record) {
                        if(! $record->activeSubscription) {
                            return null;
                        }

                        return SubscriptionResource::getUrl('edit', [$record->activeSubscription->id]);
                    })
                    ->openUrlInNewTab()
                    ->icon('heroicon-s-arrow-top-right-on-square'),

                TextColumn::make('activeBoost.name')
                    ->placeholder('N/A')
                    ->sortable(query: function (Builder $query) {
                        return $query->orWhereHas('boosts.boost', function (Builder $sortableQuery) {
                            $sortableQuery->orderBy('name');
                        });
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->orWhereHas('boosts.boost', function (Builder $subscriptionQuery) use ($search) {
                            $subscriptionQuery->where('name', 'like', "%$search%");
                        });
                    })
                    ->url(function ($record) {
                        if(! $record->activeBoost) {
                            return null;
                        }

                        return BoostResource::getUrl('edit', [$record->activeBoost->id]);
                    })
                    ->openUrlInNewTab()
                    ->icon('heroicon-s-arrow-top-right-on-square'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
