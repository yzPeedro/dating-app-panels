<?php

namespace App\Filament\Widgets;

use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MonthlyRevenue extends ChartWidget
{
    protected ?string $heading = 'Monthly Revenue';

    public ?string $filter = 'this_year';

    protected int|string|array $columnSpan = 'full';

    protected ?string $maxHeight = '30rem';

    protected function getType(): string
    {
        return 'line';
    }

    /**
     * @return array|string[]
     */
    public function getShortMonths(): array
    {
        return array_map(
            fn($m) => Carbon::create(null, $m, 1)
                ->when($this->filter === 'last_year', fn($carbon) => $carbon->subYear())
                ->format('M/y'), range(1, 12)
        );
    }

    protected function getFilters(): ?array
    {
        return [
            'last_year' => 'Last year',
            'this_year' => 'This year',
        ];
    }

    protected function getOptions(): array|RawJs|null
    {
        return RawJs::make("
            {
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(context.parsed.y);
                                }
                                
                                return label;
                            }
                        }
                    }
                }
            }
        ");
    }

    protected function getData(): array
    {
        $shortMonths = $this->getShortMonths();

        $monthlyPurchasedBoosts = $this->getMonthlyPurchasedBoosts();
        $monthlyPurchasedSubscriptions = $this->getMonthlyPurchasedSubscriptions();

        return [
            'datasets' => [
                [
                    'label' => 'Amount spent on boosts',
                    'data' => $monthlyPurchasedBoosts->toArray(),
                    'borderColor' => '#f5c242',
                    'tension' => 0.3,
                ],
                [
                    'label' => 'Amount spent on subscriptions',
                    'data' => $monthlyPurchasedSubscriptions->toArray(),
                    'borderColor' => '#f55742',
                    'tension' => 0.3,
                ]
            ],
            'labels' => $shortMonths
        ];
    }

    private function getMonthlyPurchasedBoosts(): Collection
    {
        return DB::connection('api')->table('user_boosts')
            ->join('boosts', 'boosts.id', '=', 'user_boosts.boost_id')
            ->selectRaw("
                DATE_FORMAT(user_boosts.created_at, '%b') as short_month,
                DATE_FORMAT(user_boosts.created_at, '%Y-%m') as year_month_key,
                YEAR(user_boosts.created_at) as year_value,
                MONTH(user_boosts.created_at) as month_value,
                SUM(boosts.price_in_cents) as total
            ")
            ->groupByRaw("
                DATE_FORMAT(user_boosts.created_at, '%b'),
                DATE_FORMAT(user_boosts.created_at, '%Y-%m'),
                YEAR(user_boosts.created_at),
                MONTH(user_boosts.created_at)
            ")
            ->whereBetween('boosts.created_at', match ($this->filter) {
                'last_year' => [now()->subYear()->startOfYear(), now()->subYear()->endOfYear()],
                'this_year' => [now()->startOfYear(), now()->endOfYear()],
            })
            ->orderBy('year_value')
            ->orderBy('month_value')
            ->get()
            ->mapWithKeys(fn($item) => [
                "{$item->short_month}/" . substr($item->year_value, 2) => $item->total / 100,
            ]);
    }

    private function getMonthlyPurchasedSubscriptions()
    {
        return DB::connection('api')->table('user_subscriptions')
            ->join('subscriptions', 'subscriptions.id', '=', 'user_subscriptions.subscription_id')
            ->selectRaw("
                DATE_FORMAT(user_subscriptions.started_at, '%b') as short_month,
                DATE_FORMAT(user_subscriptions.started_at, '%Y-%m') as year_month_key,
                YEAR(user_subscriptions.started_at) as year_value,
                MONTH(user_subscriptions.started_at) as month_value,
                SUM(subscriptions.price_in_cents) as total
            ")
            ->whereBetween('user_subscriptions.started_at', match ($this->filter) {
                'last_year' => [now()->subYear()->startOfYear(), now()->subYear()->endOfYear()],
                'this_year' => [now()->startOfYear(), now()->endOfYear()],
            })
            ->groupByRaw("
                DATE_FORMAT(user_subscriptions.started_at, '%b'),
                DATE_FORMAT(user_subscriptions.started_at, '%Y-%m'),
                YEAR(user_subscriptions.started_at),
                MONTH(user_subscriptions.started_at)
            ")
            ->orderBy('year_value')
            ->orderBy('month_value')
            ->get()
            ->mapWithKeys(fn($item) => [
                "{$item->short_month}/" . substr($item->year_value, 2) => $item->total / 100,
            ]);
    }
}
