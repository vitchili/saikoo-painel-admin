<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropostaClienteResource\Pages;
use App\Filament\Resources\PropostaClienteResource\RelationManagers;
use App\Models\Cliente\Cliente;
use App\Models\Cliente\Proposta\Enum\CidadeProposta;
use App\Models\Cliente\Proposta\Enum\TipoDescontoProposta;
use App\Models\Cliente\Proposta\Enum\TipoRecorrenciaCobrancaProposta;
use App\Models\Cliente\Proposta\PropostaCliente;
use App\Models\Cliente\Servico\TipoServicoCliente;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PropostaClienteResource extends Resource
{
    protected static ?string $model = PropostaCliente::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?string $navigationLabel = 'Propostas';

    protected static ?string $slug = 'propostas';

    protected static ?string $modelLabel = 'Propostas';

    protected static ?string $navigationGroup = 'Principal';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('')
                    ->schema([
                        Tab::make('Proposta Comercial')
                            ->schema([
                                Fieldset::make('Cadastro')
                                    ->schema([
                                        Select::make('cliente_id')
                                            ->options(Cliente::all()->pluck('nome', 'id'))
                                            ->preload()
                                            ->required()
                                            ->searchable()
                                            ->label('Cliente'),
                                        Select::make('responsavel_id')
                                            ->options(User::all()->pluck('name', 'id'))
                                            ->preload()
                                            ->searchable()
                                            ->required()
                                            ->label('Responsável'),
                                        Select::make('cidade_id')
                                            ->label('Cidade')
                                            ->options(collect(CidadeProposta::cases())->mapWithKeys(fn($cidade) => [$cidade->value => $cidade->label()]))
                                            ->searchable(),
                                    ])
                                    ->columns(3),
                                Fieldset::make('Parametrização de Valores e Descontos')
                                    ->schema([
                                        Repeater::make('valoresEDescontosProposta')
                                            ->label('')
                                            ->relationship('valoresEDescontosProposta')
                                            ->schema([
                                                TextInput::make('descricao')
                                                    ->label('Descrição')
                                                    ->required()
                                                    ->columnSpan(2),
                                                Select::make('tipo_recorrencia_cobranca_id')
                                                    ->label('Tipo Recorrência Cobrança')
                                                    ->required()
                                                    ->options(collect(TipoRecorrenciaCobrancaProposta::cases())->mapWithKeys(fn($tipo) => [$tipo->value => $tipo->label()]))
                                                    ->searchable(),
                                                TextInput::make('qtd_profissionais')
                                                    ->label('Qtd Prof.')
                                                    ->numeric()
                                                    ->required(),
                                                TextInput::make('valor')
                                                    ->label('Valor')
                                                    ->numeric()
                                                    ->prefix('R$')
                                                    ->required(),
                                                Select::make('tipo_desconto_id')
                                                    ->label('Tipo Desconto')
                                                    ->required()
                                                    ->options(collect(TipoDescontoProposta::cases())->mapWithKeys(fn($tipo) => [$tipo->value => $tipo->label()]))
                                                    ->searchable(),
                                                TextInput::make('valor_desconto')
                                                    ->numeric()
                                                    ->label('Valor Desconto')
                                                    ->prefix('R$'),
                                            ])->columns(4),
                                    ])->columns(1),
                                RichEditor::make('info')
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
                                    ->label('Info')
                                    ->default('
                                    <b>Formas de Pagamento:</b>
                                    <br/>
                                    À vista: 5% de Desconto.
                                    <br/>
                                    À prazo: Entrada + 03 vezes no cheque ou cartão de crédito.
                                    <br/>
                                    As mensalidades são pré-pagas.
                                    <br/>
                                    O investimento na implantação e parametrização são 20 horas de treinamento.
                                    '),
                            ])->columns(1),
                        Tab::make('Itens')
                            ->schema([
                                Fieldset::make('Apresentar')
                                    ->schema([
                                        Checkbox::make('apresentacao_info_opcionais')
                                            ->label('Apresentar - Infos Opcionais'),
                                        Checkbox::make('apresentacao_split_pagamento')
                                            ->label('Apresentar - Saikoo - Split de Pagamento (Mensal)'),
                                        Checkbox::make('apresentacao_sms_mensal')
                                            ->label('Apresentar - Saikoo - SMS (Mensal)'),
                                        Checkbox::make('apresentacao_saikoo_mobile')
                                            ->label('Apresentar - Saikoo Mobile - Tablets e Smartphones (Mensal)'),
                                        Checkbox::make('apresentacao_modulos_fiscais')
                                            ->label('Apresentar - Módulos Fiscais: NFC-e / NFS-e / NF-e (Mensal)'),
                                        Checkbox::make('apresentacao_agenda_online')
                                            ->label('Apresentar - Agenda Online (Mensal)'),
                                        Checkbox::make('apresentacao_cartao_comanda')
                                            ->label('Apresentar - Cartão de Comanda'),
                                        Checkbox::make('apresentacao_microterminal_comanda')
                                            ->label('Apresentar - Microterminal de Comanda'),
                                        Checkbox::make('apresentacao_terminal_comanda_touch_screen')
                                            ->label('Apresentar - Terminal de Comanda - TouchScreen'),
                                        Checkbox::make('apresentacao_terminal_comanda_tablet')
                                            ->label('Apresentar - Terminal de Comanda - Tablet'),
                                        Checkbox::make('apresentacao_requisitos_minimos_instalacao')
                                            ->label('Apresentar - Requisitos Mínimos Instalação Sistema Saikoo'),
                                    ]),
                            ]),
                        Tab::make('Serviços')
                            ->schema([
                                Repeater::make('Adicionar Serviços')
                                    ->relationship('servicosPropostaCliente')
                                    ->schema([
                                        Select::make('servico_id')
                                            ->options(TipoServicoCliente::all()->pluck('nome', 'id'))
                                            ->preload()
                                            ->required()
                                            ->searchable()
                                            ->label('Serviço')
                                            ->columnSpan(2),
                                        TextInput::make('qtd')
                                            ->label('Quantidade')
                                            ->numeric()
                                            ->required(),
                                        TextInput::make('valor')
                                            ->label('Valor')
                                            ->numeric()
                                            ->prefix('R$')
                                            ->required(),
                                        Toggle::make('calc_por_qtd')
                                            ->label('Calc. por Qtd.')
                                            ->inline(false)
                                            ->reactive(),
                                        Toggle::make('cobrar_instalacao')
                                            ->label('Cobrar Instalação')
                                            ->inline(false)
                                            ->reactive(),
                                    ])->columns(6),
                            ]),

                    ])->columns(1),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('cliente.nome')
                    ->label('Cliente')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(function ($state) {
                        return \Illuminate\Support\Str::limit(strip_tags($state), 200);
                    })
                    ->wrap()
                    ->size(TextColumnSize::ExtraSmall),
                TextColumn::make('responsavel.name')
                    ->label('Responsável')
                    ->sortable()
                    ->searchable()
                    ->size(TextColumnSize::ExtraSmall),

                TextColumn::make('info')
                    ->label('Informações')
                    ->html()
                    ->html(fn($state) => $state)
                    ->formatStateUsing(function ($state) {
                        return \Illuminate\Support\Str::limit(strip_tags($state), 200);
                    })
                    ->wrap()
                    ->size(TextColumnSize::ExtraSmall),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
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
            'index' => Pages\ListPropostaClientes::route('/'),
            'create' => Pages\CreatePropostaCliente::route('/create'),
            'edit' => Pages\EditPropostaCliente::route('/{record}/edit'),
        ];
    }
}
