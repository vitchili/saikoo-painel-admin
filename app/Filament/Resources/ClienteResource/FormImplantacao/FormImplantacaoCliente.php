<?php

namespace App\Filament\Resources\ClienteResource\FormImplantacao;

use App\Models\Implantacao\TelaTopicoModeloImplantacao;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;

class FormImplantacaoCliente
{
    public const CADASTRO = 1;
    public const ATENDIMENTO = 2;
    public const COMISSAO = 3;
    public const ESTOQUE = 4;
    public const FINANCEIRO = 5;
    public const RELATORIO = 6;

    public function __construct()
    {
    }

    public static function getForm(): array
    {
        $telasTopicoCadastro = [];
        $telasTopicoAtendimento = [];
        $telasTopicoComissao = [];
        $telasTopicoEstoque = [];
        $telasTopicoFinanceiro = [];
        $telasTopicoRelatorio = [];

        foreach (TelaTopicoModeloImplantacao::all() as $tela) {
            switch ($tela['topico_id']) {
                case self::CADASTRO:
                    array_push($telasTopicoCadastro, $tela);
                    break;
                case self::ATENDIMENTO:
                    array_push($telasTopicoAtendimento, $tela);
                    break;
                case self::COMISSAO:
                    array_push($telasTopicoComissao, $tela);
                    break;
                case self::ESTOQUE:
                    array_push($telasTopicoEstoque, $tela);
                    break;
                case self::FINANCEIRO:
                    array_push($telasTopicoFinanceiro, $tela);
                    break;
                case self::RELATORIO:
                    array_push($telasTopicoRelatorio, $tela);
                default;
            }
        }

        $repeaterCadastro = [];
        $count = 0;
        foreach ($telasTopicoCadastro as $tela) {
            $repeaterCadastro[] = Fieldset::make('implantacaoClienteCadastro')
                ->label('')
                ->schema([
                    TextInput::make('tela_id' . $count)
                        ->label('Tela')
                        ->placeholder($tela['nome'])
                        ->columnSpan(2)
                        ->disabled(),
                    Select::make('faz_parte_do_treinamento' . $count)
                        ->label('Sim/Não')
                        ->options([
                            1 => 'Sim',
                            0 => 'Não'
                        ])
                        ->default(1),
                    DatePicker::make('data_treinamento' . $count)
                        ->label('Data')
                        ->columnSpan(2),
                    TextInput::make('treinado' . $count)
                        ->label('Treinado'),
                    TextInput::make('treinado_por' . $count)
                        ->label('Treinado por'),
                    Select::make('confirmado' . $count)
                        ->label('Confirmado?')
                        ->disabled()
                        ->options([
                            1 => 'Sim',
                            0 => 'Não'
                        ])
                        ->default(0),
                ])
                ->columns(8);
            $count++;
        }

        $repeaterAtendimento = [];
        $countAtendimento = 0;
        foreach ($telasTopicoAtendimento as $tela) {
            $repeaterAtendimento[] = Fieldset::make('implantacaoClienteAtendimento')
                ->label('')
                ->schema([
                    TextInput::make('tela_id' . $countAtendimento)
                        ->label('Tela')
                        ->placeholder($tela['nome'])
                        ->columnSpan(2)
                        ->disabled(),
                    Select::make('faz_parte_do_treinamento' . $countAtendimento)
                        ->label('Sim/Não')
                        ->options([
                            1 => 'Sim',
                            0 => 'Não'
                        ])
                        ->default(1),
                    DatePicker::make('data_treinamento' . $countAtendimento)
                        ->label('Data')
                        ->columnSpan(2),
                    TextInput::make('treinado' . $countAtendimento)
                        ->label('Treinado'),
                    TextInput::make('treinado_por' . $countAtendimento)
                        ->label('Treinado por'),
                    Select::make('confirmado' . $countAtendimento)
                        ->label('Confirmado?')
                        ->disabled()
                        ->options([
                            1 => 'Sim',
                            0 => 'Não'
                        ])
                        ->default(0),
                ])
                ->columns(8);
            $countAtendimento++;
        }

        $repeaterComissao = [];
        $countComissao = 0;
        foreach ($telasTopicoComissao as $tela) {
            $repeaterComissao[] = Fieldset::make('implantacaoClienteComissao')
                ->label('')
                ->schema([
                    TextInput::make('tela_id' . $countComissao)
                        ->label('Tela')
                        ->placeholder($tela['nome'])
                        ->columnSpan(2)
                        ->disabled(),
                    Select::make('faz_parte_do_treinamento' . $countComissao)
                        ->label('Sim/Não')
                        ->options([
                            1 => 'Sim',
                            0 => 'Não'
                        ])
                        ->default(1),
                    DatePicker::make('data_treinamento' . $countComissao)
                        ->label('Data')
                        ->columnSpan(2),
                    TextInput::make('treinado' . $countComissao)
                        ->label('Treinado'),
                    TextInput::make('treinado_por' . $countComissao)
                        ->label('Treinado por'),
                    Select::make('confirmado' . $countComissao)
                        ->label('Confirmado?')
                        ->disabled()
                        ->options([
                            1 => 'Sim',
                            0 => 'Não'
                        ])
                        ->default(0),
                ])
                ->columns(8);
            $countComissao++;
        }

        $repeaterEstoque = [];
        $countEstoque = 0;
        foreach ($telasTopicoEstoque as $tela) {
            $repeaterEstoque[] = Fieldset::make('implantacaoClienteEstoque')
                ->label('')
                ->schema([
                    TextInput::make('tela_id' . $countEstoque)
                        ->label('Tela')
                        ->placeholder($tela['nome'])
                        ->columnSpan(2)
                        ->disabled(),
                    Select::make('faz_parte_do_treinamento' . $countEstoque)
                        ->label('Sim/Não')
                        ->options([
                            1 => 'Sim',
                            0 => 'Não'
                        ])
                        ->default(1),
                    DatePicker::make('data_treinamento' . $countEstoque)
                        ->label('Data')
                        ->columnSpan(2),
                    TextInput::make('treinado' . $countEstoque)
                        ->label('Treinado'),
                    TextInput::make('treinado_por' . $countEstoque)
                        ->label('Treinado por'),
                    Select::make('confirmado' . $countEstoque)
                        ->label('Confirmado?')
                        ->disabled()
                        ->options([
                            1 => 'Sim',
                            0 => 'Não'
                        ])
                        ->default(0),
                ])
                ->columns(8);
            $countEstoque++;
        }

        $repeaterFinanceiro = [];
        $countFinanceiro = 0;
        foreach ($telasTopicoFinanceiro as $tela) {
            $repeaterFinanceiro[] = Fieldset::make('implantacaoClienteFinanceiro')
                ->label('')
                ->schema([
                    TextInput::make('tela_id' . $countFinanceiro)
                        ->label('Tela')
                        ->placeholder($tela['nome'])
                        ->columnSpan(2)
                        ->disabled(),
                    Select::make('faz_parte_do_treinamento' . $countFinanceiro)
                        ->label('Sim/Não')
                        ->options([
                            1 => 'Sim',
                            0 => 'Não'
                        ])
                        ->default(1),
                    DatePicker::make('data_treinamento' . $countFinanceiro)
                        ->label('Data')
                        ->columnSpan(2),
                    TextInput::make('treinado' . $countFinanceiro)
                        ->label('Treinado'),
                    TextInput::make('treinado_por' . $countFinanceiro)
                        ->label('Treinado por'),
                    Select::make('confirmado' . $countFinanceiro)
                        ->label('Confirmado?')
                        ->disabled()
                        ->options([
                            1 => 'Sim',
                            0 => 'Não'
                        ])
                        ->default(0),
                ])
                ->columns(8);
            $countFinanceiro++;
        }

        $repeaterRelatorio = [];
        $countRelatorio = 0;
        foreach ($telasTopicoRelatorio as $tela) {
            $repeaterRelatorio[] = Fieldset::make('implantacaoClienteRelatorio')
                ->label('')
                ->schema([
                    TextInput::make('tela_id' . $countRelatorio)
                        ->label('Tela')
                        ->placeholder($tela['nome'])
                        ->columnSpan(2)
                        ->disabled(),
                    Select::make('faz_parte_do_treinamento' . $countRelatorio)
                        ->label('Sim/Não')
                        ->options([
                            1 => 'Sim',
                            0 => 'Não'
                        ])
                        ->default(1),
                    DatePicker::make('data_treinamento' . $countRelatorio)
                        ->label('Data')
                        ->columnSpan(2),
                    TextInput::make('treinado' . $countRelatorio)
                        ->label('Treinado'),
                    TextInput::make('treinado_por' . $countRelatorio)
                        ->label('Treinado por'),
                    Select::make('confirmado' . $countRelatorio)
                        ->label('Confirmado?')
                        ->disabled()
                        ->options([
                            1 => 'Sim',
                            0 => 'Não'
                        ])
                        ->default(0),
                ])
                ->columns(8);
            $countRelatorio++;
        }

        return [
            Wizard::make([
                Wizard\Step::make('Cadastro')
                    ->schema($repeaterCadastro),
                Wizard\Step::make('Atendimento')
                    ->schema($repeaterAtendimento),
                Wizard\Step::make('Comissão')
                    ->schema($repeaterComissao),
                Wizard\Step::make('Estoque')
                    ->schema($repeaterEstoque),
                Wizard\Step::make('Financeiro')
                    ->schema($repeaterFinanceiro),
                Wizard\Step::make('Relatório')
                    ->schema($repeaterRelatorio),
            ])
        ];
    }
}
