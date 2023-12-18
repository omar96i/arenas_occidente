<?php

namespace App\Filament\Resources\OilResource\Pages;

use App\Filament\Resources\OilResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOil extends ListRecords
{
    protected static string $resource = OilResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
