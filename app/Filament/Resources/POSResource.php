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
use Filament\Tables\Filters;

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
                \Filament\Tables\Columns\TextColumn::make('id')->sortable(),
                \Filament\Tables\Columns\TextColumn::make('invoice_no')->searchable(),
                \Filament\Tables\Columns\TextColumn::make('date')->date()->sortable(),
                \Filament\Tables\Columns\TextColumn::make('customer')->toggleable(),
                \Filament\Tables\Columns\TextColumn::make('sub_total')->money('BDT')->toggleable(),
                \Filament\Tables\Columns\TextColumn::make('discount')->money('BDT')->toggleable(),
                \Filament\Tables\Columns\TextColumn::make('vat')->money('BDT')->toggleable(),
                \Filament\Tables\Columns\TextColumn::make('amount')->money('BDT'),
                \Filament\Tables\Columns\TextColumn::make('payable')->money('BDT'),
                \Filament\Tables\Columns\TextColumn::make('paid')->money('BDT'),
                \Filament\Tables\Columns\TextColumn::make('due')->money('BDT'),
                \Filament\Tables\Columns\TextColumn::make('status')
                    ->formatStateUsing(fn ($state) => ucfirst($state))
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'pending' => 'warning',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->label('Status'),
                Tables\Filters\Filter::make('invoice_no')
                    ->form([
                        Forms\Components\TextInput::make('invoice_no')->label('Invoice No'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['invoice_no'], fn ($query) => $query->where('invoice_no', 'like', '%' . $data['invoice_no'] . '%'));
                    }),
                Tables\Filters\Filter::make('customer')
                    ->form([
                        Forms\Components\TextInput::make('customer')->label('Customer'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['customer'], fn ($query) => $query->where('customer', 'like', '%' . $data['customer'] . '%'));
                    }),
                Tables\Filters\Filter::make('date')
                    ->form([
                        Forms\Components\DatePicker::make('date_from'),
                        Forms\Components\DatePicker::make('date_until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['date_from'], fn ($query) => $query->whereDate('date', '>=', $data['date_from']))
                            ->when($data['date_until'], fn ($query) => $query->whereDate('date', '<=', $data['date_until']));
                    }),
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