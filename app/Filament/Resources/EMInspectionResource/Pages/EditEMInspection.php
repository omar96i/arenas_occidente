<?php

namespace App\Filament\Resources\EMInspectionResource\Pages;

use App\Filament\Resources\EMInspectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEMInspection extends EditRecord
{
    protected static string $resource = EMInspectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
