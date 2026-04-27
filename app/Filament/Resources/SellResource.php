<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SellResource\Pages;
use App\Models\Sell;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SellResource extends Resource
{
    protected static ?string $model = Sell::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationLabel = 'Sales';

    protected static ?string $modelLabel = 'Sale';

    protected static ?string $pluralModelLabel = 'Sales';

    protected static ?int $navigationSort = 100;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('invoice_no')->readonly(),
                Forms\Components\TextInput::make('date')->readonly(),
                Forms\Components\TextInput::make('amount')->numeric()->readonly(),
                Forms\Components\TextInput::make('discount')->numeric()->readonly(),
                Forms\Components\TextInput::make('vat')->numeric()->readonly(),
                Forms\Components\TextInput::make('payable')->numeric()->readonly(),
                Forms\Components\TextInput::make('paid')->numeric()->readonly(),
                Forms\Components\TextInput::make('due')->numeric()->readonly(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('invoice_no')->searchable(),
                Tables\Columns\TextColumn::make('date')->date()->sortable(),
                Tables\Columns\TextColumn::make('amount')->numeric()->money('BDT')->sortable(),
                Tables\Columns\TextColumn::make('discount')->numeric()->money('BDT'),
                Tables\Columns\TextColumn::make('vat')->numeric()->money('BDT'),
                Tables\Columns\TextColumn::make('payable')->numeric()->money('BDT')->sortable(),
                Tables\Columns\TextColumn::make('paid')->numeric()->money('BDT'),
                Tables\Columns\TextColumn::make('due')->numeric()->money('BDT'),
                Tables\Columns\TextColumn::make('profit')->numeric()->money('BDT'),
            ])
            ->filters([
                Tables\Filters\Filter::make('date_range')
                    ->form([
                        Forms\Components\DatePicker::make('from'),
                        Forms\Components\DatePicker::make('to'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn($q) => $q->where('date','>=',$data['from']))
                            ->when($data['to'], fn($q) => $q->where('date','<=',$data['to']));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->defaultSort('id','desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSells::route('/'),
            'view' => Pages\ViewSell::route('/{record}'),
        ];
    }
}
