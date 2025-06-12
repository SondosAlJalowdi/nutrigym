<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserWidget extends BaseWidget
{

    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->description('Tota number of registered users')
                ->chart([User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                    ->groupBy('date')
                    ->orderBy('date', 'asc')
                    ->pluck('count', 'date')])
                    ->color('primary')
                    ->descriptionIcon('heroicon-m-user-group', IconPosition::Before)
                    ->descriptionColor('primary')
                    ->chart([1,5,7,2,9,5,10,9]),
                    
                
        ];
    }
}
