<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContatoComClienteResource\Pages;
use App\Filament\Resources\ContatoComClienteResource\RelationManagers\ClienteRelationManager;
use App\Filament\Resources\ContatoComClienteResource\RelationManagers\HistoricoContatoComClienteRelationManager;
use App\Models\Cliente\Cliente;
use App\Models\Cliente\Contato\ContatoComCliente;
use App\Models\Cliente\Contato\Enum\SituacaoContato;
use App\Models\Cliente\TipoContatoPessoaCliente;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class ContatoComClienteResource extends Resource
{
    protected static ?string $model = ContatoComCliente::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone';

    protected static ?string $navigationLabel = 'Contatos';

    protected static ?string $modelLabel = 'Contatos';

    protected static ?string $navigationGroup = 'Principal';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make()->tabs([
                    Tab::make('Contato com cliente')->schema([
                        Select::make('cliente_id')
                            ->relationship(name: 'cliente', titleAttribute: 'nome')
                            ->createOptionForm([
                                TextInput::make('cpf_cnpj')
                                    ->label('CNPJ')
                                    ->mask(RawJs::make(<<<'JS'
                                $input.length > 14 ? '99.999.999/9999-99' : '999.999.999-99'
                            JS))
                                    ->rule('cpf_ou_cnpj')
                                    ->suffixAction(
                                        fn($state, $livewire, $set) => Action::make('search-action')
                                            ->icon('heroicon-o-magnifying-glass')
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
                                                $set('telefone', $cnpjData['ddd_telefone_1'] ?? null);
                                            })
                                    ),
                                Forms\Components\TextInput::make('nome')
                                    ->label('Nome')
                                    ->required(),
                                Forms\Components\TextInput::make('telefone')
                                    ->minLength(10)
                                    ->mask(RawJs::make(<<<'JS'
                                    $input.length >= 14 ? '(99)99999-9999' : '(99)9999-9999'
                                JS)),
                            ]),
                        Forms\Components\Select::make('tipo_contato_com_cliente_id')
                            ->required()
                            ->label('Tipo Contato')
                            ->options(TipoContatoPessoaCliente::all()->pluck('nome', 'id'))
                            ->searchable(),
                        Forms\Components\TextInput::make('nome')
                            ->required()
                            ->label('Nome')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('telefone')
                            ->label('Telefone')
                            ->minLength(10)
                            ->mask(RawJs::make(<<<'JS'
                            $input.length >= 14 ? '(99)99999-9999' : '(99)9999-9999'
                        JS)),
                        Forms\Components\TextInput::make('email')
                            ->label('E-mail')
                            ->email(),
                        Forms\Components\Select::make('situacao_id')
                            ->label('Situação')
                            ->options(collect(SituacaoContato::cases())->mapWithKeys(fn($situacao) => [$situacao->value => $situacao->label()])),
                        Forms\Components\Select::make('responsavel_id')
                            ->required()
                            ->label('Responsável')
                            ->options(User::all()->pluck('name', 'id'))
                            ->searchable(),
                        Forms\Components\DatePicker::make('data_contato')
                            ->required()
                            ->label('Data Contato'),
                        Forms\Components\DatePicker::make('data_retorno')
                            ->label('Data Retorno')
                            ->afterOrEqual('data_contato'),
                        RichEditor::make('descricao')
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
                            ->label('Descrição do contato'),
                        \Njxqlus\Filament\Components\Forms\RelationManager::make()
                            ->manager(HistoricoContatoComClienteRelationManager::class)
                            ->lazy(true)
                            ->hidden(fn(mixed $livewire) => $livewire instanceof CreateRecord)
                            ->columnSpanFull()
                    ])->columns(2),

                ]),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cliente.codigo')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Código')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cliente.nome')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Nome')
                    ->searchable()
                    ->limit(20),
                Tables\Columns\TextColumn::make('tipoContato.nome')
                    ->size(TextColumnSize::ExtraSmall)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('nome')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Resp. Contato')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telefone')
                    ->size(TextColumnSize::ExtraSmall)
                    ->searchable(),
                Tables\Columns\TextColumn::make('situacao_id')
                    ->label('Situação')
                    ->size(TextColumnSize::ExtraSmall)
                    ->formatStateUsing(fn($state) => SituacaoContato::from($state)->label())
                    ->badge()
                    ->color(function (string $state): string {
                        return SituacaoContato::tryFrom($state)?->color() ?? 'secondary';
                    })
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('data_contato')->date('d/m/Y')
                    ->size(TextColumnSize::ExtraSmall)
                    ->sortable(),
                Tables\Columns\TextColumn::make('data_retorno')->date('d/m/Y')
                    ->size(TextColumnSize::ExtraSmall)
                    ->sortable(),
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
            // ClienteRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContatoComClientes::route('/'),
            'create' => Pages\CreateContatoComCliente::route('/create'),
            'edit' => Pages\EditContatoComCliente::route('/{record}/edit'),
        ];
    }
}
