<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupplierBillResource\Pages;
use App\Models\SupplierBill;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SupplierBillResource extends Resource
{
    protected static ?string $model = SupplierBill::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Supplier Bills';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationGroup = 'Finance';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('bill_no')->required()->maxLength(64),
                Forms\Components\TextInput::make('supplier')->numeric(),
                Forms\Components\TextInput::make('amount')->numeric()->default(0),
                Forms\Components\Textarea::make('remarks'),
                Forms\Components\TextInput::make('entry_by')->maxLength(255),
                Forms\Components\TextInput::make('update_by')->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('bill_no')->searchable(),
                Tables\Columns\TextColumn::make('supplier')->numeric(),
                Tables\Columns\TextColumn::make('amount')->money('BDT')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
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
            'index' => Pages\ListSupplierBills::route('/'),
            'create' => Pages\CreateSupplierBill::route('/create'),
            'edit' => Pages\EditSupplierBill::route('/{record}/edit'),
        ];
    }
}