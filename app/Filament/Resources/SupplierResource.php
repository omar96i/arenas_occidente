<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupplierResource\Pages;
use App\Filament\Resources\SupplierResource\RelationManagers;
use App\Models\Supplier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Proveedores';

    protected static ?string $slug = 'proveedores';

    protected static ?string $modelLabel = 'Proveedores';

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
                Forms\Components\TextInput::make('name')->label('Nombre del proveedor')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('nit')->label('NIT')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('address')->label('Dirección')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('phone')->label('Teléfono')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('contact')->label('Contacto asesor')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('bank')->label('Nombre del banco')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('number_bank')->label('Numero de cuenta')
                    ->required()
                    ->maxLength(191),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nombre del proveedor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nit')->label('NIT')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')->label('Dirección')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')->label('Teléfono')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact')->label('Contacto asesor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bank')->label('Banco')
                    ->searchable(),
                Tables\Columns\TextColumn::make('number_bank')->label('Numero de cuenta')
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
            'index' => Pages\ListSuppliers::route('/'),
            'create' => Pages\CreateSupplier::route('/create'),
            'edit' => Pages\EditSupplier::route('/{record}/edit'),
        ];
    }
}
