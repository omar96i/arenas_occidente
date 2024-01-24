<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FuelControlSupplyResource\Pages;
use App\Filament\Resources\FuelControlSupplyResource\RelationManagers;
use App\Models\FuelControl;
use App\Models\FuelControlSupply;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FuelControlSupplyResource extends Resource
{
    protected static ?string $model = FuelControlSupply::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-circle';

    protected static ?string $navigationLabel = 'Abastecimiento de Combustible';

    protected static ?string $slug = 'abastecimiento-combustibles';

    protected static ?string $modelLabel = 'Abastecimiento de Combustible';

    protected static ?string $navigationGroup = 'Administración de Combustibles';

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('date')
                    ->label('Fecha')
                    ->required(),
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
                    }),
                Select::make('equipment_machinery_id')
                    ->label('Equipo')
                    ->relationship('equipment', 'name')
                    ->required(),
                Select::make('fuel_control_id')
                    ->label('Combustible')
                    ->relationship('tank', 'name')
                    ->required(),
                Select::make('user_id')
                    ->label('Operador o Conductor')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('amount')
                    ->label('Cantidad de Combustible')
                    ->required()
                    ->numeric()
                    ->required()
                    ->default(0)
                    ->rules([
                        'required',
                        fn (Get $get, $livewire): Closure => function (string $attribute, $value, Closure $fail) use ($get, $livewire) {
                            $fuelControlId = $get('fuel_control_id');
                            $fuelControl = FuelControl::find($fuelControlId);
                
                            if (!$fuelControl) {
                                $fail("No se encontró el control de combustible con ID proporcionado.");
                                return;
                            }
                
                            if ($value > $fuelControl->stock) {
                                $fail("La cantidad supera la disponible en la fuente.");
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
                FileUpload::make('file_evidence')->label('Evidencia')
                    ->image()
                    ->multiple()
                    ->imageEditor()
                    ->columnSpan(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListFuelControlSupplies::route('/'),
            'create' => Pages\CreateFuelControlSupply::route('/create'),
            'edit' => Pages\EditFuelControlSupply::route('/{record}/edit'),
        ];
    }    
}
