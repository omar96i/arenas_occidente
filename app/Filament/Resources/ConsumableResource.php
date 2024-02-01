<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConsumableResource\Pages;
use App\Filament\Resources\ConsumableResource\RelationManagers;
use App\Models\Consumable;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ConsumableResource extends Resource
{
    protected static ?string $model = Consumable::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Administración de consumibles y proveedores';

    protected static ?string $navigationLabel = 'Consumibles';

    protected static ?string $slug = 'consumibles';

    protected static ?string $modelLabel = 'consumibles';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')->label('Codigo del consumible')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('name')->label('Nombre del consumible')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('stock')->label('Cantidad en stock')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')->label('Codigo del consumible')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')->label('Nombre del consumible')
                    ->searchable(),
                Tables\Columns\TextColumn::make('stock')->label('Cantidad en stock')
                    ->numeric()
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
            'index' => Pages\ListConsumables::route('/'),
            'create' => Pages\CreateConsumable::route('/create'),
            'edit' => Pages\EditConsumable::route('/{record}/edit'),
        ];
    }
}
