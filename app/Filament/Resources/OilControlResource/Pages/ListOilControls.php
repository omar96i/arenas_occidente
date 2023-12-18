<?php

namespace App\Filament\Resources\OilControlResource\Pages;

use App\Filament\Resources\OilControlResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOilControls extends ListRecords
{
    protected static string $resource = OilControlResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
