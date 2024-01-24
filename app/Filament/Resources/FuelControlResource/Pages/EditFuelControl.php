<?php

namespace App\Filament\Resources\FuelControlResource\Pages;

use App\Filament\Resources\FuelControlResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFuelControl extends EditRecord
{
    protected static string $resource = FuelControlResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
