<?php

namespace App\Filament\Resources\EquipmentMachinerySoatResource\Pages;

use App\Filament\Resources\EquipmentMachinerySoatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEquipmentMachinerySoats extends ListRecords
{
    protected static string $resource = EquipmentMachinerySoatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
