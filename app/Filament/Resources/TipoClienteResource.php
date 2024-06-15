<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TipoClienteResource\Pages;
use App\Filament\Resources\TipoClienteResource\RelationManagers;
use App\Models\Cliente\TipoCliente;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TipoClienteResource extends Resource
{
    protected static ?string $model = TipoCliente::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationParentItem = 'Clientes';

    protected static ?string $modelLabel = 'Tipos de Clientes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->label('Nome')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome'),
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
            'index' => Pages\ListTipoClientes::route('/'),
            'create' => Pages\CreateTipoCliente::route('/create'),
            'edit' => Pages\EditTipoCliente::route('/{record}/edit'),
        ];
    }
}
