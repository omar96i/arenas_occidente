<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FuelControlResource\Pages;
use App\Filament\Resources\FuelControlResource\RelationManagers;
use App\Models\FuelControl;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FuelControlResource extends Resource
{
    protected static ?string $model = FuelControl::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-4';

    protected static ?string $navigationLabel = 'Combustibles';

    protected static ?string $slug = 'combustibles';

    protected static ?string $modelLabel = 'Combustibles';

    protected static ?string $navigationGroup = 'Administración de Combustibles';

    protected static ?int $navigationSort = -1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nombre de la fuente')
                    ->required(),
                TextInput::make('stock')
                    ->label('Cantidad (gal.)')
                    ->numeric()
                    ->required()
                    ->default(0),
                Select::make('type')
                    ->label('Tipo de Combustible')
                    ->required()
                    ->options(['ACPM' => 'ACPM', 'GASOLINA' => 'GASOLINA']),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->sortable(),
                TextColumn::make('stock')
                    ->label('Stock')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Tipo Combustible')
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
            'index' => Pages\ListFuelControls::route('/'),
            'create' => Pages\CreateFuelControl::route('/create'),
            'edit' => Pages\EditFuelControl::route('/{record}/edit'),
        ];
    }    
}
