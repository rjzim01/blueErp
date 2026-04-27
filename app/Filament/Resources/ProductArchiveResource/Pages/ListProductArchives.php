<?php

namespace App\Filament\Resources\ProductArchiveResource\Pages;

use App\Filament\Resources\ProductArchiveResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductArchives extends ListRecords
{
    protected static string $resource = ProductArchiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}