<?php

namespace App\Filament\Resources\DamageResource\Pages;

use App\Filament\Resources\DamageResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDamage extends ViewRecord
{
    protected static string $resource = DamageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}