<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConsumableSupplierResource\Pages;
use App\Filament\Resources\ConsumableSupplierResource\RelationManagers;
use App\Models\ConsumableSupplier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ConsumableSupplierResource extends Resource
{
    protected static ?string $model = ConsumableSupplier::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationGroup = 'Administración de consumibles y proveedores';

    protected static ?string $navigationLabel = 'Abastecimento de consumibles';

    protected static ?string $slug = 'abastecimiento-de-consumibles';

    protected static ?string $modelLabel = 'Abastecimento de consumibles';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('consumable_id')->label('Selecciona un consumible')
                    ->relationship('consumable', 'name')
                    ->required(),
                Forms\Components\Select::make('supplier_id')->label('Selecciona un proveedor')
                    ->relationship('supplier', 'name')
                    ->required(),
                Forms\Components\TextInput::make('price')->label('Precio')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\TextInput::make('amount')->label('Cantidad')
                    ->required()
                    ->numeric(),
                Forms\Components\FileUpload::make('file')->label('Evidencia')
                ->image()
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
                Tables\Columns\TextColumn::make('supplier.name')->label('Proveedor')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')->label('Precio')
                    ->money('COP')
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')->label('Cantidad')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('file')->label('Evidencia')
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
            'index' => Pages\ListConsumableSuppliers::route('/'),
            'create' => Pages\CreateConsumableSupplier::route('/create'),
            'edit' => Pages\EditConsumableSupplier::route('/{record}/edit'),
        ];
    }
}
