<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DamageResource\Pages;
use App\Models\Damage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DamageResource extends Resource
{
    protected static ?string $model = Damage::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-exclamation';

    protected static ?string $navigationLabel = 'Damages';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationGroup = 'Stock';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('barcode_id')
                    ->numeric()
                    ->label('Barcode ID'),
                Forms\Components\TextInput::make('product_id')
                    ->numeric()
                    ->label('Product ID'),
                Forms\Components\TextInput::make('product_name')
                    ->maxLength(255)
                    ->label('Product Name'),
                Forms\Components\TextInput::make('barcode')
                    ->maxLength(255)
                    ->label('Barcode'),
                Forms\Components\TextInput::make('code')
                    ->maxLength(255)
                    ->label('Product Code'),
                Forms\Components\DatePicker::make('damage_date')
                    ->label('Damage Date'),
                Forms\Components\Textarea::make('damage_reason')
                    ->label('Damage Reason'),
                Forms\Components\Select::make('status')
                    ->options([
                        1 => 'Pending',
                        2 => 'Approved',
                        3 => 'Rejected',
                        4 => 'Resolved',
                    ])
                    ->default(1)
                    ->label('Status'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->label('ID'),
                Tables\Columns\TextColumn::make('barcode')
                    ->searchable()
                    ->label('Barcode'),
                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->label('Code'),
                Tables\Columns\TextColumn::make('product_name')
                    ->searchable()
                    ->label('Product'),
                Tables\Columns\TextColumn::make('damage_date')
                    ->date()
                    ->sortable()
                    ->label('Damage Date'),
                Tables\Columns\TextColumn::make('damage_reason')
                    ->searchable()
                    ->limit(50)
                    ->label('Reason'),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 1,
                        'success' => 2,
                        'danger' => 3,
                        'info' => 4,
                    ])
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        1 => 'Pending',
                        2 => 'Approved',
                        3 => 'Rejected',
                        4 => 'Resolved',
                        default => 'Unknown',
                    }),
                Tables\Columns\TextColumn::make('entry_by')
                    ->numeric()
                    ->sortable()
                    ->label('Entry By'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Created At'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Updated At'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        1 => 'Pending',
                        2 => 'Approved',
                        3 => 'Rejected',
                        4 => 'Resolved',
                    ])
                    ->label('Status'),
                Tables\Filters\Filter::make('damage_date')
                    ->form([
                        Forms\Components\DatePicker::make('damage_from'),
                        Forms\Components\DatePicker::make('damage_until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['damage_from'], fn ($query) => $query->whereDate('damage_date', '>=', $data['damage_from']))
                            ->when($data['damage_until'], fn ($query) => $query->whereDate('damage_date', '<=', $data['damage_until']));
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
            'index' => Pages\ListDamages::route('/'),
            'create' => Pages\CreateDamage::route('/create'),
            'edit' => Pages\EditDamage::route('/{record}/edit'),
            'view' => Pages\ViewDamage::route('/{record}'),
        ];
    }
}