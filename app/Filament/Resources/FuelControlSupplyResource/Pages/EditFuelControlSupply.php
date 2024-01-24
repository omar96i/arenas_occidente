<?php

namespace App\Filament\Resources\FuelControlSupplyResource\Pages;

use App\Filament\Resources\FuelControlSupplyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFuelControlSupply extends EditRecord
{
    protected static string $resource = FuelControlSupplyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
