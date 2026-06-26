<?php

namespace App\Filament\Resources\Api\Users\Pages;

use App\Filament\Resources\Api\Users\UserResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Password;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    function refreshPage($record): void
    {
        $this->redirect($this->getUrl([$record]));
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),

            $this->record->status !== 'blocked'
                ? Action::make('block')
                ->label('Block User')
                ->icon('heroicon-m-no-symbol')
                ->color('danger')
                ->requiresConfirmation()
                ->action(function ($record) {
                    $record->status = 'blocked';
                    $record->save();

                    Notification::make()->title('User blocked with success')->success()->send();
                    $this->refreshPage($record);
                })
                : Action::make('activate')
                ->label('Activate User')
                ->icon('heroicon-m-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->action(function ($record) {
                    $record->status = 'active';
                    $record->save();

                    Notification::make()->title('User activated with success')->success()->send();
                    $this->refreshPage($record);
                }),

            Action::make('resetPassword')
                ->label('Send Reset Link')
                ->icon('heroicon-m-lock-closed')
                ->color('warning')
                ->requiresConfirmation()
                ->action(function ($record) {
                    ResetPassword::createUrlUsing(fn() => config('app.api.url') . '/api/reset-password');

                    $status = Password::broker('api-users')->sendResetLink(
                        ['email' => $record->email]
                    );

                    if ($status === Password::RESET_LINK_SENT) {
                        Notification::make()->title('Reset link sent successfully')->success()->send();
                    } else {
                        Notification::make()->title('Error sending reset link')->danger()->send();
                    }
                }),
        ];
    }
}
