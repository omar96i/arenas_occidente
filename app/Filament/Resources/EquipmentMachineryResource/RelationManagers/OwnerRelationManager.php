<?php

namespace App\Filament\Resources\EquipmentMachineryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OwnerRelationManager extends RelationManager
{
    protected static string $relationship = 'owner';

    protected static ?string $title = 'Dueño';

    protected static ?string $modelLabel = 'Dueño';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('full_name')->label('Nombre completo')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('nit')->label('NIT')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('tuition')->label('Matricula')
                    ->required()
                    ->maxLength(191),
                Forms\Components\FileUpload::make('file')->label('Subir evidencia'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('full_name')
            ->columns([
                Tables\Columns\ImageColumn::make('file')->label('imagen')
                    ->circular()
                    ->disk('public'),
                Tables\Columns\TextColumn::make('equipment_machinery.name')->label('Equipo o maquinaria')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('full_name')->label('Nombre completo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nit')->label('NIT')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tuition')->label('Matricula')
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
