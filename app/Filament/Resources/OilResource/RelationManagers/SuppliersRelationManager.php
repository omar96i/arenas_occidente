<?php

namespace App\Filament\Resources\OilResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SuppliersRelationManager extends RelationManager
{
    protected static string $relationship = 'suppliers';

    protected static ?string $title = 'Abastecimientos';

    protected static ?string $modelLabel = 'Abastecimientos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('supplier_id')->label('Proveedor')
                    ->relationship('supplier', 'name')
                    ->required(),
                Forms\Components\TextInput::make('mark')->label('Marca del aceite')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('stock')->label('Galones')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('price')->label('Precio')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\TextInput::make('stock_2')->label('Tambor')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('price_2')->label('Precio')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('mark')
            ->columns([
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
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock_2')->label('Tambores')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price_2')->label('Precio')
                    ->money()
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
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
