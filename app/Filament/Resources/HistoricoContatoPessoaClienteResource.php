<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HistoricoContatoPessoaClienteResource\Pages;
use App\Filament\Resources\HistoricoContatoPessoaClienteResource\RelationManagers;
use App\Models\Cliente\Contato\HistoricoContatoPessoaCliente;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HistoricoContatoPessoaClienteResource extends Resource
{
    protected static ?string $model = HistoricoContatoPessoaCliente::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Clientes';

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
                //
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
            'index' => Pages\ListHistoricoContatoPessoaClientes::route('/'),
            'create' => Pages\CreateHistoricoContatoPessoaCliente::route('/create'),
            'edit' => Pages\EditHistoricoContatoPessoaCliente::route('/{record}/edit'),
        ];
    }
}
