<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShipmentResource\Pages;
use App\Models\Shipment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ShipmentResource extends Resource
{
    protected static ?string $model = Shipment::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationLabel = 'Shipments';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'Logistics';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('tracking_no')->required()->maxLength(255),
                Forms\Components\TextInput::make('mobile')->maxLength(45),
                Forms\Components\TextInput::make('packet_no')->maxLength(45),
                Forms\Components\TextInput::make('order_no')->required()->maxLength(255),
                Forms\Components\TextInput::make('channel_id')->maxLength(255),
                Forms\Components\TextInput::make('channel_name')->maxLength(255),
                Forms\Components\TextInput::make('channel_uid')->numeric(),
                Forms\Components\Textarea::make('remarks'),
                Forms\Components\TextInput::make('photo')->maxLength(255),
                Forms\Components\TextInput::make('delivery_boy_id')->numeric(),
                Forms\Components\TextInput::make('delivery_boy_name')->maxLength(45),
                Forms\Components\TextInput::make('approval_waiting')->maxLength(45),
                Forms\Components\TextInput::make('status')->maxLength(255),
                Forms\Components\TextInput::make('entry_by')->maxLength(255),
                Forms\Components\TextInput::make('update_by')->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('tracking_no')->searchable(),
                Tables\Columns\TextColumn::make('order_no')->searchable(),
                Tables\Columns\TextColumn::make('mobile'),
                Tables\Columns\TextColumn::make('channel_name'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('delivery_boy_name'),
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
            'index' => Pages\ListShipments::route('/'),
            'create' => Pages\CreateShipment::route('/create'),
            'edit' => Pages\EditShipment::route('/{record}/edit'),
        ];
    }
}