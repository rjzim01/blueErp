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
                Tables\Columns\TextColumn::make('supplier')->numeric()->toggleable(),
                Tables\Columns\TextColumn::make('amount')->money('BDT')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('bill_no')
                    ->form([
                        Forms\Components\TextInput::make('bill_no')->label('Bill No'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['bill_no'], fn ($query) => $query->where('bill_no', 'like', '%' . $data['bill_no'] . '%'));
                    }),
                Tables\Filters\Filter::make('supplier')
                    ->form([
                        Forms\Components\TextInput::make('supplier')->label('Supplier'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['supplier'], fn ($query) => $query->where('supplier', 'like', '%' . $data['supplier'] . '%'));
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
            'index' => Pages\ListSupplierBills::route('/'),
            'create' => Pages\CreateSupplierBill::route('/create'),
            'edit' => Pages\EditSupplierBill::route('/{record}/edit'),
        ];
    }
}