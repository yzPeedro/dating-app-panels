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

    protected function getFormActions(): array
    {
        return [];
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            Action::make('answer')
                ->icon('heroicon-s-envelope')
                ->iconPosition(IconPosition::After)
                ->label('Reply Report')
                ->modal()
                ->schema([
                    Toggle::make('solved')
                        ->hidden($this->record->isSolved())
                        ->label('Problem was solved?'),
                    RichEditor::make('answer')
                        ->required()
                        ->label('Answer Report'),
                ])
                ->action(function (UserAppReport $record, array $data) {
                    $record->answer($data['answer'], $data['solved'] ?? null);

                    Notification::make()
                        ->title('Answer sent successfully!')
                        ->success()
                        ->send();
                }),
            Action::make('solve')
                ->unless($this->record->refresh()->isSolved(), function ($component) {
                    $component
                        ->icon('heroicon-s-check-circle')
                        ->label('Mark as solved')
                        ->color('success');
                })
                ->when($this->record->refresh()->isSolved(), function ($component) {
                    $component
                        ->icon('heroicon-s-exclamation-triangle')
                        ->label('Mark as pending')
                        ->color('gray');
                })
                ->iconPosition(IconPosition::After)
                ->requiresConfirmation()
                ->action(function (UserAppReport $record) {
                    $solved = $record->isSolved();

                    $record->resolve(!$solved);

                    Notification::make()
                        ->when(!$solved, function ($component) {
                            $component->title('Report marked as solved successfully!');
                        })
                        ->when($solved, function ($component) {
                            $component->title('Report marked as pending successfully!');
                        })
                        ->success()
                        ->send();

                    return redirect(request()->header('Referer'));
                })
        ];
    }
}
