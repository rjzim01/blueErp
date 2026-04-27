<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SalaryResource\Pages;
use App\Models\SalaryPosting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SalaryResource extends Resource
{
    protected static ?string $model = SalaryPosting::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationLabel = 'Salary';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationGroup = 'HR';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('posting_no')->required()->maxLength(30),
                Forms\Components\TextInput::make('yearmonth')->maxLength(255),
                Forms\Components\TextInput::make('outlet')->numeric(),
                Forms\Components\TextInput::make('emp_id')->numeric(),
                Forms\Components\Textarea::make('items'),
                Forms\Components\TextInput::make('net_payable')->numeric()->default(0),
                Forms\Components\Select::make('status')->options(['pending' => 'Pending', 'paid' => 'Paid']),
                Forms\Components\TextInput::make('entry_by')->maxLength(255),
                Forms\Components\TextInput::make('update_by')->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('posting_no')->searchable(),
                Tables\Columns\TextColumn::make('yearmonth')->toggleable(),
                Tables\Columns\TextColumn::make('emp_id')->numeric()->toggleable(),
                Tables\Columns\TextColumn::make('outlet')->numeric()->toggleable(),
                Tables\Columns\TextColumn::make('net_payable')->money('BDT')->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->formatStateUsing(fn ($state) => ucfirst($state))
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'pending' => 'warning',
                        'paid' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                    ])
                    ->label('Status'),
                Tables\Filters\Filter::make('posting_no')
                    ->form([
                        Forms\Components\TextInput::make('posting_no')->label('Posting No'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['posting_no'], fn ($query) => $query->where('posting_no', 'like', '%' . $data['posting_no'] . '%'));
                    }),
                Tables\Filters\Filter::make('emp_id')
                    ->form([
                        Forms\Components\TextInput::make('emp_id')->label('Employee ID'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['emp_id'], fn ($query) => $query->where('emp_id', 'like', '%' . $data['emp_id'] . '%'));
                    }),
                Tables\Filters\Filter::make('yearmonth')
                    ->form([
                        Forms\Components\TextInput::make('yearmonth')->label('Year/Month'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['yearmonth'], fn ($query) => $query->where('yearmonth', 'like', '%' . $data['yearmonth'] . '%'));
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
            'index' => Pages\ListSalaries::route('/'),
            'create' => Pages\CreateSalary::route('/create'),
            'edit' => Pages\EditSalary::route('/{record}/edit'),
        ];
    }
}