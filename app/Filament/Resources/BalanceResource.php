<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BalanceResource\Pages;
use App\Models\Balance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BalanceResource extends Resource
{
    protected static ?string $model = Balance::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationLabel = 'Balance';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Finance';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('outlet')->numeric()->required(),
                Forms\Components\TextInput::make('amount')->numeric()->required(),
                Forms\Components\TextInput::make('balance_method')->numeric()->required(),
                Forms\Components\TextInput::make('method_name')->maxLength(255),
                Forms\Components\TextInput::make('entry_by')->maxLength(255),
                Forms\Components\TextInput::make('update_by')->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('outlet')->numeric()->searchable(),
                Tables\Columns\TextColumn::make('amount')->money('BDT')->sortable(),
                Tables\Columns\TextColumn::make('method_name')->searchable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('outlet')
                    ->form([
                        Forms\Components\TextInput::make('outlet')->label('Outlet'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['outlet'], fn ($query) => $query->where('outlet', 'like', '%' . $data['outlet'] . '%'));
                    }),
                Tables\Filters\Filter::make('method_name')
                    ->form([
                        Forms\Components\TextInput::make('method_name')->label('Method Name'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['method_name'], fn ($query) => $query->where('method_name', 'like', '%' . $data['method_name'] . '%'));
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
            'index' => Pages\ListBalance::route('/'),
            'create' => Pages\CreateBalance::route('/create'),
            'edit' => Pages\EditBalance::route('/{record}/edit'),
        ];
    }
}