<?php

namespace App\Filament\Resources\UserAppReports\Schemas;

use App\Filament\Resources\Api\Users\UserResource;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class UserAppReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->disabled()
            ->components([
                Group::make()
                    ->columnSpanFull()
                    ->columns()
                    ->schema([
                        TextInput::make('id')
                            ->dehydrated(false),
                        Select::make('user_id')
                            ->relationship(name: 'user', titleAttribute: 'name')
                            ->suffixActions([
                                Action::make('open_user_page')
                                    ->url(fn ($record) => UserResource::getUrl('edit', [$record->user_id]))
                                    ->icon('heroicon-o-arrow-top-right-on-square')
                                    ->openUrlInNewTab()
                            ])
                            ->dehydrated(false),
                        TextInput::make('type')
                            ->label('Type')
                            ->dehydrated(false),
                        TextInput::make('status')
                            ->label('Status')
                            ->suffixIcon(fn ($record) => match ($record->status) {
                                'solved' => Heroicon::CheckCircle,
                                'pending' => Heroicon::XMark
                            })
                            ->suffixIconColor(fn ($record) => match ($record->status) {
                                'solved' => 'success',
                                'pending' => 'danger',
                            })
                            ->dehydrated(false),
                        TextInput::make('answered')
                            ->label('Answered')
                            ->suffixIcon(fn ($record) => match ($record->answered) {
                                true => Heroicon::CheckCircle,
                                false => Heroicon::XMark
                            })
                            ->suffixIconColor(fn ($record) => match ($record->answered) {
                                true => 'success',
                                false => 'danger',
                            })
                            ->formatStateUsing(fn ($state) => $state ? 'Yes' : 'No')
                            ->dehydrated(false),
                        DatePicker::make('validated_at')
                            ->label('Validated at')
                            ->dehydrated(false),
                        DatePicker::make('created_at')
                            ->label('Reported at')
                            ->dehydrated(false),
                        Textarea::make('reason')
                            ->label('Reason')
                            ->autosize()
                            ->columnSpanFull()
                            ->dehydrated(false),
                    ])
            ]);
    }
}
