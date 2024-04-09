<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OilControlResource\Pages;
use App\Filament\Resources\OilControlResource\RelationManagers;
use App\Models\OilControl;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
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

    protected static ?string $navigationGroup = 'Administración de consumibles y proveedores';

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
                        Forms\Components\Select::make('area')->label('Selecciona un area')
                            ->options([
                                'Ceniza' => 'Ceniza',
                                'Cachaza' => 'Cachaza',
                                'Compost' => 'Compost',
                                'Carbon' => 'Carbon',
                                'Calderas' => 'Calderas',
                                'Bagzo' => 'Bagzo',
                                'Botadero' => 'Botadero',
                                'Otro' => 'Otro'
                            ])
                            ->required(),
                        Forms\Components\DatePicker::make('date')->label('Fecha')
                            ->required(),
                    ])->columns(3),
                Section::make('Cantidad')
                    ->description('Información de la cantidad')
                    ->schema([
                        Forms\Components\Select::make('input1')->label('Galones')->live()
                            ->options(function(){
                                $options = [];
                                for ($i=0; $i < 1000; $i++) {
                                    $options[($i+1)] = ($i+1)." Galones";
                                }
                                return $options;
                            })
                            ->afterStateUpdated(function (Get $get, Set $set, $state){
                                if ($state) {
                                    $number2 = $get('input2');
                                    if($number2){
                                        $set('amount', floatval($state)+floatval($number2));
                                    }else{
                                        $set('amount', intval($state));
                                    }
                                }
                            }),
                        Forms\Components\Select::make('input2')->label('Cuartos')->live()
                            ->options([
                                '0.25' => '1/4',
                                '0.50' => '2/4',
                                '0.75' => '3/4',
                            ])
                            ->afterStateUpdated(function (Get $get, Set $set, $state){
                                $number2 =  $get('input1');
                                if ($state) {
                                    if($number2){
                                        $set('amount', floatval($state)+floatval($number2));
                                    }else{
                                        $set('amount', floatval($state));
                                    }
                                }else{
                                    $set('amount', 0 + floatval($number2));
                                }
                            }),
                        Forms\Components\TextInput::make('amount')->label('Cantidad Total')
                            ->numeric()
                            ->readonly(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('applicant.full_name')->label('Solicitante')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('oil.code')->label('Aceite')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('equipment_machinery.name')->label('Equipo o maquinaria')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')->label('Fecha')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')->label('Cantidad')
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
            ])
            ->defaultSort('id', 'desc');
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
