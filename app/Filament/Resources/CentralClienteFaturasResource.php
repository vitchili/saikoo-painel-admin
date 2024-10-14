<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CentralClienteFaturasResource\Pages;
use App\Filament\Resources\CentralClienteFaturasResource\RelationManagers;
use App\Gateway\Bitpag\CobrancaBitpag;
use App\Models\Cliente\Cliente;
use App\Models\Cliente\Fatura\Enum\StatusFaturaCliente;
use App\Models\Cliente\Fatura\FaturaCliente;
use App\Models\User;
use Carbon\Carbon;
use Filament\Actions\ImportAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
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
            ->defaultSort('vencimento', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('vencimento')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Vencimento')
                    ->dateTime('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('referencia')
                    ->size(TextColumnSize::ExtraSmall)
                    ->limit(25)
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
                    ->label('Forma pagamento'),
                Tables\Columns\TextColumn::make('final_cartao')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Cartão')
                    ->formatStateUsing(function (string $state): string {
                        return ! empty($state) ? '.... - .... - .... - ' . $state : '';
                    })
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([])
            ->actions([
                ActionGroup::make([
                    CommentsAction::make()
                        ->label('Conversa'),
                    Action::make('gerarBoleto')
                        ->label('Gerar Boleto')
                        ->hidden(fn(FaturaCliente $record) => $record->formapagamento !== 'Boleto' || ($record->formapagamento === 'Boleto' && ! empty($record->cobranca_bitpag_id)))
                        ->requiresConfirmation()
                        ->action(function (FaturaCliente $faturaCliente) {
                            $bitPagCobranca = new CobrancaBitpag();
                            $bitPagCobranca->cadastrarCobranca($faturaCliente);

                            Notification::make()->success()->title('Boleto gerado com suesso e será enviado por e-mail.')->icon('heroicon-o-currency-dollar')->send();
                        })
                        ->icon('heroicon-o-currency-dollar'),
                    Action::make('boletoGerado')
                        ->icon('heroicon-o-currency-dollar')
                        ->label('Boleto Gerado')
                        ->hidden(fn(FaturaCliente $record) => $record->formapagamento !== 'Boleto' || ($record->formapagamento == 'Boleto' && empty($record->cobranca_bitpag_id)))
                        ->action(function (FaturaCliente $faturaCliente) {
                            Notification::make()->success()->title("Boleto já enviado via e-mail. Entre em contato via 'Conversa' para solicitar o boleto atualizado.")->send();
                        }),
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
