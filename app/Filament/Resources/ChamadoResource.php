<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChamadoResource\Pages;
use App\Models\Chamado\Chamado;
use App\Models\Chamado\DepartamentoChamado;
use App\Models\Chamado\Enum\SituacaoChamado;
use App\Models\Chamado\MeioAberturaChamado;
use App\Models\Chamado\TipoChamado;
use App\Models\Cliente\Cliente;
use App\Models\Cliente\Servico\TipoServicoCliente;
use App\Models\Diversos\Veiculo;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;
use Parallax\FilamentComments\Tables\Actions\CommentsAction;

class ChamadoResource extends Resource
{
    protected static ?string $model = Chamado::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';

    protected static ?string $navigationGroup = 'Principal';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Select::make('departamento_id')
                            ->label('Departamento')
                            ->required()
                            ->options(DepartamentoChamado::all()->pluck('nome', 'id'))
                            ->searchable(),
                        Radio::make('tipo_chamado_id')
                            ->label('Tipo')
                            ->required()
                            ->options(TipoChamado::all()->pluck('nome', 'id'))
                            ->inline()
                            ->inlineLabel(false)
                            ->reactive()
                            ->default(1),
                        Select::make('gerente_id')
                            ->label('Gerente')
                            ->options(User::all()->pluck('name', 'id'))
                            ->searchable(),
                        Select::make('cliente_id')
                            ->label('Cliente')
                            ->options(Cliente::all()->pluck('nome', 'id'))
                            ->searchable(),
                        Select::make('meio_abertura_id')
                            ->label('Meio abertura')
                            ->options(MeioAberturaChamado::all()->pluck('nome', 'id'))
                            ->searchable(),
                        Select::make('tecnicos')
                            ->label('Técnicos')
                            ->options(User::all()->pluck('name', 'id'))
                            ->multiple()
                            ->relationship('tecnicos', 'name')
                            ->preload()
                            ->searchable(),
                        Select::make('veiculo_id')
                            ->label('Veículo')
                            ->options(Veiculo::all()->pluck('nome', 'id'))
                            ->searchable()
                            ->visible(fn ($get) => $get('tipo_chamado_id') == TipoChamado::where('nome', '=', 'Externo')->first()->id),
                        Select::make('tecnico_condutor_ida_id')
                            ->label('Técnico Condutor Ida')
                            ->options(User::all()->pluck('name', 'id'))
                            ->searchable()
                            ->visible(fn ($get) => $get('tipo_chamado_id') == TipoChamado::where('nome', '=', 'Externo')->first()->id),
                        Select::make('tecnico_condutor_volta_id')
                            ->label('Técnico Condutor Volta')
                            ->options(User::all()->pluck('name', 'id'))
                            ->searchable()
                            ->visible(fn ($get) => $get('tipo_chamado_id') == TipoChamado::where('nome', '=', 'Externo')->first()->id),
                        DatePicker::make('data_visita')
                            ->label('Data da visita')
                            ->hidden(fn ($get) => $get('tipo_chamado_id') == TipoChamado::where('nome', '=', 'Interno')->first()->id),
                        TimePicker::make('data_hora_inicial')
                            ->label('Hora inicial')
                            ->seconds(false)
                            ->hidden(fn ($get) => $get('tipo_chamado_id') == TipoChamado::where('nome', '=', 'Interno')->first()->id),
                        TimePicker::make('data_hora_final')
                            ->label('Hora final')
                            ->seconds(false)
                            ->hidden(fn ($get) => $get('tipo_chamado_id') == TipoChamado::where('nome', '=', 'Interno')->first()->id),
                        Select::make('situacao_id')
                            ->label('Situação')
                            ->options(collect(SituacaoChamado::cases())->mapWithKeys(fn ($situacao) => [$situacao->value => $situacao->label()]))
                            ->searchable(),
                        Select::make('servicos')
                            ->label('Serviços')
                            ->options(TipoServicoCliente::all()->pluck('nome', 'id'))
                            ->multiple()
                            ->relationship('servicos', 'nome')
                            ->preload()
                            ->searchable(),
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
                            ->label('Observação'),
                        Toggle::make('sera_cobrado')
                            ->label('Será cobrado?')
                            ->inline(false)
                            ->reactive(),
                        Toggle::make('fatura_foi_alterada')
                            ->label('Fatura foi alterada?')
                            ->inline(false)
                            ->reactive()
                            ->visible(fn ($get) => $get('sera_cobrado') === true),
                        DatePicker::make('vencimento_fatura')
                            ->label('Vencimento fatura')
                            ->visible(fn ($get) => $get('fatura_foi_alterada') === true),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Código')
                    ->size(TextColumnSize::ExtraSmall)
                    ->sortable(),
                    Tables\Columns\TextColumn::make('cadastrado_em')
                    ->label('Data')
                    ->size(TextColumnSize::ExtraSmall)
                    ->dateTime('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('cliente.nome')
                    ->label('Cliente')
                    ->size(TextColumnSize::ExtraSmall)
                    ->limit(20),
                Tables\Columns\TextColumn::make('descricao')
                    ->label('Descrição')
                    ->size(TextColumnSize::ExtraSmall)
                    ->formatStateUsing(function ($state) {
                        return \Illuminate\Support\Str::limit(strip_tags($state), 200);
                    })
                    ->wrap(),
                Tables\Columns\TextColumn::make('departamento.nome')
                    ->label('Departamento')
                    ->size(TextColumnSize::ExtraSmall),
                Tables\Columns\TextColumn::make('tipoChamado.nome')
                    ->label('Tipo')
                    ->size(TextColumnSize::ExtraSmall),
                Tables\Columns\TextColumn::make('meioAbertura.nome')
                    ->label('Abertura')
                    ->size(TextColumnSize::ExtraSmall),
                Tables\Columns\TextColumn::make('situacao_id')
                    ->label('Situação')
                    ->size(TextColumnSize::ExtraSmall)
                    ->formatStateUsing(fn ($state) => SituacaoChamado::from($state)->label())
                    ->badge()
                    ->color(function (string $state): string {
                        return SituacaoChamado::tryFrom($state)?->color() ?? 'secondary';
                    })
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    CommentsAction::make(),
                ]),
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
            'index' => Pages\ListChamados::route('/'),
            'create' => Pages\CreateChamado::route('/create'),
            'edit' => Pages\EditChamado::route('/{record}/edit'),
        ];
    }
}
