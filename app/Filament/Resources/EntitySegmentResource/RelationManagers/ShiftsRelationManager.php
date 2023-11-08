<?php

namespace App\Filament\Resources\EntitySegmentResource\RelationManagers;

use App\Models\EntityMeasure;
use App\Models\EntityShift;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Closure;
use Filament\Forms\Components\Section;
use Filament\Forms\Get;

class ShiftsRelationManager extends RelationManager
{
    protected static string $relationship = 'shifts';

    protected static ?string $title = 'Turnos';

    public function form(Form $form): Form
    {

        return $form
            ->schema([
                Section::make()
                    ->description("Recuerda que en la asignación de turno se maneja un limite de tiempo")
                    ->schema([
                        Forms\Components\DatePicker::make('date')->label('Fecha de asignación')
                            ->required()
                            ->rules([
                                'required',
                                fn (Get $get, $livewire): Closure => function (string $attribute, $value, Closure $fail) use ($get, $livewire) {
                                    $entity_measure_id = $get('entity_measure_id');
                                    $user_id = $get('user_id');
                                    $entity_segment_id =  $livewire->ownerRecord->id;
                                    $existingShift = EntityShift::where('date', $value)
                                        ->where('entity_measure_id', $entity_measure_id)
                                        ->where('user_id', $user_id)
                                        ->where('entity_segment_id', $entity_segment_id)
                                        ->first();
                                    if ($existingShift) {
                                        $fail('Ya existe un turno con la misma fecha, medida, usuario y segmento de entidad.');
                                    }
                                    $limit_time = $livewire->ownerRecord->time_limit;
                                    $total_time = 0;
                                    $shifts = EntityShift::where('user_id', $user_id)->where('entity_segment_id', $entity_segment_id)->with('measure')->get();
                                    foreach ($shifts as $shift) {
                                        switch ($shift->measure->description) {
                                            case 'Primer turno: de 6am-2pm':
                                            case 'Segundo turno: de 2pm-10pm':
                                            case 'Tercer turno: de 10pm-6am':
                                                $total_time += 8;
                                                break;
                                            case 'Turno día fin de semana: de 6am-6pm':
                                            case 'Turno noche fin de semana: de 6pm-6am':
                                                $total_time += 12;
                                                break;
                                            case 'Descanso':
                                                // No se suma tiempo en este caso
                                                break;
                                        }
                                    }

                                    if ($total_time >= $limit_time) {
                                        $fail('El usuario sobrepasa las horas asignadas');
                                    }

                                },
                            ]),
                        Forms\Components\Select::make('entity_measure_id')->label('Medida a asignar')
                            ->options(function($livewire){
                                $entity_id = $livewire->ownerRecord->entity_id;
                                $measures = EntityMeasure::where('entity_id', $entity_id)->get();
                                if ($measures) {
                                    return $measures->pluck('name', 'id')->toArray();
                                }
                            })
                            ->required(),
                        Forms\Components\Select::make('user_id')->label('Trabajador a asignar')
                            ->relationship('user', 'name')
                            ->required(),
                    ]),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('date')
            ->columns([
                Tables\Columns\TextColumn::make('date')->sortable()->searchable()->label('Fecha de asignación'),
                Tables\Columns\TextColumn::make('user.name')->sortable()->searchable()->label('Trabajador asignado'),
                Tables\Columns\TextColumn::make('measure.description')->sortable()->searchable()->label('Medida'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Nuevo turno')->modalHeading('Crear nuevo turno'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Editar')->modalHeading('Editar turno'),
                Tables\Actions\DeleteAction::make()->label('Eliminar'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Eliminar'),
                ]),
            ]);
    }
}
