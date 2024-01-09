<?php

namespace App\Filament\Resources\EquipmentMachineryLaborResource\Pages;

use App\Filament\Resources\EquipmentMachineryLaborResource;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEquipmentMachineryLabor extends CreateRecord
{
    protected static string $resource = EquipmentMachineryLaborResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // $entry_time = Carbon::parse($data['entry_time']);
        // $departure_time = Carbon::parse($data['departure_time']);
        // $data['time_worked'] = $departure_time->diff($entry_time)->format('%H:%I:%S');  calculo para el tiempo trabajado

        $data['hr_lab'] = $data['hr_fin'] - $data['hr_ini'];
    
        return $data;
    }
}
