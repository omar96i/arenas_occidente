<?php

namespace App\Filament\Resources\FuelControlConsumptionResource\Pages;

use App\Filament\Resources\FuelControlConsumptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFuelControlConsumptions extends ListRecords
{
    protected static string $resource = FuelControlConsumptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
