<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockEntryResource\Pages;
use App\Models\StockEntry;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StockEntryResource extends Resource
{
    protected static ?string $model = StockEntry::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-tray';

    protected static ?string $navigationLabel = 'Stock Entry';

    protected static ?int $navigationSort = 7;

    protected static ?string $navigationGroup = 'Inventory';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('fy')->numeric()->required(),
                Forms\Components\TextInput::make('statement')->maxLength(255),
                Forms\Components\Textarea::make('items'),
                Forms\Components\TextInput::make('total')->numeric()->default(0),
                Forms\Components\TextInput::make('entry_by')->maxLength(255),
                Forms\Components\TextInput::make('update_by')->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('fy')->numeric()->toggleable(),
                Tables\Columns\TextColumn::make('statement')->searchable(),
                Tables\Columns\TextColumn::make('total')->money('BDT')->sortable(),
                Tables\Columns\TextColumn::make('items')->limit(50)->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('entry_by')->toggleable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('statement')
                    ->form([
                        Forms\Components\TextInput::make('statement')->label('Statement'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['statement'], fn ($query) => $query->where('statement', 'like', '%' . $data['statement'] . '%'));
                    }),
                Tables\Filters\Filter::make('fy')
                    ->form([
                        Forms\Components\TextInput::make('fy')->label('FY'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['fy'], fn ($query) => $query->where('fy', 'like', '%' . $data['fy'] . '%'));
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
            'index' => Pages\ListStockEntries::route('/'),
            'create' => Pages\CreateStockEntry::route('/create'),
            'edit' => Pages\EditStockEntry::route('/{record}/edit'),
        ];
    }
}