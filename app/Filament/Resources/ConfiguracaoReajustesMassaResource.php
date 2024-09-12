<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConfiguracaoReajustesMassaResource\Pages;
use App\Models\ConfiguracaoReajusteMassa;
use App\Models\Igpm;
use App\Models\IndiceCorrecaoGenerico;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ConfiguracaoReajustesMassaResource extends Resource
{
    protected static ?string $model = ConfiguracaoReajusteMassa::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationLabel = 'Config. de Índices de Reajuste';

    protected static ?string $slug = 'configuracao-indices-reajuste';

    protected static ?string $title = 'Config. de Índices de Reajuste';

    protected static ?string $modelLabel = 'Config. de Índices de Reajuste';

    protected static ?string $navigationGroup = 'Financeiro';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Índices percentuais somados no reajuste anual')
                    ->schema([
                        TextInput::make('nome')
                            ->label('Nome')
                            ->required(),
                        Select::make('indice_correcao_generica_id')
                            ->label('Índice Padrão')
                            ->options(IndiceCorrecaoGenerico::all()->mapWithKeys(function ($item) {
                                return [
                                    $item->id => 'Nome: ' . $item->nome . '. Índice: ' . number_format($item->valor, 2)
                                ];
                            }))
                            ->preload()
                            ->searchable(),
                        Select::make('igpm_id')
                            ->label('Índice IGPM')
                            ->options(Igpm::orderBy('id', 'desc')->get()->mapWithKeys(function ($item) {
                                return [
                                    $item->id => 'Data: ' . Carbon::parse($item->data)->format('d/m/Y') . '. Índice: ' . number_format($item->valor, 2)
                                ];
                            }))
                            ->preload()
                            ->searchable(),
                        DatePicker::make('data_inicio')
                            ->label('Data Ínicio Cobrança')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nome')
                    ->label('Nome'),
                TextColumn::make('igpm.valor')
                    ->label('IGPM')
                    ->suffix('%'),
                TextColumn::make('indiceCorrecaoGenerica.valor')
                    ->label('Índice Padrão')
                    ->suffix('%'),
                TextColumn::make('data_inicio')
                    ->label('Data de início')
                    ->date('d/m/Y')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListConfiguracaoReajustesMassas::route('/'),
            // 'create' => Pages\CreateConfiguracaoReajustesMassa::route('/create'),
            'edit' => Pages\EditConfiguracaoReajustesMassa::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
