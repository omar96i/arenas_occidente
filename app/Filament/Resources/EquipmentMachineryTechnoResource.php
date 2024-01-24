<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipmentMachineryTechnoResource\Pages;
use App\Filament\Resources\EquipmentMachineryTechnoResource\RelationManagers;
use App\Models\EquipmentMachineryTechno;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EquipmentMachineryTechnoResource extends Resource
{
    protected static ?string $model = EquipmentMachineryTechno::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static ?string $navigationLabel = 'Tecnomecanica';

    protected static ?string $slug = 'tecnomecanica';

    protected static ?string $modelLabel = 'Tecnomecanica';

    protected static ?string $navigationGroup = 'Administración de maquinaria y equipos';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('equipment_machinery_id')->label('Equipo o maquinaria')
                    ->relationship('equipment_machinery', 'name')
                    ->required(),
                Forms\Components\TextInput::make('technomechanical')->label('Tecnomecanica')
                    ->required()
                    ->maxLength(191),
                Forms\Components\DatePicker::make('date_tuition')->label('Fecha de matricula')
                    ->required(),
                Forms\Components\DatePicker::make('last_revision')->label('Fecha de ultima revisión')
                    ->required(),
                Forms\Components\DatePicker::make('date_revision')->label('Fecha de revisión')
                    ->required(),
                Forms\Components\FileUpload::make('file')->label('Subir evidencia'),
                Forms\Components\Select::make('status')->label('Estado')
                    ->required()
                    ->options([
                        'Vigente' => 'Vigente',
                        'Expirado' => 'Expirado',
                    ]),
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
                Tables\Columns\TextColumn::make('technomechanical')->label('Tecnomecanica')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_tuition')->label('Fecha de matricula')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_revision')->label('Fecha de ultima revisión')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_revision')->label('Fecha de revisión')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')->label('Estado')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEquipmentMachineryTechnos::route('/'),
            'create' => Pages\CreateEquipmentMachineryTechno::route('/create'),
            'edit' => Pages\EditEquipmentMachineryTechno::route('/{record}/edit'),
        ];
    }
}
