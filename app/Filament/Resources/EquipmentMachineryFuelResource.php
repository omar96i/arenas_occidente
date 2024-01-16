<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipmentMachineryFuelResource\Pages;
use App\Filament\Resources\EquipmentMachineryFuelResource\RelationManagers;
use App\Models\EquipmentMachinery;
use App\Models\EquipmentMachineryFuel;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
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
                    ->label('ACPM (gal.)')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('price_acpm')
                    ->label('Precio ACPM')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('horom_tanq')
                    ->label('Horometro Tanqueo')
                    ->required()
                    ->numeric(),
                Select::make('source')
                    ->label('Fuente')
                    ->preload()
                    ->searchable()
                    ->relationship(name: 'source', titleAttribute: 'name')
                    ->native(false)
                    ->createOptionForm([
                        Toggle::make('is_equipment')
                            ->live()
                            ->label('Es un equipo?'),
                        Select::make('equipment_machinery_id')->label('Seleccionar el equipo')
                            ->native(false)
                            ->reactive()
                            ->searchable()
                            ->afterStateUpdated(function (Set $set, $state) {
                                $set('name', EquipmentMachinery::find($state)->name);
                            })
                            ->options(function () {
                                return EquipmentMachinery::query()->pluck('name', 'id');
                            })
                            ->visible(function ($get): ?bool {
                                return $get('is_equipment');
                            })
                            ->required(),
                        TextInput::make('name')
                            ->label('Nombre de la fuente')
                            ->required(),
                    ])->columns(1)
                    ->createOptionAction(function (Action $action){
                        return $action
                            ->modalHeading('Añadir Cuenta')
                            ->modalWidth('sm');
                    }),
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
                Tables\Columns\TextColumn::make('source.name')
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
