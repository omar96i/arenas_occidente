<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class EquipmentMachineryFuel extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.equipment-machinery-fuel';

    protected static ?string $title = 'Combustible por Equipos';

    protected static ?string $pluralModelLabel = 'Combustible por Equipos';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationGroup = 'Administración de maquinaria y equipos';
}
