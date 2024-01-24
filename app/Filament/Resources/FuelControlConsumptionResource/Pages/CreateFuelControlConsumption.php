<?php

namespace App\Filament\Resources\FuelControlConsumptionResource\Pages;

use App\Filament\Resources\FuelControlConsumptionResource;
use App\Models\FuelControl;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFuelControlConsumption extends CreateRecord
{
    protected static string $resource = FuelControlConsumptionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $fuel_control = FuelControl::find($data['fuel_control_id']);
        $fuel_control->stock -= $data['amount'];
        $fuel_control->save();
        return $data;
    }
}
