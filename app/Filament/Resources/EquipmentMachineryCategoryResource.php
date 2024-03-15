<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipmentMachineryCategoryResource\Pages;
use App\Filament\Resources\EquipmentMachineryCategoryResource\RelationManagers;
use App\Filament\Resources\EquipmentMachineryCategoryResource\RelationManagers\OptionsRelationManager;
use App\Models\EquipmentMachineryCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EquipmentMachineryCategoryResource extends Resource
{
    protected static ?string $model = EquipmentMachineryCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationLabel = 'Categorias (Opciones)';

    protected static ?string $slug = 'categorias';

    protected static ?string $modelLabel = 'Categorias';

    protected static ?string $navigationGroup = 'Administración de maquinaria y equipos';

    protected static ?int $navigationSort = 0;

    public static function canViewAny(): bool
    {
        $user = auth()->user();
        $allowedRoles = ['administracion'];
        return in_array($user->position, $allowedRoles);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')->label('Nombre de la categoria')
                            ->maxLength(191)->required(),
                    ]),
            ])->columns(1);
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
            'index' => Pages\ListEquipmentMachineryCategories::route('/'),
            // 'create' => Pages\CreateEquipmentMachineryCategory::route('/create'),
            'edit' => Pages\EditEquipmentMachineryCategory::route('/{record}/edit'),
        ];
    }
}
