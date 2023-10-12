<?php

namespace App\Filament\Pages;

use App\Models\EntityShift;
use Filament\Pages\Page;

class Calendar extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static string $view = 'filament.pages.calendar';

    protected static ?string $navigationLabel = 'Calendario';

    protected static ?string $title = 'calendario';

    protected static ?string $pluralModelLabel = 'calendario';

    public $shifts = [];

    public function mount(){
        $this->shifts = EntityShift::with('user', 'measure', 'segment.entity')->get();
    }
}
