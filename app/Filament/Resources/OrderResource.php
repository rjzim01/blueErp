<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationLabel = 'Orders';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationGroup = 'Sales';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('order_no')->required()->maxLength(255),
                Forms\Components\DatePicker::make('date')->required(),
                Forms\Components\TextInput::make('customer')->numeric(),
                Forms\Components\TextInput::make('mobile')->maxLength(255),
                Forms\Components\TextInput::make('outlet')->numeric(),
                Forms\Components\Textarea::make('items'),
                Forms\Components\TextInput::make('sub_total')->numeric()->default(0),
                Forms\Components\TextInput::make('discount')->numeric()->default(0),
                Forms\Components\TextInput::make('delivery_fee')->numeric()->default(0),
                Forms\Components\TextInput::make('vat')->numeric()->default(0),
                Forms\Components\TextInput::make('net_payable')->numeric()->default(0),
                Forms\Components\TextInput::make('paid')->numeric()->default(0),
                Forms\Components\TextInput::make('delivery_chalan')->maxLength(255),
                Forms\Components\TextInput::make('delivery_channel')->numeric(),
                Forms\Components\TextInput::make('pathao_consignment_id')->maxLength(25),
                Forms\Components\TextInput::make('pathao_pickup')->numeric(),
                Forms\Components\Textarea::make('remarks'),
                Forms\Components\Select::make('status')
                    ->options([
                        'Pending' => 'Pending',
                        'Confirmed' => 'Confirmed',
                        'Packaged' => 'Packaged',
                        'Shipped' => 'Shipped',
                        'Delivered' => 'Delivered',
                        'Completed' => 'Completed',
                        'Canceled' => 'Canceled',
                    ]),
                Forms\Components\TextInput::make('entry_by')->maxLength(255),
                Forms\Components\TextInput::make('update_by')->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('order_no')->searchable(),
                Tables\Columns\TextColumn::make('date')->date('Y-m-d')->sortable(),
                Tables\Columns\TextColumn::make('customer')->numeric(),
                Tables\Columns\TextColumn::make('mobile'),
                Tables\Columns\TextColumn::make('net_payable')->money('BDT')->sortable(),
                Tables\Columns\TextColumn::make('paid')->money('BDT')->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => $state ?? 'Pending')
                    ->color(fn ($state) => match($state) {
                        'Pending' => 'gray',
                        'Confirmed' => 'info',
                        'Packaged' => 'warning',
                        'Shipped' => 'warning',
                        'Delivered' => 'success',
                        'Completed' => 'success',
                        'Canceled' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Pending' => 'Pending',
                        'Confirmed' => 'Confirmed',
                        'Packaged' => 'Packaged',
                        'Shipped' => 'Shipped',
                        'Delivered' => 'Delivered',
                        'Completed' => 'Completed',
                        'Canceled' => 'Canceled',
                    ]),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}