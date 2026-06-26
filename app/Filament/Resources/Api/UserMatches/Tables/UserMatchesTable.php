<?php

namespace App\Filament\Resources\Api\UserMatches\Tables;

use App\Filament\Resources\Api\Users\UserResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserMatchesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->searchable()->sortable(),

                TextColumn::make('firstUser.name')->label('User')
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => UserResource::getUrl('edit', [$record->first_user]))
                    ->openUrlInNewTab()
                    ->icon('heroicon-s-arrow-top-right-on-square'),

                TextColumn::make('secondUser.name')->label('Matched With')
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => UserResource::getUrl('edit', [$record->second_user]))
                    ->openUrlInNewTab()
                    ->icon('heroicon-s-arrow-top-right-on-square'),

                TextColumn::make('created_at')
                    ->label('Matched At')
                    ->dateTime('d/m/Y H:i:s')
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
