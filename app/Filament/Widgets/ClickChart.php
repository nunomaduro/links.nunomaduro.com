<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Link;
use Filament\Widgets\ChartWidget;

final class ClickChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected ?string $heading = 'Clicks per link';

    protected ?string $description = 'Number of clicks per link, ordered by slug.';

    protected function getData(): array
    {
        $links = Link::query()
            ->withCount('clicks')
            ->orderBy('slug')
            ->pluck('clicks_count', 'slug');

        return [
            'datasets' => [[
                'label' => 'Clicks',
                'data' => $links->values(),
            ]],
            'labels' => $links->keys(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
