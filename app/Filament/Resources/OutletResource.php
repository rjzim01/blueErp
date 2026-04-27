<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OutletResource\Pages;
use App\Models\Outlet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OutletResource extends Resource
{
    protected static ?string $model = Outlet::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $navigationLabel = 'Outlets';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationGroup = 'Inventory';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('outlet_manager')->numeric(),
                Forms\Components\TextInput::make('name')->required()->maxLength(255),
                Forms\Components\TextInput::make('mobile')->maxLength(255),
                Forms\Components\TextInput::make('pathao_store_id')->numeric(),
                Forms\Components\TextInput::make('description')->maxLength(255),
                Forms\Components\TextInput::make('description2')->maxLength(255),
                Forms\Components\Select::make('active')->options(['yes' => 'Active', 'no' => 'Inactive']),
                Forms\Components\TextInput::make('entry_by')->maxLength(255),
                Forms\Components\TextInput::make('update_by')->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('mobile')->toggleable(),
                Tables\Columns\TextColumn::make('pathao_store_id')->numeric()->toggleable(),
                Tables\Columns\TextColumn::make('description')->limit(50)->toggleable(),
                Tables\Columns\TextColumn::make('description2')->limit(50)->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('outlet_manager')->numeric()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('active')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => $state === 'yes' ? 'Active' : 'Inactive')
                    ->color(fn ($state) => $state === 'yes' ? 'success' : 'danger'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('active')
                    ->options(['yes' => 'Active', 'no' => 'Inactive'])
                    ->label('Status'),
                Tables\Filters\Filter::make('name')
                    ->form([
                        Forms\Components\TextInput::make('name')->label('Name'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['name'], fn ($query) => $query->where('name', 'like', '%' . $data['name'] . '%'));
                    }),
                Tables\Filters\Filter::make('mobile')
                    ->form([
                        Forms\Components\TextInput::make('mobile')->label('Mobile'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['mobile'], fn ($query) => $query->where('mobile', 'like', '%' . $data['mobile'] . '%'));
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
            'index' => Pages\ListOutlets::route('/'),
            'create' => Pages\CreateOutlet::route('/create'),
            'edit' => Pages\EditOutlet::route('/{record}/edit'),
        ];
    }
}