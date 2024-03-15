<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipmentMachineryResource\Pages;
use App\Filament\Resources\EquipmentMachineryResource\RelationManagers;
use App\Filament\Resources\EquipmentMachineryResource\RelationManagers\InspectionControlRelationManager;
use App\Filament\Resources\EquipmentMachineryResource\RelationManagers\InsuranceRelationManager;
use App\Filament\Resources\EquipmentMachineryResource\RelationManagers\MaintenanceRelationManager;
use App\Filament\Resources\EquipmentMachineryResource\RelationManagers\OwnerRelationManager;
use App\Filament\Resources\EquipmentMachineryResource\RelationManagers\SchedulesRelationManager;
use App\Filament\Resources\EquipmentMachineryResource\RelationManagers\SoatsRelationManager;
use App\Filament\Resources\EquipmentMachineryResource\RelationManagers\TechnosRelationManager;
use App\Filament\Resources\EquipmentMachineryResource\RelationManagers\ValuesRelationManager;
use App\Models\EquipmentMachinery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EquipmentMachineryResource extends Resource
{
    protected static ?string $model = EquipmentMachinery::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationLabel = 'Equipos y Maquinaria';

    protected static ?string $slug = 'equipos';

    protected static ?string $modelLabel = 'Equipos y Maquinaria';

    protected static ?string $navigationGroup = 'Administración de maquinaria y equipos';

    protected static ?int $navigationSort = 1;

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
                                        'inactivo' => 'Inactivo',
                                        'para reparación' => 'Para reparación',
                                        'varado en taller' => 'Varado en taller',
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
                    ->circular()
                    ->disk('public'),
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
            ValuesRelationManager::class,
            MaintenanceRelationManager::class,
            SchedulesRelationManager::class,
            InspectionControlRelationManager::class,
            TechnosRelationManager::class,
            InsuranceRelationManager::class,
            SoatsRelationManager::class,
            OwnerRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEquipmentMachineries::route('/'),
            'create' => Pages\CreateEquipmentMachinery::route('/create'),
            'edit' => Pages\EditEquipmentMachinery::route('/{record}/edit'),
        ];
    }
}
