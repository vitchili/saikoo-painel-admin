<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CentralClienteFaturasResource\Pages;
use App\Gateway\Bitpag\CobrancaBitpag;
use App\Models\Cliente\Fatura\Enum\FormaPagamento;
use App\Models\Cliente\Fatura\Enum\StatusFaturaCliente;
use App\Models\Cliente\Fatura\FaturaCliente;
use App\Models\Cliente\Serial\SerialCliente;
use Carbon\Carbon;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;
use Parallax\FilamentComments\Tables\Actions\CommentsAction;

class CentralClienteFaturasResource extends Resource
{
    protected static ?string $model = FaturaCliente::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $slug = 'central-faturas';

    protected static ?string $navigationLabel = 'Minhas Faturas';

    protected static ?string $title = 'Minhas Faturas';

    protected static ?string $modelLabel = 'Minhas Faturas';

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('Cliente');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn(Builder $query) => $query->where('id_cliente', auth()->user()->cliente_id))
            ->defaultSort('vencimento', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('vencimento')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Venc.')
                    ->dateTime('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('vencimento_boleto')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Venc. Boleto')
                    ->dateTime('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('referencia')
                    ->size(TextColumnSize::ExtraSmall)
                    ->limit(20)
                    ->label('Referência'),
                Tables\Columns\TextColumn::make('valor')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Valor')
                    ->prefix('R$'),
                Tables\Columns\TextColumn::make('valor_atualizado')
                    ->label('Valor Att.')
                    ->size(TextColumnSize::ExtraSmall)
                    ->prefix('R$'),
                Tables\Columns\TextColumn::make('valor_pago')
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
                    ->sortable()
                    ->color(function (string $state): string {
                        return StatusFaturaCliente::tryFrom($state)?->color() ?? 'secondary';
                    }),
                Tables\Columns\TextColumn::make('formapagamento')
                    ->size(TextColumnSize::ExtraSmall)
                    ->sortable()
                    ->label('Forma pagamento')
                    ->formatStateUsing(fn($state) => $state == FormaPagamento::BOLETO->value ? 'Boleto/PIX' : ''),
                Tables\Columns\TextColumn::make('final_cartao')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Cartão')
                    ->formatStateUsing(function (string $state): string {
                        return ! empty($state) ? '.... - .... - .... - ' . $state : '';
                    })
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('info_add')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Info Add.')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([])
            ->actions([
                Action::make('gerarBoletoOuPix')
                    ->label('Gerar Boleto/PIX')
                    ->hidden(
                        fn(FaturaCliente $record) =>
                        $record->status == StatusFaturaCliente::APROVADO->value ||
                            $record->status == StatusFaturaCliente::CANCELADO->value ||
                            ($record->status == 'Aguardando Pagto' && Carbon::parse($record->vencimento_boleto) > now()) ||
                            ! empty($record->valor_pago) ||
                            (
                                $record->formapagamento !== FormaPagamento::BOLETO->value &&
                                $record->formapagamento !== FormaPagamento::PIX->value
                            )
                    )
                    ->requiresConfirmation()
                    ->form([
                        Select::make('forma_pagamento')
                            ->label('Forma Pagamento')
                            ->options([
                                FormaPagamento::BOLETO->value => FormaPagamento::BOLETO->value,
                                FormaPagamento::PIX->value => FormaPagamento::PIX->value,
                            ]),
                    ])
                    ->action(function (array $data, FaturaCliente $faturaCliente) {
                        $faturaCliente->vencimento_boleto = Carbon::parse($faturaCliente->vencimento)->gt(now()) ? $faturaCliente->vencimento : now()->format('Y-m-d');
                        $faturaCliente->formapagamento = $data['forma_pagamento'];
                        $bitPagCobranca = new CobrancaBitpag();
                        $bitPagCobranca->cadastrarCobranca($faturaCliente);

                        Notification::make()->success()->title("$faturaCliente->formapagamento gerado com suesso.")->icon('heroicon-o-currency-dollar')->send();
                    })
                    ->icon('heroicon-o-currency-dollar'),

                Action::make('boletoGerado')
                    ->icon('heroicon-o-eye')
                    ->label('Ver Boleto')
                    ->hidden(fn(FaturaCliente $record) => $record->status == StatusFaturaCliente::CANCELADO->value || $record->formapagamento !== FormaPagamento::BOLETO->value || ($record->formapagamento == FormaPagamento::BOLETO->value && empty($record->cobranca_bitpag_id)))
                    ->url(fn(FaturaCliente $record) => $record->url_boleto)
                    ->openUrlInNewTab(),
                Action::make('verPix')
                    ->icon('heroicon-o-eye')
                    ->label('Ver QR Code PIX')
                    ->hidden(
                        fn(FaturaCliente $record) =>
                        $record->status == StatusFaturaCliente::CANCELADO->value ||
                            $record->formapagamento !== FormaPagamento::PIX->value ||
                            (
                                $record->formapagamento == FormaPagamento::PIX->value &&
                                empty($record->cobranca_bitpag_id)
                            ) ||
                            (
                                !empty($record->data_expiracao_pix) &&
                                Carbon::createFromFormat('d/m/Y H:i', $record->data_expiracao_pix)->lt(now())
                            )
                    )
                    ->form([
                        Placeholder::make('qr_code_pix')
                            ->content((fn(FaturaCliente $record) => new HtmlString('<img src="' . $record->qr_code_pix . '" alt="Image" style="max-width: 100%; height: auto;" />')))
                            ->label('QR Code PIX'),
                        Placeholder::make('data_expiracao_pix')
                            ->label('Válido até')
                            ->content((fn(FaturaCliente $record) => $record->data_expiracao_pix)),
                        Placeholder::make('digitavel_pix')
                            ->label('Linha digitável')
                            ->content((fn(FaturaCliente $record) => $record->digitavel_pix)),
                    ]),
                ActionGroup::make([
                    CommentsAction::make()
                        ->label('Conversa'),
                ])
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
            'index' => Pages\ListCentralClienteFaturas::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
