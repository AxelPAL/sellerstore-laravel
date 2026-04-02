<?php

namespace App\Filament\Widgets;

use App\Models\Sale;
use Carbon\CarbonImmutable;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SalesOverviewWidget extends StatsOverviewWidget
{
    protected ?string $heading = 'Sales';
    protected ?string $description = 'Non-bot sales';

    /**
     * @return array<Stat>
     */
    protected function getCards(): array
    {
        // Use immutable timestamps to avoid accidental mutation between queries.
        $now = CarbonImmutable::now();

        $todayStart = $now->startOfDay();
        $weekStart = $now->startOfWeek();
        $monthStart = $now->startOfMonth();

        $baseQuery = Sale::query()->where('is_bot', 0);

        $todayCount = $baseQuery
            ->clone()
            ->where('created_at', '>=', $todayStart)
            ->where('created_at', '<', $now)
            ->count();

        $weekCount = $baseQuery
            ->clone()
            ->where('created_at', '>=', $weekStart)
            ->where('created_at', '<', $now)
            ->count();

        $monthCount = $baseQuery
            ->clone()
            ->where('created_at', '>=', $monthStart)
            ->where('created_at', '<', $now)
            ->count();

        return [
            Stat::make('Today', $todayCount)
                ->icon('heroicon-o-clock')
                ->color('success'),
            Stat::make('This week', $weekCount)
                ->icon('heroicon-o-calendar-days')
                ->color('primary'),
            Stat::make('This month', $monthCount)
                ->icon('heroicon-o-calendar')
                ->color('warning'),
        ];
    }
}
