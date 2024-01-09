<?php

namespace App\Filament\Resources\EMInspectionControlResource\Pages;

use App\Filament\Resources\EMInspectionControlResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEMInspectionControl extends EditRecord
{
    protected static string $resource = EMInspectionControlResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
