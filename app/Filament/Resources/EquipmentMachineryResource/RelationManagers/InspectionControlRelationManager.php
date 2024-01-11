<?php

namespace App\Filament\Resources\EquipmentMachineryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InspectionControlRelationManager extends RelationManager
{
    protected static string $relationship = 'inspection_control';

    protected static ?string $title = 'Control de inspecciones';

    protected static ?string $modelLabel = 'Control de inspecciones';

    public function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make('Datos de ultima inspección y la siguiente')
            ->schema([
                Grid::make()
                    ->schema([
                        Forms\Components\DatePicker::make('last_report')->label('Fecha del ultimo reporte'),
                        Forms\Components\DatePicker::make('actual_report')->label('Fecha actual'),
                        Forms\Components\DatePicker::make('next_report')->label('Fecha de la proxima inspección'),
                        Forms\Components\TextInput::make('hourometer')->label('Horometro o KM ultima inspección')
                            ->numeric(),
                        Forms\Components\TextInput::make('frequency')->label('Frecuencia')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('unit')->label('Unidad')
                            ->required()
                            ->maxLength(191),
                        Forms\Components\Select::make('status')->label('Estado')
                            ->required()
                            ->options([
                                'BUEN ESTADO' => 'BUEN ESTADO',
                                'PROXIMO' => 'PROXIMO',
                                'PASADO' => 'PASADO',
                            ]),
                    ])->columns(3),
            ]),

            Section::make('Datos del extintor')
                ->schema([
                    Grid::make()
                        ->schema([
                            Forms\Components\DatePicker::make('extinguisher_expiration')->label('Fecha de vencimiento Extintor')->live(),
                            Forms\Components\Select::make('extinguisher_status')->label('Estado del extintor')
                                ->options([
                                    'BUEN ESTADO' => 'BUEN ESTADO',
                                    'PROXIMO' => 'PROXIMO',
                                    'PASADO' => 'PASADO',
                                ]),
                        ])->columns(2),
                ]),
            Section::make('Datos adicionales')
                ->schema([
                    Grid::make()
                        ->schema([
                            Forms\Components\TextInput::make('installed_board')->label('Plaqueta instalada eje satelital(IMEI)')
                                ->maxLength(191),
                            Forms\Components\TextInput::make('installed_board_id')->label('Número de I. o seire del GPS provedor nacional')
                                ->maxLength(191),
                            Forms\Components\TextInput::make('installed_board_status')->label('Estado en el runt')
                                ->maxLength(191),
                        ])->columns(2),
                ]),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('last_report')
            ->columns([
                Tables\Columns\TextColumn::make('equipment_machinery.name')->label('Equipo')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_report')->label('Fecha del ultimo reporte')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('actual_report')->label('Fecha actual')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('next_report')->label('Fecha de la proxima inspección')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('hourometer')->label('Horometro o KM ultima inspección')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('frequency')->label('Frecuencia')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('unit')->label('Unidad')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')->label('Estado')
                    ->searchable(),
                Tables\Columns\TextColumn::make('extinguisher_expiration')->label('Fecha de vencimiento Extintor')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('extinguisher_status')->label('Estado del extintor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('installed_board')->label('Plaqueta instalada eje satelital(IMEI)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('installed_board_id')->label('Número de I. o seire del GPS provedor nacional')
                    ->searchable(),
                Tables\Columns\TextColumn::make('installed_board_status')->label('Estado en el runt')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')->label('Fecha de creación del registro')
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
