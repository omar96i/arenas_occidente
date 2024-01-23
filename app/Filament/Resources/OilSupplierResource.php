<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OilSupplierResource\Pages;
use App\Filament\Resources\OilSupplierResource\RelationManagers;
use App\Models\OilSupplier;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Attributes\Layout;

class OilSupplierResource extends Resource
{
    protected static ?string $model = OilSupplier::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationLabel = 'Abastecimiento de aceites';

    protected static ?string $slug = 'abastecimiento de aceites';

    protected static ?string $modelLabel = 'Abastecimiento de aceites';

    protected static ?string $navigationGroup = 'Administración de aceites y proveedores';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Aceite y Proveedor')
                    ->description('Información del aceite y el proveedor')
                    ->schema([
                        Forms\Components\Select::make('oil_id')->label('Aceite')
                            ->relationship('oil', 'code')
                            ->placeholder('Selecciona un aceite')
                            ->required(),
                        Forms\Components\Select::make('supplier_id')->label('Proveedor')
                            ->relationship('supplier', 'name')
                            ->placeholder('Selecciona un proveedor')
                            ->required(),
                        Forms\Components\TextInput::make('mark')->label('Marca')
                            ->placeholder('Ingresa la marca')
                            ->required()
                            ->maxLength(191),
                    ])->columns(3),
                Section::make('Precios')
                    ->description('Precios por galones')
                    ->schema([
                        Forms\Components\TextInput::make('stock')->label('Galones')
                            ->placeholder('Ingresa los galones')
                            ->numeric(),
                        Forms\Components\TextInput::make('price')->label('Precio')
                            ->placeholder('Ingresa el precio')
                            ->numeric()
                            ->prefix('$'),
                    ])->columns(2),
                Section::make('Evidencias')
                    ->schema([
                        FileUpload::make('file')->label('Subir evidencia')
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('file')->label('imagen')
                    ->circular()
                    ->disk('public'),
                Tables\Columns\TextColumn::make('oil.code')->label('Codigo de aceite')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('supplier.name')->label('Proveedor')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mark')->label('Marca de aceite')
                    ->searchable(),
                Tables\Columns\TextColumn::make('stock')->label('Galones')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')->label('Precio')
                    ->money('COP')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label('Creado en la fecha')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->label('Actualizado en la fecha')
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
            'index' => Pages\ListOilSuppliers::route('/'),
            'create' => Pages\CreateOilSupplier::route('/create'),
            'edit' => Pages\EditOilSupplier::route('/{record}/edit'),
        ];
    }
}
