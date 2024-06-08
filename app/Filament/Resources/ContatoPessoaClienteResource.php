<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContatoPessoaClienteResource\Pages;
use App\Filament\Resources\ContatoPessoaClienteResource\RelationManagers;
use App\Models\Cliente\Contato\ContatoPessoaCliente;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Route;

class ContatoPessoaClienteResource extends Resource
{
    protected static ?string $model = ContatoPessoaCliente::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->label('Nome')
                    ->sortable(),
                Tables\Columns\TextColumn::make('telefone')
                    ->label('Telefone')
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('E-mail')
                    ->sortable(),
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
            'index' => Pages\ListContatoPessoaClientes::route('/'),
            'create' => Pages\CreateContatoPessoaCliente::route('/create'),
            'edit' => Pages\EditContatoPessoaCliente::route('/{record}/edit'),
        ];
    }

    // public static function getEloquentQuery(): Builder
    // {
    //     return parent::getEloquentQuery()->where('cliente_id', '=', Route::current()->parameter('clienteId'));
    // }

    
}
