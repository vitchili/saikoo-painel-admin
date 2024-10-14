<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CentralClienteImplantacaoResource\Pages;
use App\Filament\Resources\CentralClienteImplantacaoResource\RelationManagers;
use App\Models\CentralClienteImplantacao;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CentralClienteImplantacaoResource extends Resource
{
    protected static ?string $model = CentralClienteImplantacao::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canAccess(): bool
    {
        return false;
    }

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
            'index' => Pages\ListCentralClienteImplantacaos::route('/'),
            'create' => Pages\CreateCentralClienteImplantacao::route('/create'),
            'edit' => Pages\EditCentralClienteImplantacao::route('/{record}/edit'),
        ];
    }
}
