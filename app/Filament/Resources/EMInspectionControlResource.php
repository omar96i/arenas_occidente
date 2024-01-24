<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EMInspectionControlResource\Pages;
use App\Filament\Resources\EMInspectionControlResource\RelationManagers;
use App\Models\EMInspectionControl;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EMInspectionControlResource extends Resource
{
    protected static ?string $model = EMInspectionControl::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    protected static ?string $navigationLabel = 'Control de inspecciones';

    protected static ?string $slug = 'control-inspecciones';

    protected static ?string $modelLabel = 'Control de inspecciones';

    protected static ?string $navigationGroup = 'Administración de maquinaria y equipos';

    protected static ?int $navigationSort = 9;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Datos de ultima inspección y la siguiente')
                ->schema([
                    Grid::make()
                        ->schema([
                            Forms\Components\Select::make('equipment_machinery_id')
                                ->relationship('equipment_machinery', 'name')
                                ->required()->label('Selecciona un equipo'),


                            Forms\Components\TextInput::make('frequency')->label('Frecuencia')
                                ->required()
                                ->numeric()
                                ->afterStateUpdated(function (Set $set, Get $get, $state){
                                    if(is_null($get('last_report'))){
                                        $last_report = Carbon::now();
                                        $frequency = $state;
                                        $new_date = $last_report->addDays($frequency);
                                        $set('next_report', $new_date->format('Y-m-d'));
                                        $today = date_create(date("Y-m-d"));
                                        $expiration_date = date_create($new_date);
                                        $interval = date_diff($today, $expiration_date);
                                        $days = $interval->format('%R%a');
                                        if($days < 0) {
                                            $set('status', 'PASADO');
                                        } elseif($days >= 0 && $days < 7) {
                                            $set('status', 'PROXIMO');
                                        } else {
                                            $set('status', 'BUEN ESTADO');
                                        }
                                    }else{
                                        $last_report = Carbon::parse($get('last_report'));
                                        $frequency = $state;
                                        $new_date = $last_report->addDays($frequency);
                                        $set('next_report', $new_date->format('Y-m-d'));
                                        $today = date_create(date("Y-m-d"));
                                        $expiration_date = date_create($new_date);
                                        $interval = date_diff($today, $expiration_date);
                                        $days = $interval->format('%R%a');
                                        if($days < 0) {
                                            $set('status', 'PASADO');
                                        } elseif($days >= 0 && $days < 7) {
                                            $set('status', 'PROXIMO');
                                        } else{
                                            $set('status', 'BUEN ESTADO');
                                        }
                                    }

                                })
                                ->live(),
                            Forms\Components\DatePicker::make('last_report')->label('Fecha del ultimo reporte')
                            ->afterStateUpdated(function (Set $set, Get $get, $state){
                                    $last_report = Carbon::parse($state);
                                    $frequency = $get('frequency');
                                    $new_date = $last_report->addDays($frequency);
                                    $set('next_report', $new_date->format('Y-m-d'));
                                    $today = date_create(date("Y-m-d"));
                                    $expiration_date = date_create($new_date);
                                    $interval = date_diff($today, $expiration_date);
                                    $days = $interval->format('%R%a');
                                    if($days < 0) {
                                        $set('status', 'PASADO');
                                    } elseif($days >= 0 && $days < 7) {
                                        $set('status', 'PROXIMO');
                                    } else {
                                        $set('status', 'BUEN ESTADO');
                                    }
                                })->live(),
                            Forms\Components\DatePicker::make('actual_report')->label('Fecha actual')->default(now()->format('Y-m-d'))->disabled(),
                            Forms\Components\DatePicker::make('next_report')->label('Fecha de la proxima inspección')
                                ->live()->disabled(),
                            Forms\Components\TextInput::make('hourometer')->label('Horometro o KM ultima inspección')
                                ->numeric(),
                            Forms\Components\TextInput::make('unit')->label('Unidad')
                                ->required()
                                ->maxLength(191),
                            Forms\Components\TextInput::make('status')->label('Estado')
                                ->readonly()
                                ->required(),
                        ])->columns(3),
                ]),

                Section::make('Datos del extintor')
                    ->schema([
                        Grid::make()
                            ->schema([
                                Forms\Components\DatePicker::make('extinguisher_expiration')->label('Fecha de vencimiento Extintor')->live()
                                    ->afterStateUpdated(function (Set $set, $state){
                                        if ($state) {
                                            $today = date_create(date("Y-m-d"));
                                            $expiration_date = date_create($state);
                                            $interval = date_diff($today, $expiration_date);
                                            $days = $interval->format('%R%a');

                                            if ($days < 0) {
                                                $set('extinguisher_status', 'PASADO');
                                            } elseif ($days >= 0 && $days < 7) {
                                                $set('extinguisher_status', 'PROXIMO');
                                            } else {
                                                $set('extinguisher_status', 'BUEN ESTADO');
                                            }
                                        }
                                    }),
                                Forms\Components\TextInput::make('extinguisher_status')->label('Estado del extintor')
                                    ->required()
                                    ->readonly(),
                            ])->columns(2),
                            // Forms\Components\DatePicker::make('extinguisher_expiration')
                            //     ->live(debounce: 500)
                            //     ->afterStateUpdated(function (Set $set, $state) {
                            //     if ($state) {
                            //         $set('extinguisher_status', true);
                            //     }
                            //     }),
                            // Forms\Components\Select::make('extinguisher_status')
                            //     ->options([
                            //         'true' => 'true',
                            //         'false' => 'false',
                            //     ])
                            //     ->default('false'),
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

    public static function table(Table $table): Table
    {
        return $table
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
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEMInspectionControls::route('/'),
            'create' => Pages\CreateEMInspectionControl::route('/create'),
            'edit' => Pages\EditEMInspectionControl::route('/{record}/edit'),
        ];
    }
}
