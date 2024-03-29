<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FuelControlConsumptionResource\Pages;
use App\Filament\Resources\FuelControlConsumptionResource\RelationManagers;
use App\Models\FuelControl;
use App\Models\FuelControlConsumption;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Get;

class FuelControlConsumptionResource extends Resource
{
    protected static ?string $model = FuelControlConsumption::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-right-circle';

    protected static ?string $navigationLabel = 'Salida de Combustible';

    protected static ?string $slug = 'salida-combustibles';

    protected static ?string $modelLabel = 'Salida de Combustible';

    protected static ?string $navigationGroup = 'Administración de Combustibles';

    protected static ?int $navigationSort = 0;

    public static function canViewAny(): bool
    {
        $user = auth()->user();
        $allowedRoles = ['administracion', 'operario', 'supervisores'];
        return in_array($user->position, $allowedRoles);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('date')
                    ->label('Fecha')
                    ->required(),
                Toggle::make('is_external_source')
                    ->label('Tiene fuente externa?')
                    ->inline(false)
                    ->onColor('success')
                    ->offColor('danger')
                    ->live(),
                Select::make('fuel_control_source_id')
                    ->label('Origen')
                    ->preload()
                    ->searchable()
                    ->relationship(name: 'origin', titleAttribute: 'name')
                    ->native(false)
                    ->createOptionForm([
                        TextInput::make('name')
                            ->label('Nombre de la fuente')
                            ->required(),
                    ])->columns(1)
                    ->createOptionAction(function (Action $action){
                        return $action
                            ->modalHeading('Añadir Origen')
                            ->modalWidth('sm');
                    })
                    ->hidden(fn (Get $get): bool => ! $get('is_external_source')),
                Select::make('fuel_control_id')
                    ->label('Combustible')
                    ->relationship('tank', 'name')
                    ->required(),
                Select::make('equipment_machinery_id')
                    ->label('Equipo')
                    ->relationship('equipment', 'name')
                    ->required(),
                TextInput::make('horom_tanq')
                    ->label('Horometro/Kilometraje del Equipo')
                    ->required(),
                Select::make('user_id')
                    ->label('Operador o Conductor')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('amount')
                    ->label('Cantidad de Combustible')
                    ->numeric()
                    ->required()
                    ->default(0)
                    ->rules([
                        'required',
                        fn (Get $get, $livewire): Closure => function (string $attribute, $value, Closure $fail) use ($get, $livewire) {
                            $fuelControlId = $get('fuel_control_id');
                            $measure = $get('measure');
                            $fuelControl = FuelControl::find($fuelControlId);

                            if (!$fuelControl) {
                                return $fail("No se encontró el control de combustible con el ID proporcionado.");
                            }
                            
                            $temp_value = ($measure == 'LITROS') ? ($value / 3.785) : $value;
                            
                            if ($temp_value > $fuelControl->stock) {
                                return $fail("La cantidad supera la disponible en la fuente.");
                            }
                        },
                    ]),
                Select::make('measure')
                    ->label('Medida')
                    ->required()
                    ->options(['GALONES' => 'GALONES', 'LITROS' => 'LITROS'])
                    ->default('GALONES'),
                TextInput::make('price')
                    ->label('Precio')
                    ->numeric()
                    ->required()
                    ->default(0),
                Forms\Components\FileUpload::make('file_evidence')->label('Evidencia')
                    ->image()
                    ->multiple()
                    ->imageEditor()
                    ->columnSpan(3),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date')
                    ->label('Fecha')
                    ->date()
                    ->sortable(),
                TextColumn::make('tank.name')
                    ->label('Fuente')
                    ->sortable(),
                TextColumn::make('equipment.name')
                    ->label('Equipo/Maquinaria')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Operador/Conductor')
                    ->sortable(),
                TextColumn::make('amount')
                    ->label('Cantidad')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('measure')
                    ->label('Medida')
                    ->sortable(),
            ])
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFuelControlConsumptions::route('/'),
            'create' => Pages\CreateFuelControlConsumption::route('/create'),
            'edit' => Pages\EditFuelControlConsumption::route('/{record}/edit'),
        ];
    }
}
