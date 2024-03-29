<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipmentMachinerySoatResource\Pages;
use App\Filament\Resources\EquipmentMachinerySoatResource\RelationManagers;
use App\Models\EquipmentMachinerySoat;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EquipmentMachinerySoatResource extends Resource
{
    protected static ?string $model = EquipmentMachinerySoat::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-check';

    protected static ?string $navigationLabel = 'Soat';

    protected static ?string $slug = 'soat';

    protected static ?string $modelLabel = 'Soat';

    protected static ?string $navigationGroup = 'Administración de maquinaria y equipos';

    protected static ?int $navigationSort = 4;

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
                Forms\Components\Select::make('equipment_machinery_id')->label('Equipo o maquinaria')
                    ->relationship('equipment_machinery', 'name')
                    ->required(),
                Forms\Components\TextInput::make('name')->label('Soat')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('beneficiary')->label('Beneficiario')
                    ->required()
                    ->maxLength(191),
                Forms\Components\DatePicker::make('validity')->label('Vigencia')
                    ->required()
                    ->afterStateUpdated(function (Set $set, Get $get, $state){
                        $last_report = Carbon::parse($state);
                        $today = date_create(date("Y-m-d"));
                        $expiration_date = date_create($last_report);
                        $interval = date_diff($today, $expiration_date);
                        $days = $interval->format('%R%a');
                        if($days < 0) {
                            $set('status', 'PASADO');
                        } elseif($days >= 0 && $days < 30) {
                            $set('status', 'PROXIMO');
                        } else {
                            $set('status', 'BUEN ESTADO');
                        }
                    })
                    ->live(),
                Forms\Components\FileUpload::make('file')->label('Subir evidencia'),
                Forms\Components\Select::make('status')->label('Estado')
                    ->required()
                    ->live()
                    ->options([
                        'PASADO' => 'PASADO',
                        'PROXIMO' => 'PROXIMO',
                        'BUEN ESTADO' => 'BUEN ESTADO',
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
                Tables\Columns\TextColumn::make('name')->label('Soat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('beneficiary')->label('Beneficiario')
                    ->searchable(),
                Tables\Columns\TextColumn::make('validity')->label('Vigencia')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')->label('Estado')

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
            'index' => Pages\ListEquipmentMachinerySoats::route('/'),
            'create' => Pages\CreateEquipmentMachinerySoat::route('/create'),
            'edit' => Pages\EditEquipmentMachinerySoat::route('/{record}/edit'),
        ];
    }
}
