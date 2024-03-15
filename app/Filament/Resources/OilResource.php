<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OilResource\Pages;
use App\Filament\Resources\OilResource\RelationManagers;
use App\Filament\Resources\OilResource\RelationManagers\SuppliersRelationManager;
use App\Models\Oil;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OilResource extends Resource
{
    protected static ?string $model = Oil::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';

    protected static ?string $navigationLabel = 'Aceites';

    protected static ?string $slug = 'aceites';

    protected static ?string $modelLabel = 'Aceites';

    protected static ?string $navigationGroup = 'Administración de consumibles y proveedores';

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
                Forms\Components\TextInput::make('code')->label('Codigo de aceite')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('type_oil')->label('Tipo de aceite')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('stock')->label('Galones disponibles')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')->label('Codigo de aceite')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type_oil')->label('Tipo de aceite')
                    ->searchable(),
                Tables\Columns\TextColumn::make('stock')->label('Galones disponibles')
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
            SuppliersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOil::route('/'),
            'create' => Pages\CreateOil::route('/create'),
            'edit' => Pages\EditOil::route('/{record}/edit'),
        ];
    }
}
