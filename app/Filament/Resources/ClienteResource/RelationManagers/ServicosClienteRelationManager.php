<?php

namespace App\Filament\Resources\ClienteResource\RelationManagers;

use App\Models\Cliente\Servico\Enum\ParametroComissao;
use App\Models\Cliente\Servico\Enum\PeriodicidadeServico;
use App\Models\Cliente\Servico\TipoServicoCliente;
use App\Models\Representante;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServicosClienteRelationManager extends RelationManager
{
    protected static string $relationship = 'servicosCliente';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Implantação')
                    ->schema([
                        Toggle::make('em_implatacao')
                            ->label('Serviço em implantação?')
                            ->inline(false),
                        DatePicker::make('dta_inicio_implatacao')
                            ->label('Data início implantação'),
                        DatePicker::make('dta_fim_implatacao')
                            ->label('Data fim implantação')
                            ->after('dta_inicio_implatacao'),
                    ])->columns(3),
                Fieldset::make('Serviço')
                    ->schema([
                        Select::make('id_servico')
                            ->options(TipoServicoCliente::all()->pluck('nome', 'id'))
                            ->preload()
                            ->label('Serviço')
                            ->searchable()
                            ->required()
                            ->columnSpan(2),
                        Select::make('id_representante')
                            ->options(Representante::all()->pluck('nome', 'id'))
                            ->preload()
                            ->label('Representante')
                            ->searchable()
                            //->required()
                            ->columnSpan(2),
                        Toggle::make('status')
                            ->label('Ativo')
                            ->required()
                            ->inline(false)
                            ->default(1),
                    ])->columns(5),
                Fieldset::make('Quantidades')
                    ->schema([
                        TextInput::make('qtd')
                            ->numeric()
                            ->required()
                            ->label('Quantidade')
                            ->maxLength(255),
                        TextInput::make('qtd_profissionais')
                            ->numeric()
                            ->label('Quantidade Prof/PC')
                            ->maxLength(255),
                        Toggle::make('validar_prof')
                            ->label('Validar Prof.')
                            ->required()
                            ->inline(false),
                        Radio::make('tipo_qtd')
                            ->label('Tipo')
                            ->required()
                            ->options([
                                'C' => 'Computadores',
                                'P' => 'Profissionais',
                            ])
                            ->inline()
                            ->inlineLabel(false),
                    ])->columns(4),
                Fieldset::make('Valores e acessos')
                    ->schema([
                        TextInput::make('valor')
                            ->numeric()
                            ->label('Valor')
                            ->required(),
                        Toggle::make('bd_btech')
                            ->label('Banco de dados BTECH')
                            ->required()
                            ->inline(false),
                        Select::make('periodicidade')
                            ->label('Periodicidade')
                            ->preload()
                            ->options(collect(PeriodicidadeServico::cases())->mapWithKeys(fn($parametro) => [$parametro->value => $parametro->label()]))
                            ->required()
                            ->searchable(),
                    ])->columns(3),
                Fieldset::make('Contratação')
                    ->schema([
                        DatePicker::make('dta_contratada')
                            ->label('Data Contratação')
                            ->required(),
                        DatePicker::make('dta_instalacao')
                            ->label('Data Instalação')
                            ->required(),
                    ])->columns(2),
                Fieldset::make('Informações Gerais')
                    ->schema([
                        TextInput::make('pagamento')
                            ->label('Informação de pagamento')
                            ->maxLength(255),
                        TextInput::make('url_agenda_online')
                            ->label('URL Agenda Online')
                            ->maxLength(255),
                        Select::make('parametro_comissao')
                            ->label('Parâmetro Comissão')
                            ->preload()
                            ->options(collect(ParametroComissao::cases())->mapWithKeys(fn($parametro) => [$parametro->value => $parametro->label()]))
                            ->searchable(),
                        TextInput::make('versao')
                            ->label('Versão')
                            ->maxLength(255),
                        TextInput::make('obs_versao')
                            ->label('Observação Versão')
                            ->maxLength(255),
                        TextInput::make('obs')
                            ->label('Observação')
                            ->maxLength(255)
                    ])->columns(1)
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('servicoCliente.nome')
            ->columns([
                Tables\Columns\TextColumn::make('dta_contratada')
                    ->size(TextColumnSize::ExtraSmall)
                    ->date('d/m/Y')
                    ->label('Contratação'),
                Tables\Columns\TextColumn::make('servicoCliente.nome')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Serviço'),
                Tables\Columns\TextColumn::make('qtd')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Qtd'),
                Tables\Columns\TextColumn::make('qtd_profissionais')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Qtd. Prof/Comp.'),
                Tables\Columns\TextColumn::make('valor')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Valor')
                    ->prefix('R$'),
                Tables\Columns\TextColumn::make('versao')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Versão'),
                Tables\Columns\TextColumn::make('periodicidade')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Período'),
                Tables\Columns\ToggleColumn::make('em_implatacao')
                    ->label('Em Implantação'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->slideOver(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->slideOver(),
            ])
            ->bulkActions([
                
            ]);
    }
}
