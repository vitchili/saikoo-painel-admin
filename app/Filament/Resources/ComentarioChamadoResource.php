<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ComentarioChamadoResource\Pages;
use App\Filament\Resources\ComentarioChamadoResource\RelationManagers;
use App\Models\Chamado\ComentarioChamado;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ComentarioChamadoResource extends Resource
{
    protected static ?string $model = ComentarioChamado::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Chamados';

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
            'index' => Pages\ListComentarioChamados::route('/'),
            'create' => Pages\CreateComentarioChamado::route('/create'),
            'edit' => Pages\EditComentarioChamado::route('/{record}/edit'),
        ];
    }
}
