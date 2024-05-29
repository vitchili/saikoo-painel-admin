<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClienteResource\Pages;
use App\Models\Cliente\Cliente;
use App\Models\Cliente\TipoCliente;
use App\Models\Cliente\TipoContatoPessoaCliente;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ClienteResource extends Resource
{
    protected static ?string $model = Cliente::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Dados da empresa')
                            ->schema([
                                Radio::make('tipo')
                                    ->label('Tipo')
                                    ->options(TipoCliente::all()->pluck('nome', 'id'))
                                    ->inline()
                                    ->inlineLabel(false),
                                // Select::make('id_representante')
                                //     ->label('Representante')
                                //     ->options([])
                                //     ->searchable(),
                                // Radio::make('cliente_parceiro')
                                //     ->label('Parceiro')
                                //     ->options([
                                //         'N' => 'Não',
                                //         'S' => 'Sim',
                                //     ])
                                //     ->inline()
                                //     ->inlineLabel(false),
                                DateTimePicker::make('data_cadastro')
                                    ->seconds(false),
                                // Select::make('id_indicacao')
                                //     ->label('Indicação')
                                //     ->options([
                                //         Cliente::all()->pluck('nomefantasia', 'id')
                                //     ])
                                //     ->searchable(),
                                // Select::make('id_usuario_cadastro')
                                //     ->label('Usuário cadastro')
                                //     ->options([
                                //     ])
                                //     ->searchable(),
                                TextInput::make('codigo')
                                    ->label('Código')
                                    ->required()
                                    ->maxLength(255),
                                // Select::make('id_usuario_auto_repre')
                                //     ->label('Aut. Repre. Visualizar')
                                //     ->options([
                                //     ])
                                //     ->searchable(),
                                TextInput::make('nome')
                                    ->label('Razão Social')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('nomefantasia')
                                    ->label('Fantasia')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('cpf_cnpj')
                                    ->label('CNPJ')
                                    ->required()
                                    ->maxLength(18),
                                TextInput::make('ie')
                                    ->label('Inscrição Estadual')
                                    ->maxLength(255),
                                TextInput::make('inscricao_municipal')
                                    ->label('Inscrição Municipal')
                                    ->maxLength(255),
                                // Toggle::make('status')
                                //     ->label('Status')
                                //     ->inline(false),
                                Toggle::make('em_implantacao')
                                    ->label('Em implantação')
                                    ->inline(false),

                            ])->columns(2),
                        Tabs\Tab::make('Responsáveis')
                            ->schema([
                                Fieldset::make('1º Responsável')
                                    ->schema([
                                        TextInput::make('inscricao_municipal')
                                            ->label('Nome')
                                            ->placeholder('Nome do responsável')
                                            ->maxLength(255),
                                        TextInput::make('inscricao_municipal')
                                            ->label('CPF do responsável')
                                            ->placeholder('Nome completo')
                                            ->maxLength(255),
                                        TextInput::make('inscricao_municipal')
                                            ->label('RG')
                                            ->placeholder('RG do responsável')
                                            ->maxLength(255),
                                        TextInput::make('inscricao_municipal')
                                            ->label('Órgão Expedidor')
                                            ->placeholder('Órgão expedidor do RG')
                                            ->maxLength(255),
                                        DatePicker::make('inscricao_municipal')
                                            ->label('Data Nascimento'),
                                        TextInput::make('inscricao_municipal')
                                            ->label('E-mail')
                                            ->placeholder('E-mail do responsável')
                                            ->maxLength(255),
                                        TextInput::make('inscricao_municipal')
                                            ->label('Telefone')
                                            ->placeholder('(xx) xxxxx-xxxx')
                                            ->maxLength(255),
                                        TextInput::make('inscricao_municipal')
                                            ->label('Senha')
                                            ->placeholder('Senha do responsável')
                                            ->maxLength(255),
                                        Toggle::make('em_implantacao')
                                            ->label('Autoriza o envio de e-mails')
                                            ->inline(false),
                                    ])->columns(4),
                                    Fieldset::make('2º Responsável')
                                    ->schema([
                                        TextInput::make('inscricao_municipal')
                                            ->label('Nome')
                                            ->placeholder('Nome do responsável')
                                            ->maxLength(255),
                                        TextInput::make('inscricao_municipal')
                                            ->label('CPF do responsável')
                                            ->placeholder('Nome completo')
                                            ->maxLength(255),
                                        TextInput::make('inscricao_municipal')
                                            ->label('RG')
                                            ->placeholder('RG do responsável')
                                            ->maxLength(255),
                                        TextInput::make('inscricao_municipal')
                                            ->label('Órgão Expedidor')
                                            ->placeholder('Órgão expedidor do RG')
                                            ->maxLength(255),
                                        DatePicker::make('inscricao_municipal')
                                            ->label('Data Nascimento'),
                                        TextInput::make('inscricao_municipal')
                                            ->label('E-mail')
                                            ->placeholder('E-mail do responsável')
                                            ->maxLength(255),
                                        TextInput::make('inscricao_municipal')
                                            ->label('Telefone')
                                            ->placeholder('(xx) xxxxx-xxxx')
                                            ->maxLength(255),
                                        TextInput::make('inscricao_municipal')
                                            ->label('Senha')
                                            ->placeholder('Senha do responsável')
                                            ->maxLength(255),
                                        Toggle::make('em_implantacao')
                                            ->label('Autoriza o envio de e-mails')
                                            ->inline(false),
                                        Toggle::make('em_implantacao')
                                            ->label('Não faz parte do contrato social')
                                            ->inline(false),
                                    ])->columns(4),
                            ])->columns(),
                        Tabs\Tab::make('Contatos')
                            ->schema([
                                Repeater::make('contatosPessoasCliente')
                                    ->label('Contatos')
                                    ->schema([
                                        Select::make('tipo_contato_pessoa_cliente_id')
                                            ->label('Tipo')
                                            ->options(TipoContatoPessoaCliente::all()->pluck('nome', 'id'))
                                            ->searchable(),
                                        TextInput::make('nome')
                                            ->label('Nome'),
                                        TextInput::make('telefone')
                                            ->label('Telefone'),
                                        TextInput::make('email')
                                            ->label('E-mail'),
                                    ])
                                    ->columns(4)
                            ]),
                        Tabs\Tab::make('Acesso/Endereço')
                            ->schema([
                                Fieldset::make('Acesso')
                                    ->schema([
                                        TextInput::make('email')
                                            ->label('Usuário de acesso'),
                                        TextInput::make('senha')
                                            ->label('Senha de acesso'),
                                    ]),
                                Fieldset::make('Endereço')
                                    ->schema([
                                        TextInput::make('cep')
                                            ->label('CEP'),
                                        TextInput::make('end')
                                            ->label('Logradouro'),
                                        TextInput::make('numero')
                                            ->label('Número'),
                                        TextInput::make('complemento')
                                            ->label('Complemento'),
                                        TextInput::make('bairro')
                                            ->label('Bairro'),
                                        TextInput::make('cidade')
                                            ->label('Cidade'),
                                        TextInput::make('uf')
                                            ->label('UF'),
                                    ]),
                                Fieldset::make('Telefones')
                                    ->schema([
                                        TextInput::make('ddd')
                                        ->label('DDD'),
                                        TextInput::make('telefone')
                                            ->label('Telefone Residencial'),
                                        TextInput::make('telefone2')
                                            ->label('Celular'),
                                    ])
                            ])->columns(2),
                        Tabs\Tab::make('Dados Bancários')
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
                                            ->label('Dv'),
                                        TextInput::make('conta')
                                            ->label('Conta'),
                                        TextInput::make('contadv')
                                            ->label('Dv'),
                                    ])->columns(4),
                                Fieldset::make('Pago')
                                    ->schema([
                                        TextInput::make('cod_pago')
                                            ->label('Cód. Pago'),
                                        TextInput::make('senha_pago')
                                            ->label('Senha Pago'),
                                    ])->columns(2)
                            ]),
                        Tabs\Tab::make('Redes Sociais')
                            ->schema([
                                Repeater::make('redesSociaisClientes')
                                    ->label('Rede social')
                                    ->schema([
                                        Select::make('redesocial')
                                            ->label('Rede Social')
                                            ->options([])
                                            ->searchable(),
                                        TextInput::make('nomeredesocial')
                                            ->label('Usuario'),
                                    ])
                                    ->columns(2)
                            ]),
                        Tabs\Tab::make('Outras Informações')
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
                                FileUpload::make('contrato')
                                    ->label('Contrato'),
                                Fieldset::make('Atualizações')
                                    ->schema([
                                        TextInput::make('versao')
                                        ->label('Versão')
                                        ->placeholder('Versão') 
                                    ])->columns(1),
                            ]),
                    ])
            ])->columns(1);
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
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListClientes::route('/'),
            'create' => Pages\CreateCliente::route('/create'),
            'view' => Pages\ViewCliente::route('/{record}'),
            'edit' => Pages\EditCliente::route('/{record}/edit'),
        ];
    }
}
