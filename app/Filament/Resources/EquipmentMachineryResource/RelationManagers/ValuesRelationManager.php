<?php

namespace App\Filament\Resources\EquipmentMachineryResource\RelationManagers;

use App\Models\EquipmentMachineryOption;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ValuesRelationManager extends RelationManager
{
    protected static string $relationship = 'values';

    protected static ?string $title = 'Datos';

    protected static ?string $modelLabel = 'Dato';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('equipment_machinery_option_id')
                    ->options(function($livewire){
                        $record_id = $livewire->ownerRecord->id;
                        $options = EquipmentMachineryOption::whereDoesntHave('equipments', function ($query) use ($record_id) {
                            $query->where('equipment_machinery_id', $record_id);
                        })->get();
                        if ($options) {
                            return $options->pluck('name', 'id')->toArray();
                        }
                    })
                    ->label('Parametro a usar')
                    ->required(),
                Forms\Components\TextInput::make('value')->label('Valor a asignar')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('value')
            ->columns([
                Tables\Columns\TextColumn::make('option.name')->label('Nombre del parametro'),
                Tables\Columns\TextColumn::make('value')->label('Valor asignado'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
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
