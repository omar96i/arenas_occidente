<?php

namespace App\Filament\Pages;

use App\Models\Entity;
use App\Models\EntitySegment;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Request;

class UserSalary extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.user-salary';

    protected static ?string $title = 'Resumen de salarios';

    protected static ?string $pluralModelLabel = 'Resumen de salarios';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationGroup = 'Administracion de turnos y contratos';

    public $entities;
    public $segments;

    public function mount(Request $request){
        $this->entities = Entity::all();

        $this->segments =EntitySegment::all();
    }
    
}
