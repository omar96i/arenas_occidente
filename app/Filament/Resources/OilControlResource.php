<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OilControlResource\Pages;
use App\Filament\Resources\OilControlResource\RelationManagers;
use App\Models\OilControl;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OilControlResource extends Resource
{
    protected static ?string $model = OilControl::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    protected static ?string $navigationLabel = 'Control de aceites';

    protected static ?string $slug = 'control-de-aceites';

    protected static ?string $modelLabel = 'Control de aceites';

    protected static ?string $navigationGroup = 'Administración de aceites y proveedores';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Solicitante y Aceite')
                    ->description('Información del solicitante y el aceite')
                    ->schema([
                        Forms\Components\Select::make('user_id')->label('Solicitante')
                            ->relationship('applicant', 'full_name')
                            ->required(),
                        Forms\Components\Select::make('oil_id')->label('Aceite')
                            ->relationship('oil', 'code')
                            ->required(),
                    ])->columns(2),
                Section::make('Equipo o Maquinaria y Adminitracion de fechas')
                    ->description('Información del equipo o maquinaria y fechas')
                    ->schema([
                        Forms\Components\Select::make('equipment_machinery_id')->label('Equipo o maquinaria')
                            ->relationship('equipment_machinery', 'name')
                            ->required(),
                        Forms\Components\Select::make('month')->label('Mes')
                            ->options([
                                'enero' => 'Enero',
                                'Febrero' => 'Febrero',
                                'Marzo' => 'Marzo',
                                'Abril' => 'Abril',
                                'Mayo' => 'Mayo',
                                'Junio' => 'Junio',
                                'Julio' => 'Julio',
                                'Agosto' => 'Agosto',
                                'Septiembre' => 'Septiembre',
                                'Octubre' => 'Octubre',
                                'Noviembre' => 'Noviembre',
                                'Diciembre' => 'Diciembre',
                            ])
                            ->required(),
                            Forms\Components\TextInput::make('year')->label('Año')
                            ->maxLength(191),
                    ])->columns(3),
                Section::make('Cantidad y costos')
                    ->description('Información de la cantidad y costos')
                    ->schema([
                        Forms\Components\TextInput::make('amount')->label('Cantidad')
                            ->numeric(),
                        Forms\Components\TextInput::make('cost_per_gallon')->label('Costo por galon')
                            ->numeric(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')->label('Solicitante')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('oil.id')->label('Aceite')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('equipment_machinery.name')->label('Equipo o maquinaria')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('month')->label('Mes')
                    ->searchable(),
                Tables\Columns\TextColumn::make('year')->label('Año')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')->label('Cantidad')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cost_per_gallon')->label('Precio por galon')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cost_total')->label('Costo total')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label('Fecha de creacion')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->label('Fecha de actualización')
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
            'index' => Pages\ListOilControls::route('/'),
            'create' => Pages\CreateOilControl::route('/create'),
            'edit' => Pages\EditOilControl::route('/{record}/edit'),
        ];
    }
}
