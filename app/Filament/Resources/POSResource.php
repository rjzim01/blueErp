<?php

namespace App\Filament\Resources;

use App\Filament\Pages\Pos;
use App\Filament\Resources\POSResource\Pages;
use App\Models\Sell;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class POSResource extends Resource
{
    protected static ?string $model = Sell::class;

    protected static ?string $slug = 'pos';

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationLabel = 'POS';

    protected static ?string $navigationGroup = 'Sales';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('customer')
                    ->label('Customer')
                    ->relationship('customer', 'name')
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')->required(),
                        Forms\Components\TextInput::make('phone'),
                        Forms\Components\TextInput::make('email'),
                        Forms\Components\TextInput::make('address'),
                    ]),
                Forms\Components\TextInput::make('invoice_no')->readonly(),
                Forms\Components\DatePicker::make('date'),
                Forms\Components\TextInput::make('sub_total')->numeric(),
                Forms\Components\TextInput::make('discount')->numeric(),
                Forms\Components\TextInput::make('vat')->numeric(),
                Forms\Components\TextInput::make('amount')->numeric(),
                Forms\Components\TextInput::make('payable')->numeric(),
                Forms\Components\TextInput::make('paid')->numeric(),
                Forms\Components\TextInput::make('due')->numeric(),
                Forms\Components\Select::make('status')->options(['pending' => 'Pending', 'completed' => 'Completed', 'cancelled' => 'Cancelled']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('id'),
                \Filament\Tables\Columns\TextColumn::make('invoice_no')->searchable(),
                \Filament\Tables\Columns\TextColumn::make('date')->date(),
                \Filament\Tables\Columns\TextColumn::make('amount')->money('BDT'),
                \Filament\Tables\Columns\TextColumn::make('payable')->money('BDT'),
                \Filament\Tables\Columns\TextColumn::make('paid')->money('BDT'),
                \Filament\Tables\Columns\TextColumn::make('due')->money('BDT'),
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => POSResource\Pages\ListPos::route('/'),
        ];
    }
}