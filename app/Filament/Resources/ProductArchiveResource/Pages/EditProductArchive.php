<?php

namespace App\Filament\Resources\ProductArchiveResource\Pages;

use App\Filament\Resources\ProductArchiveResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductArchive extends EditRecord
{
    protected static string $resource = ProductArchiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}