<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Schedules extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static string $view = 'filament.pages.schedules';

    protected static ?string $navigationGroup = 'Administración de maquinaria y equipos';

    protected static ?string $navigationLabel = 'Programación';

    protected static ?string $title = 'Programación';

    protected static ?string $slug = 'programación';

    protected static ?int $navigationSort = 7;


}
