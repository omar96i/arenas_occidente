<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipmentMachinerySureResource\Pages;
use App\Filament\Resources\EquipmentMachinerySureResource\RelationManagers;
use App\Models\EquipmentMachinerySure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EquipmentMachinerySureResource extends Resource
{
    protected static ?string $model = EquipmentMachinerySure::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-check';

    protected static ?string $navigationLabel = 'Seguro';

    protected static ?string $slug = 'seguro';

    protected static ?string $modelLabel = 'Seguro';

    protected static ?string $navigationGroup = 'Administración de maquinaria y equipos';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('equipment_machinery_id')->label('Equipo o maquinaria')
                    ->relationship('equipment_machinery', 'name')
                    ->required(),
                Forms\Components\TextInput::make('sure')->label('Seguro')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('taker')->label('Tomador')
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
                Tables\Columns\TextColumn::make('sure')->label('Seguro')
                    ->searchable(),
                Tables\Columns\TextColumn::make('taker')->label('Tomador')
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
            'index' => Pages\ListEquipmentMachinerySures::route('/'),
            'create' => Pages\CreateEquipmentMachinerySure::route('/create'),
            'edit' => Pages\EditEquipmentMachinerySure::route('/{record}/edit'),
        ];
    }
}
