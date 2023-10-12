<?php

namespace App\Filament\Resources\EntityResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MeasuresRelationManager extends RelationManager
{
    protected static string $relationship = 'measures';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('description')
                ->options([
                    'Primer turno: de 6am-2pm' => 'Primer turno: de 6am-2pm',
                    'Segundo turno: de 2pm-10pm' => 'Segundo turno: de 2pm-10pm',
                    'Tercer turno: de 10pm-6am' => 'Tercer turno: de 10pm-6am',
                    'Turno día fin de semana: de 6am-6pm' => 'Turno día fin de semana: de 6am-6pm',
                    'Turno noche fin de semana: de 6pm-6am' => 'Turno noche fin de semana: de 6pm-6am',
                    'Descanso' => 'Descanso',
                ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nombre'),
                Tables\Columns\TextColumn::make('description')->label('Descripcion'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Crear medida'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Editar'),
                Tables\Actions\DeleteAction::make()->label('Eliminar'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Eliminar'),
                ]),
            ]);
    }
}
