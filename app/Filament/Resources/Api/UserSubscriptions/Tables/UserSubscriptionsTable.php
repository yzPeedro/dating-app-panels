<?php

namespace App\Filament\Resources\Api\UserSubscriptions\Tables;

use App\Filament\Resources\Api\Subscriptions\SubscriptionResource;
use App\Filament\Resources\Api\Users\UserResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserSubscriptionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->searchable()->sortable(),
                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => UserResource::getUrl('edit', [$record->user_id]))
                    ->openUrlInNewTab()
                    ->icon('heroicon-s-arrow-top-right-on-square'),

                TextColumn::make('subscription.name')
                    ->label('Subscription')
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => SubscriptionResource::getUrl('edit', [$record->subscription_id]))
                    ->openUrlInNewTab()
                    ->icon('heroicon-s-arrow-top-right-on-square'),

                TextColumn::make('started_at')->label('Started at')->dateTime('d/m/Y H:i:s')->searchable()->sortable(),
                TextColumn::make('expires_at')->label('Expires at')->dateTime('d/m/Y H:i:s')->searchable()->sortable(),
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
