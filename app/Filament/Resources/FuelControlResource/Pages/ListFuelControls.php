<?php

namespace App\Filament\Resources\FuelControlResource\Pages;

use App\Filament\Resources\FuelControlResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFuelControls extends ListRecords
{
    protected static string $resource = FuelControlResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
