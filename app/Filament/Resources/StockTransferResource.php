<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockTransferResource\Pages;
use App\Models\StockTransfer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StockTransferResource extends Resource
{
    protected static ?string $model = StockTransfer::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left';

    protected static ?string $navigationLabel = 'Stock Transfer';

    protected static ?int $navigationSort = 8;

    protected static ?string $navigationGroup = 'Inventory';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('transfer_code')->required()->maxLength(255),
                Forms\Components\TextInput::make('fy')->numeric()->required(),
                Forms\Components\TextInput::make('transfer_from')->numeric(),
                Forms\Components\TextInput::make('from_name')->maxLength(255),
                Forms\Components\TextInput::make('transfer_to')->numeric(),
                Forms\Components\TextInput::make('to_name')->maxLength(255),
                Forms\Components\Textarea::make('items'),
                Forms\Components\Select::make('status')->options(['0' => 'Pending', '1' => 'Confirmed', '2' => 'Rejected']),
                Forms\Components\TextInput::make('initiated_by')->numeric(),
                Forms\Components\TextInput::make('initiated_name')->maxLength(255),
                Forms\Components\DatePicker::make('initiated_date'),
                Forms\Components\TextInput::make('confirmed_by')->numeric(),
                Forms\Components\TextInput::make('confirmed_name')->maxLength(255),
                Forms\Components\DatePicker::make('confirmed_date'),
                Forms\Components\TextInput::make('entry_by')->maxLength(255),
                Forms\Components\TextInput::make('update_by')->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('transfer_code')->searchable(),
                Tables\Columns\TextColumn::make('from_name'),
                Tables\Columns\TextColumn::make('to_name'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('initiated_name'),
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
            'index' => Pages\ListStockTransfers::route('/'),
            'create' => Pages\CreateStockTransfer::route('/create'),
            'edit' => Pages\EditStockTransfer::route('/{record}/edit'),
        ];
    }
}