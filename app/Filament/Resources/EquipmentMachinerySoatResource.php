<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipmentMachinerySoatResource\Pages;
use App\Filament\Resources\EquipmentMachinerySoatResource\RelationManagers;
use App\Models\EquipmentMachinerySoat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EquipmentMachinerySoatResource extends Resource
{
    protected static ?string $model = EquipmentMachinerySoat::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-check';

    protected static ?string $navigationLabel = 'Soat';

    protected static ?string $slug = 'soat';

    protected static ?string $modelLabel = 'Soat';

    protected static ?string $navigationGroup = 'Administración de maquinaria y equipos';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('equipment_machinery_id')->label('Equipo o maquinaria')
                    ->relationship('equipment_machinery', 'name')
                    ->required(),
                Forms\Components\TextInput::make('name')->label('Soat')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('beneficiary')->label('Beneficiario')
                    ->required()
                    ->maxLength(191),
                Forms\Components\DatePicker::make('validity')->label('Vigencia')
                    ->required(),
                Forms\Components\Select::make('status')->label('Estado')
                    ->required()
                    ->options([
                        'Vigente' => 'Vigente',
                        'Expirado' => 'Expirado',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('equipment_machinery.name')->label('Equipo o maquinaria')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')->label('Soat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('beneficiary')->label('Beneficiario')
                    ->searchable(),
                Tables\Columns\TextColumn::make('validity')->label('Vigencia')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')->label('Estado')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')->label('Fecha de creación')
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
            'index' => Pages\ListEquipmentMachinerySoats::route('/'),
            'create' => Pages\CreateEquipmentMachinerySoat::route('/create'),
            'edit' => Pages\EditEquipmentMachinerySoat::route('/{record}/edit'),
        ];
    }
}
