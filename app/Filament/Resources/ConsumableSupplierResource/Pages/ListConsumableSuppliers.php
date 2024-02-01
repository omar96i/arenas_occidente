<?php

namespace App\Filament\Resources\ConsumableSupplierResource\Pages;

use App\Filament\Resources\ConsumableSupplierResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListConsumableSuppliers extends ListRecords
{
    protected static string $resource = ConsumableSupplierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
