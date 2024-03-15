<?php

namespace App\Filament\Pages;

use App\Models\Entity;
use App\Models\EntityMeasure;
use App\Models\EntitySegment;
use App\Models\EntityShift;
use App\Models\User;
use Filament\Pages\Page;
use Illuminate\Http\Request;

class Calendar extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static string $view = 'filament.pages.calendar';

    protected static ?string $navigationLabel = 'Calendario';

    protected static ?string $title = 'calendario';

    protected static ?string $pluralModelLabel = 'calendario';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'Administracion de turnos y contratos';


    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();
        $allowedRoles = ['administracion'];
        return in_array($user->position, $allowedRoles);
    }

}
