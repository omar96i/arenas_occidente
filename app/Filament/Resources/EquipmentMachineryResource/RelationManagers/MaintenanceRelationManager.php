<?php

namespace App\Filament\Resources\EquipmentMachineryResource\RelationManagers;

use App\Models\EquipmentMachineryOption;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MaintenanceRelationManager extends RelationManager
{
    protected static string $relationship = 'maintenance';

    protected static ?string $title = 'Mantenimientos';

    protected static ?string $modelLabel = 'Mantenimiento';

    public function form(Form $form): Form
    {
        $options_activities = [
            'Cambio Aceite Motor' => 'Cambio Aceite Motor',								
            'Cambio Aceite Caja de Velocidades' => 'Cambio Aceite Caja de Velocidades',								
            'Cambio Aceite Transmision' => 'Cambio Aceite Transmision',								
            'Cambio Aceite Servo' => 'Cambio Aceite Servo',								
            'Cambio Aceite Hidraulico' => 'Cambio Aceite Hidraulico',								
            'Cambio Aceite Hidraulico Direccion' => 'Cambio Aceite Hidraulico Direccion',								
            'Cambio Aceite Reductores' => 'Cambio Aceite Reductores',								
            'Cambio Agua de Radiador' => 'Cambio Agua de Radiador',								
            'Engrasada General' => 'Engrasada General',		
            'Cambio Filtro Aceite Motor' => 'Cambio Filtro Aceite Motor',						
            'Cambio Filtro Combustible Primario' => 'Cambio Filtro Combustible Primario',						
            'Cambio Filtro Combustible Secund' => 'Cambio Filtro Combustible Secund',						
            'Cambio Filtro Aire Primario' => 'Cambio Filtro Aire Primario',						
            'Cambio Filtro Aire Secundario' => 'Cambio Filtro Aire Secundario',						
            'Cambio Filtro de Agua' => 'Cambio Filtro de Agua',						
            'Cambio Filtro Hidraulico' => 'Cambio Filtro Hidraulico',						
            'Cambio Filtro Hidraulico Direccion' => 'Cambio Filtro Hidraulico Direccion',						
            'Cambio Filtro Servotransmision' => 'Cambio Filtro Servotransmision',
            'Cambio Filtro Secador Aire' => 'Cambio Filtro Secador Aire',						
            'Sopleteo Filtro Aire' => 'Sopleteo Filtro Aire',		
        ];

        $activities = [
            ['activity' => 'Cambio Aceite Motor', 'cod' => '', 'cant' => '',],				
            ['activity' => 'Cambio Aceite Caja de Velocidades', 'cod' => '', 'cant' => '',],				
            ['activity' => 'Cambio Aceite Transmision', 'cod' => '', 'cant' => '',],				
            ['activity' => 'Cambio Aceite Servo', 'cod' => '', 'cant' => '',],				
            ['activity' => 'Cambio Aceite Hidraulico', 'cod' => '', 'cant' => '',],				
            ['activity' => 'Cambio Aceite Hidraulico Direccion', 'cod' => '', 'cant' => '',],				
            ['activity' => 'Cambio Aceite Reductores', 'cod' => '', 'cant' => '',],				
            ['activity' => 'Cambio Agua de Radiador', 'cod' => '', 'cant' => '',],				
            ['activity' => 'Engrasada General', 'cod' => '', 'cant' => '',],	
            ['activity' => 'Cambio Filtro Aceite Motor', 'cod' => '', 'cant' => '',],			
            ['activity' => 'Cambio Filtro Combustible Primario', 'cod' => '', 'cant' => '',],			
            ['activity' => 'Cambio Filtro Combustible Secund', 'cod' => '', 'cant' => '',],			
            ['activity' => 'Cambio Filtro Aire Primario', 'cod' => '', 'cant' => '',],			
            ['activity' => 'Cambio Filtro Aire Secundario', 'cod' => '', 'cant' => '',],			
            ['activity' => 'Cambio Filtro de Agua', 'cod' => '', 'cant' => '',],			
            ['activity' => 'Cambio Filtro Hidraulico', 'cod' => '', 'cant' => '',],			
            ['activity' => 'Cambio Filtro Hidraulico Direccion', 'cod' => '', 'cant' => '',],			
            ['activity' => 'Cambio Filtro Servotransmision', 'cod' => '', 'cant' => '',],
            ['activity' => 'Cambio Filtro Secador Aire', 'cod' => '', 'cant' => '',],			
            ['activity' => 'Sopleteo Filtro Aire', 'cod' => '', 'cant' => '',],									
        ];
        return $form
            ->schema([
                Section::make('MANTENIMIENTOS CORRECTIVOS Y PREVENTIVOS')
                    ->schema([
                        Placeholder::make('equipment_machinery.name')
                            ->label('Equipo')
                            ->content(
                                function ($livewire) {
                                    return $livewire->ownerRecord->name;
                                }
                            ),
                        TextInput::make('code')
                            ->label('Cod')
                            ->required(),
                        Select::make('maintenance_type')
                            ->label('Tipo de mantenimiento')
                            ->native(false)
                            ->options([
                                'preventivo' => 'Preventivo',
                                'correctivo' => 'Correctivo',
                            ]),
                        Grid::make()
                            ->schema([
                                DatePicker::make('entry_date')
                                    ->label('Fecha de Entrada')
                                    ->required()
                                    ->displayFormat('d/m/Y'),
                                DatePicker::make('exit_date')
                                    ->label('Fecha de Salida')
                                    ->required()
                                    ->displayFormat('d/m/Y'),
                                TextInput::make('measure')
                                    ->numeric()
                                    ->label('Medida (horometro/km)')
                                    ->required(),
                                TextInput::make('estimated_time')
                                    ->numeric()
                                    ->label('Tiempo Estimado(h)')
                                    ->required(),
                                TextInput::make('real_time')
                                    ->numeric()
                                    ->label('Tiempo Real (h)')
                                    ->required(),
                                TextInput::make('driver')
                                    ->label('Conductor'),
                        ])->columns(3),
                ])->columns(3),
                Section::make('DESCRIPCIÓN DE MANTENIMIENTO PREVENTIVO')
                ->schema([
                    Repeater::make('activities')
                        ->label('Actividades')
                        ->schema([
                            TextInput::make('activity')
                                ->label('Actividad')
                                ->required()
                                ->readOnly(),
                            TextInput::make('cod')
                                ->label('Cod'),
                            TextInput::make('cant')
                                ->label('Cant'),
                        ])
                        ->addable(false)
                        ->deletable(false)
                        ->reorderable(false)
                        ->default($activities)
                        ->columns(3)
                        ->columnSpan('full'),
                ])
                ->collapsible(),
                Section::make('OTROS TRABAJOS')
                ->schema([
                    TextInput::make('other_activities')
                        ->label('Otras Actividades'),
                    TextInput::make('welding_activities')
                        ->label('Trabajos de soldadura'),
                    TextInput::make('description_corrective_maintenance')
                        ->label('Descripcion Mantenimiento Correctivo'),
                ])
                ->columns(1)
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Id'),
                Tables\Columns\TextColumn::make('code')
                    ->label('Cod'),
                Tables\Columns\TextColumn::make('entry_date')
                    ->label('Fecha de Entrada'),
                Tables\Columns\TextColumn::make('exit_date')
                    ->label('Fecha de Salida'),
                Tables\Columns\TextColumn::make('maintenance_type')
                    ->label('Tipo de Mantenimiento'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Ver')
                    ->color('info'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
