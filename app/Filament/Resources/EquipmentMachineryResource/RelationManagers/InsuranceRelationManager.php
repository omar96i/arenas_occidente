<?php

namespace App\Filament\Resources\EquipmentMachineryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InsuranceRelationManager extends RelationManager
{
    protected static string $relationship = 'insurance';

    protected static ?string $title = 'Seguros';

    protected static ?string $modelLabel = 'Seguros';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('sure')->label('Seguro')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('taker')->label('Tomador')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('beneficiary')->label('Beneficiario')
                    ->required()
                    ->maxLength(191),
                Forms\Components\DatePicker::make('validity')->label('Vigencia')
                    ->required(),
                Forms\Components\Select::make('status')->label('Estado')
                    ->required()
                    ->options([
                        'Vigente' => 'Vigente',
                        'Expirado' => 'Expirado',
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('sure')
            ->columns([
                Tables\Columns\TextColumn::make('equipment_machinery.name')->label('Equipo o maquinaria')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sure')->label('Seguro')
                    ->searchable(),
                Tables\Columns\TextColumn::make('taker')->label('Tomador')
                    ->searchable(),
                Tables\Columns\TextColumn::make('beneficiary')->label('Beneficiario')
                    ->searchable(),
                Tables\Columns\TextColumn::make('validity')->label('Vigencia')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')->label('Estado')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')->label('Fecha de creación')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->label('Fecha de actualización')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
