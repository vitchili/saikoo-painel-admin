<?php

namespace App\Filament\Resources\ClienteResource\RelationManagers;

use App\Models\Chamado\Enum\SituacaoChamado;
use App\Models\Chamado\Enum\SituacaoContato;
use App\Models\Cliente\TipoContatoPessoaCliente;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Concerns\HasSubNavigation;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContatosPessoasClienteRelationManager extends RelationManager
{
    protected static string $relationship = 'contatosPessoasCliente';

    protected static ?string $title = 'Contatos com o Cliente';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('tipo_contato_pessoa_id')
                    ->required()
                    ->label('Tipo Contato')
                    ->options(TipoContatoPessoaCliente::all()->pluck('nome', 'id')),
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->label('Nome')
                    ->maxLength(255),
                Forms\Components\TextInput::make('telefone')
                    ->label('Telefone'),
                Forms\Components\TextInput::make('email')
                    ->label('E-mail'),
                Forms\Components\Select::make('situacao_id')
                    ->label('Situação')
                    ->options([]),
                //->options(SituacaoContato::getEnumArray()),
                Forms\Components\Select::make('responsavel_id')
                    ->required()
                    ->label('Responsável')
                    ->options(TipoContatoPessoaCliente::all()->pluck('nome', 'id')),
                Forms\Components\DatePicker::make('data_contato')
                    ->required()
                    ->label('Data Contato'),
                Forms\Components\DatePicker::make('data_contato')
                    ->label('Data Retorno'),
                Forms\Components\Section::make('Comentários')
                    ->schema([
                        Forms\Components\Repeater::make('comentarios')
                            ->relationship('comentarios')
                            ->schema([
                                Forms\Components\TextInput::make('content')->required(),
                            ]),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nome')
            ->columns([
                Tables\Columns\TextColumn::make('nome'),
                Tables\Columns\TextColumn::make('telefone'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('data_contato'),
                Tables\Columns\TextColumn::make('data_retorno'),
                Tables\Columns\TextColumn::make('responsavel.name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Novo Contato'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([]);
    }
}
