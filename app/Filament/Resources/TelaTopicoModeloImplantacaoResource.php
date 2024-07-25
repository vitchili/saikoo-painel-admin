<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TelaTopicoModeloImplantacaoResource\Pages;
use App\Filament\Resources\TelaTopicoModeloImplantacaoResource\RelationManagers;
use App\Models\Implantacao\TelaTopicoModeloImplantacao;
use App\Models\Implantacao\TopicoModeloImplantacao;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TelaTopicoModeloImplantacaoResource extends Resource
{
    protected static ?string $model = TelaTopicoModeloImplantacao::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Telas';

    protected static ?string $slug = 'telas';

    protected static ?string $modelLabel = 'Tela';

    protected static ?string $navigationGroup = 'Gerais';

    protected static ?string $navigationParentItem = 'Modelos Implantações';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('topico_id')
                    ->label('Módulo')
                    ->required()
                    ->options(TopicoModeloImplantacao::all()->pluck('nome', 'id')),
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
                TextColumn::make('topico.modelo.nome')
                    ->label('Modelo'),
                TextColumn::make('topico.nome')
                    ->label('Módulo/Tópico'),
                TextColumn::make('nome')
                    ->label('Nome')
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
            'index' => Pages\ListTelaTopicoModeloImplantacaos::route('/'),
            'create' => Pages\CreateTelaTopicoModeloImplantacao::route('/create'),
            'edit' => Pages\EditTelaTopicoModeloImplantacao::route('/{record}/edit'),
        ];
    }
}
