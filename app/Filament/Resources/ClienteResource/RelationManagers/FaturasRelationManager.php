<?php

namespace App\Filament\Resources\ClienteResource\RelationManagers;

use App\Models\Cliente\Fatura\Enum\FormaPagamento;
use App\Models\Cliente\Fatura\Enum\StatusFaturaCliente;
use App\Models\Cliente\Servico\TipoServicoCliente;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;
use Parallax\FilamentComments\Tables\Actions\CommentsAction;
use Pelmered\FilamentMoneyField\Tables\Columns\MoneyColumn;

class FaturasRelationManager extends RelationManager
{
    protected static string $relationship = 'faturas';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('vencimento')
                    ->required()
                    ->afterOrEqual('today')
                    ->label('Vencimento'),
                MoneyInput::make('valor')
                    ->required()
                    ->label('Valor'),
                Select::make('referencia')
                    ->required()
                    ->label('Serviço Referência')
                    ->options(TipoServicoCliente::all()->pluck('nome', 'nome'))
                    ->preload()
                    ->searchable(),
                Select::make('formapagamento')
                    ->required()
                    ->label('Forma de Pagamento')
                    ->options(collect(FormaPagamento::cases())->mapWithKeys(fn ($formaPagamento) => [$formaPagamento->value => $formaPagamento->label()]))
                    ->preload()
                    ->searchable(),
                // TextInput::make('motivo_alteracao')
                //     ->label('Motivo Alteração'),
                TextInput::make('qtd')
                    ->label('Quantidade Parcelas')
                    ->numeric(),
                TextInput::make('info_add')
                    ->label('Informações Adicionais'),
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('vencimento')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('vencimento')
                    ->label('Vencimento')
                    ->dateTime('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('vencimento_boleto')
                    ->label('Vencimento Boleto')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('referencia')
                    ->label('Referência'),
                MoneyColumn::make('valor')
                    ->label('Valor'),
                MoneyColumn::make('valor_atualizado')
                    ->label('Valor Atualizado')
                    ->toggleable(isToggledHiddenByDefault: true),
                MoneyColumn::make('valor_pago')
                    ->label('Valor Pago'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(function (string $state): string {
                        return StatusFaturaCliente::tryFrom($state)?->label() ?? $state;
                    })
                    ->badge()
                    ->color(function (string $state): string {
                        return StatusFaturaCliente::tryFrom($state)?->color() ?? 'secondary';
                    }),
                Tables\Columns\TextColumn::make('serial')
                    ->label('Serial')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('formapagamento')
                    ->label('Forma pagamento'),
                Tables\Columns\TextColumn::make('gerar_boleto')
                    ->label('Gerar')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('url_checkout')
                    ->label('Url Checkout')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('enviar_boleto')
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
