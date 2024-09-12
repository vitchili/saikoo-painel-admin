<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ModeloImplantacaoResource\Pages;
use App\Filament\Resources\ModeloImplantacaoResource\RelationManagers;
use App\Models\Implantacao\ModeloImplantacao;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ModeloImplantacaoResource extends Resource
{
    protected static ?string $model = ModeloImplantacao::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Modelos Implantações';

    protected static ?string $slug = 'modelos-implantacoes';

    protected static ?string $modelLabel = 'Modelos Implantações';

    protected static ?string $navigationGroup = 'Gerais';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nome')
                    ->label('Nome')
                    ->required()
                    ->maxLength(255)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nome')
                    ->label('Nome')
                    ->size(TextColumnSize::ExtraSmall)
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
            'index' => Pages\ListModeloImplantacaos::route('/'),
            'create' => Pages\CreateModeloImplantacao::route('/create'),
            'edit' => Pages\EditModeloImplantacao::route('/{record}/edit'),
        ];
    }
}
