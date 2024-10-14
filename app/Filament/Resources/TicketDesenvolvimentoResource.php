<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketDesenvolvimentoResource\Pages;
use App\Filament\Resources\TicketDesenvolvimentoResource\RelationManagers;
use App\Models\Cliente\Cliente;
use App\Models\Cliente\TicketDesenvolvimento\Enum\PrioridadeTicketDesenvolvimentoEnum;
use App\Models\Cliente\TicketDesenvolvimento\Enum\SituacaoTicketDesenvolvimentoEnum;
use App\Models\Cliente\TicketDesenvolvimento\Enum\TipoTicketDesenvolvimentoEnum;
use App\Models\Cliente\TicketDesenvolvimento\TicketDesenvolvimento;
use App\Models\Cliente\TicketDesenvolvimento\TipoProjetoTicketDesenvolvimento;
use App\Models\Diversos\Modulo;
use App\Models\Diversos\Sistema;
use App\Models\Diversos\Subtela;
use App\Models\Diversos\Tela;
use App\Models\User;
use App\Models\VersaoSistema;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class TicketDesenvolvimentoResource extends Resource
{
    protected static ?string $model = TicketDesenvolvimento::class;

    protected static ?string $modelLabel = 'Tickets Desenvolvimento';

    protected static ?string $navigationLabel = 'Tickets Desenvolvimento';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Principal';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make()->tabs([
                    Tab::make('Ticket')->schema([
                        Select::make('cliente_id')
                            ->required()
                            ->label('Cliente')
                            ->options(Cliente::all()->pluck('nome', 'id'))
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
                        Select::make('responsavel_id')
                            ->required()
                            ->label('Responsável')
                            ->options(User::whereNull('cliente_id')->get()->pluck('name', 'id'))
                            ->searchable(),
                        Select::make('prioridade_id')
                            ->label('Prioridade')
                            ->options(collect(PrioridadeTicketDesenvolvimentoEnum::cases())->mapWithKeys(fn($prioridade) => [$prioridade->value => $prioridade->label()]))
                            ->searchable(),
                        Select::make('versao_id')
                            ->label('Versão do sistema')
                            ->options(VersaoSistema::all()->pluck('versao', 'id'))
                            ->searchable(),
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
                        DatePicker::make('prazo')
                            ->label('Prazo')
                            ->after('today'),
                        DatePicker::make('previsao')
                            ->label('Previsão')
                            ->after('prazo'),
                        Select::make('situacao_id')
                            ->label('Situação')
                            ->options(collect(SituacaoTicketDesenvolvimentoEnum::cases())->mapWithKeys(fn($situacao) => [$situacao->value => $situacao->label()]))
                            ->searchable()
                            ->preload(),
                        Select::make('desenvolvedor_id')
                            ->required()
                            ->label('Desenvolvedor')
                            ->options(User::whereNull('cliente_id')->get()->pluck('name', 'id'))
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
                ])->columns(1),
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
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Código')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('cadastrado_em')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Data')
                    ->datetime('d/m/Y H:s')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('cliente.nome')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Cliente')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('prioridade_id')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Prioridade')
                    ->formatStateUsing(fn($state) => PrioridadeTicketDesenvolvimentoEnum::from($state)->label())
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(function (string $state): string {
                        return PrioridadeTicketDesenvolvimentoEnum::tryFrom($state)?->color() ?? 'secondary';
                    }),
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
                    ->label('Situação')
                    ->formatStateUsing(fn($state) => SituacaoTicketDesenvolvimentoEnum::from($state)->label())
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                
            ]);
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
            'index' => Pages\ListTicketDesenvolvimentos::route('/'),
            'create' => Pages\CreateTicketDesenvolvimento::route('/create'),
            'edit' => Pages\EditTicketDesenvolvimento::route('/{record}/edit'),
        ];
    }
}
