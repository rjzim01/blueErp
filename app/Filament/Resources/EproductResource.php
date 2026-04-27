<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EproductResource\Pages;
use App\Models\Eproduct;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EproductResource extends Resource
{
    protected static ?string $model = Eproduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationLabel = 'Ecommerce Product';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'Products';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')->required()->maxLength(255),
                Forms\Components\TextInput::make('base_code')->required()->maxLength(252),
                Forms\Components\TextInput::make('name')->maxLength(255),
                Forms\Components\Textarea::make('description'),
                Forms\Components\Textarea::make('long_description'),
                Forms\Components\TextInput::make('category')->numeric(),
                Forms\Components\TextInput::make('selling_price')->numeric()->default(0),
                Forms\Components\TextInput::make('color')->maxLength(255),
                Forms\Components\TextInput::make('discount')->numeric()->default(0),
                Forms\Components\TextInput::make('offer')->numeric()->default(0),
                Forms\Components\Select::make('active')->options(['yes' => 'Active', 'no' => 'Inactive']),
                Forms\Components\TextInput::make('current_stock')->numeric()->default(0),
                Forms\Components\TextInput::make('entry_by')->maxLength(255),
                Forms\Components\TextInput::make('update_by')->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('code')->searchable(),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('selling_price')->money('BDT')->sortable(),
                Tables\Columns\TextColumn::make('current_stock')->sortable(),
                Tables\Columns\TextColumn::make('active')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => $state === 'yes' ? 'Active' : 'Inactive')
                    ->color(fn ($state) => $state === 'yes' ? 'success' : 'danger'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('active')->options(['yes' => 'Active', 'no' => 'Inactive']),
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
            'index' => Pages\ListEproducts::route('/'),
            'create' => Pages\CreateEproduct::route('/create'),
            'edit' => Pages\EditEproduct::route('/{record}/edit'),
        ];
    }
}