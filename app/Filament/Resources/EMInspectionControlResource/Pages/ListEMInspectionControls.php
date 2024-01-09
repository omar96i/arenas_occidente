<?php

namespace App\Filament\Resources\EMInspectionControlResource\Pages;

use App\Filament\Resources\EMInspectionControlResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEMInspectionControls extends ListRecords
{
    protected static string $resource = EMInspectionControlResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
