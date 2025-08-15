<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Link;
use Filament\Widgets\ChartWidget;

final class ClickChart extends ChartWidget
{
    protected ?string $heading = 'Click Chart';

    protected function getData(): array
    {
        return [
            'datasets' => [[
                'label' => 'Clicks',
                'data' => Link::query()->orderBy('slug')->get()->map(fn (Link $link) => $link->clicks()->count())->toArray(),
                'backgroundColor' => '#36A2EB',
                'borderColor' => '#9BD0F5',
            ]],
            'labels' => Link::query()->orderBy('slug')->pluck('slug')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
