<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EMInspectionResource\Pages;
use App\Filament\Resources\EMInspectionResource\RelationManagers;
use App\Models\EMInspection;
use App\Tables\Columns\CustomColumnInspection;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DatePicker;



class EMInspectionResource extends Resource
{
    protected static ?string $model = EMInspection::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-magnifying-glass';

    protected static ?string $navigationLabel = 'Inspecciones';

    protected static ?string $slug = 'inspecciones';

    protected static ?string $modelLabel = 'Inspecciones';

    protected static ?string $navigationGroup = 'Administración de maquinaria y equipos';

    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                ->schema([
                    Forms\Components\Select::make('equipment_machinery_id')->label('Selecciona un equipo')
                    ->relationship('equipment_machinery', 'name')
                    ->required(),
                    Section::make('Documentos vehiculo')
                        ->schema([
                            Repeater::make('hourometer')->label('Horometro o km Actual')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('property_card')->label('Tarjeta de propiedad')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('soat')->label('SOAT')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('technomechanical')->label('Tecnomecanico')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                        ])->columns(3)->collapsed(),

                    Section::make('Documentos conductor')
                        ->schema([
                            Repeater::make('company_card')->label('Carnet Empresa')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('ingenio_card')->label('Carnet Ingenio')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('driving_license')->label('Licencia de conduccion')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                        ])->columns(3)->collapsed(),

                    Section::make('SST')
                        ->schema([
                            Repeater::make('helmet')->label('Casco')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('boots')->label('Botas')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('uniform')->label('Uniforme')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('glasses')->label('Gafas')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('extinguisher')->label('Extintor')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    DatePicker::make('observations')->label('Fecha de vencimiento'),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('kit')->label('Botiquin')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('reflective_tapes')->label('Cintas Reflectivas')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('cones')->label('Conos')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('reflective_vest')->label('Chaleco Reflectivo')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('anti_spill_kit')->label('Kit Antiderrame')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('cleanliness')->label('Orden y Aseo')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('access_to_machine')->label('Acceso a la maq o eq')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('ear_cap')->label('Tapa Oidos')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                        ])->columns(3)->collapsed(),
                    Section::make('Fotos')
                        ->schema([
                            Repeater::make('frontal')->label('Frontal')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    FileUpload::make('observations')->label('Subir evidencia'),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('left_side')->label('Lateral izquiera')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    FileUpload::make('observations')->label('Subir evidencia'),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('right_side')->label('Lateral derecha')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    FileUpload::make('observations')->label('Subir evidencia'),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('rear')->label('Trasera')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    FileUpload::make('observations')->label('Subir evidencia'),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('tires')->label('Llantas')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    FileUpload::make('observations')->label('Subir evidencia'),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('mileage')->label('Kilometraje')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    FileUpload::make('observations')->label('Subir evidencia'),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('leaks')->label('Fugas(si hay)')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    FileUpload::make('observations')->label('Subir evidencia'),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('pending')->label('Pendientes (si hay)')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    FileUpload::make('observations')->label('Subir evidencia'),
                                ])
                                ->addable(false)
                                ->deletable(false),
                        ])->columns(3)->collapsed(),
                    Section::make('Luces')
                        ->schema([
                            Repeater::make('streetlights')->label('Farolas')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('stops')->label('Stops')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('braking_lights')->label('Luces de Frenado')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('directional')->label('Direccionales')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('parking_lot')->label('Estacionamiento')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('interior_lights')->label('Luces interiores')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                        ])->columns(3)->collapsed(),
                    Section::make('Otros')
                        ->schema([
                            Repeater::make('reverse_alarm')->label('Alarma de reversa')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('whistle')->label('Pito')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('nibs')->label('Plumillas')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('how_i_drive')->label('Como Conduzco')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('encarped')->label('Encarpado')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('grease')->label('Engrase(se ve engrasado,fecha ultimo engrase)')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                        ])->columns(3)->collapsed(),

                    Section::make('Frenos')
                        ->schema([
                            Repeater::make('brake_fluid')->label('Nivel liq de frenos')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('pedal_return')->label('Retorno del pedal')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('parking_brake')->label('Freno estacionamiento')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('tubes')->label('Tubos, Mangueras o conexiones')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                        ])->columns(3)->collapsed(),

                    Section::make('Motor')
                        ->schema([
                            Repeater::make('battery')->label('Bateria(Soporte suelto, bornes sulfatados)')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('electric_cables')->label('Cables electricos')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('refrigeration_system')->label('Sistema de Refrigeracion (fugas)')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('coolant_level')->label('Nivel refrigerante')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('oil_leaks_without')->label('Fugas de aceite sin goteo continuo')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('oil_leaks_with')->label('Fugas de aceite con goteo continuo')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('engine_state')->label('Estado del motor( sonido inadecuado, emision de humos)')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('gear_box')->label('Caja de cambios')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('fuel_tank')->label('Deposito del combustible')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('hydraulic_oil_tank')->label('Tanque aceite hidraulico')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('hydraulic_oil_cooler')->label('Enfriador aceite hidraulico')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('hoses')->label('Mangueras en general')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                        ])->columns(3)->collapsed(),

                    Section::make('Aceites')
                        ->schema([
                            Repeater::make('engine_oil_level')->label('Nivel aceite motor')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('visual_inspection_engine_oil')->label('Inspeccion visual aceite motor')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('transmission_oil_level')->label('Nivel aceite Transmision')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('transmission_oil_inspection')->label('Inspeccion aceite transmision')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('differential_oil_level')->label('Nivel aceite Diferencial')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('differential_oil_inspection')->label('Inspeccion aceite diferencial')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('hydraulic_oil_level')->label('Nivel aceite hidraulico')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('hydraulic_oil_inspection')->label('Inspeccion aceite hidraulico')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                        ])->columns(3)->collapsed(),

