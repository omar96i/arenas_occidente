<?php

namespace App\Filament\Resources\EquipmentMachineryOwnerResource\Pages;

use App\Filament\Resources\EquipmentMachineryOwnerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEquipmentMachineryOwner extends EditRecord
{
    protected static string $resource = EquipmentMachineryOwnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
