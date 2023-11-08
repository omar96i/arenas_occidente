<?php

namespace App\Filament\Resources\EquipmentResource\RelationManagers;

use App\Models\EquipmentOption;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'options';

    protected static ?string $title = 'Parametros';

    protected static ?string $modelLabel = 'Parametro';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('equipment_option_id')->label('Parametro a usar')
                    ->options(function($livewire){
                        $record_id = $livewire->ownerRecord->id;
                        $options = EquipmentOption::whereDoesntHave('equipments', function ($query) use ($record_id) {
                            $query->where('equipment_id', $record_id);
                        })->get();
                        if ($options) {
                            return $options->pluck('name', 'id')->toArray();
                        }
                    })
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
                Tables\Columns\TextColumn::make('value')->label('Valor asignado'),
                Tables\Columns\TextColumn::make('option.name')->label('Nombre del parametro'),
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
