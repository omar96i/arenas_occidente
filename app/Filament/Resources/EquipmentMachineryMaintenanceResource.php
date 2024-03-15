<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipmentMachineryMaintenanceResource\Pages;
use App\Filament\Resources\EquipmentMachineryMaintenanceResource\RelationManagers;
use App\Models\EquipmentMachinery;
use App\Models\EquipmentMachineryMaintenance;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EquipmentMachineryMaintenanceResource extends Resource
{
    protected static ?string $model = EquipmentMachineryMaintenance::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $navigationLabel = 'Mantenimientos';

    protected static ?string $slug = 'mantenimiento';

    protected static ?int $navigationSort = 6;

    protected static ?string $modelLabel = 'Mantenimiento';

    protected static ?string $navigationGroup = 'Administración de maquinaria y equipos';

    public static function canViewAny(): bool
    {
        $user = auth()->user();
        $allowedRoles = ['administracion'];
        return in_array($user->position, $allowedRoles);
    }

    public static function form(Form $form): Form
    {
        $activities = [
            ['activity' => 'Cambio Aceite Motor', 'cod' => '', 'cant' => '',],
            ['activity' => 'Cambio Aceite Caja de Velocidades', 'cod' => '', 'cant' => '',],
            ['activity' => 'Cambio Aceite Transmision', 'cod' => '', 'cant' => '',],
            ['activity' => 'Cambio Aceite Servo', 'cod' => '', 'cant' => '',],
            ['activity' => 'Cambio Aceite Hidraulico', 'cod' => '', 'cant' => '',],
            ['activity' => 'Cambio Aceite Hidraulico Direccion', 'cod' => '', 'cant' => '',],
            ['activity' => 'Cambio Aceite Reductores', 'cod' => '', 'cant' => '',],
            ['activity' => 'Cambio Agua de Radiador', 'cod' => '', 'cant' => '',],
            ['activity' => 'Engrasada General', 'cod' => '', 'cant' => '',],
            ['activity' => 'Cambio Filtro Aceite Motor', 'cod' => '', 'cant' => '',],
            ['activity' => 'Cambio Filtro Combustible Primario', 'cod' => '', 'cant' => '',],
            ['activity' => 'Cambio Filtro Combustible Secund', 'cod' => '', 'cant' => '',],
            ['activity' => 'Cambio Filtro Aire Primario', 'cod' => '', 'cant' => '',],
            ['activity' => 'Cambio Filtro Aire Secundario', 'cod' => '', 'cant' => '',],
            ['activity' => 'Cambio Filtro de Agua', 'cod' => '', 'cant' => '',],
            ['activity' => 'Cambio Filtro Hidraulico', 'cod' => '', 'cant' => '',],
            ['activity' => 'Cambio Filtro Hidraulico Direccion', 'cod' => '', 'cant' => '',],
            ['activity' => 'Cambio Filtro Servotransmision', 'cod' => '', 'cant' => '',],
            ['activity' => 'Cambio Filtro Secador Aire', 'cod' => '', 'cant' => '',],
            ['activity' => 'Sopleteo Filtro Aire', 'cod' => '', 'cant' => '',],
        ];

        return $form
            ->schema([
                Section::make('MANTENIMIENTOS CORRECTIVOS Y PREVENTIVOS')
                    ->schema([
                        Select::make('equipment_machinery_id')
                            ->label('Equipo/Maquina')
                            ->options(EquipmentMachinery::all()->pluck('name', 'id'))
                            ->searchable(),
                        TextInput::make('code')
                            ->label('Centro de costos')
                            ->required(),
                        Select::make('maintenance_type')
                            ->label('Tipo de mantenimiento')
                            ->native(false)
                            ->options([
                                'preventivo' => 'Preventivo',
                                'correctivo' => 'Correctivo',
                            ]),
                        Grid::make()
                            ->schema([
                                DatePicker::make('entry_date')
                                    ->label('Fecha de Entrada')
                                    ->required()
                                    ->displayFormat('d/m/Y'),
                                DatePicker::make('exit_date')
                                    ->label('Fecha de Salida')
                                    ->required()
                                    ->displayFormat('d/m/Y'),
                                TextInput::make('measure')
                                    ->numeric()
                                    ->label('Medida (horometro/km)')
                                    ->required(),
                                TextInput::make('estimated_time')
                                    ->numeric()
                                    ->label('Tiempo Estimado(h)')
                                    ->required(),
                                TextInput::make('real_time')
                                    ->numeric()
                                    ->label('Tiempo Real (h)')
                                    ->required(),
                                TextInput::make('driver')
                                    ->label('Conductor'),
                        ])->columns(3),
                        FileUpload::make('file_evidence')->label('Evidencia')
                            ->image()
                            ->multiple()
                            ->imageEditor()
                            ->required()
                            ->columnSpan(3),
                ])->columns(3),
                Section::make('DESCRIPCIÓN DE MANTENIMIENTO PREVENTIVO')
                ->schema([
                    Repeater::make('activities')
                        ->label('Actividades')
                        ->schema([
                            TextInput::make('activity')
                                ->label('Actividad')
                                ->required()
                                ->readOnly(),
                            Checkbox::make('is_admin')->inline(false)
                                ->label('Cod')->live(),
                            TextInput::make('cant')->required()
                                ->label('Cant')->hidden(fn (Get $get): bool => ! $get('is_admin')),
                        ])
                        ->addable(false)
                        ->deletable(false)
                        ->reorderable(false)
                        ->default($activities)
                        ->columns(3)
                        ->columnSpan('full'),
                ])
                ->collapsible(),
                Section::make('REPUESTOS')
                ->schema([
                    TextInput::make('invoice_number')
                        ->label('Numero de Factura'),
                    TextInput::make('labor_value')
                        ->label('Valor Mano de Obra'),
                    Repeater::make('parts_amount_value')
                        ->label('Detalles de Repuestos')
                        ->schema([
                            TextInput::make('part')
                                ->label('Repuesto')
                                ->required(),
                            TextInput::make('amount')
                                ->label('Cantidad')
                                ->numeric()
                                ->required(),
                            TextInput::make('value')
                                ->label('Precio')
                                ->required(),
                        ])
                        ->defaultItems(1)
                        ->addActionLabel('Nuevo Repuesto')
                        ->columns(3)
                        ->columnSpan('full'),
                ])
                ->hidden(fn () => auth()->user()->position !== 'administracion') //validacion de edicion
                ->columns(2),
                Section::make('OTROS TRABAJOS')
                ->schema([
                    TextInput::make('other_activities')
                        ->label('Otras Actividades'),
                    TextInput::make('welding_activities')
                        ->label('Trabajos de soldadura'),
                    TextInput::make('description_corrective_maintenance')
                        ->label('Descripcion Mantenimiento Correctivo'),
                ])
                ->columns(1)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Id'),
                Tables\Columns\TextColumn::make('equipment.name')
                    ->label('Equipo/Maquinaria'),
                Tables\Columns\TextColumn::make('code')
                    ->label('Cod'),
                Tables\Columns\TextColumn::make('entry_date')
                    ->label('Fecha de Entrada'),
                Tables\Columns\TextColumn::make('exit_date')
                    ->label('Fecha de Salida'),
                Tables\Columns\TextColumn::make('maintenance_type')
                    ->label('Tipo de Mantenimiento'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Ver')
                    ->color('info'),
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
            'index' => Pages\ListEquipmentMachineryMaintenances::route('/'),
            'create' => Pages\CreateEquipmentMachineryMaintenance::route('/create'),
            'edit' => Pages\EditEquipmentMachineryMaintenance::route('/{record}/edit'),
        ];
    }
}
