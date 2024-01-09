<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipmentMachineryFuelResource\Pages;
use App\Filament\Resources\EquipmentMachineryFuelResource\RelationManagers;
use App\Models\EquipmentMachineryFuel;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EquipmentMachineryFuelResource extends Resource
{
    protected static ?string $model = EquipmentMachineryFuel::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';

    protected static ?string $navigationLabel = 'Entrada Combustible';

    protected static ?string $slug = 'entrada-combustible';

    protected static ?string $modelLabel = 'Entrada Combustible';
    protected static ?string $pluralModelLabel = 'Entrada Combustibles';

    protected static ?string $navigationGroup = 'Administración de maquinaria y equipos';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        $sources = [
            'CARROTANQUE SOB792' => 'CARROTANQUE SOB792',
            'CARROTANQUE WMB462' => 'CARROTANQUE WMB462',
            'EDS ANTIOQUEÑA' => 'EDS ANTIOQUEÑA',
            'ESTACION TERPEL PUERTA DEL SUR CANDELARIA' => 'ESTACION TERPEL PUERTA DEL SUR CANDELARIA',
            'INGENIO' => 'INGENIO',
            'PORRONES MAYAGUEZ' => 'PORRONES MAYAGUEZ',
            'TANQUE SAN CARLOS' => 'TANQUE SAN CARLOS',
            'RIO PAILA' => 'RIO PAILA',
            'EDS ZEUS' => 'EDS ZEUS',
            'ESTACION BRIO CANDELARIA EL ARENAL' => 'ESTACION BRIO CANDELARIA EL ARENAL',
            'ESTACION EL FARO DE GUACARI' => 'ESTACION EL FARO DE GUACARI',
            'ESTACION ESTRELLA DEL NORTE' => 'ESTACION ESTRELLA DEL NORTE',
            'ESTACION ROSA LA TUPIA' => 'ESTACION ROSA LA TUPIA',
            'ESTACION SAN ANTONIO' => 'ESTACION SAN ANTONIO',
            'ESTACION BIOMAX CANDELARIA' => 'ESTACION BIOMAX CANDELARIA',
            'ESTACION AMERICAS YUMBO' => 'ESTACION AMERICAS YUMBO',
            'TEXACO ARROYOHONDO' => 'TEXACO ARROYOHONDO',
            'CARRETERA' => 'CARRETERA',
            'EDS BRIO LA COLOMBIANA CANDELARIA' => 'EDS BRIO LA COLOMBIANA CANDELARIA',
            'EDS EL PALMAR' => 'EDS EL PALMAR',
            'GIRALDO-ANTIOQUIA' => 'GIRALDO-ANTIOQUIA',
            'CANECAS ITALCOL' => 'CANECAS ITALCOL',
        ];

        return $form
            ->schema([
                Select::make('equipment_machinery_id')->label('Seleccionar un equipo o maquinaria')
                    ->relationship('equipment', 'name')
                    ->native(false)
                    ->required(),
                Select::make('user_id')->label('REM')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\DatePicker::make('date')
                    ->label('Fecha')
                    ->required(),
                Forms\Components\TextInput::make('acpm')
                    ->label('ACPM')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('horom_tanq')
                    ->label('Horometro Tanqueo')
                    ->required()
                    ->numeric(),
                Select::make('source')->label('Seleccionar una fuente')
                    ->native(false)
                    ->searchable()
                    ->options($sources)
                    ->required(),
                Forms\Components\TextInput::make('consecutive_ing')
                    ->maxLength(191),
                Forms\Components\FileUpload::make('file_img')->label('Evidencia')
                    ->image()
                    ->multiple()
                    ->imageEditor()
                    ->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->label('Fecha')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('equipment.name')
                    ->label('Equipo/Maquinaria')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('acpm')
                    ->label('ACMP')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('horom_tanq')
                    ->label('Horm Tanq')
                ->numeric() 
                    ->sortable(),
                Tables\Columns\TextColumn::make('source')
                    ->label('Fuente')
                    ->searchable(),
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
            'index' => Pages\ListEquipmentMachineryFuels::route('/'),
            'create' => Pages\CreateEquipmentMachineryFuel::route('/create'),
            'edit' => Pages\EditEquipmentMachineryFuel::route('/{record}/edit'),
        ];
    }    
}
