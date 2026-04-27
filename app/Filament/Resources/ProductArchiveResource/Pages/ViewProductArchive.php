<?php

namespace App\Filament\Resources\ProductArchiveResource\Pages;

use App\Filament\Resources\ProductArchiveResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProductArchive extends ViewRecord
{
    protected static string $resource = ProductArchiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}