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
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;

class ContatoComClienteResource extends Resource
{
    protected static ?string $model = ContatoComCliente::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone';

    protected static ?string $navigationLabel = 'Contatos';

    protected static ?string $modelLabel = 'Contatos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make()->tabs([
                    Tab::make('Contato com cliente')->schema([
                        Forms\Components\Select::make('cliente_id')
                            ->required()
                            ->label('Cliente')
                            ->options(Cliente::all()->pluck('nome', 'id'))
                            ->searchable(),
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
                            ->mask(RawJs::make(<<<'JS'
                            $input.length >= 14 ? '(99)99999-9999' : '(99)9999-9999'
                        JS)),
                        Forms\Components\TextInput::make('email')
                            ->label('E-mail')
                            ->email(),
                        Forms\Components\Select::make('situacao_id')
                            ->label('Situação')
                            ->options(collect(SituacaoContato::cases())->mapWithKeys(fn ($situacao) => [$situacao->value => $situacao->label()])),
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
                            ->hidden(fn (mixed $livewire) => $livewire instanceof CreateRecord)
                    ])->columns(2),

                ]),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cliente.codigo')
                    ->label('Código')    
                    ->searchable(),
                Tables\Columns\TextColumn::make('cliente.nome')
                    ->label('Nome')
                    ->searchable()
                    ->limit(20),
                Tables\Columns\TextColumn::make('tipoContato.nome')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('nome')
                    ->label('Resp. Contato')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telefone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('data_contato')->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('data_retorno')->date('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
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
