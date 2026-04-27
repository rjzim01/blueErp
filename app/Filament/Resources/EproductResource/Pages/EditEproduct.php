<?php

namespace App\Filament\Resources\EproductResource\Pages;

use App\Filament\Resources\EproductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEproduct extends EditRecord
{
    protected static string $resource = EproductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}