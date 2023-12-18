<?php

namespace App\Filament\Resources\EquipmentMachinerySureResource\Pages;

use App\Filament\Resources\EquipmentMachinerySureResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEquipmentMachinerySure extends EditRecord
{
    protected static string $resource = EquipmentMachinerySureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
