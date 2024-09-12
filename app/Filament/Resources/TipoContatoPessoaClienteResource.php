<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TipoContatoPessoaClienteResource\Pages;
use App\Filament\Resources\TipoContatoPessoaClienteResource\RelationManagers;
use App\Models\Cliente\TipoContatoPessoaCliente;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TipoContatoPessoaClienteResource extends Resource
{
    protected static ?string $model = TipoContatoPessoaCliente::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationParentItem = 'Clientes';

    protected static ?string $modelLabel = 'Tipos de Contato';

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
                Tables\Columns\TextColumn::make('nome')->size(TextColumnSize::ExtraSmall),
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
            'index' => Pages\ListTipoContatoPessoaClientes::route('/'),
            'create' => Pages\CreateTipoContatoPessoaCliente::route('/create'),
            'edit' => Pages\EditTipoContatoPessoaCliente::route('/{record}/edit'),
        ];
    }
}
