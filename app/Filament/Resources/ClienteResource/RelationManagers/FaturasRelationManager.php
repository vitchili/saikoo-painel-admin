<?php

namespace App\Filament\Resources\ClienteResource\RelationManagers;

use App\Models\Cliente\Fatura\Enum\FormaPagamento;
use App\Models\Cliente\Fatura\Enum\StatusFaturaCliente;
use App\Models\Cliente\Servico\Enum\PeriodicidadeServico;
use App\Models\Cliente\Servico\ServicoCliente;
use App\Models\Igpm;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;
use Parallax\FilamentComments\Tables\Actions\CommentsAction;
use Pelmered\FilamentMoneyField\Tables\Columns\MoneyColumn;

class FaturasRelationManager extends RelationManager
{
    public const ID_SERVICO_PRINCIPAL = 1;
    // O select de servicos referencia só pode ser multiple se a primeira posicao for 1 ('Servicos' da lista_servivo). 

    protected static string $relationship = 'faturas';

    public function form(Form $form): Form
    {
        return $form
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
                    ->relationship('servicos', 'periodicidade', function ($query) {
                        return $query->select('serv_cliente.id', 'serv_cliente.periodicidade');
                    })
                    ->label('Periodicidade')
                    ->options(collect(PeriodicidadeServico::cases())->mapWithKeys(fn($periodicidade) => [$periodicidade->value => $periodicidade->label()]))
                    ->preload()
                    ->searchable()
                    ->reactive()
                    ->afterStateUpdated(fn($state, callable $set, callable $get) => $this->alterarPeriodicidade($state, $set, $get)),
                Select::make('servicos')
                    ->relationship('servicos', 'nome', function ($query) {
                            return $query->join('lista_servico AS ls', 'serv_cliente.id_servico', '=', 'ls.id')
                                        ->select('serv_cliente.id', 'ls.nome');
                    })
                    ->required()
                    ->multiple()
                    ->label('Serviços Referência')
                    ->options(fn($get) => $this->getServicosOptions($get('periodicidade')))
                    ->preload()
                    ->searchable()
                    ->reactive()
                    ->afterStateUpdated(fn($state, callable $set, callable $get) => $this->somaEVerificaServico($state, $set, $get)),
                Select::make('formapagamento')
                    ->required()
                    ->label('Forma de Pagamento')
                    ->options(collect(FormaPagamento::cases())->mapWithKeys(fn($formaPagamento) => [$formaPagamento->value => $formaPagamento->label()]))
                    ->preload()
                    ->searchable(),
                TextInput::make('qtd')
                    ->label('Quantidade Parcelas')
                    ->readOnly()
                    ->numeric(),
                TextInput::make('info_add')
                    ->label('Informações Adicionais'),
                Select::make('igpm_id')
                    ->label('Índice IGPM')
                    ->options(Igpm::orderBy('id', 'desc')->get()->mapWithKeys(function ($item) {
                        return [
                            $item->id => 'Data: ' . Carbon::parse($item->data)->format('d/m/Y') . '. Índice: ' . number_format($item->valor, 2)
                        ];
                    }))
                    ->preload()
                    ->searchable()
                    ->reactive()
                    ->afterStateUpdated(fn($state, callable $set, callable $get) => $this->somaEVerificaIgpm($state, $set, $get)),
                Toggle::make('reajuste_automatico')
                    ->label('Reajuste automático após última parcela?'),
                Toggle::make('reajuste_aplica_ultimo_igpm')
                    ->label('Próximo reajuste aplica IGPM mais recente?'),
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

        if (! empty($get('igpm_id'))) {
            $this->somaEVerificaIgpm($get('igpm_id'), $set, $get);
        }

        if (count($ids) > 1 && $ids[0] != self::ID_SERVICO_PRINCIPAL) {
            $set('servicos', [$ids[0]]);
            $this->getServicosOptions($get('periodicidade'));
            $this->somaEVerificaServico([$ids[0]], $set, $get);
        }
    }

    protected function somaEVerificaIgpm($idIgpm, callable $set, callable $get)
    {
        $igpm = Igpm::find($idIgpm);

        if (! empty($igpm)) {
            $somaServicos = (float) $get('valor');

            $multiplicador = ($igpm->valor / 100) + 1;

            $somaServicos *= $multiplicador;

            $set('valor', round($somaServicos, 2));
        } else {
            $idsServicos = $get('servicos');

            $this->somaEVerificaServico($idsServicos, $set, $get);
        }
    }

    protected function alterarPeriodicidade($periodicidade, callable $set, callable $get)
    {
        $set('servicos', []);
        $set('valor', '');
        $set('qtd', PeriodicidadeServico::from($periodicidade)->qtdParcelas());

        $this->getServicosOptions($periodicidade);
    }

    protected function getServicosOptions($periodicidade)
    {
        if (! $periodicidade) {
            return [];
        }

        $servicos = ServicoCliente::with('servicoCliente')
            ->where('periodicidade', $periodicidade)
            ->where('id_cliente', $this->ownerRecord->id)
            ->get()
            ->toArray();

        return array_reduce($servicos, function ($carry, $item) {
            $carry[$item['servico_cliente']['id']] = $item['servico_cliente']['nome'];
            return $carry;
        }, []);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('vencimento')
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
                MoneyColumn::make('valor_atualizado')
                    ->label('Valor Atualizado')
                    ->size(TextColumnSize::ExtraSmall)
                    ->prefix('R$')
                    ->toggleable(isToggledHiddenByDefault: true),
                MoneyColumn::make('valor_pago')
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
                Tables\Columns\TextColumn::make('enviar_boleto')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Enviar Boleto')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->slideOver()
            ])
            ->actions([
                Tables\Actions\EditAction::make()->slideOver(),
                Tables\Actions\DeleteAction::make(),
                CommentsAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
