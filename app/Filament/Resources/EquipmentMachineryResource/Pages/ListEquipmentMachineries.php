<?php

namespace App\Filament\Resources\EquipmentMachineryResource\Pages;

use App\Filament\Resources\EquipmentMachineryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEquipmentMachineries extends ListRecords
{
    protected static string $resource = EquipmentMachineryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
