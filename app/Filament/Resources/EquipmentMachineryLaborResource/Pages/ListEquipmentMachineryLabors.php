<?php

namespace App\Filament\Resources\EquipmentMachineryLaborResource\Pages;

use App\Filament\Resources\EquipmentMachineryLaborResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEquipmentMachineryLabors extends ListRecords
{
    protected static string $resource = EquipmentMachineryLaborResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
