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
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;

class EMInspectionResource extends Resource
{
    protected static ?string $model = EMInspection::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-magnifying-glass';

    protected static ?string $navigationLabel = 'Inspecciones';

    protected static ?string $slug = 'inspecciones';

    protected static ?string $modelLabel = 'Inspecciones';

    protected static ?string $navigationGroup = 'Administración de maquinaria y equipos';

    protected static ?int $navigationSort = 10;

    public static function canViewAny(): bool
    {
        $user = auth()->user();
        $allowedRoles = ['administracion'];
        return in_array($user->position, $allowedRoles);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Forms\Components\Select::make('equipment_machinery_id')->label('Selecciona un equipo')
                            ->relationship('equipment_machinery', 'name')
                            ->required(),
                        Forms\Components\DatePicker::make('date')->label('Fecha del registro'),
                        Forms\Components\Select::make('type')->label('Tipo de vehiculo')
                            ->options([
                                'volqueta' => 'Volqueta',
                                'cargador' => 'Cargador',
                            ])->required()->live(),
                        Grid::make(1)
                            ->schema([
                                Repeater::make('hourometer')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Horometro - Completo';
                                        }
                                        return 'Horometro';
                                    }),

                                Repeater::make('extinguisher')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        DatePicker::make('date')->label('Fecha de vencimiento'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Extintor - Completo';
                                        }
                                        return 'Extintor';
                                    }),
                                Repeater::make('brake_leaks')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion')->placeholder('ESTADO DE FRENOS DESCRIBIR QUE LADO DE RUEDA'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Frenos - Fugas - Completo';
                                        }
                                        return 'Frenos - Fugas';
                                    }),

                                Repeater::make('brakes_humidity')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->hidden(fn(Get $get) : bool => $get('type') == 'volqueta')
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Frenos - Humedad De Liquido - Completo';
                                        }
                                        return 'Frenos - Humedad De Liquido';
                                    }),

                                Repeater::make('brakes_bearings')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->hidden(fn(Get $get) : bool => !$get('type') == 'volqueta')
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Frenos - Rodamiento - Completo';
                                        }
                                        return 'Frenos - Rodamiento';
                                    }),


                                Repeater::make('bushing_bar_terminals')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->hidden(fn(Get $get) : bool => !$get('type') == 'volqueta')
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Terminal - Bujes - Completo';
                                        }
                                        return 'Terminal - Bujes';
                                    }),

                                Repeater::make('leaf_springs')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->hidden(fn(Get $get) : bool => !$get('type') == 'volqueta')
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Muelles - Hojas - Completo';
                                        }
                                        return 'Muelles - Hojas';
                                    }),





                                Repeater::make('leak_hoses')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion')->placeholder('DESCRIBIR POSICION DE MANGUERA'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Mangueras - Fugas - Completo';
                                        }
                                        return 'Mangueras - Fugas';
                                    }),

                                Repeater::make('cats_leak')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion')->placeholder('DESCRIBIR POSICION DEL GATO'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->hidden(fn(Get $get) : bool => $get('type') == 'volqueta')
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Gatos - Fugas - Completo';
                                        }
                                        return 'Gatos - Fugas';
                                    }),

                                Repeater::make('cervo_fuga')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion')->placeholder('DESCRIBIR ESTADO DEL ACEITE'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->hidden(fn(Get $get) : bool => $get('type') == 'volqueta')
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Cervo - Fugas - Completo';
                                        }
                                        return 'Cervo - Fugas';
                                    }),

                                Repeater::make('engine_oil_leak')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion')->label('DESCRIBIR SI ES MANGUERA,RETENEDOR O EMPAQUE'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Motor - Fuga de aceite - Completo';
                                        }
                                        return 'Motor - Fuga de aceite';
                                    }),

                                Repeater::make('engine_water_leak')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion')->placeholder('DESCRIBIR SI ES BOMBA DE AGUA O MANGUERA'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Motor - Fuga de agua - Completo';
                                        }
                                        return 'Motor - Fuga de agua';
                                    }),

                                Repeater::make('motor_leak_acpm')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion')->placeholder('DESCRIBIR SI ES MANGUERA,RETENEDOR O TOBERAS O BOMBA DE INYECCION'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Motor - Fuga de ACPM - Completo';
                                        }
                                        return 'Motor - Fuga de ACPM';
                                    }),

                                Repeater::make('turbo_leaks')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->hidden(fn(Get $get) : bool => !$get('type') == 'volqueta')
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Turbo - Fuga - Completo';
                                        }
                                        return 'Turbo - Fuga';
                                    }),

                                Repeater::make('leak_transmissions')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion')->placeholder('DESCRIBIR NOVEDADES'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Transmisiones - Fugas - Completo';
                                        }
                                        return 'Transmisiones - Fugas';
                                    }),

                                Repeater::make('oil_cooler_leaks')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->hidden(fn(Get $get) : bool => !$get('type') == 'volqueta')
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Enfriador de aceite - Fuga - Completo';
                                        }
                                        return 'Enfriador de aceite - Fuga';
                                    }),

                                Repeater::make('hydraulic_pump_leak')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion')->placeholder('DESCRIPCION NOVEDADE'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Bomba hidraulica - Fugas - Completo';
                                        }
                                        return 'Bomba hidraulica - Fugas';
                                    }),

                                Repeater::make('valves_oil_leaks')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->hidden(fn(Get $get) : bool => !$get('type') == 'volqueta')
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Valvula de aire - Fugas - Completo';
                                        }
                                        return 'Valvula de aire - Fugas';
                                    }),

                                Repeater::make('air_compressor_status')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->hidden(fn(Get $get) : bool => !$get('type') == 'volqueta')
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Compresor aire - Estado - Completo';
                                        }
                                        return 'Compresor aire - Estado';
                                    }),

                                Repeater::make('fan_clutch')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->hidden(fn(Get $get) : bool => !$get('type') == 'volqueta')
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Fan cluntch - Estado - Completo';
                                        }
                                        return 'Fan cluntch - Estado';
                                    }),

                                Repeater::make('clutch_crutch_state')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->hidden(fn(Get $get) : bool => !$get('type') == 'volqueta')
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Embrague cluntch - Para cambio - Completo';
                                        }
                                        return 'Embrague cluntch - Para cambio';
                                    }),

                                Repeater::make('dryer_valve')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->hidden(fn(Get $get) : bool => !$get('type') == 'volqueta')
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Valvula secadora - Para cambio o fuga - Completo';
                                        }
                                        return 'Valvula secadora - Para cambio o fuga';
                                    }),

                                Repeater::make('bomb_deer')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion')->label('DESCRIPCION ESTADO Y NECESIDAD'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->hidden(fn(Get $get) : bool => $get('type') == 'volqueta')
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Bomba Cervo - Completo';
                                        }
                                        return 'Bomba Cervo';
                                    }),

                                Repeater::make('radiator_leaks')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion')->label('DESCRIPCION ESTADO'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Radiador - Fugas - Completo';
                                        }
                                        return 'Radiador - Fugas';
                                    }),

                                Repeater::make('fan_retainer_change')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion')->label('DESCRIPCION ESTADO'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Ventilador - Cambio de retenedores - Completo';
                                        }
                                        return 'Ventilador - Cambio de retenedores';
                                    }),

                                Repeater::make('straps_change_belts')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion')->placeholder('DESCRIPCION UBICACIÓN DE LA CORREA'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Correas - Cambio de correa - Completo';
                                        }
                                        return 'Correas - Cambio de correa';
                                    }),

                                Repeater::make('swing_motor_leaks')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion')->placeholder('DESCRIPCION'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Motor de giro S/A - Fugas - Completo';
                                        }
                                        return 'Motor de giro S/A - Fugas';
                                    }),

                                Repeater::make('take_strenght')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->hidden(fn(Get $get) : bool => !$get('type') == 'volqueta')
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Toma fuerza - Cambio o fuga - Completo';
                                        }
                                        return 'Toma fuerza - Cambio o fuga';
                                    }),


                                Repeater::make('bucket_changing_blades')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion')->placeholder('DESCRIPCION ESTADO DEL CUCHARON Y NECESIDADES'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->hidden(fn(Get $get) : bool => $get('type') == 'volqueta')
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Cucharon - Cambio de cuchillas - Completo';
                                        }
                                        return 'Cucharon - Cambio de cuchillas';
                                    }),

                                Repeater::make('bushings_change_of_hubs')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion')->placeholder('DESCRIBIR ESTADO DE BUJES DE TODO EL EQUIPO Y UBICACIÓN'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Bujes - Cambio de Bujes - Completo';
                                        }
                                        return 'Bujes - Cambio de Bujes';
                                    }),

                                Repeater::make('cardal_cross')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->hidden(fn(Get $get) : bool => !$get('type') == 'volqueta')
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Crucetas y cardan - Cambio - Completo';
                                        }
                                        return 'Crucetas y cardan - Cambio';
                                    }),

                                Repeater::make('gearbox')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->hidden(fn(Get $get) : bool => !$get('type') == 'volqueta')
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Caja de cambio - Fuga o cambio - Completo';
                                        }
                                        return 'Caja de cambio - Fuga o cambio';
                                    }),

                                Repeater::make('address_box')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->hidden(fn(Get $get) : bool => !$get('type') == 'volqueta')
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Caja de direccion - Completo';
                                        }
                                        return 'Caja de direccion';
                                    }),

                                Repeater::make('tires_change')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion')->placeholder('ESTADO DE LA LLANTA Y UBICACIÓN'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Llantas - Cambio - Completo';
                                        }
                                        return 'Llantas - Cambio';
                                    }),

                                Repeater::make('news')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Novedades - Completo';
                                        }
                                        return 'Novedades';
                                    }),

                                Repeater::make('lc_cabin_upper_streetlights')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->hidden(fn(Get $get) : bool => $get('type') == 'volqueta')
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Luces cabina - Farolas superior de cabina (Luces) - Completo';
                                        }
                                        return 'Luces cabina - Farolas superior de cabina (Luces)';
                                    }),

                                Repeater::make('lc_main')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->hidden(fn(Get $get) : bool => !$get('type') == 'volqueta')
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Farolas (Luces), Principal - Completo';
                                        }
                                        return 'Farolas (Luces), Principal';
                                    }),

                                Repeater::make('lc_side_lights')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Luces cabina - Luces laterales - Completo';
                                        }
                                        return 'Luces cabina - Luces laterales';
                                    }),

                                Repeater::make('lc_board')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->hidden(fn(Get $get) : bool => !$get('type') == 'volqueta')
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Luces tablero - Completo';
                                        }
                                        return 'Luces tablero';
                                    }),

                                Repeater::make('lc_exploradoras')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->hidden(fn(Get $get) : bool => !$get('type') == 'volqueta')
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Luces cabina - Exploradoras de reversa estribo - Completo';
                                        }
                                        return 'Luces cabina - Exploradoras de reversa estribo';
                                    }),

                                Repeater::make('lc_rear_lights_upper_cabin')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->hidden(fn(Get $get) : bool => $get('type') == 'volqueta')
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Luces cabina - Luces traseras superior de cabina - Completo';
                                        }
                                        return 'Luces cabina - Luces traseras superior de cabina';
                                    }),

                                Repeater::make('lc_rear_lights_side_hood')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->hidden(fn(Get $get) : bool => $get('type') == 'volqueta')
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Luces cabina - Luces traseras capo lateral - Completo';
                                        }
                                        return 'Luces cabina - Luces traseras capo lateral';
                                    }),

                                Repeater::make('lc_stop')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Luces cabina - Stop - Completo';
                                        }
                                        return 'Luces cabina - Stop';
                                    }),

                                Repeater::make('lc_reverse_alarm')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Luces cabina - Alarma de reversa - Completo';
                                        }
                                        return 'Luces cabina - Alarma de reversa';
                                    }),

                                Repeater::make('lc_light_media')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Luces cabina - Luz media - Completo';
                                        }
                                        return 'Luces cabina - Luz media';
                                    }),

                                Repeater::make('lc_stationary')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Luces cabina - Estacionarias - Completo';
                                        }
                                        return 'Luces cabina - Estacionarias';
                                    }),

                                Repeater::make('lc_pito')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Luces cabina - Pito - Completo';
                                        }
                                        return 'Luces cabina - Pito';
                                    }),

                                Repeater::make('lc_feathers_change')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->hidden(fn(Get $get) : bool => !$get('type') == 'volqueta')
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Luces cabina - Plumillas cambio - Completo';
                                        }
                                        return 'Luces cabina - Plumillas cambio';
                                    }),

                                Repeater::make('lc_motor_emcarpado')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->hidden(fn(Get $get) : bool => !$get('type') == 'volqueta')
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Luces cabina - Motor de emcarpado - Completo';
                                        }
                                        return 'Luces cabina - Motor de emcarpado';
                                    }),

                                Repeater::make('lc_temperature_relog')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Luces cabina - Relog de temperatura - Completo';
                                        }
                                        return 'Luces cabina - Relog de temperatura';
                                    }),

                                Repeater::make('lc_horometer')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Luces cabina - Horometro - Completo';
                                        }
                                        return 'Luces cabina - Horometro';
                                    }),

                                Repeater::make('lc_relog_oil_pressure')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Luces cabina - Reloj presion de aceite - Completo';
                                        }
                                        return 'Luces cabina - Reloj presion de aceite';
                                    }),

                                Repeater::make('lc_battery_indicator')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Luces cabina - Indicador de baterias - Completo';
                                        }
                                        return 'Luces cabina - Indicador de baterias';
                                    }),

                                Repeater::make('lc_welding')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Luces cabina - Soldadura - Completo';
                                        }
                                        return 'Luces cabina - Soldadura';
                                    }),

                                Repeater::make('news_2')->label('')->collapsed()
                                    ->schema([
                                        Radio::make('checkbox')->label('Selecciona una opción')->required()->live()
                                            ->options([
                                                'SI' => 'SI',
                                                'NO' => 'NO',
                                            ])->columns(2),
                                        Textarea::make('description')->label('Descripcion'),
                                        FileUpload::make('image')->label('Evidencia')->image()->maxSize(3500)->minSize(512),
                                    ])
                                    ->columns(1)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->collapsible()
                                    ->itemLabel(function(array $state){
                                        if($state['checkbox']){
                                            return 'Novedades - Completo';
                                        }
                                        return 'Novedades';
                                    }),
                            ]),


                    ])->columns(3),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('equipment_machinery.name')->label('Equipamiento')
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')->label('Fecha')
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')->label('Tipo de equipo')
                    ->sortable(),
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
