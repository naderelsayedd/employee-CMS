<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Employee;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Livewire\Attributes\Title;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\EmployeeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use Filament\Tables\Filters\SelectFilter;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';


    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('User Name')
                    ->schema([
                        Forms\Components\TextInput::make('first_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('middle_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('last_name')
                            ->required()
                            ->maxLength(255),
                    ])->columns(3),
                Forms\Components\Section::make('User Address')
                    ->schema([
                        Forms\Components\TextInput::make('address')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('zip_code')
                            ->required()
                            ->maxLength(255),
                    ])->columns(2),
                Forms\Components\Section::make('Dates')
                    ->schema([
                        Forms\Components\DatePicker::make('date_of_birth')
                            ->native(0)
                            ->required(),
                        Forms\Components\DatePicker::make('date_hired')
                            ->native(0)
                            ->required(),
                    ])->columns(2),
                Forms\Components\Section::make('Other')
                    ->schema([
                        Forms\Components\Select::make('country_id')
                            ->required()
                            ->afterStateUpdated(fn(callable $set) => $set('state_id', null))
                            ->reactive()
                            ->native(0)
                            ->relationship(name: "country", titleAttribute: "name"),
                        Forms\Components\Select::make('state_id')
                            // ->relationship(name: "state", titleAttribute: "name")
                            ->required()
                            ->options(
                                fn(callable $get) =>
                                \App\Models\State::Where('country_id', $get('country_id'))
                                    ->pluck('name', 'id')
                            )
                            ->reactive()
                            ->afterStateUpdated(fn(callable $set) => $set('city_id', null))
                            ->searchable()
                            ->native(0),
                        Forms\Components\Select::make('city_id')
                            ->required()
                            ->native(0)
                            ->options(
                                fn(callable $get) =>
                                \App\Models\City::Where('state_id', $get('state_id'))
                                    ->pluck('name', 'id')
                            ),
                        // ->relationship(name: "city", titleAttribute: "name"),
                        Forms\Components\Select::make('department_id')
                            ->required()
                            ->relationship(name: "department", titleAttribute: "name")
                            ->native(0),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(option: 5)
            ->defaultSort('first_name', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('middle_name')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('zip_code')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_hired')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('country.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('state.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('city.name')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('department.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                SelectFilter::make('country')
                    ->relationship('country', 'name')
                    ->label('Filter by Country')
                    ->multiple()
                    ->searchable(),
                SelectFilter::make('department')
                    ->relationship('department', 'name')
                    ->searchable()
                    // ->multiple()
                    ->label('Filter by Department'),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->action(fn($record, $livewire) => $livewire->dispatch('open-view-modal', ['recordId' => $record->getKey()]))
                    ->requiresConfirmation(false)
                    ->modalHeading('State Details')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
                    ->modalContent(fn($record) => static::infolist(
                        Infolist::make()
                            ->record($record)
                    )),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infoList(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Employee Information')
                    ->description('Details about the state')
                    ->schema([
                        TextEntry::make('first_name')
                            ->label('First Name'),
                        TextEntry::make('middle_name')
                            ->label('Middle Name'),
                        TextEntry::make('last_name')
                            ->label('Last Name'),
                        TextEntry::make('country.name')
                            ->label('Country'),
                        TextEntry::make('state.name')
                            ->label('State'),
                        TextEntry::make('city.name')
                            ->label('City'),
                        TextEntry::make('department.name')
                            ->label('Department'),
                    ])
                    ->columns(3)
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            // 'view' => Pages\ViewEmployee::route('/{record}'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
