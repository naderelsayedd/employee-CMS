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
                ->description('All employees in the system')
                ->descriptionIcon('heroicon-m-users')
                ->url(route('filament.admin.resources.employees.index'))
                ->color('success'),

            Stat::make('Departments', Department::count())
                ->description('Total number of departments')
                ->descriptionIcon('heroicon-m-building-office')
                ->url(route('filament.admin.resources.departments.index'))
                ->color('primary'),

            Stat::make('Total Countries', Country::count())
                ->description('All Branch Countries')
                ->descriptionIcon('heroicon-m-flag')
                ->url(route('filament.admin.resources.countries.index'))
                ->color('grey')
        ];
    }

    public function getColumns(): int
    {
        return 2;
    }
}
