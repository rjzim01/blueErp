<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceResource\Pages;
use App\Models\Attendance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationLabel = 'Attendance';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'HR';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('ip')->maxLength(125),
                Forms\Components\TextInput::make('uid')->numeric(),
                Forms\Components\TextInput::make('emp_id')->numeric(),
                Forms\Components\TextInput::make('bioid')->maxLength(255),
                Forms\Components\DatePicker::make('date')->required(),
                Forms\Components\TextInput::make('type')->numeric(),
                Forms\Components\TextInput::make('medium')->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('emp_id')->numeric()->toggleable(),
                Tables\Columns\TextColumn::make('bioid')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('date')->date('Y-m-d')->sortable(),
                Tables\Columns\TextColumn::make('type')->numeric()->toggleable(),
                Tables\Columns\TextColumn::make('ip')->limit(30)->toggleable(),
                Tables\Columns\TextColumn::make('medium')->toggleable(),
                Tables\Columns\TextColumn::make('pinged_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('bioid')
                    ->form([
                        Forms\Components\TextInput::make('bioid')->label('Bio ID'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['bioid'], fn ($query) => $query->where('bioid', 'like', '%' . $data['bioid'] . '%'));
                    }),
                Tables\Filters\Filter::make('emp_id')
                    ->form([
                        Forms\Components\TextInput::make('emp_id')->label('Employee ID'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['emp_id'], fn ($query) => $query->where('emp_id', 'like', '%' . $data['emp_id'] . '%'));
                    }),
                Tables\Filters\Filter::make('date')
                    ->form([
                        Forms\Components\DatePicker::make('date_from'),
                        Forms\Components\DatePicker::make('date_until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['date_from'], fn ($query) => $query->whereDate('date', '>=', $data['date_from']))
                            ->when($data['date_until'], fn ($query) => $query->whereDate('date', '<=', $data['date_until']));
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
            'index' => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }
}