                    Section::make('Filtros')
                        ->schema([
                            Repeater::make('check_air_filters')->label('Revision filtros de aire')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('filters_with_sunken')->label('Filtros con hundidos o golpes')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('leaking_filters')->label('Filtros con fugas')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                        ])->columns(3)->collapsed(),

                    Section::make('Accionamiento')
                        ->schema([
                            Repeater::make('visible_drive_organs')->label('Organos de accionamiento visibles')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('pen_and_shovel')->label('Pluma y pala con dispositivos de bloqueo')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('warning_signs')->label('Señales de advertencia luminosas o acusticas')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('stop_device')->label('Dispositivos de parada de emergencia')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('lifting_cylinders')->label('Cilindros de levante')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('articulation_cylinders')->label('Cilindros de articulacion')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('cylinder_pins')->label('Pasadores de cilindro')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),

                        ])->columns(3)->collapsed(),

                    Section::make('Revisión interior')
                        ->schema([
                            Repeater::make('easy_access')->label('Acceso facil y seguro')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('seat')->label('Asiento, cinturon de seguridad')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('damaged_items')->label('Elementos deteriorados')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('temperature_indicator')->label('Indicador de Temperatura')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('oil_indicator')->label('Indicador de aceite')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('fuel_indicator')->label('Indicador de combustible')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('battery_indicator')->label('Indicador de bateria')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('a_c')->label('A/C')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                        ])->columns(3)->collapsed(),

                    Section::make('Revisión externa')
                        ->schema([
                            Repeater::make('general_structure')->label('Estructura general')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('doors')->label('Puertas')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('exhaust_pipe')->label('Tubo de escape')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                        ])->columns(3)->collapsed(),

                    Section::make('Llantas')
                        ->schema([
                            Repeater::make('front_left_1')->label('Delantera Izquiera(1)')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('front_right_2')->label('Delantera Derecha(2)')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('middle_left_die_3')->label('Troque medio izq (3)')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('middle_left_die_4')->label('Troque medio izq (4)')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('middle_right_die_5')->label('Troque medio der(5)')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('middle_right_die_6')->label('Troque medio der(6)')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('last_left_die_7')->label('ultimo troque izq(7)')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('last_left_die_8')->label('ultimo troque izq(8)')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('last_right_die_9')->label('ultimo troque der(9)')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('last_right_die_10')->label('ultimo troque der(10)')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('spare_tires')->label('Llanta de Repuesto')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('wheels')->label('Rines')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('nuts')->label('Tuercas, esparragos, tornillos pernos')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('tire_pressure')->label('Presion de las llantas')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                        ])->columns(3)->collapsed(),

                    Section::make('Vidrios')
                        ->schema([
                            Repeater::make('mirrors')->label('Retrovisores')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                            Repeater::make('windshield')->label('Parabrisas')
                                ->schema([
                                    Radio::make('checkbox')->label('Selecciona una opción')
                                        ->options([
                                            'CUMPLE' => 'CUMPLE',
                                            'NO CUMPLE' => 'NO CUMPLE',
                                            'N/A' => 'N/A',
                                        ])->columns(3),
                                    Textarea::make('why_not')->label('Por que no cumple?')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                    Textarea::make('observations')->label('Observación')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])
                                ->addable(false)
                                ->deletable(false),
                        ])->columns(3)->collapsed(),

                    Forms\Components\Textarea::make('observations')
                        ->maxLength(65535)
                        ->columnSpanFull()->label('Observaciones'),
                ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('equipment_machinery.name')->label('Equipamiento')
                    ->numeric()
                    ->sortable(),
                CustomColumnInspection::make('hourometer')->label('Horometro'),
                CustomColumnInspection::make('property_card')->label('Tarjeta de propiedad'),
                CustomColumnInspection::make('soat')->label('Tarjeta de propiedad'),
                CustomColumnInspection::make('technomechanical')->label('Tarjeta de propiedad'),
                CustomColumnInspection::make('company_card')->label('Tarjeta de propiedad'),
                CustomColumnInspection::make('ingenio_card')->label('Tarjeta de propiedad'),
                CustomColumnInspection::make('driving_license')->label('Tarjeta de propiedad'),
                CustomColumnInspection::make('helmet')->label('Tarjeta de propiedad'),
                CustomColumnInspection::make('boots')->label('Tarjeta de propiedad'),
                CustomColumnInspection::make('uniform')->label('Tarjeta de propiedad'),
                CustomColumnInspection::make('glasses')->label('Tarjeta de propiedad'),
                CustomColumnInspection::make('extinguisher')->label('Tarjeta de propiedad'),
                CustomColumnInspection::make('kit')->label('Tarjeta de propiedad'),
                CustomColumnInspection::make('reflective_tapes')->label('Tarjeta de propiedad'),
                CustomColumnInspection::make('cones')->label('Tarjeta de propiedad'),
                CustomColumnInspection::make('reflective_vest')->label('Tarjeta de propiedad'),
                Tables\Columns\TextColumn::make('created_at')->label('Creado en')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEMInspections::route('/'),
            'create' => Pages\CreateEMInspection::route('/create'),
            'edit' => Pages\EditEMInspection::route('/{record}/edit'),
        ];
    }
}
