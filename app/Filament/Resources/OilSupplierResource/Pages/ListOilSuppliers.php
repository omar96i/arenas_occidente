<?php

namespace App\Filament\Resources\OilSupplierResource\Pages;

use App\Filament\Resources\OilSupplierResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOilSuppliers extends ListRecords
{
    protected static string $resource = OilSupplierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
