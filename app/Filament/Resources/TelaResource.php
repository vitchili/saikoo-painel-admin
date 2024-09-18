<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TelaResource\Pages;
use App\Filament\Resources\TelaResource\RelationManagers;
use App\Models\Diversos\Modulo;
use App\Models\Diversos\Tela;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TelaResource extends Resource
{
    protected static ?string $model = Tela::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Telas';

    protected static ?string $slug = 'telas';

    protected static ?string $modelLabel = 'Tela';

    protected static ?string $navigationGroup = 'Cadastros';

    protected static ?string $navigationParentItem = 'Sistemas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('modulo_id')
                    ->label('Módulo')
                    ->options(Modulo::all()->pluck('nome', 'id'))
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
                Tables\Columns\TextColumn::make('modulo.nome')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Módulo')
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
            'index' => Pages\ListTelas::route('/'),
            'create' => Pages\CreateTela::route('/create'),
            'edit' => Pages\EditTela::route('/{record}/edit'),
        ];
    }
}
