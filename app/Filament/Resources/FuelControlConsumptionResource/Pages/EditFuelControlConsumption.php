<?php

namespace App\Filament\Resources\FuelControlConsumptionResource\Pages;

use App\Filament\Resources\FuelControlConsumptionResource;
use App\Models\FuelControl;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFuelControlConsumption extends EditRecord
{
    protected static string $resource = FuelControlConsumptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
