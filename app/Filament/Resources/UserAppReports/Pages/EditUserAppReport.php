<?php

namespace App\Filament\Resources\UserAppReports\Pages;

use App\Filament\Resources\UserAppReports\UserAppReportResource;
use App\Models\Api\UserAppReport;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Support\Enums\IconPosition;

class EditUserAppReport extends EditRecord
{
    protected static string $resource = UserAppReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            Action::make('answer')
                ->icon('heroicon-s-envelope')
                ->iconPosition(IconPosition::After)
                ->label('Reply Report')
                ->disabled(fn (UserAppReport $record) => $record->isSolved())
                ->modal()
                ->schema([
                    Toggle::make('solved')
                        ->label('Problem was solved?'),
                    RichEditor::make('answer')
                        ->required()
                        ->label('Answer Report'),
                ])
                ->action(function (UserAppReport $record, array $data) {
                    $record->answer($data['answer'], $data['solved'] ?? false);

                    Notification::make()
                        ->title('Answer sent successfully!')
                        ->success()
                        ->send();
                }),
            Action::make('solve')
                ->icon('heroicon-s-check-circle')
                ->iconPosition(IconPosition::After)
                ->label('Mark as solved')
                ->requiresConfirmation()
                ->color('success')
                ->disabled(fn (UserAppReport $record) => $record->isNotPending())
                ->action(function (UserAppReport $record) {
                    $record->resolve(true);
                })
        ];
    }
}
