<?php

namespace App\Livewire;

use App\Enums\UserStatus;
use App\Models\Api\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;

class ActiveUsers extends StatsOverviewWidget
{

    protected int | string | array $columnSpan = 'full';

    public function getActiveUserQuery(): Builder
    {
        return User::query()->where('status', '=', UserStatus::ACTIVE);
    }

    protected function getStats(): array
    {
        $activeUsers = $this->getActiveUserQuery();

        $activeSubscriptions = $this->getActiveUserQuery()
            ->whereHas('subscriptions', function (Builder $query) {
                $query->where('expires_at', '>=', now());
            })
            ->whereHas('subscriptions.subscription', function (Builder $query) {
                $query->where('is_active', '=', true);
            });

        $activeBoosts = $this->getActiveUserQuery()
            ->whereHas('boosts', function (Builder $query) {
                $query->where('expires_at', '>=', now());
            })
            ->whereHas('boosts.boost', function (Builder $query) {
                $query->where('is_active', '=', true);
            });

        return [
            Stat::make('Total Active Users', $activeUsers->count())
                ->description('Total of active users on app')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Total Active Subscriptions', $activeSubscriptions->count())
                ->description('Total of active users with subscriptions on app')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Total Active Boosts', $activeBoosts->count())
                ->description('Total of active users with boosts on app')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
        ];
    }
}
