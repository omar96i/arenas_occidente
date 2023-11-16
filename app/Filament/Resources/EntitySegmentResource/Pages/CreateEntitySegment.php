<?php

namespace App\Filament\Resources\EntitySegmentResource\Pages;

use App\Filament\Resources\EntitySegmentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEntitySegment extends CreateRecord
{
    public static ?string $title = 'Crear un nuevo area'; // Agrega esta línea

    protected static string $resource = EntitySegmentResource::class;
}
