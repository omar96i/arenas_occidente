<?php

namespace App\Filament\Resources\EquipmentMachineryCategoryResource\Pages;

use App\Filament\Resources\EquipmentMachineryCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEquipmentMachineryCategory extends EditRecord
{
    protected static string $resource = EquipmentMachineryCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
