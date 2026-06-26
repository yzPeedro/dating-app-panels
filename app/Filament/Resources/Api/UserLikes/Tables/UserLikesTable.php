<?php

namespace App\Filament\Resources\Api\UserLikes\Tables;

use App\Filament\Resources\Api\Users\UserResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserLikesTable
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

                TextColumn::make('likedBy.name')
                    ->label('Liked By')
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => UserResource::getUrl('edit', [$record->liked_by]))
                    ->openUrlInNewTab()
                    ->icon('heroicon-s-arrow-top-right-on-square'),

                TextColumn::make('type')->label('Type')->searchable()->sortable(),
                TextColumn::make('created_at')->label('Interacted On')->dateTime('d/m/Y H:i:s')->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                DeleteAction::make()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
