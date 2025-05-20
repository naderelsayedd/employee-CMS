<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class TrashEmployees extends ListRecords
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Back to Employees')
                ->icon('heroicon-o-arrow-left')
                ->url(fn() => route('filament.admin.resources.employees.index')),
        ];
    }

    protected function getTableQuery(): ?Builder
    {
        return parent::getTableQuery()->onlyTrashed();
    }

    public function getTitle(): string
    {
        return 'Trashed Employees';
    }
}
