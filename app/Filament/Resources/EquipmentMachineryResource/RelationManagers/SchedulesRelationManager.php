<?php

namespace App\Filament\Resources\EquipmentMachineryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SchedulesRelationManager extends RelationManager
{
    protected static string $relationship = 'schedules';

    protected static ?string $title = 'Programación';

    protected static ?string $modelLabel = 'Programación de mantenimiento';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('date')->label('Fecha de mantenimiento')
                    ->required(),
                Forms\Components\Textarea::make('description')->label('descripción')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('date')
            ->columns([
                Tables\Columns\TextColumn::make('date')->label('Fecha de mantenimiento'),
                Tables\Columns\TextColumn::make('description')->label('Descripción'),
                Tables\Columns\IconColumn::make('status')->label('Estado')
                ->icon(fn (string $state): string => match ($state) {
                    'cancel' => 'heroicon-o-exclamation-circle',
                    'pending' => 'heroicon-o-clock',
                    'completed' => 'heroicon-o-check-circle',
                })
                ->color(fn (string $state): string => match ($state) {
                    'cancel' => 'danger',
                    'pending' => 'warning',
                    'completed' => 'success',
                    default => 'gray',
                }),

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
