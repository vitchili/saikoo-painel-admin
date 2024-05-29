<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SituacaoResource\Pages;
use App\Filament\Resources\SituacaoResource\RelationManagers;
use App\Models\Chamado\SituacaoChamado;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SituacaoResource extends Resource
{
    protected static ?string $model = SituacaoChamado::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Situações';

    protected static ?string $modelLabel = 'Situações';

    protected static ?string $navigationGroup = 'Chamados';

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
            'index' => Pages\ListSituacaos::route('/'),
            'create' => Pages\CreateSituacao::route('/create'),
            'edit' => Pages\EditSituacao::route('/{record}/edit'),
        ];
    }
}
