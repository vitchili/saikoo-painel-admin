<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClienteResource\Pages;
use App\Filament\Resources\ClienteResource\RelationManagers\ContatosPessoasClienteRelationManager;
use App\Filament\Resources\ClienteResource\RelationManagers\HistoricoObservacoesRelationManager;
use App\Models\Cliente\Cliente;
use App\Models\Cliente\TipoCliente;
use App\Models\Cliente\TipoContatoPessoaCliente;
use App\Models\Cliente\TipoRedeSocialCliente;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;

class ClienteResource extends Resource
{
    protected static ?string $model = Cliente::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Clientes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make()->tabs([
                    Tab::make('Cadastro')->schema([
                        Tabs::make()->tabs([
                            Tab::make('Dados Cadastrais')
                                ->schema([
                                    Radio::make('tipo')
                                        ->label('Tipo')
                                        ->required()
                                        ->options(TipoCliente::all()->pluck('nome', 'id'))
                                        ->inline()
                                        ->inlineLabel(false),
                                    Select::make('id_representante')
                                        ->label('Representante')
                                        ->options([])
                                        ->searchable(),
                                    Radio::make('cliente_parceiro')
                                        ->label('Parceiro')
                                        ->options([
                                            'N' => 'Não',
                                            'S' => 'Sim',
                                        ])
                                        ->inline()
                                        ->inlineLabel(false),
                                    Radio::make('tornar_cliente')
                                        ->label('Tornar Cliente')
                                        ->required()
                                        ->options([
                                            'N' => 'Não',
                                            'S' => 'Sim',
                                        ])
                                        ->inline()
                                        ->inlineLabel(false),
                                    TextInput::make('codigo')
                                        ->label('Código')
                                        ->unique()
                                        ->maxLength(255),
                                    TextInput::make('nome')
                                        ->label('Razão Social')
                                        ->required()
                                        ->maxLength(255),
                                    TextInput::make('nomefantasia')
                                        ->label('Fantasia')
                                        ->maxLength(255),
                                    TextInput::make('cpf_cnpj')
                                        ->label('CNPJ')
                                        ->mask(RawJs::make(<<<'JS'
                                        $input.length > 14 ? '99.999.999/9999-99' : '999.999.999-99'
                                    JS))
                                        ->rule('cpf_ou_cnpj'),
                                    TextInput::make('ie')
                                        ->label('Inscrição Estadual')
                                        ->maxLength(255),
                                    TextInput::make('inscricao_municipal')
                                        ->label('Inscrição Municipal')
                                        ->maxLength(255),
                                    TextInput::make('telefone')
                                        ->label('Telefone')
                                        ->mask(RawJs::make(<<<'JS'
                                        $input.length >= 14 ? '(99)99999-9999' : '(99)9999-9999'
                                    JS)),
                                    TextInput::make('telefone2')
                                        ->label('Celular')
                                        ->mask(RawJs::make(<<<'JS'
                                        $input.length >= 14 ? '(99)99999-9999' : '(99)9999-9999'
                                    JS)),
                                    Toggle::make('em_implantacao')
                                        ->label('Em implantação')
                                        ->inline(false),
                                ])->columns(2),
                            Tab::make('Responsáveis')
                                ->schema([
                                    Fieldset::make('1º Responsável')
                                        ->schema([
                                            TextInput::make('responsavel')
                                                ->label('Nome')
                                                ->placeholder('Nome do responsável')
                                                ->maxLength(255),
                                            TextInput::make('cpf_resp')
                                                ->label('CPF')
                                                ->placeholder('CPF do responsável')
                                                ->mask('999.999.999-99')
                                                ->rule('cpf'),
                                            TextInput::make('rg')
                                                ->label('RG')
                                                ->placeholder('RG do responsável')
                                                ->maxLength(255),
                                            TextInput::make('orgao_expedidor')
                                                ->label('Órgão Expedidor')
                                                ->placeholder('Órgão expedidor do RG')
                                                ->maxLength(255),
                                            DatePicker::make('data_nasc_resp')
                                                ->label('Data Nascimento'),
                                            TextInput::make('email_resp')
                                                ->label('E-mail Responsavel')
                                                ->placeholder('E-mail do responsável')
                                                ->email()
                                                ->maxLength(255),
                                            TextInput::make('fone_resp1')
                                                ->label('Telefone')
                                                ->placeholder('Telefone do responsável')
                                                ->mask(RawJs::make(<<<'JS'
                                                $input.length >= 14 ? '(99)99999-9999' : '(99)9999-9999'
                                            JS)),
                                            TextInput::make('senha_resp')
                                                ->label('Senha')
                                                ->placeholder('Senha do responsável')
                                                ->password()
                                                ->maxLength(255),
                                            Toggle::make('aut_envio_email_resp')
                                                ->label('Autoriza o envio de e-mails')
                                                ->inline(false),
                                        ])->columns(3),
                                    Fieldset::make('2º Responsável')
                                        ->schema([
                                            TextInput::make('responsavel2')
                                                ->label('Nome')
                                                ->placeholder('Nome do 2º responsável')
                                                ->maxLength(255),
                                            TextInput::make('cpf_resp2')
                                                ->label('CPF do responsável')
                                                ->placeholder('CPF do 2º responsável')
                                                ->mask('999.999.999-99')
                                                ->rule('cpf'),
                                            TextInput::make('rg2')
                                                ->label('RG')
                                                ->placeholder('RG do 2º responsável')
                                                ->maxLength(255),
                                            TextInput::make('orgao_expedidor2')
                                                ->label('Órgão Expedidor')
                                                ->placeholder('Órgão expedidor do RG')
                                                ->maxLength(255),
                                            DatePicker::make('data_nasc_resp2')
                                                ->label('Data Nascimento'),
                                            TextInput::make('email_resp2')
                                                ->label('E-mail')
                                                ->email()
                                                ->placeholder('E-mail do 2º responsável')
                                                ->maxLength(255),
                                            TextInput::make('fone_resp2')
                                                ->label('Telefone')
                                                ->placeholder('Telefone do 2º responsável')
                                                ->mask(RawJs::make(<<<'JS'
                                                $input.length >= 14 ? '(99)99999-9999' : '(99)9999-9999'
                                            JS)),
                                            Toggle::make('aut_envio_email_resp2')
                                                ->label('Autoriza o envio de e-mails')
                                                ->inline(false),
                                            Toggle::make('nao_faz_parte_contrato2')
                                                ->label('Não faz parte do contrato')
                                                ->required()
                                                ->inline(false),
                                        ])->columns(3),
                                ]),
                            Tab::make('Contatos')
                                ->schema([
                                    Repeater::make('contatosPessoasCliente')
                                        ->label('Contatos')
                                        ->relationship('contatosPessoasCliente')
                                        ->schema([
                                            Select::make('tipo_contato_pessoa_cliente_id')
                                                ->label('Tipo')
                                                ->options(TipoContatoPessoaCliente::all()->pluck('nome', 'id'))
                                                ->searchable(),
                                            TextInput::make('nome')
                                                ->label('Nome'),
                                            TextInput::make('telefone')
                                                ->label('Telefone')
                                                ->mask(RawJs::make(<<<'JS'
                                                $input.length >= 14 ? '(99)99999-9999' : '(99)9999-9999'
                                            JS)),
                                            TextInput::make('email')
                                                ->label('E-mail'),
                                            Select::make('responsavel_id')
                                                ->label('Responsavel pelo contato')
                                                ->options(User::all()->pluck('name', 'id'))
                                        ])
                                        ->columns(3)
                                ]),
                            Tab::make('Acesso/Endereço')
                                ->schema([
                                    Fieldset::make('Endereço')
                                        ->schema([
                                            TextInput::make('cep')
                                                ->label('CEP')
                                                ->maxLength(9)
                                                ->required(),
                                            TextInput::make('end')
                                                ->label('Logradouro')
                                                ->required(),
                                            TextInput::make('numero')
                                                ->label('Número')
                                                ->required(),
                                            TextInput::make('complemento')
                                                ->label('Complemento'),
                                            TextInput::make('bairro')
                                                ->label('Bairro')
                                                ->required(),
                                            TextInput::make('cidade')
                                                ->label('Cidade')
                                                ->required(),
                                            TextInput::make('uf')
                                                ->label('UF')
                                                ->maxLength(2)
                                                ->required(),
                                        ])->columns(3),
                                    Fieldset::make('Acesso')
                                        ->schema([
                                            TextInput::make('email')
                                                ->label('Usuário de acesso'),
                                            TextInput::make('senha')
                                                ->label('Senha de acesso')
                                                ->password()
                                                ->revealable(),
                                        ]),
                                ])->columns(3),
                            Tab::make('Dados Bancários')
                                ->schema([
                                    Fieldset::make('Dados Banco')
                                        ->schema([
                                            Select::make('banco')
                                                ->label('Banco')
                                                ->options([])
                                                ->searchable(),
                                            Select::make('tipo_conta')
                                                ->label('Tipo de Conta')
                                                ->options([
                                                    0 => 'Corrente',
                                                    1 => 'Poupança'
                                                ])
                                                ->searchable(),
                                        ])->columns(2),
                                    Fieldset::make('Dados Conta')
                                        ->schema([
                                            TextInput::make('agencia')
                                                ->label('Agência'),
                                            TextInput::make('agenciadv')
                                                ->label('Dv')
                                                ->maxLength(2),
                                            TextInput::make('conta')
                                                ->label('Conta'),
                                            TextInput::make('contadv')
                                                ->label('Dv')
                                                ->maxLength(2),
                                        ])->columns(4),
                                    Fieldset::make('Financeira')
                                        ->schema([
                                            Select::make('id_tipo_financeira')
                                                ->label('Tipo Financeira')
                                                ->options([])
                                                ->searchable(),
                                            TextInput::make('cod_pago')
                                                ->label('Cód. Financeira'),
                                            TextInput::make('senha_pago')
                                                ->label('Senha Financeira')
                                                ->password()
                                                ->revealable(),
                                        ])->columns(2)
                                ]),
                            Tab::make('Rede Social')
                                ->schema([
                                    Repeater::make('redesSociais')
                                        ->label('Rede social')
                                        ->relationship('redesSociais')
                                        ->schema([
                                            Select::make('tipo_rede_social_id')
                                                ->label('Rede Social')
                                                ->options(TipoRedeSocialCliente::all()->pluck('nome', 'id'))
                                                ->searchable(),
                                            TextInput::make('url')
                                                ->label('URL'),
                                        ])
                                        ->columns(2)
                                ]),
                            Tab::make('Observações')
                                ->schema([
                                    RichEditor::make('obs')
                                        ->toolbarButtons([
                                            'blockquote',
                                            'bold',
                                            'bulletList',
                                            'codeBlock',
                                            'italic',
                                            'link',
                                            'orderedList',
                                            'redo',
                                            'strike',
                                            'underline',
                                            'undo',
                                        ])
                                        ->columnSpanFull()
                                        ->label('Observação'),
                                    RichEditor::make('obs_tendimento')
                                        ->toolbarButtons([
                                            'blockquote',
                                            'bold',
                                            'bulletList',
                                            'codeBlock',
                                            'italic',
                                            'link',
                                            'orderedList',
                                            'redo',
                                            'strike',
                                            'underline',
                                            'undo',
                                        ])
                                        ->columnSpanFull()
                                        ->label('Observação Atendimento'),
                                    RichEditor::make('servicos_c')
                                        ->toolbarButtons([
                                            'blockquote',
                                            'bold',
                                            'bulletList',
                                            'codeBlock',
                                            'italic',
                                            'link',
                                            'orderedList',
                                            'redo',
                                            'strike',
                                            'underline',
                                            'undo',
                                        ])
                                        ->columnSpanFull()
                                        ->label('Serviços'),
                                    TextInput::make('versao')
                                        ->label('Atualização Versão')
                                        ->placeholder('Versão'),
                                    TextInput::make('url_api')
                                        ->label('URL API')
                                        ->placeholder('URL API'),
                                    FileUpload::make('contrato')
                                        ->label('Contrato'),
                                    FileUpload::make('certificado')
                                        ->label('Certificado Digital'),
                                    FileUpload::make('logo')
                                        ->label('Logotipo'),
                                    \Njxqlus\Filament\Components\Forms\RelationManager::make()->manager(HistoricoObservacoesRelationManager::class)->lazy(false)
                                ]),
                        ]),
                    ]),
                    Tab::make('Contatos com cliente')->schema([
                        \Njxqlus\Filament\Components\Forms\RelationManager::make()->manager(ContatosPessoasClienteRelationManager::class)->lazy(false)
                    ]),
                ]),

            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('codigo')
                    ->label('Código')
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('status')
                    ->label('Ativo'),
                Tables\Columns\TextColumn::make('autor.name')
                    ->label('Usuário')
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('nome')
                    ->label('Razão'),
                Tables\Columns\TextColumn::make('nomefantasia')
                    ->label('Fantasia'),
                Tables\Columns\TextColumn::make('bairro')
                    ->label('Bairro'),
                Tables\Columns\TextColumn::make('cidade')
                    ->label('Cidade'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClientes::route('/'),
            'create' => Pages\CreateCliente::route('/create'),
            'view' => Pages\ViewCliente::route('/{record}'),
            'edit' => Pages\EditCliente::route('/{record}/edit'),
        ];
    }
}
