<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlanoResource\Pages;
use App\Filament\Resources\PlanoResource\RelationManagers;
use App\Models\Plano\Enum\TipoPlanoEnum;
use App\Models\Plano\Plano;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PlanoResource extends Resource
{
    protected static ?string $model = Plano::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationLabel = 'Planos';

    protected static ?string $modelLabel = 'Planos';

    protected static ?string $navigationGroup = 'Cadastros';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Planos')
                    ->schema([
                        Fieldset::make('Descriçao')
                            ->schema([
                                Radio::make('tipo_id')
                                    ->label('Tipo')
                                    ->options(collect(TipoPlanoEnum::cases())->mapWithKeys(fn ($tipo) => [$tipo->value => $tipo->label()]))
                                    ->inline()
                                    ->inlineLabel(false)
                                    ->reactive()
                                    ->default(1),
                                Forms\Components\TextInput::make('nome')
                                    ->label('Nome')
                                    ->required(),
                                Forms\Components\TextInput::make('descricao')
                                    ->label('Descrição')
                                    ->required(),
                            ])->columns(1),
                        Fieldset::make('Valores e Descontos')
                            ->schema([
                                Forms\Components\TextInput::make('qtd_profissionais')
                                    ->label('Qtd. Profissionais')
                                    ->numeric()
                                    ->hidden(fn ($get) => $get('tipo_id') != TipoPlanoEnum::SISTEMA->value),
                                Forms\Components\TextInput::make('valor_geral')
                                    ->label('Valor')
                                    ->numeric()
                                    ->prefix('R$')
                                    ->hidden(fn ($get) => $get('tipo_id') != TipoPlanoEnum::TREINAMENTO->value),
                                Forms\Components\TextInput::make('valor_mensal')
                                    ->label('Valor Mensal')
                                    ->numeric()
                                    ->prefix('R$')
                                    ->hidden(fn ($get) => $get('tipo_id') == TipoPlanoEnum::TREINAMENTO->value),
                                Forms\Components\TextInput::make('desconto_mensal')
                                    ->label('Desconto Mensal')
                                    ->numeric()
                                    ->hidden(fn ($get) => $get('tipo_id') == TipoPlanoEnum::TREINAMENTO->value),
                                Forms\Components\TextInput::make('valor_semestral')
                                    ->label('Valor Semestral')
                                    ->numeric()
                                    ->prefix('R$')
                                    ->hidden(fn ($get) => $get('tipo_id') == TipoPlanoEnum::TREINAMENTO->value),
                                Forms\Components\TextInput::make('desconto_semestral')
                                    ->label('Desconto Semestral')
                                    ->numeric()
                                    ->hidden(fn ($get) => $get('tipo_id') == TipoPlanoEnum::TREINAMENTO->value),
                                Forms\Components\TextInput::make('valor_anual')
                                    ->label('Valor Anual')
                                    ->numeric()
                                    ->prefix('R$')
                                    ->hidden(fn ($get) => $get('tipo_id') == TipoPlanoEnum::TREINAMENTO->value),
                                Forms\Components\TextInput::make('desconto_anual')
                                    ->label('Desconto Anual')
                                    ->numeric()
                                    ->hidden(fn ($get) => $get('tipo_id') == TipoPlanoEnum::TREINAMENTO->value),
                                Radio::make('tipo_desconto')
                                    ->label('Tipo Desconto')
                                    ->options([
                                        '$' => 'Real (R$)',
                                        '%' => 'Percentual (%)',
                                    ])
                                    ->inline()
                                    ->inlineLabel(false)
                                    ->hidden(fn ($get) => $get('tipo_id') == TipoPlanoEnum::TREINAMENTO->value),
                            ])->columns(2),
                        Fieldset::make('Quantidades Diversas')
                            ->schema([
                                Forms\Components\TextInput::make('qtd_horas')
                                    ->label('Qtd. Horas')
                                    ->numeric()
                                    ->hidden(fn ($get) => ($get('tipo_id') != TipoPlanoEnum::TREINAMENTO->value && $get('tipo_id') != TipoPlanoEnum::SISTEMA->value)),
                                Forms\Components\TextInput::make('qtd_dias_valido')
                                    ->label('Qtd Dias Válido')
                                    ->numeric()
                                    ->hidden(fn ($get) => $get('tipo_id') != TipoPlanoEnum::TREINAMENTO->value),
                                Forms\Components\TextInput::make('qtd_limites_ligacoes')
                                    ->label('Qtd Limite Ligações')
                                    ->numeric()
                                    ->hidden(fn ($get) => $get('tipo_id') != TipoPlanoEnum::SUPORTE_TELEFONICO->value),
                            ])->columns(2)->hidden(fn ($get) => ($get('tipo_id') != TipoPlanoEnum::SUPORTE_TELEFONICO->value && $get('tipo_id') != TipoPlanoEnum::TREINAMENTO->value && $get('tipo_id') != TipoPlanoEnum::SISTEMA->value)),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListPlanos::route('/'),
            'create' => Pages\CreatePlano::route('/create'),
            'edit' => Pages\EditPlano::route('/{record}/edit'),
        ];
    }
}
