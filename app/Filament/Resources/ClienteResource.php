<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClienteResource\FormImplantacao\FormImplantacaoCliente;
use App\Filament\Resources\ClienteResource\Pages;
use App\Filament\Resources\ClienteResource\RelationManagers\ContatosComClienteRelationManager;
use App\Filament\Resources\ClienteResource\RelationManagers\FaturasRelationManager;
use App\Filament\Resources\ClienteResource\RelationManagers\HistoricoNumeroProfissionaisRelationManager;
use App\Filament\Resources\ClienteResource\RelationManagers\HistoricoObservacoesRelationManager;
use App\Filament\Resources\ClienteResource\RelationManagers\ParceirosRelationManager;
use App\Filament\Resources\ClienteResource\RelationManagers\SeriaisRelationManager;
use App\Filament\Resources\ClienteResource\RelationManagers\ServicosClienteRelationManager;
use App\Filament\Resources\ClienteResource\RelationManagers\TicketsDesenvolvimentoRelationManager;
use App\Models\Banco;
use App\Models\Cliente\Cliente;
use App\Models\Cliente\Contato\Enum\Estado;
use App\Models\Cliente\TipoCliente;
use App\Models\Cliente\TipoContatoPessoaCliente;
use App\Models\Cliente\TipoRedeSocialCliente;
use App\Models\Representante;
use App\Models\User;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\Actions\Action;
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
use Filament\Infolists\Components\Tabs as ComponentsTabs;
use Filament\Infolists\Components\Tabs\Tab as TabsTab;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class ClienteResource extends Resource
{
    protected static ?string $model = Cliente::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

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
                                        ->options(Representante::all()->pluck('nome', 'id'))
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
                                        ->unique(ignoreRecord: true)
                                        ->readOnly()
                                        ->hidden(fn (mixed $livewire) => empty($livewire->data['tornar_cliente']) || $livewire->data['tornar_cliente'] != 'S')
                                        ->maxLength(255),
                                    TextInput::make('cpf_cnpj')
                                        ->label('CNPJ')
                                        ->mask(RawJs::make(<<<'JS'
                                        $input.length > 14 ? '99.999.999/9999-99' : '999.999.999-99'
                                    JS))
                                        ->rule('cpf_ou_cnpj')
                                        ->suffixAction(
                                            fn ($state, $livewire, $set) => Action::make('search-action')
                                                ->icon('heroicon-o-rectangle-stack')
                                                ->action(function () use ($state, $livewire, $set) {
                                                    $livewire->validateOnly('data.cpf_ou_cnpj');
                                                    $state = preg_replace('/[^0-9]/', '', $state);

                                                    $cnpjData = Http::get(
                                                        "https://brasilapi.com.br/api/cnpj/v1/{$state}"
                                                    )->json();

                                                    if (!empty($cnpjData['message'])) {
                                                        throw ValidationException::withMessages([
                                                            'data.cpf_ou_cnpj' => $cnpjData['message']
                                                        ]);
                                                    }

                                                    $set('nome', $cnpjData['razao_social'] ?? null);
                                                    $set('nomefantasia', $cnpjData['nome_fantasia'] ?? null);
                                                    $set('telefone', $cnpjData['ddd_telefone_1'] ?? null);
                                                    $set('telefone2', $cnpjData['ddd_telefone_2'] ?? null);
                                                    $set('responsavel', $cnpjData['qsa'][0]['nome_socio'] ?? null);
                                                    $set('fone_resp1', $cnpjData['ddd_telefone_1'] ?? null);
                                                    $set('responsavel2', $cnpjData['qsa'][1]['nome_socio'] ?? null);
                                                    $set('fone_resp2', $cnpjData['ddd_telefone_2'] ?? null);
                                                })
                                        ),




                                    TextInput::make('nome')
                                        ->label('Razão Social')
                                        ->required()
                                        ->maxLength(255),
                                    TextInput::make('nomefantasia')
                                        ->label('Fantasia')
                                        ->maxLength(255),
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
                                                ->required()
                                                ->mask('99999-999')
                                                ->suffixAction(
                                                    fn ($state, $livewire, $set) => Action::make('search-action')
                                                        ->icon('heroicon-o-rectangle-stack')
                                                        ->action(function () use ($state, $livewire, $set) {
                                                            $livewire->validateOnly('data.cep');

                                                            $cepData = Http::get(
                                                                "https://viacep.com.br/ws/{$state}/json"
                                                            )->throw()->json();

                                                            if (in_array('erro', $cepData)) {
                                                                throw ValidationException::withMessages([
                                                                    'data.cep' => 'Erro ao buscar CEP'
                                                                ]);
                                                            }

                                                            $set('end', $cepData['logradouro'] ?? null);
                                                            $set('cidade', $cepData['localidade'] ?? null);
                                                            $set('uf', $cepData['uf'] ?? null);
                                                            $set('bairro', $cepData['bairro'] ?? null);
                                                        })
                                                ),
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
                                            Select::make('uf')
                                                ->label('UF')
                                                ->options(collect(Estado::cases())->mapWithKeys(fn ($situacao) => [$situacao->value => $situacao->label()]))
                                                ->searchable(),
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
                                                ->options(Banco::all()->pluck('nome', 'id'))
                                                ->preload()
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
                                        ->label('Logotipo')
                                        ->image()
                                        ->directory('logos_clientes'),
                                    \Njxqlus\Filament\Components\Forms\RelationManager::make()
                                        ->manager(HistoricoObservacoesRelationManager::class)
                                        ->lazy(true)
                                        ->hidden(fn (mixed $livewire) => empty($livewire->data['tornar_cliente']) || $livewire->data['tornar_cliente'] != 'S')
                                ]),
                        ]),
                    ]),
                    Tab::make('Faturas')->schema([
                        \Njxqlus\Filament\Components\Forms\RelationManager::make()->manager(FaturasRelationManager::class)
                            ->lazy(true)
                    ])->hidden(fn (mixed $livewire) => empty($livewire->data['tornar_cliente']) || $livewire->data['tornar_cliente'] != 'S'),
                    Tab::make('Seriais')->schema([
                        \Njxqlus\Filament\Components\Forms\RelationManager::make()->manager(SeriaisRelationManager::class)
                            ->lazy(true)
                    ])->hidden(fn (mixed $livewire) => empty($livewire->data['tornar_cliente']) || $livewire->data['tornar_cliente'] != 'S'),
                    Tab::make('Serviços')->schema([
                        \Njxqlus\Filament\Components\Forms\RelationManager::make()->manager(ServicosClienteRelationManager::class)
                            ->lazy(true)
                    ])->hidden(fn (mixed $livewire) => empty($livewire->data['tornar_cliente']) || $livewire->data['tornar_cliente'] != 'S'),
                    Tab::make('Nº Profissionais')->schema([
                        \Njxqlus\Filament\Components\Forms\RelationManager::make()->manager(HistoricoNumeroProfissionaisRelationManager::class)
                            ->lazy(true)
                    ])->hidden(fn (mixed $livewire) => empty($livewire->data['tornar_cliente']) || $livewire->data['tornar_cliente'] != 'S'),
                    Tab::make('Saikoo Web')->schema([
                        Fieldset::make('Saikoo Web')
                            ->relationship('conexaoSaikooWeb')
                            ->schema([
                                TextInput::make('url_app')
                                    ->label('URL do App')
                                    ->nullable(),
                                TextInput::make('url')
                                    ->label('URL')
                                    ->nullable(),
                                TextInput::make('host')
                                    ->label('Host')
                                    ->nullable(),
                                TextInput::make('usuario')
                                    ->label('Usuário')
                                    ->nullable(),
                                TextInput::make('senha')
                                    ->label('Senha')
                                    ->password()
                                    ->nullable(),
                                TextInput::make('bd')
                                    ->label('Banco de Dados')
                                    ->nullable(),
                                Toggle::make('status')
                                    ->label('Status')
                                    ->nullable()
                                    ->default(1),
                            ])
                            ->columns(3)
                    ])->hidden(fn (mixed $livewire) => empty($livewire->data['tornar_cliente']) || $livewire->data['tornar_cliente'] != 'S'),
                    Tab::make('Contatos com cliente')->schema([
                        \Njxqlus\Filament\Components\Forms\RelationManager::make()->manager(ContatosComClienteRelationManager::class)
                            ->lazy(true)
                    ])->hidden(fn (mixed $livewire) => $livewire instanceof CreateRecord),
                    Tab::make('Implantação')->schema(
                        FormImplantacaoCliente::getForm()
                    )->hidden(fn (mixed $livewire) => empty($livewire->data['tornar_cliente']) || $livewire->data['tornar_cliente'] != 'S'),
                    Tab::make('Parceiros')->schema([
                        \Njxqlus\Filament\Components\Forms\RelationManager::make()->manager(ParceirosRelationManager::class)
                            ->lazy(true)
                    ])->hidden(fn (mixed $livewire) => empty($livewire->data['tornar_cliente']) || $livewire->data['tornar_cliente'] != 'S'),
                    Tab::make('Tickets Desenv.')->schema([
                        \Njxqlus\Filament\Components\Forms\RelationManager::make()->manager(TicketsDesenvolvimentoRelationManager::class)
                            ->lazy(true)
                    ])->hidden(fn (mixed $livewire) => empty($livewire->data['tornar_cliente']) || $livewire->data['tornar_cliente'] != 'S'),
                    
                ]),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->label('Logo')
                    ->circular()
                    ->height(40),
                Tables\Columns\TextColumn::make('codigo')
                    ->label('Código')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nome')
                    ->label('Razão')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('nomefantasia')
                    ->label('Fantasia')
                    ->limit(30)
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('bairro')
                    ->label('Bairro')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cidade')
                    ->label('Cidade')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('status')
                    ->label('Ativo'),
            ])
            ->filters([
                Filter::make('status')
                    ->query(fn (Builder $query): Builder => $query->where('status', 'A'))
                    ->label('Apenas ativos'),
                Filter::make('em_implantacao')
                    ->query(fn (Builder $query): Builder => $query->where('em_implantacao', true)),
                Filter::make('dynamic_filters')
                    ->form([
                        Repeater::make('filters')
                            ->schema([
                                Select::make('field')
                                    ->options([
                                        'codigo' => 'Código',
                                        'nome' => 'Razão',
                                        'nomefantasia' => 'Fantasia',
                                        'bairro' => 'Bairro',
                                        'cidade' => 'Cidade',
                                        'uf' => 'UF',
                                    ])
                                    ->label('Campo')
                                    ->required(),
                                Select::make('condition')
                                    ->options([
                                        'equals' => 'Igual',
                                        'not_equals' => 'Diferente',
                                        'contains' => 'Contém',
                                        'starts_with' => 'Começa com',
                                        'ends_with' => 'Termina com',
                                        'greater_than' => 'Maior que',
                                        'less_than' => 'Menor que',
                                    ])
                                    ->label('Condição')
                                    ->required(),
                                TextInput::make('value')
                                    ->label('Valor')
                                    ->required(),
                            ])
                            ->label('Filtros')
                    ])
                    ->query(function (Builder $query, array $data) {
                        foreach ($data['filters'] as $filter) {
                            $field = $filter['field'];
                            $condition = $filter['condition'];
                            $value = $filter['value'];

                            switch ($condition) {
                                case 'equals':
                                    $query->where($field, '=', $value);
                                    break;
                                case 'not_equals':
                                    $query->where($field, '!=', $value);
                                    break;
                                case 'contains':
                                    $query->where($field, 'like', '%' . $value . '%');
                                    break;
                                case 'starts_with':
                                    $query->where($field, 'like', $value . '%');
                                    break;
                                case 'ends_with':
                                    $query->where($field, 'like', '%' . $value);
                                    break;
                                case 'greater_than':
                                    $query->where($field, '>', $value);
                                    break;
                                case 'less_than':
                                    $query->where($field, '<', $value);
                                    break;
                            }
                        }
                    }),
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
