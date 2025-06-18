<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class UserChartWidget extends ChartWidget
{
    protected static ?int $sort = 4;
    use InteractsWithPageFilters;

    protected static ?string $heading = 'User Chart';

    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $start = $this->filters['start_date'];
        $end = $this->filters['end_date'];


        $data = Trend::model(User::class)
        ->between(
            start: $start ? Carbon::parse($start) : now()->subMonth(6),
            end: $end ? Carbon::parse($end) :  now(),
        )
        ->perMonth()
        ->count();


        return [
            

        'datasets' => [
                [
                    'label' => 'Total Users',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' =>  $data->map(fn (TrendValue $value) => $value->date),
        
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    
}
