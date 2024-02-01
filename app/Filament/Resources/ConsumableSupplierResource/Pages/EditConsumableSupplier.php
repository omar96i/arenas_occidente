<?php

namespace App\Filament\Resources\ConsumableSupplierResource\Pages;

use App\Filament\Resources\ConsumableSupplierResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditConsumableSupplier extends EditRecord
{
    protected static string $resource = ConsumableSupplierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
