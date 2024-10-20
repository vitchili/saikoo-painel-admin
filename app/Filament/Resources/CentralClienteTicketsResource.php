<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CentralClienteTicketsResource\Pages;
use App\Models\Cliente\TicketDesenvolvimento\Enum\PrioridadeTicketDesenvolvimentoEnum;
use App\Models\Cliente\TicketDesenvolvimento\TicketDesenvolvimento;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Models\Cliente\Cliente;
use App\Models\Cliente\TicketDesenvolvimento\Enum\SituacaoTicketDesenvolvimentoEnum;
use App\Models\Cliente\TicketDesenvolvimento\Enum\TipoTicketDesenvolvimentoEnum;
use App\Models\Cliente\TicketDesenvolvimento\TipoProjetoTicketDesenvolvimento;
use App\Models\Diversos\Modulo;
use App\Models\Diversos\Sistema;
use App\Models\Diversos\Subtela;
use App\Models\Diversos\Tela;
use App\Models\User;
use App\Models\VersaoSistema;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Collection;
use Parallax\FilamentComments\Tables\Actions\CommentsAction;

class CentralClienteTicketsResource extends Resource
{
    protected static ?string $model = TicketDesenvolvimento::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $slug = 'central-tickets';

    protected static ?string $navigationLabel = 'Meus Tickets';

    protected static ?string $title = 'Meus Tickets';

    protected static ?string $modelLabel = 'Meus Tickets';

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('Cliente');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make()->tabs([
                    Tab::make('Ticket')->schema([
                        Select::make('cliente_id')
                            ->required()
                            ->label('Cliente')
                            ->options(Cliente::find(Auth::user()->cliente_id)->pluck('nome', 'id'))
                            ->searchable(),
                        Radio::make('tipo_id')
                            ->label('Tipo')
                            ->required()
                            ->options(collect(TipoTicketDesenvolvimentoEnum::cases())->mapWithKeys(fn($tipo) => [$tipo->value => $tipo->label()]))
                            ->inline()
                            ->inlineLabel(false)
                            ->reactive()
                            ->default(1),
                        Radio::make('tipo_projeto_id')
                            ->label('Projeto')
                            ->required()
                            ->options(TipoProjetoTicketDesenvolvimento::all()->pluck('nome', 'id'))
                            ->inline()
                            ->inlineLabel(false)
                            ->reactive(),
                        Select::make('sistema_id')
                            ->label('Sistema')
                            ->options(Sistema::all()->pluck('nome', 'id'))
                            ->preload()
                            ->reactive()
                            ->searchable(),
                        Select::make('modulo_id')
                            ->label('Módulo')
                            ->options(fn($get) => self::getModulos($get('sistema_id')))
                            ->preload()
                            ->reactive()
                            ->searchable(),
                        Select::make('tela_id')
                            ->label('Tela')
                            ->options(fn($get) => self::getTelas($get('modulo_id')))
                            ->preload()
                            ->reactive()
                            ->searchable(),
                        Select::make('subtela_id')
                            ->label('Subtela')
                            ->options(fn($get) => self::getSubTelas($get('tela_id')))
                            ->preload()
                            ->searchable(),
                        RichEditor::make('comentario')
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
                            ->label('Comentário'),
                        FileUpload::make('anexo')
                            ->label('Anexo')
                            ->columnSpanFull()
                            ->directory('anexo_ticket_desenvolvimento'),
                    ])->columns(2),
                    Tab::make('Levantamento de Requisito')->schema([
                        TextInput::make('titulo')
                            ->label('Título'),
                        TextInput::make('objetivo')
                            ->label('Objetivo'),
                        RichEditor::make('situacao_atual')
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
                            ->label('Situação Atual'),
                        RichEditor::make('situacao_proposta')
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
                            ->label('Situação Proposta'),
                        RichEditor::make('testes_em_caso_de_erro')
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
                            ->label('Testes realizados em caso de erro:'),
                        FileUpload::make('imagens')
                            ->label('Imagens')
                            ->multiple()
                            ->directory('tickets_desenvolvimento_imagens')
                    ]),
                ])->columns(2),
            ])->columns(1);
    }

    public static function getModulos($sistemaId): Collection
    {
        return Modulo::where('sistema_id', $sistemaId)->pluck('nome', 'id');
    }

    public static function getTelas($moduloId): Collection
    {
        return Tela::where('modulo_id', $moduloId)->pluck('nome', 'id');
    }

    public static function getSubTelas($telaId): Collection
    {
        return Subtela::where('tela_id', $telaId)->pluck('nome', 'id');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                return $query->where('cliente_id', auth()->user()->cliente_id);
            })
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Código')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('cadastrado_em')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Data')
                    ->datetime('d/m/Y H:s')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('prioridade_id')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Prioridade')
                    ->formatStateUsing(fn($state) => PrioridadeTicketDesenvolvimentoEnum::from($state)->label())
                    ->sortable()
                    ->searchable()
                    ->badge(),
                Tables\Columns\TextColumn::make('sistema.nome')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Sistema')
                    ->limit(30)
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('modulo.nome')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Módulo')
                    ->limit(30)
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('responsavel.name')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Responsável')
                    ->limit(30)
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('desenvolvedor.name')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Desenvolvedor')
                    ->limit(30)
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('situacao_id')
                    ->size(TextColumnSize::ExtraSmall)
                    ->formatStateUsing(fn($state) => SituacaoTicketDesenvolvimentoEnum::from($state)->label())
                    ->label('Situação')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                CommentsAction::make()
                    ->label('Conversa'),
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
            'index' => Pages\ListCentralClienteTickets::route('/'),
        ];
    }

}
