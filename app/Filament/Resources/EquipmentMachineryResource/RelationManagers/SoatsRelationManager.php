<?php

namespace App\Filament\Resources\EquipmentMachineryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SoatsRelationManager extends RelationManager
{
    protected static string $relationship = 'soats';

    protected static ?string $title = 'Soats';

    protected static ?string $modelLabel = 'Soats';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->label('Soat')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('beneficiary')->label('Beneficiario')
                    ->required()
                    ->maxLength(191),
                Forms\Components\DatePicker::make('validity')->label('Vigencia')
                    ->required(),
                Forms\Components\FileUpload::make('file')->label('Subir evidencia'),
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
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\ImageColumn::make('file')->label('imagen')
                    ->circular()
                    ->disk('public'),
                Tables\Columns\TextColumn::make('equipment_machinery.name')->label('Equipo o maquinaria')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')->label('Soat')
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
