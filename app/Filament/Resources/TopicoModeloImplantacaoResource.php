<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TopicoModeloImplantacaoResource\Pages;
use App\Filament\Resources\TopicoModeloImplantacaoResource\RelationManagers;
use App\Models\Implantacao\ModeloImplantacao;
use App\Models\Implantacao\TopicoModeloImplantacao;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TopicoModeloImplantacaoResource extends Resource
{
    protected static ?string $model = TopicoModeloImplantacao::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Módulos Implantações';

    protected static ?string $slug = 'topicos-implantacoes';

    protected static ?string $modelLabel = 'Tópicos/Módulos Implantações';

    protected static ?string $navigationGroup = 'Gerais';

    protected static ?string $navigationParentItem = 'Modelos Implantações';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('modelo_id')
                    ->label('Modelo Implantação')
                    ->required()
                    ->options(ModeloImplantacao::all()->pluck('nome', 'id')),
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
                TextColumn::make('modelo.nome')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Modelo'),
                TextColumn::make('nome')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Nome')
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
            'index' => Pages\ListTopicoModeloImplantacaos::route('/'),
            'create' => Pages\CreateTopicoModeloImplantacao::route('/create'),
            'edit' => Pages\EditTopicoModeloImplantacao::route('/{record}/edit'),
        ];
    }
}
