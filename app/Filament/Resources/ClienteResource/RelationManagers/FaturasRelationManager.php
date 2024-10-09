<?php

namespace App\Filament\Resources\ClienteResource\RelationManagers;

use App\Models\Cliente\Fatura\Enum\FormaPagamento;
use App\Models\Cliente\Fatura\Enum\StatusFaturaCliente;
use App\Models\Cliente\Fatura\FaturaCliente;
use App\Models\Cliente\Servico\Enum\PeriodicidadeServico;
use App\Models\Cliente\Servico\ServicoCliente;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;
use Parallax\FilamentComments\Tables\Actions\CommentsAction;
use Filament\Tables\Actions\ActionGroup;

class FaturasRelationManager extends RelationManager
{
    public const ID_SERVICO_PRINCIPAL = 1;

    protected static string $relationship = 'faturas';
    
    protected int $quantidadeTotalServicosPeriodicidade = 0;
    protected int $quantidadeTotalServicosSelecionados = 0;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Dados da Fatura')
                    ->schema([
                        DatePicker::make('vencimento')
                            ->required()
                            ->afterOrEqual('today')
                            ->label('Vencimento'),
                        TextInput::make('valor')
                            ->required()
                            ->label('Valor')
                            ->numeric()
                            ->prefix('R$'),
                        Select::make('periodicidade')
                            // ->relationship('servicos', 'periodicidade', function ($query) {
                            //     return $query->select('serv_cliente.id', 'serv_cliente.periodicidade');
                            // })
                            ->disabled(! empty($this->mountedTableActionRecord) && $this->mountedTableActionRecord > 0)
                            ->required()
                            ->label('Periodicidade')
                            ->options(collect(PeriodicidadeServico::cases())->mapWithKeys(fn($periodicidade) => [$periodicidade->value => $periodicidade->label()]))
                            ->preload()
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(fn($state, callable $set, callable $get) => $this->alterarPeriodicidade($state, $set, $get)),
                        Select::make('servicos')
                            // ->relationship('servicos', 'nome', function ($query) {
                            //         return $query->join('lista_servico AS ls', 'serv_cliente.id_servico', '=', 'ls.id')
                            //                     ->select('serv_cliente.id', 'ls.nome');
                            // })
                            ->required()
                            ->disabled(! empty($this->mountedTableActionRecord) && $this->mountedTableActionRecord > 0)
                            ->multiple()
                            ->label('Serviços Referência')
                            ->options(fn($get) => $this->getServicosOptions($get('periodicidade'), $get))
                            ->preload()
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(fn($state, callable $set, callable $get) => $this->somaEVerificaServico($state, $set, $get)),
                        TextInput::make('qtd')
                            ->label('Quantidade Parcelas')
                            ->readOnly()
                            ->numeric(),
                        TextInput::make('info_add')
                            ->label('Informações Adicionais'),
                        Select::make('formapagamento')
                            ->required()
                            ->label('Forma de Pagamento')
                            ->options(collect(FormaPagamento::cases())->mapWithKeys(fn($formaPagamento) => [$formaPagamento->value => $formaPagamento->label()]))
                            ->preload()
                            ->reactive()
                            ->searchable(),
                    ]),
                Fieldset::make('Cartão de Crédito - Gateway BitPag (não armazenados localmente).')
                    ->schema([
                        TextInput::make('tempCreditoNumber')
                            ->label('Número do cartão')
                            ->mask('9999 9999 9999 9999')
                            ->placeholder('XXXX-XXXX-XXXX-XXXX'),
                        TextInput::make('tempCreditoCvv')
                            ->label('CVV')
                            ->numeric()
                            ->mask('999')
                            ->placeholder('XXX'),
                        TextInput::make('tempCreditoDataExp')
                            ->label('Data exp.')
                            ->mask('99/99')
                            ->placeholder('XX/XX'),
                        TextInput::make('tempCreditoNomeImpresso')
                            ->label('Nome impresso')
                            ->placeholder('Nome como está no cartão'),
                    ])->visible(fn($get) => $get('formapagamento') == 'Cartão de crédito'),
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
                    ->label('Observação Interna'),
                TextInput::make('url_checkout')
                    ->label('URL'),
                Toggle::make('gerar_serial')
                    ->label('Gerar Serial?')
                    ->inline(false),
            ]);
    }

    protected function somaEVerificaServico($ids, callable $set, callable $get)
    {
        $somaServicos = 0;
        $servicos = ServicoCliente::whereIn('id', $ids)->get();

        foreach ($servicos as $servico) {
            $somaServicos += $servico->valor;
        }

        $set('valor', round($somaServicos, 2));

        if (count($ids) > 1 && $servicos[0]->id_servico != self::ID_SERVICO_PRINCIPAL) {
            $set('servicos', [$ids[0]]);
            $this->getServicosOptions($get('periodicidade'), $get);
            $this->somaEVerificaServico([$ids[0]], $set, $get);
        }
    }

    protected function alterarPeriodicidade($periodicidade, callable $set, callable $get)
    {
        $set('servicos', []);
        $set('valor', '');

        if ($periodicidade != 0) {
            $set('qtd', PeriodicidadeServico::from($periodicidade)->qtdParcelas());
            $this->getServicosOptions($periodicidade, $get);
        }
    }

    protected function getServicosOptions($periodicidade, $get)
    {
        if (! $periodicidade) {
            return [];
        }

        $servicos = ServicoCliente::with('servicoCliente')
            ->where('periodicidade', $periodicidade)
            ->where('id_cliente', $this->ownerRecord->id)
            ->get()
            ->toArray();

        $this->quantidadeTotalServicosPeriodicidade = count($servicos);
        $this->quantidadeTotalServicosSelecionados = count($get('servicos'));

        if ($this->quantidadeTotalServicosSelecionados > 0 && 
            $this->quantidadeTotalServicosSelecionados < $this->quantidadeTotalServicosPeriodicidade) {
            $this->geraNotificacaoServicosIncompletos();
        }

        return array_reduce($servicos, function ($carry, $item) {
            $carry[$item['id']] = $item['servico_cliente']['nome'];
            return $carry;
        }, []);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('vencimento')
            ->defaultSort('vencimento', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('vencimento')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Vencimento')
                    ->dateTime('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('vencimento_boleto')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Vencimento Boleto')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('referencia')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Referência'),
                TextColumn::make('valor')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Valor')
                    ->prefix('R$'),
                TextColumn::make('valor_atualizado')
                    ->label('Valor Atualizado')
                    ->size(TextColumnSize::ExtraSmall)
                    ->prefix('R$')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('valor_pago')
                    ->size(TextColumnSize::ExtraSmall)
                    ->prefix('R$')
                    ->label('Valor Pago'),
                Tables\Columns\TextColumn::make('status')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Status')
                    ->formatStateUsing(function (string $state): string {
                        return StatusFaturaCliente::tryFrom($state)?->label() ?? $state;
                    })
                    ->badge()
                    ->color(function (string $state): string {
                        return StatusFaturaCliente::tryFrom($state)?->color() ?? 'secondary';
                    }),
                Tables\Columns\TextColumn::make('serial')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Serial')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('formapagamento')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Forma pagamento'),
                Tables\Columns\TextColumn::make('gerar_boleto')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Gerar')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('url_checkout')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Url Checkout')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('cobranca_bitpag_id')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Link BitPag')
                    ->formatStateUsing(fn($state) => sprintf(
                        '<a href="https://empresa.sandbox.splitpag.com.br/charge/list-charges-recurrence/%s" target="_blank">Abrir Link</a>',
                        $state
                    ))
                    ->html(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->slideOver()
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make()->slideOver(),
                    CommentsAction::make(),
                    Action::make('quitarFatura')
                        ->requiresConfirmation()
                        ->hidden(fn(FaturaCliente $record) => $record->formapagamento !== 'Dinheiro')
                        ->action(function (FaturaCliente $record) {
                            $record->valor_pago = $record->valor_atualizado ?? $record->valor;
                            $record->status = StatusFaturaCliente::APROVADO;
                            $record->save();
                            Notification::make()->success()->title('Fatura quitada com sucesso!')->icon('heroicon-o-currency-dollar')->send();
                        })
                        ->icon('heroicon-o-currency-dollar'),
                ]),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public function geraNotificacaoServicosIncompletos()
    {
        $qtd = ($this->quantidadeTotalServicosPeriodicidade - $this->quantidadeTotalServicosSelecionados);
        $disp = 'disponíveis';
        $serv = 'serviços';

        if ($qtd == 1) {
            $disp = 'disponível';
            $serv = 'serviço';
        }

        Notification::make()->info()->title("Ainda há {$qtd} {$serv} referência {$disp} para essa periodicidade.")->icon('heroicon-o-exclamation-circle')->send();
    }
}
