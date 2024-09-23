<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Filament\Resources\RoleResource\RelationManagers;
use App\Models\Permission;
use App\Models\Role;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Arr;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Perfil de acesso';

    protected static ?string $slug = 'tipo-perfil';

    protected static ?string $modelLabel = 'Perfil de acesso';

    protected static ?string $navigationParentItem = 'Usuários';

    protected static ?string $navigationGroup = 'Cadastros';

    public static function form(Form $form): Form
    {
        $options = Permission::all()->pluck('name', 'id')->toArray();

        return $form
            ->schema([
                Section::make('')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\Section::make('Permissões Gerais')
                            ->schema([
                                Forms\Components\Checkbox::make('mostrar_valor_tela_atendimento')
                                    ->label('Mostrar valor tela atendimento'),
                                Forms\Components\Checkbox::make('pedidos_realizados')
                                    ->label('Pedidos Realizados'),
                                Forms\Components\Checkbox::make('dashboard_suporte')
                                    ->label('Dashboard Suporte'),
                                Forms\Components\Checkbox::make('dashboard_bhair')
                                    ->label('Dashboard BHair'),
                            ]),
                        // Subitens dentro de "Menu Cliente"
                        Forms\Components\Section::make('Menu Cliente')
                            ->schema([
                                Forms\Components\Checkbox::make('menu_cliente')
                                    ->label('Menu Cliente'),

                                Forms\Components\Checkbox::make('menu_cliente_cadastrar_cliente')
                                    ->label('Cadastrar Cliente'),

                                Forms\Components\Checkbox::make('menu_cliente_dados')
                                    ->label('Dados'),

                                Forms\Components\Checkbox::make('menu_cliente_dados_status_cliente')
                                    ->label('Status Cliente'),

                                Forms\Components\Checkbox::make('menu_cliente_dados_alterar_termos')
                                    ->label('Alterar Termos'),

                                Forms\Components\Checkbox::make('menu_cliente_dados_enviar_boas_vindas')
                                    ->label('Enviar Boas Vindas'),

                                Forms\Components\Checkbox::make('menu_cliente_dados_senha_cliente')
                                    ->label('Senha Cliente'),

                                Forms\Components\Checkbox::make('menu_cliente_dados_ver_dados_bancarios')
                                    ->label('Ver Dados Bancários'),
                            ]),
                        Forms\Components\Section::make('Fatura e Serial')
                            ->schema([
                                // Outros campos
                                Forms\Components\Checkbox::make('faturas')
                                    ->label('Faturas'),

                                Forms\Components\Checkbox::make('faturas_alterar_status_da_fatura')
                                    ->label('Alterar status da fatura'),

                                Forms\Components\Checkbox::make('faturas_reprocessar_serial')
                                    ->label('Reprocessar Serial'),

                                Forms\Components\Checkbox::make('faturas_cadastrar_faturas')
                                    ->label('Cadastrar faturas'),

                                Forms\Components\Checkbox::make('faturas_alterar_fatura')
                                    ->label('Alterar fatura'),

                                Forms\Components\Checkbox::make('faturas_excluir_fatura')
                                    ->label('Excluir fatura'),

                                Forms\Components\Checkbox::make('serial')
                                    ->label('Serial'),

                                Forms\Components\Checkbox::make('serial_gerar_serial_temporario_com_limite_excedido')
                                    ->label('Gerar serial temporário com limite excedido'),
                            ]),
                        Forms\Components\Section::make('Serviços')
                            ->schema([
                                Forms\Components\Checkbox::make('servicos_adicionar_servicos')
                                    ->label('Adicionar Serviços'),

                                Forms\Components\Checkbox::make('servicos_excluir_servicos')
                                    ->label('Excluir Serviços'),

                                Forms\Components\Checkbox::make('servicos_alterar_servicos')
                                    ->label('Alterar Serviços'),

                                Forms\Components\Checkbox::make('servicos_alterar_servicos_versao')
                                    ->label('Alterar Serviços (Versão)'),

                                Forms\Components\Checkbox::make('servicos_alterar_servicos_implantacao')
                                    ->label('Alterar Serviços (Implantação)'),

                                Forms\Components\Checkbox::make('servicos_servicos_log')
                                    ->label('Serviços (Log)'),

                                Forms\Components\Checkbox::make('servicos_visualizar_servicos')
                                    ->label('Visualizar Serviços'),

                                Forms\Components\Checkbox::make('servicos_gerar_serial_servicos')
                                    ->label('Gerar Serial Serviços'),
                            ]),
                        Forms\Components\Section::make('Clientes e relatórios')
                            ->schema([
                                Forms\Components\Checkbox::make('n_profissionais')
                                    ->label('Nº Profissionais'),

                                Forms\Components\Checkbox::make('saikoo_web')
                                    ->label('Saikoo Web'),

                                Forms\Components\Checkbox::make('manual_de_implantacao')
                                    ->label('Manual de Implantação'),

                                Forms\Components\Checkbox::make('relato_de_implantacao')
                                    ->label('Relato de Implantação'),

                                Forms\Components\Checkbox::make('contatos_com_o_cliente')
                                    ->label('Contatos com o Cliente'),

                                Forms\Components\Checkbox::make('propostas')
                                    ->label('Propostas'),

                                Forms\Components\Checkbox::make('menu_ata_de_reuniao')
                                    ->label('Ata de Reunião'),

                                Forms\Components\Checkbox::make('cadastrar_ata_de_reuniao')
                                    ->label('Cadastrar Ata de Reunião'),

                                Forms\Components\Checkbox::make('menu_chamado')
                                    ->label('Chamado'),

                                Forms\Components\Checkbox::make('menu_agenda')
                                    ->label('Agenda'),

                                Forms\Components\Checkbox::make('menu_ci')
                                    ->label('CI'),

                                Forms\Components\Checkbox::make('menu_relatorios')
                                    ->label('Relatórios'),

                                Forms\Components\Checkbox::make('menu_relatorios_pagto_aprovados')
                                    ->label('Pagto Aprovados'),

                                Forms\Components\Checkbox::make('menu_relatorios_pagto_em_aberto')
                                    ->label('Pagto em Aberto'),

                                Forms\Components\Checkbox::make('menu_relatorios_versao_do_sistema')
                                    ->label('Versão do Sistema'),

                                Forms\Components\Checkbox::make('menu_relatorios_log_faturas_e_servicos')
                                    ->label('Log Faturas e Serviços'),

                                Forms\Components\Checkbox::make('menu_relatorios_servicos_contratados')
                                    ->label('Serviços Contratados'),

                                Forms\Components\Checkbox::make('menu_relatorios_tickets_dev_prazo')
                                    ->label('Tickets Dev. Prazo'),

                                Forms\Components\Checkbox::make('menu_relatorios_list_cliente_chamados_nos_ultimos_20_dias')
                                    ->label('List. Cliente Chamados nos últimos 20 dias'),

                                Forms\Components\Checkbox::make('ver_remuneracoes')
                                    ->label('Ver Remunerações'),

                                Forms\Components\Checkbox::make('lancamento_de_remuneracao')
                                    ->label('Lançamento de Remuneração'),

                                Forms\Components\Checkbox::make('ticket_desenvolvimento')
                                    ->label('Ticket Desenvolvimento'),

                                Forms\Components\Checkbox::make('menu_prioridade_de_tickets')
                                    ->label('Prioridade de Tickets'),

                                Forms\Components\Checkbox::make('alterar_prioridade_de_ticket')
                                    ->label('Alterar Prioridade de Ticket'),

                                Forms\Components\Checkbox::make('atualizacoes')
                                    ->label('Atualizações'),

                                Forms\Components\Checkbox::make('clientes_versoes')
                                    ->label('Clientes Versões'),

                                Forms\Components\Checkbox::make('arquivos')
                                    ->label('Arquivos'),

                                Forms\Components\Checkbox::make('marketing')
                                    ->label('Marketing'),

                                Forms\Components\Checkbox::make('configuracoes')
                                    ->label('Configurações'),

                                Forms\Components\Checkbox::make('configuracoes_representantes')
                                    ->label('Representantes'),

                                Forms\Components\Checkbox::make('configuracoes_versao_do_sistema')
                                    ->label('Versão do Sistema'),
                            ]),
                        // Menu de Acesso
                        Forms\Components\Section::make('Menu Acesso')
                            ->schema([
                                Forms\Components\Checkbox::make('menu_acesso')
                                    ->label('Menu Acesso'),

                                Forms\Components\Checkbox::make('menu_acesso_usuarios')
                                    ->label('Usuários'),

                                Forms\Components\Checkbox::make('menu_acesso_perfil')
                                    ->label('Perfil'),
                            ])
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Nome')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Cadastrado em')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Atualizado em')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
