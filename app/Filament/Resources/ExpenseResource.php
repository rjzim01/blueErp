<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseResource\Pages;
use App\Models\Expense;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static ?string $navigationIcon = 'heroicon-o-receipt-percent';

    protected static ?string $navigationLabel = 'Expenses';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'Finance';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('expense_sector')->numeric(),
                Forms\Components\TextInput::make('outlet')->numeric(),
                Forms\Components\TextInput::make('method')->numeric(),
                Forms\Components\TextInput::make('from_balance')->numeric(),
                Forms\Components\Select::make('status')->options(['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected']),
                Forms\Components\TextInput::make('approved_by')->numeric(),
                Forms\Components\TextInput::make('amount')->numeric()->default(0),
                Forms\Components\Textarea::make('remarks'),
                Forms\Components\TextInput::make('receipt_no')->maxLength(255),
                Forms\Components\TextInput::make('entry_by')->numeric(),
                Forms\Components\TextInput::make('update_by')->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('expense_sector')->numeric()->toggleable(),
                Tables\Columns\TextColumn::make('outlet')->numeric()->toggleable(),
                Tables\Columns\TextColumn::make('amount')->money('BDT')->sortable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('receipt_no')->searchable(),
                Tables\Columns\TextColumn::make('remarks')->limit(50)->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->label('Status'),
Tables\Filters\Filter::make('expense_sector')
                    ->form([
                        Forms\Components\TextInput::make('expense_sector')->label('Expense sector'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['expense_sector'], fn ($query) => $query->where('expense_sector', 'like', '%' . $data['expense_sector'] . '%'));
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
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpense::route('/create'),
            'edit' => Pages\EditExpense::route('/{record}/edit'),
        ];
    }
}