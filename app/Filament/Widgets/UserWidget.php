<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Appointment;
use App\Models\Subscription;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class UserWidget extends BaseWidget
{
    protected static ?int $sort = 3;
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
            Stat::make('Appointments', Appointment::count())
                ->description('Total number of appointments made')
                ->color('info')
                ->descriptionIcon('heroicon-m-arrow-trending-up', IconPosition::Before) 
                ->descriptionColor('info')
                ->chart([2,3,5,1,4,6,8,3]),
            Stat::make('Subscription', Subscription::count())
                ->description('Total number of users with subscriptions')
                ->color('success')
                ->descriptionColor('success')
                ->descriptionIcon('heroicon-m-currency-dollar', IconPosition::Before)
                ->chart([3,2,4,1,5,6,2,8]),


        ];
    }
}
