<?php

namespace App\Filament\Resources\EquipmentMachineryFuelResource\Pages;

use App\Filament\Resources\EquipmentMachineryFuelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEquipmentMachineryFuels extends ListRecords
{
    protected static string $resource = EquipmentMachineryFuelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
