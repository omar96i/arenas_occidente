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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FuelControlSupplyResource extends Resource
{
    protected static ?string $model = FuelControlSupply::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-circle';

    protected static ?string $navigationLabel = 'Entrada de combustible';

    protected static ?string $slug = 'entrada-combustibles';

    protected static ?string $modelLabel = 'Entrada de combustible';

    protected static ?string $navigationGroup = 'Administración de Combustibles';

    protected static ?int $navigationSort = 0;

    public static function canViewAny(): bool
    {
        $user = auth()->user();
        $allowedRoles = ['administracion'];
        return in_array($user->position, $allowedRoles);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('date')
                    ->label('Fecha')
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
                    ->default(0),
                Select::make('measure')
                    ->label('Medida')
                    ->required()
                    ->options(['GALONES' => 'GALONES'])
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
                    ->label('Combustible')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Operador')
                    ->sortable(),
                TextColumn::make('amount')
                    ->label('Cantidad')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('measure')
                    ->label('Medida')
                    ->sortable(),
                TextColumn::make('price')
                    ->label('Precio')
                    ->sortable(),
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
