<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipmentOptionCategoryResource\RelationManagers\OptionsRelationManager;
use App\Filament\Resources\EquipmentOptionCategoryResource\Pages;
use App\Filament\Resources\EquipmentOptionCategoryResource\RelationManagers;
use App\Models\EquipmentOptionCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EquipmentOptionCategoryResource extends Resource
{
    protected static ?string $model = EquipmentOptionCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationLabel = 'Opciones';

    protected static ?string $slug = 'opciones';

    protected static ?string $modelLabel = 'Categorias';

    protected static ?string $navigationGroup = 'Administración de maquinaria y equipos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')->label('Nombre de la categoria')
                            ->maxLength(191)->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nombre de la categoria')
                    ->searchable(),
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
            OptionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEquipmentOptionCategories::route('/'),
            'create' => Pages\CreateEquipmentOptionCategory::route('/create'),
            'edit' => Pages\EditEquipmentOptionCategory::route('/{record}/edit'),
        ];
    }
}
