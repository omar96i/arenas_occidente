<?php

namespace App\Filament\Pages;

use App\Models\Entity;
use App\Models\EntitySegment;
use Filament\Pages\Page;
use Illuminate\Http\Request;

class Reports extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-magnifying-glass';

    protected static string $view = 'filament.pages.reports';

    protected static ?string $title = 'Informes';

    protected static ?string $pluralModelLabel = 'Informes';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationGroup = 'Reportes';

    public $entities;
    public $segments;

    public function mount(Request $request){
        $this->entities = Entity::all();

        $this->segments =EntitySegment::all();
    }
}
