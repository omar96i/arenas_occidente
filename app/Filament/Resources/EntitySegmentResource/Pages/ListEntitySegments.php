<?php

namespace App\Filament\Resources\EntitySegmentResource\Pages;

use App\Filament\Resources\EntitySegmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEntitySegments extends ListRecords
{
    protected static string $resource = EntitySegmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Crear turno'),
        ];
    }
}
