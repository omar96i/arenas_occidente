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

    protected static ?string $navigationLabel = 'Segmentos';

    protected static ?string $slug = 'segmentos';

    protected static ?string $pluralModelLabel = 'segmentos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('entity_id')
                    ->relationship('entity', 'name')
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('sub_title')
                    ->required()
                    ->maxLength(191),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('entity.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sub_title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
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
