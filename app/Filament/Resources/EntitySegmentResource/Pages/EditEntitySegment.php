<?php

namespace App\Filament\Resources\EntitySegmentResource\Pages;

use App\Filament\Resources\EntitySegmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEntitySegment extends EditRecord
{
    public static ?string $title = 'Editar Modulo'; // Agrega esta línea

    protected static string $resource = EntitySegmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
