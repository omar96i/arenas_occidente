<?php

namespace App\Filament\Resources\EquipmentMachineryMaintenanceResource\Pages;

use App\Filament\Resources\EquipmentMachineryMaintenanceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEquipmentMachineryMaintenances extends ListRecords
{
    protected static string $resource = EquipmentMachineryMaintenanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
