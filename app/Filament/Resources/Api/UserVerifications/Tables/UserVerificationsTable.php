<?php

namespace App\Filament\Resources\Api\UserVerifications\Tables;

use App\Filament\Resources\Api\Users\UserResource;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Hugomyb\FilamentMediaAction\Actions\MediaAction;

class UserVerificationsTable
{

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->searchable()->sortable(),
                TextColumn::make('user.name')
                    ->label('User Name')
                    ->searchable()
                    ->url(fn ($record) => UserResource::getUrl('edit', [$record->user_id]))
                    ->openUrlInNewTab()
                    ->icon('heroicon-s-arrow-top-right-on-square'),
                TextColumn::make('status')
                    ->searchable()
                    ->sortable()
                    ->label('Status')
                    ->icon(fn (string $state): string => match ($state) {
                        'pending' => 'heroicon-m-exclamation-circle',
                        'approved' => 'heroicon-m-check-circle',
                        'rejected' => 'heroicon-m-no-symbol',
                        default => 'heroicon-m-question-mark-circle',
                    })->color(fn (string $state): string => match ($state) {
                        'pending' => 'yellow',
                        'approved' => 'green',
                        'rejected' => 'red',
                        default => 'gray',
                    }),
                TextColumn::make('rejection_reason')
                    ->label('Rejection Reason')
                    ->searchable()
                    ->sortable()
                    ->placeholder('N/A')
            ])
            ->filters([
                //
            ])
            ->recordActions([
                MediaAction::make()
                    ->iconButton()
                    ->icon('heroicon-m-play-circle')
                    ->tooltip('watch video')
                    ->media(fn ($record) => $record->video_path)
                    ->mediaType(MediaAction::TYPE_VIDEO)
                    ->disableDownload()
                    ->disableRemotePlayback()
                    ->preload(false),
                Action::make('approve')
                    ->iconButton()
                    ->icon('heroicon-s-check-circle')
                    ->tooltip('approve')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->approve();

                        Notification::make()
                            ->title('User verification rejected')
                            ->success()
                            ->send();
                    }),
                Action::make('reject')
                    ->iconButton()
                    ->tooltip('reject')
                    ->icon('heroicon-s-no-symbol')
                    ->color('danger')
                    ->schema([
                        Textarea::make('rejection_reason')
                            ->label('Reason')
                            ->rows(3)
                            ->required()
                    ])
                    ->action(function (array $data, $record) {
                        $record->reject($data['rejection_reason']);

                        Notification::make()
                            ->title('User verification rejected')
                            ->success()
                            ->send();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
