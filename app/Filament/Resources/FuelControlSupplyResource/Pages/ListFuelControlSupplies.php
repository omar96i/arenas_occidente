<?php

namespace App\Filament\Resources\FuelControlSupplyResource\Pages;

use App\Filament\Resources\FuelControlSupplyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFuelControlSupplies extends ListRecords
{
    protected static string $resource = FuelControlSupplyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
