<?php

namespace App\Filament\Resources\EquipmentMachineryResource\RelationManagers;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
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
                Forms\Components\DatePicker::make('date')->label('Fecha de mantenimiento')->live()
                    ->afterStateUpdated(function (Set $set, $state){
                        if ($state) {
                            $selectedDate = Carbon::parse($state);
                            $today = Carbon::now();
                            $sevenDaysFromNow = $today->copy()->addDays(7);

                            if ($selectedDate->lt($today)) {
                                $set('status', 'PASADO');
                            } elseif ($selectedDate->between($today, $sevenDaysFromNow)) {
                                $set('status', 'PROXIMO');
                            } else {
                                $set('status', 'BUEN ESTADO');
                            }
                        }
                    })
                    ->required(),
                Forms\Components\Select::make('user_id')->label('Empleado')
                        ->relationship('user', 'full_name')
                        ->placeholder('Selecciona un empleado')
                        ->required(),
                Forms\Components\Textarea::make('description')->label('descripción')
                    ->required(),
                Forms\Components\TextInput::make('mileage')->label('Kilometraje')
                    ->required(),
                Forms\Components\TextInput::make('hourometer')->label('Horometro')
                    ->required(),
                Forms\Components\TextInput::make('status')->label('Estado')
                    ->readonly()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('date')
            ->columns([
                Tables\Columns\TextColumn::make('user.full_name')->label('Empleado'),
                Tables\Columns\TextColumn::make('date')->label('Fecha de mantenimiento'),
                Tables\Columns\TextColumn::make('description')->label('Descripción'),
                Tables\Columns\TextColumn::make('mileage')->label('Kilometraje'),
                Tables\Columns\TextColumn::make('hourometer')->label('Horometro'),

                Tables\Columns\IconColumn::make('status')->label('Estado')
                ->icon(fn (string $state): string => match ($state) {
                    'PASADO' => 'heroicon-o-exclamation-circle',
                    'PROXIMO' => 'heroicon-o-clock',
                    'BUEN ESTADO' => 'heroicon-o-check-circle',
                })
                ->color(fn (string $state): string => match ($state) {
                    'PASADO' => 'danger',
                    'PROXIMO' => 'warning',
                    'BUEN ESTADO' => 'success',
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
