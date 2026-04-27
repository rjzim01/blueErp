<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductArchiveResource\Pages;
use App\Models\ProductArchive;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductArchiveResource extends Resource
{
    protected static ?string $model = ProductArchive::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?string $navigationLabel = 'Product Archive';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Products';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('product_id')->numeric(),
                Forms\Components\TextInput::make('fy')->label('Financial Year'),
                Forms\Components\TextInput::make('ptype')->numeric(),
                Forms\Components\TextInput::make('barcode')->maxLength(255),
                Forms\Components\TextInput::make('code')->maxLength(255),
                Forms\Components\TextInput::make('name')->maxLength(255),
                Forms\Components\TextInput::make('price')->numeric(),
                Forms\Components\TextInput::make('purchase')->numeric(),
                Forms\Components\TextInput::make('outlet_id')->numeric(),
                Forms\Components\TextInput::make('outlet_name')->maxLength(255),
                Forms\Components\TextInput::make('supplier_id')->numeric(),
                Forms\Components\TextInput::make('supplier_name')->maxLength(255),
                Forms\Components\TextInput::make('status')->numeric(),
                Forms\Components\Textarea::make('entry_statement'),
                Forms\Components\Textarea::make('transfer'),
                Forms\Components\Textarea::make('sell'),
                Forms\Components\Textarea::make('return'),
                Forms\Components\DateTimePicker::make('audit_at'),
                Forms\Components\DateTimePicker::make('entry_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('product_id')->sortable(),
                Tables\Columns\TextColumn::make('barcode')->searchable(),
                Tables\Columns\TextColumn::make('code')->searchable(),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('price')->money('BDT')->sortable(),
                Tables\Columns\TextColumn::make('outlet_name')->searchable(),
                Tables\Columns\TextColumn::make('supplier_name')->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => $state == 1 ? 'Active' : 'Inactive')
                    ->color(fn ($state) => $state == 1 ? 'success' : 'danger'),
                Tables\Columns\TextColumn::make('entry_at')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('audit_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options([1 => 'Active', 0 => 'Inactive']),
                Tables\Filters\Filter::make('entry_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['created_from'], fn ($query) => $query->whereDate('entry_at', '>=', $data['created_from']))
                            ->when($data['created_until'], fn ($query) => $query->whereDate('entry_at', '<=', $data['created_until']));
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
            'index' => Pages\ListProductArchives::route('/'),
            'create' => Pages\CreateProductArchive::route('/create'),
            'edit' => Pages\EditProductArchive::route('/{record}/edit'),
            'view' => Pages\ViewProductArchive::route('/{record}'),
        ];
    }
}