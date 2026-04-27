<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Employees';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'HR';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('uid')->numeric(),
                Forms\Components\TextInput::make('bioid')->maxLength(255),
                Forms\Components\TextInput::make('outlet')->numeric(),
                Forms\Components\TextInput::make('name')->required()->maxLength(255),
                Forms\Components\TextInput::make('designation')->maxLength(255),
                Forms\Components\TextInput::make('type')->maxLength(24),
                Forms\Components\TextInput::make('salary')->numeric()->default(0),
                Forms\Components\TextInput::make('vacations')->numeric()->default(0),
                Forms\Components\TextInput::make('vacation_remains')->numeric()->default(0),
                Forms\Components\TextInput::make('check_in_time')->type('time'),
                Forms\Components\TextInput::make('check_out_time')->type('time'),
                Forms\Components\TextInput::make('entry_by')->maxLength(255),
                Forms\Components\TextInput::make('update_by')->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('designation')->toggleable(),
                Tables\Columns\TextColumn::make('type')->toggleable(),
                Tables\Columns\TextColumn::make('salary')->money('BDT')->sortable(),
                Tables\Columns\TextColumn::make('vacations')->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('vacation_remains')->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('outlet')->numeric()->toggleable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('name')
                    ->form([
                        Forms\Components\TextInput::make('name')->label('Name'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['name'], fn ($query) => $query->where('name', 'like', '%' . $data['name'] . '%'));
                    }),
                Tables\Filters\Filter::make('designation')
                    ->form([
                        Forms\Components\TextInput::make('designation')->label('Designation'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['designation'], fn ($query) => $query->where('designation', 'like', '%' . $data['designation'] . '%'));
                    }),
                Tables\Filters\Filter::make('outlet')
                    ->form([
                        Forms\Components\TextInput::make('outlet')->label('Outlet'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['outlet'], fn ($query) => $query->where('outlet', 'like', '%' . $data['outlet'] . '%'));
                    }),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['created_from'], fn ($query) => $query->whereDate('created_at', '>=', $data['created_from']))
                            ->when($data['created_until'], fn ($query) => $query->whereDate('created_at', '<=', $data['created_until']));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}