<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipmentResource\RelationManagers\OptionsRelationManager;
use App\Filament\Resources\EquipmentResource\Pages;
use App\Models\Equipment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EquipmentResource extends Resource
{
    protected static ?string $model = Equipment::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationLabel = 'Equipos';

    protected static ?string $slug = 'equipos';

    protected static ?string $modelLabel = 'Equipos';

    protected static ?string $navigationGroup = 'Administración de maquinaria y equipos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Grid::make()
                            ->columns(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')->label('Nombre del equipo')
                                    ->maxLength(191)->required(),
                                Forms\Components\TextInput::make('description')->label('Descripción del equipo')
                                    ->maxLength(191)->required(),
                                Forms\Components\TextInput::make('register_number')->label('Numero de registro')
                                    ->maxLength(191)->required(),
                                Forms\Components\Select::make('status')->label('Estado')
                                    ->options([
                                        'operativo' => 'Operativo',
                                        'alquilado' => 'Alquilado',
                                    ])->required(),
                            ]),

                        Forms\Components\FileUpload::make('file_img')->label('Imagen')
                            ->image()
                            ->multiple()
                            ->imageEditor()
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('file_img')->label('imagen')
                    ->circular(),
                Tables\Columns\TextColumn::make('name')->label('Nombre del equipo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')->label('Descripción')
                    ->searchable(),
                Tables\Columns\TextColumn::make('register_number')->label('Numero de registro')
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
            OptionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEquipment::route('/'),
            'create' => Pages\CreateEquipment::route('/create'),
            'edit' => Pages\EditEquipment::route('/{record}/edit'),
        ];
    }
}
