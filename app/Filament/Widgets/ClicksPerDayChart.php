<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Click;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Schema;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\ChartWidget\Concerns\HasFiltersSchema;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

final class ClicksPerDayChart extends ChartWidget
{
    use HasFiltersSchema;

    protected static ?int $sort = 3;

    protected ?string $heading = 'Clicks per day';

    protected ?string $description = 'Number of clicks per day over a specified period.';

    public function filtersSchema(Schema $schema): Schema
    {
        return $schema->components([
            DatePicker::make('start_date')
                ->label('Start date')
                ->default(now()->subDays(7))
                ->required(),
            DatePicker::make('end_date')
                ->label('End date')
                ->default(now())
                ->required(),
        ]);
    }

    protected function getData(): array
    {
        $startDate = Carbon::parse($this->filters['start_date'].' 00:00:00');
        $endDate = Carbon::parse($this->filters['end_date'].' 23:59:59');

        $data = Trend::model(Click::class)
            ->between(
                start: $startDate,
                end: $endDate,
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => "Clicks from {$startDate->format('d/m')} to {$endDate->format('d/m')}",
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => Carbon::parse($value->date)->format('d/m')),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
