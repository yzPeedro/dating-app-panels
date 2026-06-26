<?php

namespace App\Filament\Resources\UserAppReports\Tables;

use App\Filament\Resources\Api\Users\UserResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserAppReportsTable
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
                TextColumn::make('status')
                    ->label('Status')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('answered')
                    ->label('Answered')
                    ->searchable()
                    ->sortable()
                    ->icon(fn (bool $state): Heroicon => match ($state) {
                        true => Heroicon::CheckCircle,
                        false => Heroicon::XMark
                    }),
                TextColumn::make('validated_at')
                    ->label('Validated At')
                    ->searchable()
                    ->sortable()
                    ->dateTime('d/m/Y H:i:s')
                    ->placeholder('N/A'),
                TextColumn::make('created_at')
                    ->label('Reported At')
                    ->searchable()
                    ->sortable()
                    ->dateTime('d/m/Y H:i:s'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
