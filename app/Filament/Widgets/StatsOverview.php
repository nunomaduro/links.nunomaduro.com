<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Click;
use App\Models\Link;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

final class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected int|array|null $columns = 2;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Links', Link::count())
                ->icon(Heroicon::OutlinedGlobeAlt),
            Stat::make('Total Clicks', Click::count())
                ->icon(Heroicon::OutlinedArrowTrendingUp),
        ];
    }
}
