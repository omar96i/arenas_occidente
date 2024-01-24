<?php

namespace App\Filament\Resources\EquipmentMachineryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TechnosRelationManager extends RelationManager
{
    protected static string $relationship = 'technos';

    protected static ?string $title = 'Tecnomecanica';

    protected static ?string $modelLabel = 'Tecnomecanica';

    public function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('technomechanical')->label('Tecnomecanica')
                ->required()
                ->maxLength(191),
            Forms\Components\DatePicker::make('date_tuition')->label('Fecha de matricula')
                ->required(),
            Forms\Components\DatePicker::make('last_revision')->label('Fecha de ultima revisión')
                ->required(),
            Forms\Components\DatePicker::make('date_revision')->label('Fecha de revisión')
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
            ->recordTitleAttribute('technomechanical')
            ->columns([
                Tables\Columns\ImageColumn::make('file')->label('imagen')
                    ->circular()
                    ->disk('public'),
                Tables\Columns\TextColumn::make('equipment_machinery.name')->label('Equipo o maquinaria')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('technomechanical')->label('Tecnomecanica')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_tuition')->label('Fecha de matricula')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_revision')->label('Fecha de ultima revisión')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_revision')->label('Fecha de revisión')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')->label('Estado')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
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
