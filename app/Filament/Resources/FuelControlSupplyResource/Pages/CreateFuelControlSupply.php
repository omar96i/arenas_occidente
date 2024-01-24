<?php

namespace App\Filament\Resources\FuelControlSupplyResource\Pages;

use App\Filament\Resources\FuelControlSupplyResource;
use App\Models\FuelControl;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFuelControlSupply extends CreateRecord
{
    protected static string $resource = FuelControlSupplyResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $fuel_control = FuelControl::find($data['fuel_control_id']);
        $fuel_control->stock += $data['amount'];
        $fuel_control->save();
        return $data;
    }
}
