<?php

namespace App\Filament\Resources\OilSupplierResource\Pages;

use App\Filament\Resources\OilSupplierResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOilSupplier extends EditRecord
{
    protected static string $resource = OilSupplierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
