<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationLabel = 'Payments';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Finance';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('fy')->numeric()->required(),
                Forms\Components\DatePicker::make('date')->required(),
                Forms\Components\TextInput::make('payment_no')->required()->maxLength(255),
                Forms\Components\TextInput::make('balance_tran_no')->maxLength(255),
                Forms\Components\TextInput::make('balance_method')->numeric(),
                Forms\Components\TextInput::make('payment_method')->numeric(),
                Forms\Components\TextInput::make('order_no')->maxLength(255),
                Forms\Components\TextInput::make('outlet')->numeric(),
                Forms\Components\TextInput::make('amount')->numeric()->default(0),
                Forms\Components\TextInput::make('type')->numeric(),
                Forms\Components\TextInput::make('entry_by')->maxLength(255),
                Forms\Components\TextInput::make('update_by')->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('payment_no')->searchable(),
                Tables\Columns\TextColumn::make('date')->date('Y-m-d')->sortable(),
                Tables\Columns\TextColumn::make('order_no')->searchable(),
                Tables\Columns\TextColumn::make('outlet')->numeric(),
                Tables\Columns\TextColumn::make('amount')->money('BDT')->sortable(),
                Tables\Columns\TextColumn::make('type')->numeric(),
                Tables\Columns\TextColumn::make('balance_tran_no')->limit(30),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('payment_no')
                    ->form([
                        Forms\Components\TextInput::make('payment_no')->label('Payment No'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['payment_no'], fn ($query) => $query->where('payment_no', 'like', '%' . $data['payment_no'] . '%'));
                    }),
                Tables\Filters\Filter::make('order_no')
                    ->form([
                        Forms\Components\TextInput::make('order_no')->label('Order No'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['order_no'], fn ($query) => $query->where('order_no', 'like', '%' . $data['order_no'] . '%'));
                    }),
                Tables\Filters\Filter::make('outlet')
                    ->form([
                        Forms\Components\TextInput::make('outlet')->label('Outlet'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['outlet'], fn ($query) => $query->where('outlet', 'like', '%' . $data['outlet'] . '%'));
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}