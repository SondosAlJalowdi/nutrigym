<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\Subscription;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class SubsciptionChartWidget extends ChartWidget
{
    protected static ?int $sort = 4;

    protected static ?string $heading = 'subscription Chart';

    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $data = Trend::model(Subscription::class)
        ->between(
            start: now()->startOfMonth(),
            end: now()->endOfMonth(),
        )
        ->perDay()
        ->count();
        return [
            'datasets' => [
                [
                    'label' => 'Total Subscriptions',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),



                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
