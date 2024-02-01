<?php

namespace App\Filament\Resources\ConsumableControlResource\Pages;

use App\Filament\Resources\ConsumableControlResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditConsumableControl extends EditRecord
{
    protected static string $resource = ConsumableControlResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
