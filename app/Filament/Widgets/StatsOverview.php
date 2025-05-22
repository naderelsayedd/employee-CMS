<?php

namespace App\Filament\Widgets;

use App\Models\Country;
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
                ->description('Total Employees In System')
                ->descriptionIcon('heroicon-m-user')
                ->color('primary')
                ->url(route('filament.admin.resources.employees.index')),


            Stat::make('Total Departments', Department::count())
                ->description('Total Departments')
                ->descriptionIcon('heroicon-m-building-office')
                ->url(route('filament.admin.resources.departments.index'))
                ->color('primary'),


            Stat::make('Hired Recently', Employee::where('date_hired', '>=', now()->subMonths(1))->count())
                ->description('Employees Hired Last Month')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('primary'),

        ];
    }

    public function getColumns(): int
    {
        return 3;
    }
}
