<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipmentMachineryLaborResource\Pages;
use App\Filament\Resources\EquipmentMachineryLaborResource\RelationManagers;
use App\Models\EquipmentMachineryLabor;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EquipmentMachineryLaborResource extends Resource
{
    protected static ?string $model = EquipmentMachineryLabor::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationLabel = 'Base de datos';

    protected static ?string $slug = 'labores';

    protected static ?string $modelLabel = 'Labor';
    protected static ?string $pluralModelLabel = 'Labores';

    protected static ?string $navigationGroup = 'Administración de maquinaria y equipos';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        $activities = [
            'ceniza' => 'CENIZA',
            'compostaje' => 'COMPOSTAJE',
            'caldera' => 'CALDERA',
            'carbon' => 'CARBON',
            'lodos' => 'LODOS',
            'cachaza' => 'CACHAZA',
            'carretera' => 'CARRETERA',
            'combustible' => 'COMBUSTIBLE',
            'vias' => 'VIAS',
            'movimiento maquinaria' => 'MOVIMIENTO MAQUINARIA',
            'oficios varios' => 'OFICIOS VARIOS',
            'varada' => 'VARADA',
            'sin contrato' => 'SIN CONTRATO',
            'stand by' => 'STAND BY',
            'cargue volquetas' => 'CARGUE VOLQUETAS',
            'conformacion vias' => 'CONFORMACION VIAS',
            'bagazo' => 'BAGAZO',
            'organizando via principal' => 'ORGANIZANDO VIA PRINCIPAL',
            'tanqueo maquinaria' => 'TANQUEO MAQUINARIA',
            'tanqueo finca' => 'TANQUEO FINCA',
            'taller' => 'TALLER',
            'escoria' => 'ESCORIA',
        ];

        return $form
            ->schema([
                Grid::make(['default' => 3])->schema([
                    DatePicker::make('date')
                        ->label('Fecha ')
                        ->required()
                        ->displayFormat('d/m/Y'),
                    Select::make('equipment_machinery_id')->label('Seleccionar un equipo o maquinaria')
                        ->relationship('equipment', 'name')
                        ->native(false)
                        ->required(),
                    Select::make('entity_id')->label('Seleccionar un contrato (Cliente)')
                        ->relationship('entity', 'name')
                        ->required(),
                    Select::make('user_id')->label('Seleccionar un Conductor')
                        ->relationship('driver', 'name')
                        ->required(),
                    TextInput::make('location')->label('Ubicación/Predio')
                        ->required()
                        ->maxLength(191),
                    Select::make('activity')->label('Seleccionar una actividad')
                        ->native(false)
                        ->searchable()
                        ->options($activities)
                        ->required(),
                ]),
                Grid::make(['default' => 4,])->schema([
                        TimePicker::make('entry_time')->label('Entrada')
                            ->seconds(false)
                            ->required(),
                        TimePicker::make('departure_time')->label('Salida')
                            ->seconds(false)
                            ->required(),
                        TextInput::make('hr_ini')->label('Horometro Inicial')
                            ->numeric()
                            ->required(),
                        TextInput::make('hr_fin')->label('Horometro Final')
                            ->numeric()
                            ->required(),
                    ]),
                TextInput::make('trips')->label('Viajes')
                    ->numeric()
                    ->required(),
                TextInput::make('ton')->label('Ton')
                    ->numeric(),
                TextInput::make('state_fact')->label('Estado Fact'),
                TextInput::make('observations')->label('Observaciones'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                ->label('Id'),
                Tables\Columns\TextColumn::make('date')
                    ->label('Fecha'),
                Tables\Columns\TextColumn::make('equipment.name')
                    ->label('Equipo/Maquinaria'),
                Tables\Columns\TextColumn::make('entry_time')
                    ->label('Entrada'),
                Tables\Columns\TextColumn::make('departure_time')
                    ->label('Salida'),
                Tables\Columns\TextColumn::make('activity')
                    ->label('Actividad'),
                    Tables\Columns\TextColumn::make('hr_ini')
                    ->label('Hr Ini'),
                Tables\Columns\TextColumn::make('hr_fin')
                    ->label('Hr Fin'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->label('Condición')
                    ->color(fn (string $state): string => match ($state) {
                        'DISPONIBLE' => 'success',
                        'TRABAJO' => 'danger',
                    })
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
            'index' => Pages\ListEquipmentMachineryLabors::route('/'),
            'create' => Pages\CreateEquipmentMachineryLabor::route('/create'),
            'edit' => Pages\EditEquipmentMachineryLabor::route('/{record}/edit'),
        ];
    }    
}
