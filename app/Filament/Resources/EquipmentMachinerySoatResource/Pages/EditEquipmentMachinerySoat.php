<?php

namespace App\Filament\Resources\EquipmentMachinerySoatResource\Pages;

use App\Filament\Resources\EquipmentMachinerySoatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEquipmentMachinerySoat extends EditRecord
{
    protected static string $resource = EquipmentMachinerySoatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
