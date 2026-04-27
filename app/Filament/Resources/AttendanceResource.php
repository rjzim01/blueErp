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
                Tables\Columns\TextColumn::make('emp_id')->numeric(),
                Tables\Columns\TextColumn::make('bioid'),
                Tables\Columns\TextColumn::make('date')->date('Y-m-d')->sortable(),
                Tables\Columns\TextColumn::make('type')->numeric(),
                Tables\Columns\TextColumn::make('pinged_at')->dateTime(),
            ])
            ->actions([
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