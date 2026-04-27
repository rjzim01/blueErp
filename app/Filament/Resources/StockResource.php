<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockResource\Pages;
use App\Models\Stock;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StockResource extends Resource
{
    protected static ?string $model = Stock::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?string $navigationLabel = 'Stock';

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationGroup = 'Inventory';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('product')->numeric(),
                Forms\Components\TextInput::make('outlet')->numeric(),
                Forms\Components\TextInput::make('quantity')->numeric()->default(0),
                Forms\Components\TextInput::make('entry_by')->maxLength(255),
                Forms\Components\TextInput::make('update_by')->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('product')->numeric()->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('outlet')->numeric()->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('quantity')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('product')
                    ->form([
                        Forms\Components\TextInput::make('product')->label('Product ID'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['product'], fn ($query) => $query->where('product', 'like', '%' . $data['product'] . '%'));
                    }),
                Tables\Filters\Filter::make('outlet')
                    ->form([
                        Forms\Components\TextInput::make('outlet')->label('Outlet ID'),
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
            'index' => Pages\ListStock::route('/'),
            'create' => Pages\CreateStock::route('/create'),
            'edit' => Pages\EditStock::route('/{record}/edit'),
        ];
    }
}