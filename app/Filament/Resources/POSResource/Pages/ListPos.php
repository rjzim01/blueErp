<?php

namespace App\Filament\Resources\POSResource\Pages;

use App\Filament\Resources\POSResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPos extends ListRecords
{
    protected static string $resource = POSResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Create New')
                ->url('/admin/pos/create'),
        ];
    }
}