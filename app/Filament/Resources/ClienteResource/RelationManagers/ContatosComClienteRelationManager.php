<?php

namespace App\Filament\Resources\ClienteResource\RelationManagers;

use App\Models\Cliente\TipoContatoPessoaCliente;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use Parallax\FilamentComments\Tables\Actions\CommentsAction;

class ContatosComClienteRelationManager extends RelationManager
{
    protected static string $relationship = 'contatosComCliente';

    protected static ?string $title = 'Contatos com o Cliente';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('tipo_contato_com_cliente_id')
                    ->required()
                    ->label('Tipo Contato')
                    ->options(TipoContatoPessoaCliente::all()->pluck('nome', 'id')),
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->label('Nome')
                    ->maxLength(255),
                Forms\Components\TextInput::make('telefone')
                    ->label('Telefone')
                    ->mask(RawJs::make(<<<'JS'
                        $input.length >= 14 ? '(99)99999-9999' : '(99)9999-9999'
                    JS)),
                Forms\Components\TextInput::make('email')
                    ->label('E-mail')
                    ->email(),
                Forms\Components\Select::make('situacao_id')
                    ->label('Situação')
                    ->options([]),
                //->options(SituacaoContato::getEnumArray()),
                Forms\Components\Select::make('responsavel_id')
                    ->required()
                    ->label('Responsável')
                    ->options(User::all()->pluck('name', 'id')),
                Forms\Components\DatePicker::make('data_contato')
                    ->required()
                    ->label('Data Contato'),
                Forms\Components\DatePicker::make('data_retorno')
                    ->label('Data Retorno'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nome')
            ->columns([
                Tables\Columns\TextColumn::make('tipoContato.nome'),
                Tables\Columns\TextColumn::make('nome'),
                Tables\Columns\TextColumn::make('telefone'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('data_contato')->date('d/m/Y'),
                Tables\Columns\TextColumn::make('data_retorno')->date('d/m/Y'),
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
                CommentsAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([]);
    }
}
