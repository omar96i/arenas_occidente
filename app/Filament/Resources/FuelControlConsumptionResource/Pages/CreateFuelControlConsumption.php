<?php

namespace App\Filament\Resources\FuelControlConsumptionResource\Pages;

use App\Filament\Resources\FuelControlConsumptionResource;
use App\Models\FuelControl;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFuelControlConsumption extends CreateRecord
{
    protected static string $resource = FuelControlConsumptionResource::class;
    
}
