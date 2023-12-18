<?php

namespace App\Filament\Resources\OilControlResource\Pages;

use App\Filament\Resources\OilControlResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOilControl extends EditRecord
{
    protected static string $resource = OilControlResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
