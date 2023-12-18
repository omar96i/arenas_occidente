<?php

namespace App\Filament\Resources\EquipmentMachineryTechnoResource\Pages;

use App\Filament\Resources\EquipmentMachineryTechnoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEquipmentMachineryTechnos extends ListRecords
{
    protected static string $resource = EquipmentMachineryTechnoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
