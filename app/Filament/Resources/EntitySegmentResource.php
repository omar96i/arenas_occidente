<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EntitySegmentResource\Pages;
use App\Filament\Resources\EntitySegmentResource\RelationManagers;
use App\Filament\Resources\EntitySegmentResource\RelationManagers\EntityRelationManager;
use App\Filament\Resources\EntitySegmentResource\RelationManagers\ShiftsRelationManager;
use App\Models\EntitySegment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EntitySegmentResource extends Resource
{
    protected static ?string $model = EntitySegment::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationLabel = 'Areas';

    protected static ?string $slug = 'areas';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Administracion de turnos y contratos';

    protected static ?string $pluralModelLabel = 'Areas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('entity_id')->label('Seleccionar un contrato')
                    ->relationship('entity', 'name')
                    ->required(),
                Forms\Components\TextInput::make('name')->label('Nombre del area')
                    ->required()
                    ->maxLength(191),
                Forms\Components\Select::make('sub_title')
                    ->label('Mes')
                    ->required()
                    ->options([
                        'enero' => 'Enero',
                        'febrero' => 'Febrero',
                        'marzo' => 'Marzo',
                        'abril' => 'Abril',
                        'mayo' => 'Mayo',
                        'junio' => 'Junio',
                        'julio' => 'Julio',
                        'agosto' => 'Agosto',
                        'septiembre' => 'Septiembre',
                        'octubre' => 'Octubre',
                        'noviembre' => 'Noviembre',
                        'diciembre' => 'Diciembre',
                    ]),
                Forms\Components\TextInput::make('time_limit')->label('Limite de horas')
                    ->required()->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('entity.name')->label('Contrato')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')->label('Nombre del turno')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sub_title')->label('Sub titulo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')->label('Fecha de creación')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->label('Fecha de actualizaón')
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
            ShiftsRelationManager::class,
            EntityRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEntitySegments::route('/'),
            'create' => Pages\CreateEntitySegment::route('/create'),
            'edit' => Pages\EditEntitySegment::route('/{record}/edit'),
        ];
    }
}
