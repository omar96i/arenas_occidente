<?php

namespace App\Filament\Resources\EquipmentOptionCategoryResource\Pages;

use App\Filament\Resources\EquipmentOptionCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEquipmentOptionCategory extends EditRecord
{
    protected static string $resource = EquipmentOptionCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
