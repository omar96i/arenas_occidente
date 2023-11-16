<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContractsRelationManager extends RelationManager
{
    protected static string $relationship = 'contracts';

    protected static ?string $title  = 'Contratos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('start_date')
                    ->label('Fecha de Inicio')
                    ->required()
                    ->displayFormat('d/m/Y'),
                DatePicker::make('end_date')
                    ->label('Fecha de Finalización')
                    ->displayFormat('d/m/Y'),
                TextInput::make('salary')
                    ->numeric()
                    ->required()
                    ->maxLength(255),
                Toggle::make('status')
                    ->default(true)
                    ->label('Estado')
                    ->onColor('success')
                    ->offColor('danger')
                    ->inline(true),
            ])->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modelLabel('Contrato')
            ->columns([
                TextColumn::make('id')
                    ->label('Id'),
                TextColumn::make('start_date')
                    ->label('Fecha Inicio'),
                TextColumn::make('end_date')
                    ->label('Fecha Fin'),
                TextColumn::make('salary')
                    ->label('Salario'),
                ToggleColumn::make('status')
                    ->label('Estado')
                    ->onColor('success')
                    ->offColor('danger')
                    ->sortable(),
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
