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

    public $entities = [];

    public $entity_selected = 0;

    public $shifts = [];

    public $load_calendar = false;

    public $segments = [];

    public $users = [];

    public $measures = [];

    public $entity_form = 0;

    public $segment_form = 0;

    public $measure_form = 0;

    public $user_form = 0;

    public $date_form = 0;

    public function mount(Request $request){
        if($request->query('entity_id')){
            $entity_id = intval($request->query('entity_id'));
            $this->entity_selected = $entity_id;
            $this->shifts = EntityShift::whereHas('measure', function($query) use($entity_id){
                $query->where('entity_id', $entity_id);
            })->with('user', 'measure')->get();
        }else{
            $this->shifts = EntityShift::with('user', 'measure', 'segment')->get();
        }
        $this->entities = Entity::get();

        $this->users = User::get();
    }

    public function searchBy(){
        return redirect()->route('filament.admin.pages.calendar', ['entity_id' => $this->entity_selected]);
    }

    public function getData(){

        $this->segments = EntitySegment::where('entity_id', $this->entity_form)->get();
        $this->measures = EntityMeasure::where('entity_id', $this->entity_form)->get();

    }

    public function storeShift(){
        dd("entro aqui");
    }

    public function closeModal(){
        return redirect()->back();
    }
}
