<?php

namespace App\Filament\Resources\ClienteResource\RelationManagers;

use App\Gateway\Bitpag\CobrancaBitpag;
use App\Models\Cliente\Fatura\Enum\FormaPagamento;
use App\Models\Cliente\Fatura\Enum\StatusFaturaCliente;
use App\Models\Cliente\Fatura\FaturaCliente;
use App\Models\Cliente\Serial\SerialCliente;
use App\Models\Cliente\Servico\Enum\PeriodicidadeServico;
use App\Models\Cliente\Servico\ServicoCliente;
use Carbon\Carbon;
use Closure;
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
                            ->required(empty($this->mountedTableActionRecord))
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
                            ->disabled(! empty($this->mountedTableActionRecord) && $this->mountedTableActionRecord > 0)
                            ->required(empty($this->mountedTableActionRecord))
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
                    ->inline(false)
                    ->default(true),
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

        if (
            $this->quantidadeTotalServicosSelecionados > 0 &&
            $this->quantidadeTotalServicosSelecionados < $this->quantidadeTotalServicosPeriodicidade
        ) {
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
                    ->label('Venc.')
                    ->dateTime('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('vencimento_boleto')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Venc. Boleto')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('referencia')
                    ->size(TextColumnSize::ExtraSmall)
                    ->limit(25)
                    ->label('Referência'),
                TextColumn::make('valor')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Valor')
                    ->prefix('R$'),
                TextColumn::make('valor_atualizado')
                    ->label('Valor Att.')
                    ->size(TextColumnSize::ExtraSmall)
                    ->prefix('R$'),
                TextColumn::make('valor_pago')
                    ->size(TextColumnSize::ExtraSmall)
                    ->prefix('R$')
                    ->label('Valor Pago'),
                TextColumn::make('info_add')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Info Add.')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->size(TextColumnSize::ExtraSmall)
                    ->sortable()
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
                    ->sortable()
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
                        '<a href="https://empresa.sandbox.splitpag.com.br/charge/show/%s" target="_blank">Abrir Link</a>',
                        $state
                    ))
                    ->html()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->slideOver()
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->slideOver()
                        ->hidden(fn(FaturaCliente $record) => $record->status == StatusFaturaCliente::CANCELADO->value),
                    CommentsAction::make(),
                    Action::make('gerarBoleto')
                        ->label('Gerar Boleto Atualizado')
                        ->form([
                            DatePicker::make('vencimento_boleto')
                            ->label('Venc. Boleto')
                            ->after('today')
                            ->hidden(fn(FaturaCliente $record) => Carbon::parse($record->vencimento)->diffInDays(now()) <= 0)
                        ])
                        ->hidden(fn(FaturaCliente $record) => 
                            $record->status == StatusFaturaCliente::APROVADO->value && 
                            ! empty($record->valor_pago) && 
                            $record->formapagamento !== 'Boleto'
                        )
                            
                        ->requiresConfirmation()
                        ->action(function (array $data, FaturaCliente $faturaCliente) {
                            $bitPagCobranca = new CobrancaBitpag();
                            $bitPagCobranca->cadastrarCobranca($faturaCliente);

                            if (Carbon::parse($faturaCliente->vencimento)->lt(now())) {
                                $serial = new SerialCliente();
                                $serial->id_cliente = $faturaCliente->id_cliente;
                                $serial->vencimento_serial = now()->addDays(2);
                                $serial->save();

                                $faturaCliente->vencimento_boleto = $data['vencimento_boleto'];
                                $faturaCliente->gerar_serial = false;
                                $faturaCliente->update([
                                    'serial' => $serial->serial
                                ]);
                            }

                            Notification::make()->success()->title('Boleto gerado com suesso.')->icon('heroicon-o-currency-dollar')->send();
                        })
                        ->icon('heroicon-o-currency-dollar'),
                    Action::make('boletoGerado')
                        ->icon('heroicon-o-eye')
                        ->label('Ver Boleto Atual')
                        ->hidden(fn(FaturaCliente $record) => $record->status == StatusFaturaCliente::CANCELADO->value || $record->formapagamento !== 'Boleto' || ($record->formapagamento == 'Boleto' && empty($record->cobranca_bitpag_id)))
                        ->url(fn(FaturaCliente $record) => $record->url_boleto)
                        ->openUrlInNewTab(),
                    Action::make('gerenciarJurosMulta')
                        ->label('Gerenciar Juros e Multa')
                        ->hidden(fn(FaturaCliente $record) => $record->status == StatusFaturaCliente::CANCELADO->value || $record->formapagamento == 'Cartão de crédito')
                        ->requiresConfirmation()
                        ->form([
                            TextInput::make('valor_original')
                                ->disabled()
                                ->default(function (FaturaCliente $record): float {
                                    return $record->valor;
                                })
                                ->label('Valor')
                                ->numeric()
                                ->prefix('R$'),
                            Fieldset::make()->schema([
                                TextInput::make('juros_atraso')
                                    ->label('Juros')
                                    ->default(function (FaturaCliente $record): float {
                                        return $record->juros_atraso ?? 0;
                                    })
                                    ->numeric()
                                    ->minValue(0)
                                    ->reactive()
                                    ->suffix('%')
                                    ->afterStateUpdated(function ($get, $set, $state) {
                                        $juros = (float) $state ?? 0;
                                        $multa = (float) $get('multa_atraso') ?? 0;
                                        $valorOriginal = $get('valor_original') ?? 0;
                                        $diasAtraso = $get('dias_atraso') ?? 0;

                                        $valorJuros = $valorOriginal * ($juros / 100);
                                        $valorMulta = $valorOriginal * ($multa / 100);

                                        $valorAtualizado = $valorOriginal + $valorJuros * ($diasAtraso / 30) + $valorMulta;

                                        if ($diasAtraso > 0) {
                                            $set('valor_atualizado', (float) number_format($valorAtualizado, 2));
                                        }
                                    }),
                                TextInput::make('multa_atraso')
                                    ->label('Multa')
                                    ->default(function (FaturaCliente $record): float {
                                        return $record->multa_atraso ?? 0;
                                    })
                                    ->numeric()
                                    ->minValue(0)
                                    ->reactive()
                                    ->suffix('%')
                                    ->afterStateUpdated(function ($get, $set, $state) {
                                        $multa = (float) $state ?? 0;
                                        $juros = (float) $get('juros_atraso') ?? 0;
                                        $valorOriginal = $get('valor_original') ?? 0;
                                        $diasAtraso = $get('dias_atraso') ?? 0;

                                        $valorJuros = $valorOriginal * ($juros / 100);
                                        $valorMulta = $valorOriginal * ($multa / 100);

                                        $valorAtualizado = $valorOriginal + $valorJuros * ($diasAtraso / 30) + $valorMulta;

                                        if ($diasAtraso > 0) {
                                            $set('valor_atualizado', (float) number_format($valorAtualizado, 2));
                                        }
                                    }),
                                TextInput::make('dias_atraso')
                                    ->disabled()
                                    ->default(function (FaturaCliente $record): int|string {
                                        $dataInformada = \Carbon\Carbon::createFromFormat('Y-m-d', $record->vencimento);
                                        $hoje = \Carbon\Carbon::now();

                                        return $dataInformada->diffInDays($hoje) > 0 ? $dataInformada->diffInDays($hoje) : 0;
                                    })
                                    ->label('Dias em atraso'),
                            ])->columns(3),
                            TextInput::make('valor_atualizado')
                                ->readOnly()
                                ->reactive()
                                ->default(function (FaturaCliente $record): float {
                                    return $record->valor_atualizado ?? $record->valor;
                                })
                                ->label('Valor Atualizado')
                                ->numeric()
                                ->prefix('R$')
                                ->afterStateHydrated(function ($get, $set, $state) {
                                    $multa = (float) $get('multa_atraso') ?? 0;
                                    $juros = (float) $get('juros_atraso') ?? 0;
                                    $valorOriginal = $get('valor_original') ?? 0;
                                    $diasAtraso = $get('dias_atraso') ?? 0;

                                    $valorJuros = $valorOriginal * ($juros / 100);
                                    $valorMulta = $valorOriginal * ($multa / 100);

                                    $valorAtualizado = $valorOriginal + $valorJuros * ($diasAtraso / 30) + $valorMulta;

                                    if ($diasAtraso > 0) {
                                        $set('valor_atualizado', (float) number_format($valorAtualizado, 2));
                                    }
                                }),
                        ])
                        ->action(function (array $data, FaturaCliente $record): void {
                            $record->multa_atraso = $data['multa_atraso'];
                            $record->juros_atraso = $data['juros_atraso'];
                            $record->valor_atualizado = $data['valor_atualizado'];
                            $record->save();
                        })
                        ->icon('heroicon-o-calculator'),
                    Action::make('quitarFatura')
                        ->requiresConfirmation()
                        ->hidden(fn(FaturaCliente $record) => $record->formapagamento !== 'Dinheiro' || $record->status == StatusFaturaCliente::CANCELADO->value)
                        ->action(function (FaturaCliente $record) {
                            $record->valor_pago = $record->valor_atualizado ?? $record->valor;
                            $record->status = StatusFaturaCliente::APROVADO;
                            $record->save();
                            Notification::make()->success()->title('Fatura quitada com sucesso!')->icon('heroicon-o-currency-dollar')->send();
                        })
                        ->icon('heroicon-o-currency-dollar'),
                    Action::make('cancelarFatura')
                        ->requiresConfirmation()
                        ->hidden(fn(FaturaCliente $record) => $record->status == StatusFaturaCliente::CANCELADO->value || $record->formapagamento == 'Cartão de crédito')
                        ->form([
                            TextInput::make('info_add')
                                ->label('Informação de cancelamento')
                                ->required()
                        ])
                        ->action(function (array $data, FaturaCliente $record): void {
                            $record->info_add = $data['info_add'];
                            $record->status = StatusFaturaCliente::CANCELADO->value;
                            $record->save();

                            Notification::make()->success()->title('Fatura cancelada com sucesso.')->icon('heroicon-o-currency-dollar')->send();
                            Notification::make()->warning()->title('Necessário cancelar boleto no BitPag!')->icon('heroicon-o-currency-dollar')->duration(100000)->send();
                        })
                        ->icon('heroicon-o-x-circle'),
                    Action::make('delete')
                        ->label('Excluir Permanentemente')
                        ->action(fn($record) => $record->delete())
                        ->requiresConfirmation()
                        ->color('danger')
                        ->icon('heroicon-o-trash'),
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
