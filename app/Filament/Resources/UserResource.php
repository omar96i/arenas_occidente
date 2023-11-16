<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\UserResource\RelationManagers\ContractsRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\PersonalInformationRelationManager;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationLabel = 'Usuarios';

    protected static ?string $slug = 'usuarios';

    protected static ?int $navigationSort = 1;

    protected static ?string $pluralModelLabel = 'usuarios';

    protected static ?string $navigationGroup = 'Administracion de usuarios';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Label')
                    ->tabs([
                        Tab::make('Usuario')
                            ->schema([
                                TextInput::make('name')->label('Nombre de Usuario')
                                    ->required()
                                    ->maxLength(191),
                                TextInput::make('email')->label('Email')
                                    ->email()
                                    ->required()
                                    ->maxLength(191),
                                TextInput::make('password')->label('Contraseña')
                                    ->password()
                                    ->maxLength(191),
                            ])->columns(2),
                        Tabs\Tab::make('Datos Personales')
                            ->schema([
                                TextInput::make('full_name')
                                    ->label('Nombres')
                                     ->maxLength(191),
                                TextInput::make('last_name')
                                    ->label('Apellidos')
                                    ->maxLength(191),
                                TextInput::make('document')
                                    ->label('Documento')
                                    ->maxLength(191),
                                TextInput::make('address')
                                    ->label('Dirección')
                                    ->maxLength(191),
                            ])->columns(2),
                    ])->contained(false)->activeTab(1)
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')->label('Correo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')->label('Fecha de creacion')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Editar'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Eliminar'),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ContractsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
