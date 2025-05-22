<?php

namespace App\Filament\Resources\DashboardResource\Widgets;

use App\Models\Employee;
use App\Models\Department;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Employees', Employee::count())
                ->description('All employees in the system')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),

            Stat::make('Departments', Department::count())
                ->description('Total number of departments')
                ->descriptionIcon('heroicon-m-building-office')
                ->color('primary'),

            Stat::make('Recently Hired', Employee::where('date_hired', '>=', now()->subMonths(3))->count())
                ->description('Employees hired in last 3 months')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('warning'),

        ];
    }
}
