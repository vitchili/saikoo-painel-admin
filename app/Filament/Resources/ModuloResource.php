<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ModuloResource\Pages;
use App\Filament\Resources\ModuloResource\RelationManagers;
use App\Models\Diversos\Modulo;
use App\Models\Diversos\Sistema;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ModuloResource extends Resource
{
    protected static ?string $model = Modulo::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Módulos';

    protected static ?string $slug = 'modulos';

    protected static ?string $modelLabel = 'Módulo';

    protected static ?string $navigationGroup = 'Cadastros';

    protected static ?string $navigationParentItem = 'Sistemas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('sistema_id')
                    ->label('Sistema')
                    ->options(Sistema::all()->pluck('nome', 'id'))
                    ->required()
                    ->preload()
                    ->searchable(),
                Forms\Components\TextInput::make('nome')
                    ->label('Nome')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sistema.nome')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Sistema')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nome')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Nome')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                
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
            'index' => Pages\ListModulos::route('/'),
            'create' => Pages\CreateModulo::route('/create'),
            'edit' => Pages\EditModulo::route('/{record}/edit'),
        ];
    }
}
