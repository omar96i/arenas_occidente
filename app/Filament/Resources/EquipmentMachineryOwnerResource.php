<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipmentMachineryOwnerResource\Pages;
use App\Filament\Resources\EquipmentMachineryOwnerResource\RelationManagers;
use App\Models\EquipmentMachineryOwner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EquipmentMachineryOwnerResource extends Resource
{
    protected static ?string $model = EquipmentMachineryOwner::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Dueños';

    protected static ?string $slug = 'dueños';

    protected static ?string $modelLabel = 'Dueños';

    protected static ?string $navigationGroup = 'Administración de maquinaria y equipos';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('equipment_machinery_id')->label('Equipo o maquinaria')
                    ->relationship('equipment_machinery', 'name')
                    ->required(),
                Forms\Components\TextInput::make('full_name')->label('Nombre completo')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('nit')->label('NIT')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('tuition')->label('Matricula')
                    ->required()
                    ->maxLength(191),
                Forms\Components\FileUpload::make('file')->label('Subir evidencia'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('file')->label('imagen')
                    ->circular()
                    ->disk('public'),
                Tables\Columns\TextColumn::make('equipment_machinery.name')->label('Equipo o maquinaria')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('full_name')->label('Nombre completo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nit')->label('NIT')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tuition')->label('Matricula')
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
            'index' => Pages\ListEquipmentMachineryOwners::route('/'),
            'create' => Pages\CreateEquipmentMachineryOwner::route('/create'),
            'edit' => Pages\EditEquipmentMachineryOwner::route('/{record}/edit'),
        ];
    }
}
