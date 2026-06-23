<?php

namespace App\Filament\Resources\Api\Users\Tables;

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
                    ->copyable()
                    ->sortable(query: function (Builder $query) {
                        return $query->orWhereHas('subscriptions.subscription', function (Builder $sortableQuery) {
                            $sortableQuery->orderBy('name');
                        });
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->orWhereHas('subscriptions.subscription', function (Builder $subscriptionQuery) use ($search) {
                            $subscriptionQuery->where('name', 'like', "%$search%");
                        });
                    }),
                TextColumn::make('activeBoost.name')
                    ->placeholder('N/A')
                    ->copyable()
                    ->sortable(query: function (Builder $query) {
                        return $query->orWhereHas('boosts.boost', function (Builder $sortableQuery) {
                            $sortableQuery->orderBy('name');
                        });
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->orWhereHas('boosts.boost', function (Builder $subscriptionQuery) use ($search) {
                            $subscriptionQuery->where('name', 'like', "%$search%");
                        });
                    }),
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
