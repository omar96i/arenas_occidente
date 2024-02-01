<?php

namespace App\Filament\Resources\ConsumableControlResource\Pages;

use App\Filament\Resources\ConsumableControlResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListConsumableControls extends ListRecords
{
    protected static string $resource = ConsumableControlResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
