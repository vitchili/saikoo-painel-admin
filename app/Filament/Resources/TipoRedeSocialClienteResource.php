<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TipoRedeSocialClienteResource\Pages;
use App\Filament\Resources\TipoRedeSocialClienteResource\RelationManagers;
use App\Models\Cliente\TipoRedeSocialCliente;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TipoRedeSocialClienteResource extends Resource
{
    protected static ?string $model = TipoRedeSocialCliente::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationParentItem = 'Clientes';

    protected static ?string $modelLabel = 'Tipos de Rede Sociais';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
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
            'index' => Pages\ListTipoRedeSocialClientes::route('/'),
            'create' => Pages\CreateTipoRedeSocialCliente::route('/create'),
            'edit' => Pages\EditTipoRedeSocialCliente::route('/{record}/edit'),
        ];
    }
}
