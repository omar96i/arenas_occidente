<?php

namespace App\Filament\Resources\EquipmentMachineryCategoryResource\Pages;

use App\Filament\Resources\EquipmentMachineryCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEquipmentMachineryCategories extends ListRecords
{
    protected static string $resource = EquipmentMachineryCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->modalWidth('sm'),
        ];
    }
}
