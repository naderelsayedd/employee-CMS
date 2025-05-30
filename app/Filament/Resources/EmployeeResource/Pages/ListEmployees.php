<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListEmployees extends ListRecords
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('trash')
                ->label('Trash')
                ->icon('heroicon-o-trash')
                ->url(fn() => route('filament.admin.resources.employees.trash')),
        ];
    }

    protected function getTableQuery(): ?Builder
    {
        return parent::getTableQuery()->withoutTrashed();
    }
}
