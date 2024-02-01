<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConsumableControlResource\Pages;
use App\Filament\Resources\ConsumableControlResource\RelationManagers;
use App\Models\ConsumableControl;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ConsumableControlResource extends Resource
{
    protected static ?string $model = ConsumableControl::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    protected static ?string $navigationGroup = 'Administración de consumibles y proveedores';

    protected static ?string $navigationLabel = 'Control de consumibles';

    protected static ?string $slug = 'control-de-consumibles';

    protected static ?string $modelLabel = 'Control de consumibles';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('consumable_id')->label('Selecciona un consumible')
                    ->relationship('consumable', 'name')
                    ->required(),
                Forms\Components\Select::make('user_id')->label('Selecciona el usuario que realizo la petición')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\Select::make('equipment_machinery_id')->label('Selecciona el equipo')
                    ->relationship('equipment_machinery', 'name')
                    ->required(),
                Forms\Components\TextInput::make('amount')->label('Cantidad usada')
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('date')->label('Fecha')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('consumable.name')->label('Consumible')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')->label('Usuario')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('equipment_machinery.name')->label('Equipo')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')->label('Cantidad')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')->label('Fecha')
                    ->date()
                    ->sortable(),
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
            'index' => Pages\ListConsumableControls::route('/'),
            'create' => Pages\CreateConsumableControl::route('/create'),
            'edit' => Pages\EditConsumableControl::route('/{record}/edit'),
        ];
    }
}
