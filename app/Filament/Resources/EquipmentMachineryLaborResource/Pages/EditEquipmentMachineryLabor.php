<?php

namespace App\Filament\Resources\EquipmentMachineryLaborResource\Pages;

use App\Filament\Resources\EquipmentMachineryLaborResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEquipmentMachineryLabor extends EditRecord
{
    protected static string $resource = EquipmentMachineryLaborResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['hr_lab'] = $data['hr_fin'] - $data['hr_ini'];
    
        return $data;
    }
}
