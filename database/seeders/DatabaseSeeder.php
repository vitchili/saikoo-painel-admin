<?php

namespace Database\Seeders;

use App\Models\Chamado\DepartamentoChamado;
use App\Models\Chamado\MeioAberturaChamado;
use App\Models\Chamado\SituacaoChamado;
use App\Models\Chamado\TipoChamado;
use App\Models\Cliente\Contato\TipoContatoComCliente;
use App\Models\Cliente\Servico\TipoServicoCliente;
use App\Models\Cliente\TicketDesenvolvimento\TipoProjetoTicketDesenvolvimento;
use App\Models\Cliente\TipoCliente;
use App\Models\Cliente\TipoContatoPessoaCliente;
use App\Models\Cliente\TipoRedeSocialCliente;
use App\Models\ConfiguracaoReajusteMassa;
use App\Models\Diversos\Modulo;
use App\Models\Diversos\Sistema;
use App\Models\Diversos\Tela;
use App\Models\Diversos\Veiculo;
use App\Models\Implantacao\ModeloImplantacao;
use App\Models\Implantacao\TelaTopicoModeloImplantacao;
use App\Models\Implantacao\TopicoModeloImplantacao;
use App\Models\Lembrete\PeriodicidadeLembrete;
use App\Models\Permission;
use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->geraBancos();

        $this->geraSistemas();

        $this->geraConfigIndiceReajuste();
        
        TipoProjetoTicketDesenvolvimento::create([
            'nome' => 'Sistema',
        ]);

        TipoProjetoTicketDesenvolvimento::create([
            'nome' => 'Website',
        ]);

        TipoProjetoTicketDesenvolvimento::create([
            'nome' => 'Desenvolvimento Interno',
        ]);

        /* PeriodicidadeLembrete do chamado */
        PeriodicidadeLembrete::create([
            'nome' => 'Atípico',
        ]);

        PeriodicidadeLembrete::create([
            'nome' => 'Diário',
        ]);

        PeriodicidadeLembrete::create([
            'nome' => 'Semanal',
        ]);

        PeriodicidadeLembrete::create([
            'nome' => 'Quinzenal',
        ]);

        PeriodicidadeLembrete::create([
            'nome' => 'Mensal',
        ]);

        PeriodicidadeLembrete::create([
            'nome' => 'Anual',
        ]);

        /* Departamento do chamado */
        DepartamentoChamado::create([
            'nome' => 'Suporte',
        ]);

        DepartamentoChamado::create([
            'nome' => 'Implantação',
        ]);

        DepartamentoChamado::create([
            'nome' => 'Comercial',
        ]);

        DepartamentoChamado::create([
            'nome' => 'Financeiro',
        ]);

        DepartamentoChamado::create([
            'nome' => 'Web',
        ]);

        /* MeioAbertura do chamado */
        MeioAberturaChamado::create([
            'nome' => 'Treinamento',
        ]);

        MeioAberturaChamado::create([
            'nome' => 'Email',
        ]);

        MeioAberturaChamado::create([
            'nome' => 'Saikoo Workspace',
        ]);

        MeioAberturaChamado::create([
            'nome' => 'Webite',
        ]);

        MeioAberturaChamado::create([
            'nome' => 'Telefone',
        ]);

        /* Tipos Clientes */

        TipoCliente::create([
            'nome' => 'Sistema',
        ]);

        TipoCliente::create([
            'nome' => 'Web',
        ]);

        TipoCliente::create([
            'nome' => 'Sistema & Web',
        ]);

        /**
         * TipoContatoPessoaCliente
         */

        TipoContatoPessoaCliente::create([
            'nome' => 'Comercial',
        ]);

        TipoContatoPessoaCliente::create([
            'nome' => 'Diretoria',
        ]);

        TipoContatoPessoaCliente::create([
            'nome' => 'Financeiro',
        ]);

        TipoContatoPessoaCliente::create([
            'nome' => 'Gerência',
        ]);

        TipoContatoPessoaCliente::create([
            'nome' => 'Outros',
        ]);
        
        TipoContatoPessoaCliente::create([
            'nome' => 'RH',
        ]);

        TipoContatoPessoaCliente::create([
            'nome' => 'TI',
        ]);

        /** Tipo Rede Social */
        TipoRedeSocialCliente::create([
            'nome' => 'Facebook',
        ]);

        TipoRedeSocialCliente::create([
            'nome' => 'Github',
        ]);

        TipoRedeSocialCliente::create([
            'nome' => 'Instagram',
        ]);

        TipoRedeSocialCliente::create([
            'nome' => 'Linkedin',
        ]);

        TipoRedeSocialCliente::create([
            'nome' => 'Outros',
        ]);
        
        TipoRedeSocialCliente::create([
            'nome' => 'Telegram',
        ]);
        
        TipoRedeSocialCliente::create([
            'nome' => 'Whatsapp',
        ]);
        
        TipoRedeSocialCliente::create([
            'nome' => 'X',
        ]);

        /** Veiculos */

        Veiculo::create([
            'tipo' => 'Carro',
            'nome' => 'GOL G6 1.0',
            'placa' => 'OBD 3172',
        ]);

        Veiculo::create([
            'tipo' => 'Moto',
            'nome' => 'Fan 125',
            'placa' => 'QCP 6694',
        ]);
        
        Veiculo::create([
            'tipo' => 'Moto',
            'nome' => 'V. Pessoal',
            'placa' => 'Outros',
        ]);
        
        Veiculo::create([
            'tipo' => 'Carro',
            'nome' => 'V. Pessoal',
            'placa' => 'Outros',
        ]);
        
        Veiculo::create([
            'tipo' => 'Carro',
            'nome' => 'Ônibus',
            'placa' => 'Outros',
        ]);

        /** Tipo Servico Cliente */

        TipoServicoCliente::create([
            'nome' => 'Sistemas',
        ]);
        TipoServicoCliente::create([
            'nome' => 'Desenvolvimento de website',
        ]);
        TipoServicoCliente::create([
            'nome' => 'Email Marketing',
        ]);
        TipoServicoCliente::create([
            'nome' => 'Registro de domínio',
        ]);
        TipoServicoCliente::create([
            'nome' => 'Hospedagem de sites',
        ]);
        TipoServicoCliente::create([
            'nome' => 'Serviço de informática',
        ]);
        TipoServicoCliente::create([
            'nome' => 'Emissão de NF-e',
        ]);
        TipoServicoCliente::create([
            'nome' => 'Emissão de NFS-e',
        ]);
        TipoServicoCliente::create([
            'nome' => 'Emissão de NFC-e',
        ]);
        TipoServicoCliente::create([
            'nome' => 'Envio de SMS - MODEM',
        ]);
        TipoServicoCliente::create([
            'nome' => 'Mobile',
        ]);
        TipoServicoCliente::create([
            'nome' => 'Sped Fiscal',
        ]);
        TipoServicoCliente::create([
            'nome' => 'Outros',
        ]);
        TipoServicoCliente::create([
            'nome' => 'Módulo Fiscal Completo (NFC-e, NF-e, NFS-e e Sped Fiscal)',
        ]);
        TipoServicoCliente::create([
            'nome' => 'MICROTERMINAL DE COMANDA - FIT BÁSICO - BEMATECH',
        ]);
        TipoServicoCliente::create([
            'nome' => 'TERMINAL DE COMANDA - TOUCH SCREEN',
        ]);
        TipoServicoCliente::create([
            'nome' => 'INSTALAÇÃO, TREINAMENTO E PARAMETRIZAÇÃO',
        ]);
        TipoServicoCliente::create([
            'nome' => 'STREAMING DE ÁUDIO (AO VIVO)',
        ]);
        TipoServicoCliente::create([
            'nome' => 'Módulo Fiscal de Produto Completo (NFC-e, NF-e e SPED FISCAL)',
        ]);
        TipoServicoCliente::create([
            'nome' => 'NFC-e ou Cupom Fiscal + NFS-e + SPED FISCAL',
        ]);
        TipoServicoCliente::create([
            'nome' => 'Módulo Fiscal de Produto (NFC-e e NF-e)',
        ]);
        TipoServicoCliente::create([
            'nome' => 'ADESÃO Agenda Online',
        ]);
        TipoServicoCliente::create([
            'nome' => 'Treinamento Online',
        ]);
        TipoServicoCliente::create([
            'nome' => 'Suporte Telefônico',
        ]);
        TipoServicoCliente::create([
            'nome' => 'CUPOM FISCAL + NFS-E',
        ]);
        TipoServicoCliente::create([
            'nome' => 'Hospedagem de sites Básico 1GB',
        ]);
        TipoServicoCliente::create([
            'nome' => 'Hospedagem de sites Avançado 3GB',
        ]);
        TipoServicoCliente::create([
            'nome' => 'Hospedagem de sites Premium 10GB',
        ]);
        TipoServicoCliente::create([
            'nome' => 'Registro de domínio internacional',
        ]);
        TipoServicoCliente::create([
            'nome' => 'Registro de domínio Nacional',
        ]);
        TipoServicoCliente::create([
            'nome' => 'NFC-e + NFS-e',
        ]);
        TipoServicoCliente::create([
            'nome' => 'TERMINAL DE COMANDA - TABLET',
        ]);
        TipoServicoCliente::create([
            'nome' => 'BACKUP ONLINE',
        ]);
        TipoServicoCliente::create([
            'nome' => 'TERMINAL DE LANÇAMENTO NA COMANDA',
        ]);
        TipoServicoCliente::create([
            'nome' => 'PROFISSIONAL - SAIKOO SISTEMAS',
        ]);
        TipoServicoCliente::create([
            'nome' => 'PROFISSIONAL TEF COM SPLIT - SAIKOO SISTEMAS',
        ]);
        TipoServicoCliente::create([
            'nome' => 'TEF COM SPLIT',
        ]);
        TipoServicoCliente::create([
            'nome' => 'SITE PRONTO',
        ]);
        TipoServicoCliente::create([
            'nome' => 'IMPLANTAÇÃO E PARAMETRIZAÇÃO DE MODULO OPCIONAL',
        ]);
        TipoServicoCliente::create([
            'nome' => 'E-commerce/Venda Online',
        ]);
        TipoServicoCliente::create([
            'nome' => 'LICENÇA DE WEBSITE',
        ]);
        TipoServicoCliente::create([
            'nome' => 'ADESÃO DE WEBSITE',
        ]);
        TipoServicoCliente::create([
            'nome' => 'PROJETO SISTEMA WEB',
        ]);
        TipoServicoCliente::create([
            'nome' => 'BANCO DE DADOS SQL SERVER ONLINE 200 MB ',
        ]);
        TipoServicoCliente::create([
            'nome' => 'BANCO DE DADOS SQL SERVER ONLINE 350 MB ',
        ]);
        TipoServicoCliente::create([
            'nome' => 'BANCO DE DADOS SQL SERVER ONLINE 500 MB ',
        ]);
        TipoServicoCliente::create([
            'nome' => 'TREINAMENTO COMERCIAL - AGENTE DE VENDAS',
        ]);
        TipoServicoCliente::create([
            'nome' => 'CRÉDITO DE SMS',
        ]);
        TipoServicoCliente::create([
            'nome' => 'MÓDULO FISCAL PRODUTO E SERVIÇO (SAT, NF-E E NFS-E OU NFC-E, NF-E E NFS-E)',
        ]);
        TipoServicoCliente::create([
            'nome' => 'SISTEMA DE GERENCIAMENTO DE BOLETOS',
        ]);
        TipoServicoCliente::create([
            'nome' => 'IP FIXO - DDNS',
        ]);
        TipoServicoCliente::create([
            'nome' => 'Envio de SMS - Adesão',
        ]);
        TipoServicoCliente::create([
            'nome' => 'ENVIO DE SMS - WEBSERVICE',
        ]);
        TipoServicoCliente::create([
            'nome' => 'SMS - ACIMA DE 2000 Unidades',
        ]);
        TipoServicoCliente::create([
            'nome' => 'SMS - ENTRE 01 ATÉ 1999 SMS UNIDADES',
        ]);
        TipoServicoCliente::create([
            'nome' => 'EMISSÃO DE NFS-E - SALÃO PARCEIRO',
        ]);
        TipoServicoCliente::create([
            'nome' => 'APLICATIVO',
        ]);
        TipoServicoCliente::create([
            'nome' => 'HOSPEDAGEM CLOUD',
        ]);
        TipoServicoCliente::create([
            'nome' => 'SMS marketing mobile landing page',
        ]);
        TipoServicoCliente::create([
            'nome' => 'LICENÇA DE USO, SUPORTE E MANUTENÇÃO AO APLICATIVO (APP)',
        ]);
        TipoServicoCliente::create([
            'nome' => 'SAIKOO START',
        ]);
        TipoServicoCliente::create([
            'nome' => 'Transferência de Domínios',
        ]);
        TipoServicoCliente::create([
            'nome' => 'ONDA ELEITORAL - PLATAFORMA WEB',
        ]);
        TipoServicoCliente::create([
            'nome' => 'SAIKOO DELIVERY - LICENÇA DE USO',
        ]);
        TipoServicoCliente::create([
            'nome' => 'ADESÃO SAIKOO DELIVERY',
        ]);
        TipoServicoCliente::create([
            'nome' => 'LICENÇA DE USO - SISTEMA GESTÃO DE MANDATO',
        ]);
        TipoServicoCliente::create([
            'nome' => 'ADESÃO - SISTEMA GESTÃO DE MANDATO',
        ]);
        TipoServicoCliente::create([
            'nome' => 'LICENÇA DE USO - AGENDA ONLINE',
        ]);
        TipoServicoCliente::create([
            'nome' => 'Treinamento Poder Ativo',
        ]);
        TipoServicoCliente::create([
            'nome' => 'Agenda Online',
        ]);
        TipoServicoCliente::create([
            'nome' => 'PODER ATIVO - PLATAFORMA',
        ]);
        TipoServicoCliente::create([
            'nome' => 'E-mail',
        ]);
        TipoServicoCliente::create([
            'nome' => 'SAIKOO BTECH',
        ]);
        TipoServicoCliente::create([
            'nome' => 'Upgrade de Plano de Hospedagem de Sites',
        ]);
        TipoServicoCliente::create([
            'nome' => 'HOSPEDAGEM DE SITES PROFISSIONAL 5GB',
        ]);
        TipoServicoCliente::create([
            'nome' => 'SAIKOOZAP',
        ]);
        TipoServicoCliente::create([
            'nome' => 'SAIKOOZAP - CRÉDITO PUSH',
        ]);
        TipoServicoCliente::create([
            'nome' => 'HOSPEDAGEM DE SITES WD HOST 01 | 1GB',
        ]);
        TipoServicoCliente::create([
            'nome' => 'HOSPEDAGEM DE SITES WD HOST 02 | 3GB',
        ]);
        TipoServicoCliente::create([
            'nome' => 'HOSPEDAGEM DE SITES WD HOST 03 | 5GB',
        ]);
        TipoServicoCliente::create([
            'nome' => 'HOSPEDAGEM DE SITES WD HOST 04 | 10GB',
        ]);
        TipoServicoCliente::create([
            'nome' => 'HOSPEDAGEM DE SITES WD HOST 05 | 20GB',
        ]);
        TipoServicoCliente::create([
            'nome' => 'HOSPEDAGEM DE SITES WD HOST 06 | 30GB',
        ]);
        TipoServicoCliente::create([
            'nome' => 'HOSPEDAGEM DE SITES WD HOST 07 | 40GB',
        ]);
        TipoServicoCliente::create([
            'nome' => 'HOSPEDAGEM DE SITES WD HOST 08 | 50GB',
        ]);
        TipoServicoCliente::create([
            'nome' => 'HOSPEDAGEM DE SITES WD HOST 09 | 75GB',
        ]);
        TipoServicoCliente::create([
            'nome' => 'HOSPEDAGEM DE SITES WD HOST 10 | 100GB',
        ]);
        TipoServicoCliente::create([
            'nome' => 'SAIKOOZAP - Workspace - Licença de Uso',
        ]);
        TipoServicoCliente::create([
            'nome' => 'SAIKOOZAP - Workspace - Adesão',
        ]);
        TipoServicoCliente::create([
            'nome' => 'VOIP',
        ]);

        /** Tipo Chamado */
        TipoChamado::create([
            'nome' => 'Interno',
        ]);
        TipoChamado::create([
            'nome' => 'Interno com Cliente',
        ]);
        TipoChamado::create([
            'nome' => 'Externo',
        ]);

        //Tipo Contato com Cliente
        TipoContatoComCliente::create([
            'nome' => 'Telefone',
        ]);
        TipoContatoComCliente::create([
            'nome' => 'Visita',
        ]);
        TipoContatoComCliente::create([
            'nome' => 'Cobranca',
        ]);

        //Permissoes
        Permission::create([
            'name' => 'Cobranca',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'Mostrar valor tela atendimento',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Pedidos Realizados',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Dashboard Suporte',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Dashboard BHair',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Menu Clientes',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Menu Cliente.Cadastrar Cliente',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Menu Cliente.Dados',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Menu Cliente.Dados.Status Cliente',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Menu Cliente.Dados.Alterar Termos',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Menu Cliente.Dados.Enviar Boas Vindas',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Menu Cliente.Dados.Senha Cliente',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Menu Cliente.Dados.Ver Dados Bancários',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Faturas',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Faturas.Alterar status da fatura',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Faturas.Reprocessar Serial',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Faturas.Cadastrar faturas',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Faturas.Alterar fatura',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Faturas.Excluir fatura',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Serial',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Serial.Gerar serial temporário com limite excedido',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Serviços',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Serviços.Adicionar Serviços',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Serviços.Excluir Serviços',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Serviços.Alterar Serviços',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Serviços.Alterar Serviços (Versão)',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Serviços.Alterar Serviços (Implantação)',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Serviços.Serviços (Log)',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Serviços.Visualizar Serviços',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Serviços.Gerar Serial Serviços',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Nº Profissionais',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Saikoo Web',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Manual de Implantação',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Relato de implantação',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Contatos com o cliente',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Propostas',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Menu Ata de reunião',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Cadastrar Ata de reunião',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Menu Chamado',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Menu Agenda',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Menu CI',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Menu Relatórios',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Menu Relatórios.Pagto aprovados',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Menu Relatórios.Pagto em aberto',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Menu Relatórios.Versão do sistema',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Menu Relatórios.Log Faturas e Serviços',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Menu Relatórios.Serviços contratados',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Menu Relatórios.Tickets Dev. Prazo',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Menu Relatórios.List. cliente chamados nos últimos 20 dias',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Ver Remunerações',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Lançamento de Remuneração',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Ticket Desenvolvimento',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Menu prioridade de tickets',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Alterar prioridade de ticket',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Atualizações',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Clientes Versões',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Arquivos',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Marketing',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Configurações',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Configurações.Representantes',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Configurações.Versão do sistema',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Cadastros',
        ]);
        Permission::create([
            'name' => 'Menu Acesso',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Menu Acesso.Usuários',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'Menu Acesso.Perfil',
            'guard_name' => 'web',
        ]);

        //Perfis Acesso

        Role::create([
            'name' => 'Suporte TI',
            'guard_name' => 'web',
        ]);
        Role::create([
            'name' => 'Gerente',
            'guard_name' => 'web',
        ]);
        Role::create([
            'name' => 'Financeiro',
            'guard_name' => 'web',
        ]);
        Role::create([
            'name' => 'Desenvolvedor',
            'guard_name' => 'web',
        ]);
        Role::create([
            'name' => 'Comercial Interno',
            'guard_name' => 'web',
        ]);
        Role::create([
            'name' => 'Diretor(a)',
            'guard_name' => 'web',
        ]);
        Role::create([
            'name' => 'Web Master',
            'guard_name' => 'web',
        ]);
        Role::create([
            'name' => 'Em treinamento',
            'guard_name' => 'web',
        ]);
        Role::create([
            'name' => 'REPRESENTANTE',
            'guard_name' => 'web',
        ]);
        Role::create([
            'name' => 'Coordenador',
            'guard_name' => 'web',
        ]);
        Role::create([
            'name' => 'REPRESENTANTE MEIOS DE PAGAMENTO',
            'guard_name' => 'web',
        ]);
        Role::create([
            'name' => 'Comercial Interno Trainee',
            'guard_name' => 'web',
        ]);
        Role::create([
            'name' => 'Bhair',
            'guard_name' => 'web',
        ]);

        //Modelo Implantacao
        ModeloImplantacao::create([
            'nome' => 'Saikoo Implantação'
        ]);

        //Topicos Modelo Implantacao
        TopicoModeloImplantacao::create([
            'modelo_id' => 1,
            'nome' => 'Cadastro',
            'descricao' => 'Módulo I',
        ]);

        TopicoModeloImplantacao::create([
            'modelo_id' => 1,
            'nome' => 'Atendimento',
            'descricao' => 'Módulo II',
        ]);

        TopicoModeloImplantacao::create([
            'modelo_id' => 1,
            'nome' => 'Comissão',
            'descricao' => 'Módulo III',
        ]);

        TopicoModeloImplantacao::create([
            'modelo_id' => 1,
            'nome' => 'Estoque',
            'descricao' => 'Módulo IV',
        ]);

        TopicoModeloImplantacao::create([
            'modelo_id' => 1,
            'nome' => 'Financeiro',
            'descricao' => 'Módulo V',
        ]);

        TopicoModeloImplantacao::create([
            'modelo_id' => 1,
            'nome' => 'Relatório',
            'descricao' => 'Módulo VI',
        ]);

        //Telas

        TelaTopicoModeloImplantacao::create([
            'topico_id' => 1,
            'nome' => 'Perfil de Acesso'
        ]);
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 1,
            'nome' => 'Usuário do Sistema'
        ]);
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 1,
            'nome' => 'Pessoa Física'
        ]);
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 1,
            'nome' => 'Pessoa Jurídica'
        ]);
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 1,
            'nome' => 'Profissionais'
        ]);
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 1,
            'nome' => 'Produtos'
        ]);
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 1,
            'nome' => 'Serviços'
        ]);
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 1,
            'nome' => 'Serviço Auxiliar'
        ]);
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 1,
            'nome' => 'Treinamento de Pacotes'
        ]);
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 1,
            'nome' => 'Explicar como gerar BACKUP pelo sistema'
        ]);
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 1,
            'nome' => 'Explicar como gerar BOLETO para pagamento'
        ]);

        TelaTopicoModeloImplantacao::create([
            'topico_id' => 2, 
            'nome' => 'Configuração dos Parâmetros'
        ]);	
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 2, 
            'nome' => 'Configurar Comissões'
        ]);	
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 2, 
            'nome' => 'Cadastro dos Caixas'
        ]);	
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 2, 
            'nome' => 'Abertura de Caixa'
        ]);	
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 2, 
            'nome' => 'Fechamento de Caixa'
        ]);	
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 2, 
            'nome' => 'Suprimento'
        ]);	
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 2, 
            'nome' => 'Sangria de Caixa'
        ]);	
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 2, 
            'nome' => 'Contas a Receber (levantar necessidade)'
        ]);	
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 2, 
            'nome' => 'Lançamento das Comandas'
        ]);	
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 2, 
            'nome' => 'Comandas Finalizada'
        ]);	
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 2, 
            'nome' => 'Agenda de Horários'
        ]);	
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 2, 
            'nome' => 'Gestão de Clientes'
        ]);	
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 2, 
            'nome' => 'Orçamento'
        ]);

        TelaTopicoModeloImplantacao::create([
            'topico_id' => 3, 
            'nome' => 'Pagamento de Adiantamento'
        ]);	
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 3, 
            'nome' => 'Relatório de Comissão (Opcional Consulta em Tela)'
        ]);	
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 3, 
            'nome' => 'Pagamento de Comissão Individual ou em Lote'
        ]);
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 3, 
            'nome' => 'Pagamento de Contas'
        ]);

        TelaTopicoModeloImplantacao::create([
            'topico_id' => 4,
            'nome' => 'Inventário de Produtos'
        ]);
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 4,
            'nome' => 'Entrada de Produtos (Nota Fiscal)'
        ]);
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 4,
            'nome' => 'Saída de produtos'
        ]);

        TelaTopicoModeloImplantacao::create([
            'topico_id' => 5,
            'nome' => 'Contas a Pagar'
        ]);
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 5,
            'nome' => 'Pagamentos de Contas'
        ]);
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 5,
            'nome' => 'Estornos de Pagamentos'
        ]);
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 5,
            'nome' => 'Depósito de Cheques Recebidos'
        ]);
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 5,
            'nome' => 'Devolução de Cheques Depositados'
        ]);
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 5,
            'nome' => 'Negociação de Cheques'
        ]);
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 5,
            'nome' => 'Movimentações em Conta'
        ]);
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 5,
            'nome' => 'Recebimento de Cartão de Crédito'
        ]);

        TelaTopicoModeloImplantacao::create([
            'topico_id' => 6,
            'nome' => 'Relatórios de Cadastro'
        ]);
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 6,
            'nome' => 'Relatórios de Agenda de Horário'
        ]);
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 6,
            'nome' => 'Relatórios de Comandas e Venda'
        ]);
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 6,
            'nome' => 'Relatório de Caixa'
        ]);
        TelaTopicoModeloImplantacao::create([
            'topico_id' => 6,
            'nome' => 'Relatório de Financeiro'
        ]);
    }

    /**
     * Gera todos bancos a utilizar na aplicacao
     */
    public function geraBancos(): void
    {
        \App\Models\Banco::create([
            "ispb" => "00000000",
            "nome" => "BCO DO BRASIL S.A.",
            "codigo" => '001',
            "nome_completo" => "Banco do Brasil S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "00000208",
            "nome" => "BRB - BCO DE BRASILIA S.A.",
            "codigo" => '070',
            "nome_completo" => "BRB - BANCO DE BRASILIA S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "00122327",
            "nome" => "SANTINVEST S.A. - CFI",
            "codigo" => '539',
            "nome_completo" => "SANTINVEST S.A. - CREDITO, FINANCIAMENTO E INVESTIMENTOS"
        ]);
        \App\Models\Banco::create([
            "ispb" => "00204963",
            "nome" => "CCR SEARA",
            "codigo" => '430',
            "nome_completo" => "COOPERATIVA DE CREDITO RURAL SEARA - CREDISEARA"
        ]);
        \App\Models\Banco::create([
            "ispb" => "00250699",
            "nome" => "AGK CC S.A.",
            "codigo" => '272',
            "nome_completo" => "AGK CORRETORA DE CAMBIO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "00315557",
            "nome" => "CONF NAC COOP CENTRAIS UNICRED",
            "codigo" => '136',
            "nome_completo" => "CONFEDERAÇÃO NACIONAL DAS COOPERATIVAS CENTRAIS UNICRED LTDA. - UNICRED DO BRASI"
        ]);
        \App\Models\Banco::create([
            "ispb" => "00329598",
            "nome" => "ÍNDIGO INVESTIMENTOS DTVM LTDA.",
            "codigo" => '407',
            "nome_completo" => "ÍNDIGO INVESTIMENTOS DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIÁRIOS LTDA."
        ]);
        \App\Models\Banco::create([
            "ispb" => "00360305",
            "nome" => "CAIXA ECONOMICA FEDERAL",
            "codigo" => '104',
            "nome_completo" => "CAIXA ECONOMICA FEDERAL"
        ]);
        \App\Models\Banco::create([
            "ispb" => "00416968",
            "nome" => "BANCO INTER",
            "codigo" => '077',
            "nome_completo" => "Banco Inter S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "00460065",
            "nome" => "COLUNA S.A. DTVM",
            "codigo" => '423',
            "nome_completo" => "COLUNA S/A DISTRIBUIDORA DE TITULOS E VALORES MOBILIÁRIOS"
        ]);
        \App\Models\Banco::create([
            "ispb" => "00517645",
            "nome" => "BCO RIBEIRAO PRETO S.A.",
            "codigo" => '741',
            "nome_completo" => "BANCO RIBEIRAO PRETO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "00556603",
            "nome" => "BANCO BARI S.A.",
            "codigo" => '330',
            "nome_completo" => "BANCO BARI DE INVESTIMENTOS E FINANCIAMENTOS S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "00558456",
            "nome" => "BCO CETELEM S.A.",
            "codigo" => '739',
            "nome_completo" => "Banco Cetelem S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "00714671",
            "nome" => "EWALLY IP S.A.",
            "codigo" => '534',
            "nome_completo" => "EWALLY INSTITUIÇÃO DE PAGAMENTO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "00795423",
            "nome" => "BANCO SEMEAR",
            "codigo" => '743',
            "nome_completo" => "Banco Semear S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "00806535",
            "nome" => "PLANNER CV S.A.",
            "codigo" => '100',
            "nome_completo" => "Planner Corretora de Valores S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "00954288",
            "nome" => "FDO GARANTIDOR CRÉDITOS",
            "codigo" => '541',
            "nome_completo" => "FUNDO GARANTIDOR DE CREDITOS - FGC"
        ]);
        \App\Models\Banco::create([
            "ispb" => "00997185",
            "nome" => "BCO B3 S.A.",
            "codigo" => '096',
            "nome_completo" => "Banco B3 S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "01023570",
            "nome" => "BCO RABOBANK INTL BRASIL S.A.",
            "codigo" => '747',
            "nome_completo" => "Banco Rabobank International Brasil S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "01027058",
            "nome" => "CIELO IP S.A.",
            "codigo" => '362',
            "nome_completo" => "CIELO S.A. - INSTITUIÇÃO DE PAGAMENTO"
        ]);
        \App\Models\Banco::create([
            "ispb" => "01073966",
            "nome" => "CCR DE ABELARDO LUZ",
            "codigo" => '322',
            "nome_completo" => "Cooperativa de Crédito Rural de Abelardo Luz - Sulcredi/Crediluz"
        ]);
        \App\Models\Banco::create([
            "ispb" => "01181521",
            "nome" => "BCO COOPERATIVO SICREDI S.A.",
            "codigo" => '748',
            "nome_completo" => "BANCO COOPERATIVO SICREDI S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "01330387",
            "nome" => "CREHNOR LARANJEIRAS",
            "codigo" => '350',
            "nome_completo" => "COOPERATIVA DE CRÉDITO RURAL DE PEQUENOS AGRICULTORES E DA REFORMA AGRÁRIA DO CE"
        ]);
        \App\Models\Banco::create([
            "ispb" => "01522368",
            "nome" => "BCO BNP PARIBAS BRASIL S A",
            "codigo" => '752',
            "nome_completo" => "Banco BNP Paribas Brasil S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "01658426",
            "nome" => "CECM COOPERFORTE",
            "codigo" => '379',
            "nome_completo" => "COOPERFORTE - COOPERATIVA DE ECONOMIA E CRÉDITO MÚTUO DE FUNCIONÁRIOS DE INSTITU"
        ]);
        \App\Models\Banco::create([
            "ispb" => "01701201",
            "nome" => "KIRTON BANK",
            "codigo" => '399',
            "nome_completo" => "Kirton Bank S.A. - Banco Múltiplo"
        ]);
        \App\Models\Banco::create([
            "ispb" => "01852137",
            "nome" => "BCO BRASILEIRO DE CRÉDITO S.A.",
            "codigo" => '378',
            "nome_completo" => "BANCO BRASILEIRO DE CRÉDITO SOCIEDADE ANÔNIMA"
        ]);
        \App\Models\Banco::create([
            "ispb" => "01858774",
            "nome" => "BCO BV S.A.",
            "codigo" => '413',
            "nome_completo" => "BANCO BV S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "02038232",
            "nome" => "BANCO SICOOB S.A.",
            "codigo" => '756',
            "nome_completo" => "BANCO COOPERATIVO SICOOB S.A. - BANCO SICOOB"
        ]);
        \App\Models\Banco::create([
            "ispb" => "02276653",
            "nome" => "TRINUS CAPITAL DTVM",
            "codigo" => '360',
            "nome_completo" => "TRINUS CAPITAL DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIÁRIOS S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "02318507",
            "nome" => "BCO KEB HANA DO BRASIL S.A.",
            "codigo" => '757',
            "nome_completo" => "BANCO KEB HANA DO BRASIL S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "02332886",
            "nome" => "XP INVESTIMENTOS CCTVM S/A",
            "codigo" => '102',
            "nome_completo" => "XP INVESTIMENTOS CORRETORA DE CÂMBIO,TÍTULOS E VALORES MOBILIÁRIOS S/A"
        ]);
        \App\Models\Banco::create([
            "ispb" => "02398976",
            "nome" => "SISPRIME DO BRASIL - COOP",
            "codigo" => '084',
            "nome_completo" => "SISPRIME DO BRASIL - COOPERATIVA DE CRÉDITO"
        ]);
        \App\Models\Banco::create([
            "ispb" => "02685483",
            "nome" => "CM CAPITAL MARKETS CCTVM LTDA",
            "codigo" => '180',
            "nome_completo" => "CM CAPITAL MARKETS CORRETORA DE CÂMBIO, TÍTULOS E VALORES MOBILIÁRIOS LTDA"
        ]);
        \App\Models\Banco::create([
            "ispb" => "02801938",
            "nome" => "BCO MORGAN STANLEY S.A.",
            "codigo" => '066',
            "nome_completo" => "BANCO MORGAN STANLEY S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "02819125",
            "nome" => "UBS BRASIL CCTVM S.A.",
            "codigo" => '015',
            "nome_completo" => "UBS Brasil Corretora de Câmbio, Títulos e Valores Mobiliários S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "02992317",
            "nome" => "TREVISO CC S.A.",
            "codigo" => '143',
            "nome_completo" => "Treviso Corretora de Câmbio S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "03012230",
            "nome" => "HIPERCARD BM S.A.",
            "codigo" => '062',
            "nome_completo" => "Hipercard Banco Múltiplo S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "03017677",
            "nome" => "BCO. J.SAFRA S.A.",
            "codigo" => '074',
            "nome_completo" => "Banco J. Safra S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "03046391",
            "nome" => "UNIPRIME COOPCENTRAL LTDA.",
            "codigo" => '099',
            "nome_completo" => "UNIPRIME CENTRAL NACIONAL - CENTRAL NACIONAL DE COOPERATIVA DE CREDITO"
        ]);
        \App\Models\Banco::create([
            "ispb" => "03215790",
            "nome" => "BCO TOYOTA DO BRASIL S.A.",
            "codigo" => '387',
            "nome_completo" => "Banco Toyota do Brasil S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "03311443",
            "nome" => "PARATI - CFI S.A.",
            "codigo" => '326',
            "nome_completo" => "PARATI - CREDITO, FINANCIAMENTO E INVESTIMENTO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "03323840",
            "nome" => "BCO ALFA S.A.",
            "codigo" => '025',
            "nome_completo" => "Banco Alfa S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "03532415",
            "nome" => "BCO ABN AMRO S.A.",
            "codigo" => '075',
            "nome_completo" => "Banco ABN Amro S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "03609817",
            "nome" => "BCO CARGILL S.A.",
            "codigo" => '040',
            "nome_completo" => "Banco Cargill S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "03751794",
            "nome" => "TERRA INVESTIMENTOS DTVM",
            "codigo" => '307',
            "nome_completo" => "Terra Investimentos Distribuidora de Títulos e Valores Mobiliários Ltda."
        ]);
        \App\Models\Banco::create([
            "ispb" => "03844699",
            "nome" => "CECM DOS TRAB.PORT. DA G.VITOR",
            "codigo" => '385',
            "nome_completo" => "COOPERATIVA DE ECONOMIA E CREDITO MUTUO DOS TRABALHADORES PORTUARIOS DA GRANDE V"
        ]);
        \App\Models\Banco::create([
            "ispb" => "03881423",
            "nome" => "SOCINAL S.A. CFI",
            "codigo" => '425',
            "nome_completo" => "SOCINAL S.A. - CRÉDITO, FINANCIAMENTO E INVESTIMENTO"
        ]);
        \App\Models\Banco::create([
            "ispb" => "03973814",
            "nome" => "SERVICOOP",
            "codigo" => '190',
            "nome_completo" => "SERVICOOP - COOPERATIVA DE CRÉDITO DOS SERVIDORES PÚBLICOS ESTADUAIS E MUNICIPAI"
        ]);
        \App\Models\Banco::create([
            "ispb" => "04062902",
            "nome" => "OZ CORRETORA DE CÂMBIO S.A.",
            "codigo" => '296',
            "nome_completo" => "OZ CORRETORA DE CÂMBIO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "04184779",
            "nome" => "BANCO BRADESCARD",
            "codigo" => '063',
            "nome_completo" => "Banco Bradescard S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "04257795",
            "nome" => "NOVA FUTURA CTVM LTDA.",
            "codigo" => '191',
            "nome_completo" => "Nova Futura Corretora de Títulos e Valores Mobiliários Ltda."
        ]);
        \App\Models\Banco::create([
            "ispb" => "04307598",
            "nome" => "FIDUCIA SCMEPP LTDA",
            "codigo" => '382',
            "nome_completo" => "FIDÚCIA SOCIEDADE DE CRÉDITO AO MICROEMPREENDEDOR E À EMPRESA DE PEQUENO PORTE L"
        ]);
        \App\Models\Banco::create([
            "ispb" => "04332281",
            "nome" => "GOLDMAN SACHS DO BRASIL BM S.A",
            "codigo" => '064',
            "nome_completo" => "GOLDMAN SACHS DO BRASIL BANCO MULTIPLO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "04546162",
            "nome" => "CCM SERV. PÚBLICOS SP",
            "codigo" => '459',
            "nome_completo" => "COOPERATIVA DE CRÉDITO MÚTUO DE SERVIDORES PÚBLICOS DO ESTADO DE SÃO PAULO - CRE"
        ]);
        \App\Models\Banco::create([
            "ispb" => "04632856",
            "nome" => "CREDISIS CENTRAL DE COOPERATIVAS DE CRÉDITO LTDA.",
            "codigo" => '097',
            "nome_completo" => "Credisis - Central de Cooperativas de Crédito Ltda."
        ]);
        \App\Models\Banco::create([
            "ispb" => "04715685",
            "nome" => "CCM DESP TRÂNS SC E RS",
            "codigo" => '016',
            "nome_completo" => "COOPERATIVA DE CRÉDITO MÚTUO DOS DESPACHANTES DE TRÂNSITO DE SANTA CATARINA E RI"
        ]);
        \App\Models\Banco::create([
            "ispb" => "04814563",
            "nome" => "BCO AFINZ S.A. - BM",
            "codigo" => '299',
            "nome_completo" => "BANCO AFINZ S.A. - BANCO MÚLTIPLO"
        ]);
        \App\Models\Banco::create([
            "ispb" => "04831810",
            "nome" => "CECM SERV PUBL PINHÃO",
            "codigo" => '471',
            "nome_completo" => "COOPERATIVA DE ECONOMIA E CREDITO MUTUO DOS SERVIDORES PUBLICOS DE PINHÃO - CRES"
        ]);
        \App\Models\Banco::create([
            "ispb" => "04862600",
            "nome" => "PORTOSEG S.A. CFI",
            "codigo" => '468',
            "nome_completo" => "PORTOSEG S.A. - CREDITO, FINANCIAMENTO E INVESTIMENTO"
        ]);
        \App\Models\Banco::create([
            "ispb" => "04866275",
            "nome" => "BANCO INBURSA",
            "codigo" => '012',
            "nome_completo" => "Banco Inbursa S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "04902979",
            "nome" => "BCO DA AMAZONIA S.A.",
            "codigo" => '003',
            "nome_completo" => "BANCO DA AMAZONIA S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "04913129",
            "nome" => "CONFIDENCE CC S.A.",
            "codigo" => '060',
            "nome_completo" => "Confidence Corretora de Câmbio S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "04913711",
            "nome" => "BCO DO EST. DO PA S.A.",
            "codigo" => '037',
            "nome_completo" => "Banco do Estado do Pará S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "05192316",
            "nome" => "VIA CERTA FINANCIADORA S.A. - CFI",
            "codigo" => '411',
            "nome_completo" => "Via Certa Financiadora S.A. - Crédito, Financiamento e Investimentos"
        ]);
        \App\Models\Banco::create([
            "ispb" => "05351887",
            "nome" => "ZEMA CFI S/A",
            "codigo" => '359',
            "nome_completo" => "ZEMA CRÉDITO, FINANCIAMENTO E INVESTIMENTO S/A"
        ]);
        \App\Models\Banco::create([
            "ispb" => "05442029",
            "nome" => "CASA CREDITO S.A. SCM",
            "codigo" => '159',
            "nome_completo" => "Casa do Crédito S.A. Sociedade de Crédito ao Microempreendedor"
        ]);
        \App\Models\Banco::create([
            "ispb" => "05463212",
            "nome" => "COOPCENTRAL AILOS",
            "codigo" => '085',
            "nome_completo" => "Cooperativa Central de Crédito - Ailos"
        ]);
        \App\Models\Banco::create([
            "ispb" => "05491616",
            "nome" => "COOP CREDITAG",
            "codigo" => '400',
            "nome_completo" => "COOPERATIVA DE CRÉDITO, POUPANÇA E SERVIÇOS FINANCEIROS DO CENTRO OESTE - CREDIT"
        ]);
        \App\Models\Banco::create([
            "ispb" => "05676026",
            "nome" => "CREDIARE CFI S.A.",
            "codigo" => '429',
            "nome_completo" => "Crediare S.A. - Crédito, financiamento e investimento"
        ]);
        \App\Models\Banco::create([
            "ispb" => "05684234",
            "nome" => "PLANNER SOCIEDADE DE CRÉDITO DIRETO",
            "codigo" => '410',
            "nome_completo" => "PLANNER SOCIEDADE DE CRÉDITO DIRETO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "05790149",
            "nome" => "CENTRAL COOPERATIVA DE CRÉDITO NO ESTADO DO ESPÍRITO SANTO",
            "codigo" => '114',
            "nome_completo" => "Central Cooperativa de Crédito no Estado do Espírito Santo - CECOOP"
        ]);
        \App\Models\Banco::create([
            "ispb" => "05841967",
            "nome" => "CECM FABRIC CALÇADOS SAPIRANGA",
            "codigo" => '328',
            "nome_completo" => "COOPERATIVA DE ECONOMIA E CRÉDITO MÚTUO DOS FABRICANTES DE CALÇADOS DE SAPIRANGA"
        ]);
        \App\Models\Banco::create([
            "ispb" => "06271464",
            "nome" => "BCO BBI S.A.",
            "codigo" => '036',
            "nome_completo" => "Banco Bradesco BBI S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "07138049",
            "nome" => "LIGA INVEST DTVM LTDA.",
            "codigo" => '469',
            "nome_completo" => "LIGA INVEST DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIÁRIOS LTDA"
        ]);
        \App\Models\Banco::create([
            "ispb" => "07207996",
            "nome" => "BCO BRADESCO FINANC. S.A.",
            "codigo" => '394',
            "nome_completo" => "Banco Bradesco Financiamentos S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "07237373",
            "nome" => "BCO DO NORDESTE DO BRASIL S.A.",
            "codigo" => '004',
            "nome_completo" => "Banco do Nordeste do Brasil S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "07253654",
            "nome" => "HEDGE INVESTMENTS DTVM LTDA.",
            "codigo" => '458',
            "nome_completo" => "HEDGE INVESTMENTS DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIÁRIOS LTDA."
        ]);
        \App\Models\Banco::create([
            "ispb" => "07450604",
            "nome" => "BCO CCB BRASIL S.A.",
            "codigo" => '320',
            "nome_completo" => "China Construction Bank (Brasil) Banco Múltiplo S/A"
        ]);
        \App\Models\Banco::create([
            "ispb" => "07512441",
            "nome" => "HS FINANCEIRA",
            "codigo" => '189',
            "nome_completo" => "HS FINANCEIRA S/A CREDITO, FINANCIAMENTO E INVESTIMENTOS"
        ]);
        \App\Models\Banco::create([
            "ispb" => "07652226",
            "nome" => "LECCA CFI S.A.",
            "codigo" => '105',
            "nome_completo" => "Lecca Crédito, Financiamento e Investimento S/A"
        ]);
        \App\Models\Banco::create([
            "ispb" => "07656500",
            "nome" => "BCO KDB BRASIL S.A.",
            "codigo" => '076',
            "nome_completo" => "Banco KDB do Brasil S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "07679404",
            "nome" => "BANCO TOPÁZIO S.A.",
            "codigo" => '082',
            "nome_completo" => "BANCO TOPÁZIO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "07693858",
            "nome" => "HSCM SCMEPP LTDA.",
            "codigo" => '312',
            "nome_completo" => "HSCM - SOCIEDADE DE CRÉDITO AO MICROEMPREENDEDOR E À EMPRESA DE PEQUENO PORTE LT"
        ]);
        \App\Models\Banco::create([
            "ispb" => "07799277",
            "nome" => "VALOR SCD S.A.",
            "codigo" => '195',
            "nome_completo" => "VALOR SOCIEDADE DE CRÉDITO DIRETO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "07945233",
            "nome" => "POLOCRED SCMEPP LTDA.",
            "codigo" => '093',
            "nome_completo" => "PÓLOCRED   SOCIEDADE DE CRÉDITO AO MICROEMPREENDEDOR E À EMPRESA DE PEQUENO PORT"
        ]);
        \App\Models\Banco::create([
            "ispb" => "08240446",
            "nome" => "CCR DE IBIAM",
            "codigo" => '391',
            "nome_completo" => "COOPERATIVA DE CREDITO RURAL DE IBIAM - SULCREDI/IBIAM"
        ]);
        \App\Models\Banco::create([
            "ispb" => "08253539",
            "nome" => "CCR DE SÃO MIGUEL DO OESTE",
            "codigo" => '273',
            "nome_completo" => "Cooperativa de Crédito Rural de São Miguel do Oeste - Sulcredi/São Miguel"
        ]);
        \App\Models\Banco::create([
            "ispb" => "08357240",
            "nome" => "BCO CSF S.A.",
            "codigo" => '368',
            "nome_completo" => "Banco CSF S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "08561701",
            "nome" => "PAGSEGURO INTERNET IP S.A.",
            "codigo" => '290',
            "nome_completo" => "PAGSEGURO INTERNET INSTITUIÇÃO DE PAGAMENTO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "08609934",
            "nome" => "MONEYCORP BCO DE CÂMBIO S.A.",
            "codigo" => '259',
            "nome_completo" => "MONEYCORP BANCO DE CÂMBIO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "08673569",
            "nome" => "F D GOLD DTVM LTDA",
            "codigo" => '395',
            "nome_completo" => "F.D'GOLD - DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIÁRIOS LTDA."
        ]);
        \App\Models\Banco::create([
            "ispb" => "09089356",
            "nome" => "EFÍ S.A. - IP",
            "codigo" => '364',
            "nome_completo" => "EFÍ S.A. - INSTITUIÇÃO DE PAGAMENTO"
        ]);
        \App\Models\Banco::create([
            "ispb" => "09105360",
            "nome" => "ICAP DO BRASIL CTVM LTDA.",
            "codigo" => '157',
            "nome_completo" => "ICAP do Brasil Corretora de Títulos e Valores Mobiliários Ltda."
        ]);
        \App\Models\Banco::create([
            "ispb" => "09210106",
            "nome" => "SOCRED SA - SCMEPP",
            "codigo" => '183',
            "nome_completo" => "SOCRED S.A. - SOCIEDADE DE CRÉDITO AO MICROEMPREENDEDOR E À EMPRESA DE PEQUENO P"
        ]);
        \App\Models\Banco::create([
            "ispb" => "09274232",
            "nome" => "STATE STREET BR S.A. BCO COMERCIAL",
            "codigo" => '014',
            "nome_completo" => "STATE STREET BRASIL S.A. - BANCO COMERCIAL"
        ]);
        \App\Models\Banco::create([
            "ispb" => "09313766",
            "nome" => "CARUANA SCFI",
            "codigo" => '130',
            "nome_completo" => "CARUANA S.A. - SOCIEDADE DE CRÉDITO, FINANCIAMENTO E INVESTIMENTO"
        ]);
        \App\Models\Banco::create([
            "ispb" => "09464032",
            "nome" => "MIDWAY S.A. - SCFI",
            "codigo" => '358',
            "nome_completo" => "MIDWAY S.A. - CRÉDITO, FINANCIAMENTO E INVESTIMENTO"
        ]);
        \App\Models\Banco::create([
            "ispb" => "09512542",
            "nome" => "codigoPE CVC S.A.",
            "codigo" => '127',
            "nome_completo" => "codigope Corretora de Valores e Câmbio S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "09516419",
            "nome" => "PICPAY BANK - BANCO MÚLTIPLO S.A",
            "codigo" => '079',
            "nome_completo" => "PICPAY BANK - BANCO MÚLTIPLO S.A"
        ]);
        \App\Models\Banco::create([
            "ispb" => "09526594",
            "nome" => "MASTER BI S.A.",
            "codigo" => '141',
            "nome_completo" => "BANCO MASTER DE INVESTIMENTO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "09554480",
            "nome" => "SUPERDIGITAL I.P. S.A.",
            "codigo" => '340',
            "nome_completo" => "SUPERDIGITAL INSTITUIÇÃO DE PAGAMENTO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "10264663",
            "nome" => "BANCOSEGURO S.A.",
            "codigo" => '081',
            "nome_completo" => "BancoSeguro S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "10371492",
            "nome" => "BCO YAMAHA MOTOR S.A.",
            "codigo" => '475',
            "nome_completo" => "Banco Yamaha Motor do Brasil S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "10398952",
            "nome" => "CRESOL CONFEDERAÇÃO",
            "codigo" => '133',
            "nome_completo" => "CONFEDERAÇÃO NACIONAL DAS COOPERATIVAS CENTRAIS DE CRÉDITO E ECONOMIA FAMILIAR E"
        ]);
        \App\Models\Banco::create([
            "ispb" => "10573521",
            "nome" => "MERCADO PAGO IP LTDA.",
            "codigo" => '323',
            "nome_completo" => "MERCADO PAGO INSTITUIÇÃO DE PAGAMENTO LTDA."
        ]);
        \App\Models\Banco::create([
            "ispb" => "10664513",
            "nome" => "BCO AGIBANK S.A.",
            "codigo" => '121',
            "nome_completo" => "Banco Agibank S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "10690848",
            "nome" => "BCO DA CHINA BRASIL S.A.",
            "codigo" => '083',
            "nome_completo" => "Banco da China Brasil S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "10853017",
            "nome" => "GET MONEY CC LTDA",
            "codigo" => '138',
            "nome_completo" => "Get Money Corretora de Câmbio S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "10866788",
            "nome" => "BCO BANDEPE S.A.",
            "codigo" => '024',
            "nome_completo" => "Banco Bandepe S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "11165756",
            "nome" => "GLOBAL SCM LTDA",
            "codigo" => '384',
            "nome_completo" => "GLOBAL FINANÇAS SOCIEDADE DE CRÉDITO AO MICROEMPREENDEDOR E À EMPRESA DE PEQUENO"
        ]);
        \App\Models\Banco::create([
            "ispb" => "11285104",
            "nome" => "NEON FINANCEIRA - CFI S.A.",
            "codigo" => '426',
            "nome_completo" => "NEON FINANCEIRA - CRÉDITO, FINANCIAMENTO E INVESTIMENTO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "11476673",
            "nome" => "BANCO RANDON S.A.",
            "codigo" => '088',
            "nome_completo" => "BANCO RANDON S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "11495073",
            "nome" => "OM DTVM LTDA",
            "codigo" => '319',
            "nome_completo" => "OM DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIÁRIOS LTDA"
        ]);
        \App\Models\Banco::create([
            "ispb" => "11581339",
            "nome" => "BMP SCMEPP LTDA",
            "codigo" => '274',
            "nome_completo" => "BMP SOCIEDADE DE CRÉDITO AO MICROEMPREENDEDOR E A EMPRESA DE PEQUENO PORTE LTDA."
        ]);
        \App\Models\Banco::create([
            "ispb" => "11703662",
            "nome" => "TRAVELEX BANCO DE CÂMBIO S.A.",
            "codigo" => '095',
            "nome_completo" => "Travelex Banco de Câmbio S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "11758741",
            "nome" => "BANCO FINAXIS",
            "codigo" => '094',
            "nome_completo" => "Banco Finaxis S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "11760553",
            "nome" => "GAZINCRED S.A. SCFI",
            "codigo" => '478',
            "nome_completo" => "GAZINCRED S.A. SOCIEDADE DE CRÉDITO, FINANCIAMENTO E INVESTIMENTO"
        ]);
        \App\Models\Banco::create([
            "ispb" => "11970623",
            "nome" => "BCO SENFF S.A.",
            "codigo" => '276',
            "nome_completo" => "BANCO SENFF S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "12392983",
            "nome" => "MIRAE ASSET CCTVM LTDA",
            "codigo" => '447',
            "nome_completo" => "MIRAE ASSET WEALTH MANAGEMENT (BRAZIL) CORRETORA DE CÂMBIO, TÍTULOS E VALORES MO"
        ]);
        \App\Models\Banco::create([
            "ispb" => "13009717",
            "nome" => "BCO DO EST. DE SE S.A.",
            "codigo" => '047',
            "nome_completo" => "Banco do Estado de Sergipe S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "13059145",
            "nome" => "BEXS BCO DE CAMBIO S.A.",
            "codigo" => '144',
            "nome_completo" => "BEXS BANCO DE CÂMBIO S/A"
        ]);
        \App\Models\Banco::create([
            "ispb" => "13140088",
            "nome" => "ACESSO SOLUÇÕES DE PAGAMENTO S.A. - INSTITUIÇÃO DE PAGAMENTO",
            "codigo" => '332',
            "nome_completo" => "ACESSO SOLUÇÕES DE PAGAMENTO S.A. - INSTITUIÇÃO DE PAGAMENTO"
        ]);
        \App\Models\Banco::create([
            "ispb" => "13203354",
            "nome" => "FITBANK IP",
            "codigo" => '450',
            "nome_completo" => "FITBANK INSTITUIÇÃO DE PAGAMENTOS ELETRÔNICOS S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "13220493",
            "nome" => "BR PARTNERS BI",
            "codigo" => '126',
            "nome_completo" => "BR Partners Banco de Investimento S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "13293225",
            "nome" => "ÓRAMA DTVM S.A.",
            "codigo" => '325',
            "nome_completo" => "Órama Distribuidora de Títulos e Valores Mobiliários S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "13370835",
            "nome" => "DOCK IP S.A.",
            "codigo" => '301',
            "nome_completo" => "DOCK INSTITUIÇÃO DE PAGAMENTO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "13486793",
            "nome" => "BRL TRUST DTVM SA",
            "codigo" => '173',
            "nome_completo" => "BRL Trust Distribuidora de Títulos e Valores Mobiliários S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "13673855",
            "nome" => "FRAM CAPITAL DTVM S.A.",
            "codigo" => '331',
            "nome_completo" => "Fram Capital Distribuidora de Títulos e Valores Mobiliários S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "13720915",
            "nome" => "BCO WESTERN UNION",
            "codigo" => '119',
            "nome_completo" => "Banco Western Union do Brasil S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "13884775",
            "nome" => "HUB IP S.A.",
            "codigo" => '396',
            "nome_completo" => "HUB INSTITUIÇÃO DE PAGAMENTO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "13935893",
            "nome" => "CELCOIN IP S.A.",
            "codigo" => '509',
            "nome_completo" => "CELCOIN INSTITUICAO DE PAGAMENTO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "14190547",
            "nome" => "CAMBIONET CC LTDA",
            "codigo" => '309',
            "nome_completo" => "CAMBIONET CORRETORA DE CÂMBIO LTDA."
        ]);
        \App\Models\Banco::create([
            "ispb" => "14388334",
            "nome" => "PARANA BCO S.A.",
            "codigo" => '254',
            "nome_completo" => "PARANÁ BANCO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "14511781",
            "nome" => "BARI CIA HIPOTECÁRIA",
            "codigo" => '268',
            "nome_completo" => "BARI COMPANHIA HIPOTECÁRIA"
        ]);
        \App\Models\Banco::create([
            "ispb" => "15111975",
            "nome" => "IUGU IP S.A.",
            "codigo" => '401',
            "nome_completo" => "IUGU INSTITUIÇÃO DE PAGAMENTO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "15114366",
            "nome" => "BCO BOCOM BBM S.A.",
            "codigo" => '107',
            "nome_completo" => "Banco Bocom BBM S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "15124464",
            "nome" => "BANCO BESA S.A.",
            "codigo" => '334',
            "nome_completo" => "BANCO BESA S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "15173776",
            "nome" => "SOCIAL BANK S/A",
            "codigo" => '412',
            "nome_completo" => "SOCIAL BANK BANCO MÚLTIPLO S/A"
        ]);
        \App\Models\Banco::create([
            "ispb" => "15357060",
            "nome" => "BCO WOORI BANK DO BRASIL S.A.",
            "codigo" => '124',
            "nome_completo" => "Banco Woori Bank do Brasil S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "15581638",
            "nome" => "FACTA S.A. CFI",
            "codigo" => '149',
            "nome_completo" => "Facta Financeira S.A. - Crédito Financiamento e Investimento"
        ]);
        \App\Models\Banco::create([
            "ispb" => "16501555",
            "nome" => "STONE IP S.A.",
            "codigo" => '197',
            "nome_completo" => "STONE INSTITUIÇÃO DE PAGAMENTO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "16695922",
            "nome" => "ID CTVM",
            "codigo" => '439',
            "nome_completo" => "ID CORRETORA DE TÍTULOS E VALORES MOBILIÁRIOS S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "16927221",
            "nome" => "AMAZÔNIA CC LTDA.",
            "codigo" => '313',
            "nome_completo" => "AMAZÔNIA CORRETORA DE CÂMBIO LTDA."
        ]);
        \App\Models\Banco::create([
            "ispb" => "16944141",
            "nome" => "BROKER BRASIL CC LTDA.",
            "codigo" => '142',
            "nome_completo" => "Broker Brasil Corretora de Câmbio Ltda."
        ]);
        \App\Models\Banco::create([
            "ispb" => "17079937",
            "nome" => "PINBANK IP",
            "codigo" => '529',
            "nome_completo" => "PINBANK BRASIL INSTITUIÇÃO DE PAGAMENTO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "17184037",
            "nome" => "BCO MERCANTIL DO BRASIL S.A.",
            "codigo" => '389',
            "nome_completo" => "Banco Mercantil do Brasil S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "17298092",
            "nome" => "BCO ITAÚ BBA S.A.",
            "codigo" => '184',
            "nome_completo" => "Banco Itaú BBA S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "17351180",
            "nome" => "BCO TRIANGULO S.A.",
            "codigo" => '634',
            "nome_completo" => "BANCO TRIANGULO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "17352220",
            "nome" => "SENSO CCVM S.A.",
            "codigo" => '545',
            "nome_completo" => "SENSO CORRETORA DE CAMBIO E VALORES MOBILIARIOS S.A"
        ]);
        \App\Models\Banco::create([
            "ispb" => "17453575",
            "nome" => "ICBC DO BRASIL BM S.A.",
            "codigo" => '132',
            "nome_completo" => "ICBC do Brasil Banco Múltiplo S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "17772370",
            "nome" => "VIPS CC LTDA.",
            "codigo" => '298',
            "nome_completo" => "Vip's Corretora de Câmbio Ltda."
        ]);
        \App\Models\Banco::create([
            "ispb" => "17826860",
            "nome" => "BMS SCD S.A.",
            "codigo" => '377',
            "nome_completo" => "BMS SOCIEDADE DE CRÉDITO DIRETO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "18188384",
            "nome" => "CREFAZ SCMEPP LTDA",
            "codigo" => '321',
            "nome_completo" => "CREFAZ SOCIEDADE DE CRÉDITO AO MICROEMPREENDEDOR E A EMPRESA DE PEQUENO PORTE LT"
        ]);
        \App\Models\Banco::create([
            "ispb" => "18236120",
            "nome" => "NU PAGAMENTOS - IP",
            "codigo" => '260',
            "nome_completo" => "NU PAGAMENTOS S.A. - INSTITUIÇÃO DE PAGAMENTO"
        ]);
        \App\Models\Banco::create([
            "ispb" => "18394228",
            "nome" => "CDC SCD S.A.",
            "codigo" => '470',
            "nome_completo" => "CDC SOCIEDADE DE CRÉDITO DIRETO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "18520834",
            "nome" => "UBS BRASIL BI S.A.",
            "codigo" => '129',
            "nome_completo" => "UBS Brasil Banco de Investimento S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "19307785",
            "nome" => "BRAZA BANK S.A. BCO DE CÂMBIO",
            "codigo" => '128',
            "nome_completo" => "BRAZA BANK S.A. BANCO DE CÂMBIO"
        ]);
        \App\Models\Banco::create([
            "ispb" => "19324634",
            "nome" => "LAMARA SCD S.A.",
            "codigo" => '416',
            "nome_completo" => "LAMARA SOCIEDADE DE CRÉDITO DIRETO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "19540550",
            "nome" => "ASAAS IP S.A.",
            "codigo" => '461',
            "nome_completo" => "ASAAS GESTÃO FINANCEIRA INSTITUIÇÃO DE PAGAMENTO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "20155248",
            "nome" => "PARMETAL DTVM LTDA",
            "codigo" => '194',
            "nome_completo" => "PARMETAL DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIÁRIOS LTDA"
        ]);
        \App\Models\Banco::create([
            "ispb" => "20855875",
            "nome" => "NEON PAGAMENTOS S.A. IP",
            "codigo" => '536',
            "nome_completo" => "NEON PAGAMENTOS S.A. - INSTITUIÇÃO DE PAGAMENTO"
        ]);
        \App\Models\Banco::create([
            "ispb" => "21018182",
            "nome" => "EBANX IP LTDA.",
            "codigo" => '383',
            "nome_completo" => "EBANX INSTITUICAO DE PAGAMENTOS LTDA."
        ]);
        \App\Models\Banco::create([
            "ispb" => "21332862",
            "nome" => "CARTOS SCD S.A.",
            "codigo" => '324',
            "nome_completo" => "CARTOS SOCIEDADE DE CRÉDITO DIRETO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "22610500",
            "nome" => "VORTX DTVM LTDA.",
            "codigo" => '310',
            "nome_completo" => "VORTX DISTRIBUIDORA DE TITULOS E VALORES MOBILIARIOS LTDA."
        ]);
        \App\Models\Banco::create([
            "ispb" => "22896431",
            "nome" => "PICPAY",
            "codigo" => '380',
            "nome_completo" => "PICPAY INSTITUIçãO DE PAGAMENTO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "23862762",
            "nome" => "WILL FINANCEIRA S.A.CFI",
            "codigo" => '280',
            "nome_completo" => "WILL FINANCEIRA S.A. CRÉDITO, FINANCIAMENTO E INVESTIMENTO"
        ]);
        \App\Models\Banco::create([
            "ispb" => "24074692",
            "nome" => "GUITTA CC LTDA",
            "codigo" => '146',
            "nome_completo" => "GUITTA CORRETORA DE CAMBIO LTDA."
        ]);
        \App\Models\Banco::create([
            "ispb" => "24537861",
            "nome" => "FFA SCMEPP LTDA.",
            "codigo" => '343',
            "nome_completo" => "FFA SOCIEDADE DE CRÉDITO AO MICROEMPREENDEDOR E À EMPRESA DE PEQUENO PORTE LTDA."
        ]);
        \App\Models\Banco::create([
            "ispb" => "26563270",
            "nome" => "COOP DE PRIMAVERA DO LESTE",
            "codigo" => '279',
            "nome_completo" => "PRIMACREDI COOPERATIVA DE CRÉDITO DE PRIMAVERA DO LESTE"
        ]);
        \App\Models\Banco::create([
            "ispb" => "27098060",
            "nome" => "BANCO DIGIO",
            "codigo" => '335',
            "nome_completo" => "Banco Digio S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "27214112",
            "nome" => "AL5 S.A. CFI",
            "codigo" => '349',
            "nome_completo" => "AL5 S.A. CRÉDITO, FINANCIAMENTO E INVESTIMENTO"
        ]);
        \App\Models\Banco::create([
            "ispb" => "27302181",
            "nome" => "CRED-UFES",
            "codigo" => '427',
            "nome_completo" => "COOPERATIVA DE CREDITO DOS SERVIDORES DA UNIVERSIDADE FEDERAL DO ESPIRITO SANTO"
        ]);
        \App\Models\Banco::create([
            "ispb" => "27351731",
            "nome" => "REALIZE CFI S.A.",
            "codigo" => '374',
            "nome_completo" => "REALIZE CRÉDITO, FINANCIAMENTO E INVESTIMENTO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "27652684",
            "nome" => "GENIAL INVESTIMENTOS CVM S.A.",
            "codigo" => '278',
            "nome_completo" => "Genial Investimentos Corretora de Valores Mobiliários S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "27842177",
            "nome" => "IB CCTVM S.A.",
            "codigo" => '271',
            "nome_completo" => "IB Corretora de Câmbio, Títulos e Valores Mobiliários S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "28127603",
            "nome" => "BCO BANESTES S.A.",
            "codigo" => '021',
            "nome_completo" => "BANESTES S.A. BANCO DO ESTADO DO ESPIRITO SANTO"
        ]);
        \App\Models\Banco::create([
            "ispb" => "28195667",
            "nome" => "BCO ABC BRASIL S.A.",
            "codigo" => '246',
            "nome_completo" => "Banco ABC Brasil S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "28650236",
            "nome" => "BS2 DTVM S.A.",
            "codigo" => '292',
            "nome_completo" => "BS2 Distribuidora de Títulos e Valores Mobiliários S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "29030467",
            "nome" => "SCOTIABANK BRASIL",
            "codigo" => '751',
            "nome_completo" => "Scotiabank Brasil S.A. Banco Múltiplo"
        ]);
        \App\Models\Banco::create([
            "ispb" => "29162769",
            "nome" => "TORO CTVM S.A.",
            "codigo" => '352',
            "nome_completo" => "TORO CORRETORA DE TÍTULOS E VALORES MOBILIÁRIOS S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "30306294",
            "nome" => "BANCO BTG PACTUAL S.A.",
            "codigo" => '208',
            "nome_completo" => "Banco BTG Pactual S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "30680829",
            "nome" => "NU FINANCEIRA S.A. CFI",
            "codigo" => '386',
            "nome_completo" => "NU FINANCEIRA S.A. - Sociedade de Crédito, Financiamento e Investimento"
        ]);
        \App\Models\Banco::create([
            "ispb" => "30723886",
            "nome" => "BCO MODAL S.A.",
            "codigo" => '746',
            "nome_completo" => "Banco Modal S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "30980539",
            "nome" => "U4C INSTITUIÇÃO DE PAGAMENTO S.A.",
            "codigo" => '546',
            "nome_completo" => "U4C INSTITUIÇÃO DE PAGAMENTO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "31597552",
            "nome" => "BCO CLASSICO S.A.",
            "codigo" => '241',
            "nome_completo" => "BANCO CLASSICO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "31749596",
            "nome" => "IDEAL CTVM S.A.",
            "codigo" => '398',
            "nome_completo" => "IDEAL CORRETORA DE TÍTULOS E VALORES MOBILIÁRIOS S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "31872495",
            "nome" => "BCO C6 S.A.",
            "codigo" => '336',
            "nome_completo" => "Banco C6 S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "31880826",
            "nome" => "BCO GUANABARA S.A.",
            "codigo" => '612',
            "nome_completo" => "Banco Guanabara S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "31895683",
            "nome" => "BCO INDUSTRIAL DO BRASIL S.A.",
            "codigo" => '604',
            "nome_completo" => "Banco Industrial do Brasil S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "32062580",
            "nome" => "BCO CREDIT SUISSE S.A.",
            "codigo" => '505',
            "nome_completo" => "Banco Credit Suisse (Brasil) S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "32402502",
            "nome" => "QI SCD S.A.",
            "codigo" => '329',
            "nome_completo" => "QI Sociedade de Crédito Direto S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "32648370",
            "nome" => "FAIR CC S.A.",
            "codigo" => '196',
            "nome_completo" => "FAIR CORRETORA DE CAMBIO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "32997490",
            "nome" => "CREDITAS SCD",
            "codigo" => '342',
            "nome_completo" => "Creditas Sociedade de Crédito Direto S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "33042151",
            "nome" => "BCO LA NACION ARGENTINA",
            "codigo" => '300',
            "nome_completo" => "Banco de la Nacion Argentina"
        ]);
        \App\Models\Banco::create([
            "ispb" => "33042953",
            "nome" => "CITIBANK N.A.",
            "codigo" => '477',
            "nome_completo" => "Citibank N.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "33132044",
            "nome" => "BCO CEDULA S.A.",
            "codigo" => '266',
            "nome_completo" => "BANCO CEDULA S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "33147315",
            "nome" => "BCO BRADESCO BERJ S.A.",
            "codigo" => '122',
            "nome_completo" => "Banco Bradesco BERJ S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "33172537",
            "nome" => "BCO J.P. MORGAN S.A.",
            "codigo" => '376',
            "nome_completo" => "BANCO J.P. MORGAN S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "33264668",
            "nome" => "BCO XP S.A.",
            "codigo" => '348',
            "nome_completo" => "Banco XP S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "33466988",
            "nome" => "BCO CAIXA GERAL BRASIL S.A.",
            "codigo" => '473',
            "nome_completo" => "Banco Caixa Geral - Brasil S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "33479023",
            "nome" => "BCO CITIBANK S.A.",
            "codigo" => '745',
            "nome_completo" => "Banco Citibank S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "33603457",
            "nome" => "BCO RODOBENS S.A.",
            "codigo" => '120',
            "nome_completo" => "BANCO RODOBENS S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "33644196",
            "nome" => "BCO FATOR S.A.",
            "codigo" => '265',
            "nome_completo" => "Banco Fator S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "33657248",
            "nome" => "BNDES",
            "codigo" => '007',
            "nome_completo" => "BANCO NACIONAL DE DESENVOLVIMENTO ECONOMICO E SOCIAL"
        ]);
        \App\Models\Banco::create([
            "ispb" => "33775974",
            "nome" => "ATIVA S.A. INVESTIMENTOS CCTVM",
            "codigo" => '188',
            "nome_completo" => "ATIVA INVESTIMENTOS S.A. CORRETORA DE TÍTULOS, CÂMBIO E VALORES"
        ]);
        \App\Models\Banco::create([
            "ispb" => "33862244",
            "nome" => "BGC LIQUIDEZ DTVM LTDA",
            "codigo" => '134',
            "nome_completo" => "BGC LIQUIDEZ DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIÁRIOS LTDA"
        ]);
        \App\Models\Banco::create([
            "ispb" => "33885724",
            "nome" => "BANCO ITAÚ CONSIGNADO S.A.",
            "codigo" => '029',
            "nome_completo" => "Banco Itaú Consignado S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "33886862",
            "nome" => "MASTER S/A CCTVM",
            "codigo" => '467',
            "nome_completo" => "MASTER S/A CORRETORA DE CâMBIO, TíTULOS E VALORES MOBILIáRIOS"
        ]);
        \App\Models\Banco::create([
            "ispb" => "33923798",
            "nome" => "BANCO MASTER",
            "codigo" => '243',
            "nome_completo" => "BANCO MASTER S/A"
        ]);
        \App\Models\Banco::create([
            "ispb" => "34088029",
            "nome" => "LISTO SCD S.A.",
            "codigo" => '397',
            "nome_completo" => "LISTO SOCIEDADE DE CREDITO DIRETO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "34111187",
            "nome" => "HAITONG BI DO BRASIL S.A.",
            "codigo" => '078',
            "nome_completo" => "Haitong Banco de Investimento do Brasil S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "34265629",
            "nome" => "INTERCAM CC LTDA",
            "codigo" => '525',
            "nome_completo" => "INTERCAM CORRETORA DE CÂMBIO LTDA."
        ]);
        \App\Models\Banco::create([
            "ispb" => "34335592",
            "nome" => "ÓTIMO SCD S.A.",
            "codigo" => '355',
            "nome_completo" => "ÓTIMO SOCIEDADE DE CRÉDITO DIRETO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "34711571",
            "nome" => "VITREO DTVM S.A.",
            "codigo" => '367',
            "nome_completo" => "VITREO DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIÁRIOS S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "34829992",
            "nome" => "REAG DTVM S.A.",
            "codigo" => '528',
            "nome_completo" => "REAG DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIÁRIOS S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "35551187",
            "nome" => "PLANTAE CFI",
            "codigo" => '445',
            "nome_completo" => "PLANTAE S.A. - CRÉDITO, FINANCIAMENTO E INVESTIMENTO"
        ]);
        \App\Models\Banco::create([
            "ispb" => "35977097",
            "nome" => "UP.P SEP S.A.",
            "codigo" => '373',
            "nome_completo" => "UP.P SOCIEDADE DE EMPRÉSTIMO ENTRE PESSOAS S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "36113876",
            "nome" => "OLIVEIRA TRUST DTVM S.A.",
            "codigo" => '111',
            "nome_completo" => "OLIVEIRA TRUST DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIARIOS S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "36266751",
            "nome" => "FINVEST DTVM",
            "codigo" => '512',
            "nome_completo" => "FINVEST DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIÁRIOS LTDA."
        ]);
        \App\Models\Banco::create([
            "ispb" => "36583700",
            "nome" => "QISTA S.A. CFI",
            "codigo" => '516',
            "nome_completo" => "QISTA S.A. - CRÉDITO, FINANCIAMENTO E INVESTIMENTO"
        ]);
        \App\Models\Banco::create([
            "ispb" => "36586946",
            "nome" => "BONUSPAGO SCD S.A.",
            "codigo" => '408',
            "nome_completo" => "BONUSPAGO SOCIEDADE DE CRÉDITO DIRETO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "36864992",
            "nome" => "MAF DTVM SA",
            "codigo" => '484',
            "nome_completo" => "MAF DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIÁRIOS S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "36947229",
            "nome" => "COBUCCIO S.A. SCFI",
            "codigo" => '402',
            "nome_completo" => "COBUCCIO S/A - SOCIEDADE DE CRÉDITO, FINANCIAMENTO E INVESTIMENTOS"
        ]);
        \App\Models\Banco::create([
            "ispb" => "37229413",
            "nome" => "SCFI EFÍ S.A.",
            "codigo" => '507',
            "nome_completo" => "SOCIEDADE DE CRÉDITO, FINANCIAMENTO E INVESTIMENTO EFÍ S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "37241230",
            "nome" => "SUMUP SCD S.A.",
            "codigo" => '404',
            "nome_completo" => "SUMUP SOCIEDADE DE CRÉDITO DIRETO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "37414009",
            "nome" => "ZIPDIN SCD S.A.",
            "codigo" => '418',
            "nome_completo" => "ZIPDIN SOLUÇÕES DIGITAIS SOCIEDADE DE CRÉDITO DIRETO S/A"
        ]);
        \App\Models\Banco::create([
            "ispb" => "37526080",
            "nome" => "LEND SCD S.A.",
            "codigo" => '414',
            "nome_completo" => "LEND SOCIEDADE DE CRÉDITO DIRETO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "37555231",
            "nome" => "DM",
            "codigo" => '449',
            "nome_completo" => "DM SOCIEDADE DE CRÉDITO DIRETO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "37679449",
            "nome" => "MERCADO CRÉDITO SCFI S.A.",
            "codigo" => '518',
            "nome_completo" => "MERCADO CRÉDITO SOCIEDADE DE CRÉDITO, FINANCIAMENTO E INVESTIMENTO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "37715993",
            "nome" => "ACCREDITO SCD S.A.",
            "codigo" => '406',
            "nome_completo" => "ACCREDITO - SOCIEDADE DE CRÉDITO DIRETO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "37880206",
            "nome" => "CORA SCD S.A.",
            "codigo" => '403',
            "nome_completo" => "CORA SOCIEDADE DE CRÉDITO DIRETO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "38129006",
            "nome" => "NUMBRS SCD S.A.",
            "codigo" => '419',
            "nome_completo" => "NUMBRS SOCIEDADE DE CRÉDITO DIRETO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "38224857",
            "nome" => "DELCRED SCD S.A.",
            "codigo" => '435',
            "nome_completo" => "DELCRED SOCIEDADE DE CRÉDITO DIRETO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "38429045",
            "nome" => "FÊNIX DTVM LTDA.",
            "codigo" => '455',
            "nome_completo" => "FÊNIX DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIÁRIOS LTDA."
        ]);
        \App\Models\Banco::create([
            "ispb" => "39343350",
            "nome" => "CC LAR CREDI",
            "codigo" => '421',
            "nome_completo" => "LAR COOPERATIVA DE CRÉDITO - LAR CREDI"
        ]);
        \App\Models\Banco::create([
            "ispb" => "39416705",
            "nome" => "CREDIHOME SCD",
            "codigo" => '443',
            "nome_completo" => "CREDIHOME SOCIEDADE DE CRÉDITO DIRETO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "39519944",
            "nome" => "MARU SCD S.A.",
            "codigo" => '535',
            "nome_completo" => "MARÚ SOCIEDADE DE CRÉDITO DIRETO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "39587424",
            "nome" => "UY3 SCD S/A",
            "codigo" => '457',
            "nome_completo" => "UY3 SOCIEDADE DE CRÉDITO DIRETO S/A"
        ]);
        \App\Models\Banco::create([
            "ispb" => "39664698",
            "nome" => "CREDSYSTEM SCD S.A.",
            "codigo" => '428',
            "nome_completo" => "CREDSYSTEM SOCIEDADE DE CRÉDITO DIRETO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "39669186",
            "nome" => "HEMERA DTVM LTDA.",
            "codigo" => '448',
            "nome_completo" => "HEMERA DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIÁRIOS LTDA."
        ]);
        \App\Models\Banco::create([
            "ispb" => "39676772",
            "nome" => "CREDIFIT SCD S.A.",
            "codigo" => '452',
            "nome_completo" => "CREDIFIT SOCIEDADE DE CRÉDITO DIRETO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "39738065",
            "nome" => "FFCRED SCD S.A.",
            "codigo" => '510',
            "nome_completo" => "FFCRED SOCIEDADE DE CRÉDITO DIRETO S.A.."
        ]);
        \App\Models\Banco::create([
            "ispb" => "39908427",
            "nome" => "STARK SCD S.A.",
            "codigo" => '462',
            "nome_completo" => "STARK SOCIEDADE DE CRÉDITO DIRETO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "40083667",
            "nome" => "CAPITAL CONSIG SCD S.A.",
            "codigo" => '465',
            "nome_completo" => "CAPITAL CONSIG SOCIEDADE DE CRÉDITO DIRETO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "40303299",
            "nome" => "PORTOPAR DTVM LTDA",
            "codigo" => '306',
            "nome_completo" => "PORTOPAR DISTRIBUIDORA DE TITULOS E VALORES MOBILIARIOS LTDA."
        ]);
        \App\Models\Banco::create([
            "ispb" => "40434681",
            "nome" => "AZUMI DTVM",
            "codigo" => '463',
            "nome_completo" => "AZUMI DISTRIBUIDORA DE TíTULOS E VALORES MOBILIáRIOS LTDA."
        ]);
        \App\Models\Banco::create([
            "ispb" => "40475846",
            "nome" => "J17 - SCD S/A",
            "codigo" => '451',
            "nome_completo" => "J17 - SOCIEDADE DE CRÉDITO DIRETO S/A"
        ]);
        \App\Models\Banco::create([
            "ispb" => "40654622",
            "nome" => "TRINUS SCD S.A.",
            "codigo" => '444',
            "nome_completo" => "TRINUS SOCIEDADE DE CRÉDITO DIRETO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "40768766",
            "nome" => "LIONS TRUST DTVM",
            "codigo" => '519',
            "nome_completo" => "LIONS TRUST DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIÁRIOS LTDA."
        ]);
        \App\Models\Banco::create([
            "ispb" => "41592532",
            "nome" => "MÉRITO DTVM LTDA.",
            "codigo" => '454',
            "nome_completo" => "MÉRITO DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIÁRIOS LTDA."
        ]);
        \App\Models\Banco::create([
            "ispb" => "42047025",
            "nome" => "UNAVANTI SCD S/A",
            "codigo" => '460',
            "nome_completo" => "UNAVANTI SOCIEDADE DE CRÉDITO DIRETO S/A"
        ]);
        \App\Models\Banco::create([
            "ispb" => "42066258",
            "nome" => "RJI",
            "codigo" => '506',
            "nome_completo" => "RJI CORRETORA DE TITULOS E VALORES MOBILIARIOS LTDA"
        ]);
        \App\Models\Banco::create([
            "ispb" => "42259084",
            "nome" => "SBCASH SCD",
            "codigo" => '482',
            "nome_completo" => "SBCASH SOCIEDADE DE CRÉDITO DIRETO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "42272526",
            "nome" => "BNY MELLON BCO S.A.",
            "codigo" => '017',
            "nome_completo" => "BNY Mellon Banco S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "43180355",
            "nome" => "PEFISA S.A. - C.F.I.",
            "codigo" => '174',
            "nome_completo" => "PEFISA S.A. - CRÉDITO, FINANCIAMENTO E INVESTIMENTO"
        ]);
        \App\Models\Banco::create([
            "ispb" => "43599047",
            "nome" => "SUPERLÓGICA SCD S.A.",
            "codigo" => '481',
            "nome_completo" => "SUPERLÓGICA SOCIEDADE DE CRÉDITO DIRETO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "44019481",
            "nome" => "PEAK SEP S.A.",
            "codigo" => '521',
            "nome_completo" => "PEAK SOCIEDADE DE EMPRÉSTIMO ENTRE PESSOAS S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "44077014",
            "nome" => "BR-CAPITAL DTVM S.A.",
            "codigo" => '433',
            "nome_completo" => "BR-CAPITAL DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIÁRIOS S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "44189447",
            "nome" => "BCO LA PROVINCIA B AIRES BCE",
            "codigo" => '495',
            "nome_completo" => "Banco de La Provincia de Buenos Aires"
        ]);
        \App\Models\Banco::create([
            "ispb" => "44292580",
            "nome" => "HR DIGITAL SCD",
            "codigo" => '523',
            "nome_completo" => "HR DIGITAL - SOCIEDADE DE CRÉDITO DIRETO S/A"
        ]);
        \App\Models\Banco::create([
            "ispb" => "44478623",
            "nome" => "ATICCA SCD S.A.",
            "codigo" => '527',
            "nome_completo" => "ATICCA - SOCIEDADE DE CRÉDITO DIRETO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "44683140",
            "nome" => "MAGNUM SCD",
            "codigo" => '511',
            "nome_completo" => "MAGNUM SOCIEDADE DE CRÉDITO DIRETO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "44728700",
            "nome" => "ATF CREDIT SCD S.A.",
            "codigo" => '513',
            "nome_completo" => "ATF CREDIT SOCIEDADE DE CRÉDITO DIRETO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "45246410",
            "nome" => "BANCO GENIAL",
            "codigo" => '125',
            "nome_completo" => "BANCO GENIAL S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "45745537",
            "nome" => "EAGLE SCD S.A.",
            "codigo" => '532',
            "nome_completo" => "EAGLE SOCIEDADE DE CRÉDITO DIRETO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "45756448",
            "nome" => "MICROCASH SCMEPP LTDA.",
            "codigo" => '537',
            "nome_completo" => "MICROCASH SOCIEDADE DE CRÉDITO AO MICROEMPREENDEDOR E À EMPRESA DE PEQUENO PORTE"
        ]);
        \App\Models\Banco::create([
            "ispb" => "45854066",
            "nome" => "WNT CAPITAL DTVM",
            "codigo" => '524',
            "nome_completo" => "WNT CAPITAL DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIÁRIOS S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "46026562",
            "nome" => "MONETARIE SCD",
            "codigo" => '526',
            "nome_completo" => "MONETARIE SOCIEDADE DE CRÉDITO DIRETO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "46518205",
            "nome" => "JPMORGAN CHASE BANK",
            "codigo" => '488',
            "nome_completo" => "JPMorgan Chase Bank, National Association"
        ]);
        \App\Models\Banco::create([
            "ispb" => "47593544",
            "nome" => "RED SCD S.A.",
            "codigo" => '522',
            "nome_completo" => "RED SOCIEDADE DE CRÉDITO DIRETO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "47873449",
            "nome" => "SER FINANCE SCD S.A.",
            "codigo" => '530',
            "nome_completo" => "SER FINANCE SOCIEDADE DE CRÉDITO DIRETO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "48795256",
            "nome" => "BCO ANDBANK S.A.",
            "codigo" => '065',
            "nome_completo" => "Banco AndBank (Brasil) S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "50579044",
            "nome" => "LEVYCAM CCV LTDA",
            "codigo" => '145',
            "nome_completo" => "LEVYCAM - CORRETORA DE CAMBIO E VALORES LTDA."
        ]);
        \App\Models\Banco::create([
            "ispb" => "50585090",
            "nome" => "BCV - BCO, CRÉDITO E VAREJO S.A.",
            "codigo" => '250',
            "nome_completo" => "BCV - BANCO DE CRÉDITO E VAREJO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "52937216",
            "nome" => "BEXS CC S.A.",
            "codigo" => '253',
            "nome_completo" => "Bexs Corretora de Câmbio S/A"
        ]);
        \App\Models\Banco::create([
            "ispb" => "53518684",
            "nome" => "BCO HSBC S.A.",
            "codigo" => '269',
            "nome_completo" => "BANCO HSBC S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "54403563",
            "nome" => "BCO ARBI S.A.",
            "codigo" => '213',
            "nome_completo" => "Banco Arbi S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "55230916",
            "nome" => "INTESA SANPAOLO BRASIL S.A. BM",
            "codigo" => '139',
            "nome_completo" => "Intesa Sanpaolo Brasil S.A. - Banco Múltiplo"
        ]);
        \App\Models\Banco::create([
            "ispb" => "57839805",
            "nome" => "BCO TRICURY S.A.",
            "codigo" => '018',
            "nome_completo" => "Banco Tricury S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "58160789",
            "nome" => "BCO SAFRA S.A.",
            "codigo" => '422',
            "nome_completo" => "Banco Safra S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "58497702",
            "nome" => "BCO LETSBANK S.A.",
            "codigo" => '630',
            "nome_completo" => "BANCO LETSBANK S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "58616418",
            "nome" => "BCO FIBRA S.A.",
            "codigo" => '224',
            "nome_completo" => "Banco Fibra S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "59109165",
            "nome" => "BCO VOLKSWAGEN S.A",
            "codigo" => '393',
            "nome_completo" => "Banco Volkswagen S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "59118133",
            "nome" => "BCO LUSO BRASILEIRO S.A.",
            "codigo" => '600',
            "nome_completo" => "Banco Luso Brasileiro S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "59274605",
            "nome" => "BCO GM S.A.",
            "codigo" => '390',
            "nome_completo" => "BANCO GM S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "59285411",
            "nome" => "BANCO PAN",
            "codigo" => '623',
            "nome_completo" => "Banco Pan S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "59588111",
            "nome" => "BCO VOTORANTIM S.A.",
            "codigo" => '655',
            "nome_completo" => "Banco Votorantim S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "60394079",
            "nome" => "BCO ITAUBANK S.A.",
            "codigo" => '479',
            "nome_completo" => "Banco ItauBank S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "60498557",
            "nome" => "BCO MUFG BRASIL S.A.",
            "codigo" => '456',
            "nome_completo" => "Banco MUFG Brasil S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "60518222",
            "nome" => "BCO SUMITOMO MITSUI BRASIL S.A.",
            "codigo" => '464',
            "nome_completo" => "Banco Sumitomo Mitsui Brasileiro S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "60701190",
            "nome" => "ITAÚ UNIBANCO S.A.",
            "codigo" => '341',
            "nome_completo" => "ITAÚ UNIBANCO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "60746948",
            "nome" => "BCO BRADESCO S.A.",
            "codigo" => '237',
            "nome_completo" => "Banco Bradesco S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "60814191",
            "nome" => "BCO MERCEDES-BENZ S.A.",
            "codigo" => '381',
            "nome_completo" => "BANCO MERCEDES-BENZ DO BRASIL S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "60850229",
            "nome" => "OMNI BANCO S.A.",
            "codigo" => '613',
            "nome_completo" => "Omni Banco S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "60889128",
            "nome" => "BCO SOFISA S.A.",
            "codigo" => '637',
            "nome_completo" => "BANCO SOFISA S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "61024352",
            "nome" => "BANCO VOITER",
            "codigo" => '653',
            "nome_completo" => "BANCO VOITER S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "61033106",
            "nome" => "BCO CREFISA S.A.",
            "codigo" => '069',
            "nome_completo" => "Banco Crefisa S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "61088183",
            "nome" => "BCO MIZUHO S.A.",
            "codigo" => '370',
            "nome_completo" => "Banco Mizuho do Brasil S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "61182408",
            "nome" => "BANCO INVESTCRED UNIBANCO S.A.",
            "codigo" => '249',
            "nome_completo" => "Banco Investcred Unibanco S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "61186680",
            "nome" => "BCO BMG S.A.",
            "codigo" => '318',
            "nome_completo" => "Banco BMG S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "61348538",
            "nome" => "BCO C6 CONSIG",
            "codigo" => '626',
            "nome_completo" => "BANCO C6 CONSIGNADO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "61384004",
            "nome" => "AVENUE SECURITIES DTVM LTDA.",
            "codigo" => '508',
            "nome_completo" => "AVENUE SECURITIES DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIÁRIOS LTDA."
        ]);
        \App\Models\Banco::create([
            "ispb" => "61444949",
            "nome" => "SAGITUR CC",
            "codigo" => '270',
            "nome_completo" => "SAGITUR CORRETORA DE CÂMBIO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "61533584",
            "nome" => "BCO SOCIETE GENERALE BRASIL",
            "codigo" => '366',
            "nome_completo" => "BANCO SOCIETE GENERALE BRASIL S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "61723847",
            "nome" => "NEON CTVM S.A.",
            "codigo" => '113',
            "nome_completo" => "NEON CORRETORA DE TÍTULOS E VALORES MOBILIÁRIOS S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "61747085",
            "nome" => "TULLETT PREBON BRASIL CVC LTDA",
            "codigo" => '131',
            "nome_completo" => "TULLETT PREBON BRASIL CORRETORA DE VALORES E CÂMBIO LTDA"
        ]);
        \App\Models\Banco::create([
            "ispb" => "61809182",
            "nome" => "C.SUISSE HEDGING-GRIFFO CV S/A",
            "codigo" => '011',
            "nome_completo" => "CREDIT SUISSE HEDGING-GRIFFO CORRETORA DE VALORES S.A"
        ]);
        \App\Models\Banco::create([
            "ispb" => "61820817",
            "nome" => "BCO PAULISTA S.A.",
            "codigo" => '611',
            "nome_completo" => "Banco Paulista S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "62073200",
            "nome" => "BOFA MERRILL LYNCH BM S.A.",
            "codigo" => '755',
            "nome_completo" => "Bank of America Merrill Lynch Banco Múltiplo S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "62109566",
            "nome" => "CREDISAN CC",
            "codigo" => '089',
            "nome_completo" => "CREDISAN COOPERATIVA DE CRÉDITO"
        ]);
        \App\Models\Banco::create([
            "ispb" => "62144175",
            "nome" => "BCO PINE S.A.",
            "codigo" => '643',
            "nome_completo" => "Banco Pine S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "62169875",
            "nome" => "NU INVEST CORRETORA DE VALORES S.A.",
            "codigo" => '140',
            "nome_completo" => "NU INVEST CORRETORA DE VALORES S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "62232889",
            "nome" => "BCO DAYCOVAL S.A",
            "codigo" => '707',
            "nome_completo" => "Banco Daycoval S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "62237649",
            "nome" => "CAROL DTVM LTDA.",
            "codigo" => '288',
            "nome_completo" => "CAROL DISTRIBUIDORA DE TITULOS E VALORES MOBILIARIOS LTDA."
        ]);
        \App\Models\Banco::create([
            "ispb" => "62285390",
            "nome" => "SINGULARE CTVM S.A.",
            "codigo" => '363',
            "nome_completo" => "SINGULARE CORRETORA DE TÍTULOS E VALORES MOBILIÁRIOS S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "62287735",
            "nome" => "RENASCENCA DTVM LTDA",
            "codigo" => '101',
            "nome_completo" => "RENASCENCA DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIÁRIOS LTDA"
        ]);
        \App\Models\Banco::create([
            "ispb" => "62331228",
            "nome" => "DEUTSCHE BANK S.A.BCO ALEMAO",
            "codigo" => '487',
            "nome_completo" => "DEUTSCHE BANK S.A. - BANCO ALEMAO"
        ]);
        \App\Models\Banco::create([
            "ispb" => "62421979",
            "nome" => "BANCO CIFRA",
            "codigo" => '233',
            "nome_completo" => "Banco Cifra S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "65913436",
            "nome" => "GUIDE",
            "codigo" => '177',
            "nome_completo" => "Guide Investimentos S.A. Corretora de Valores"
        ]);
        \App\Models\Banco::create([
            "ispb" => "67030395",
            "nome" => "TRUSTEE DTVM LTDA.",
            "codigo" => '438',
            "nome_completo" => "TRUSTEE DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIÁRIOS LTDA."
        ]);
        \App\Models\Banco::create([
            "ispb" => "68757681",
            "nome" => "SIMPAUL",
            "codigo" => '365',
            "nome_completo" => "SIMPAUL CORRETORA DE CAMBIO E VALORES MOBILIARIOS  S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "68900810",
            "nome" => "BCO RENDIMENTO S.A.",
            "codigo" => '633',
            "nome_completo" => "Banco Rendimento S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "71027866",
            "nome" => "BCO BS2 S.A.",
            "codigo" => '218',
            "nome_completo" => "Banco BS2 S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "71590442",
            "nome" => "LASTRO RDV DTVM LTDA",
            "codigo" => '293',
            "nome_completo" => "Lastro RDV Distribuidora de Títulos e Valores Mobiliários Ltda."
        ]);
        \App\Models\Banco::create([
            "ispb" => "71677850",
            "nome" => "FRENTE CC S.A.",
            "codigo" => '285',
            "nome_completo" => "FRENTE CORRETORA DE CÂMBIO S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "73622748",
            "nome" => "B&T CC LTDA.",
            "codigo" => '080',
            "nome_completo" => "B&T CORRETORA DE CAMBIO LTDA."
        ]);
        \App\Models\Banco::create([
            "ispb" => "74828799",
            "nome" => "NOVO BCO CONTINENTAL S.A. - BM",
            "codigo" => '753',
            "nome_completo" => "Novo Banco Continental S.A. - Banco Múltiplo"
        ]);
        \App\Models\Banco::create([
            "ispb" => "75647891",
            "nome" => "BCO CRÉDIT AGRICOLE BR S.A.",
            "codigo" => '222',
            "nome_completo" => "BANCO CRÉDIT AGRICOLE BRASIL S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "76461557",
            "nome" => "CCR COOPAVEL",
            "codigo" => '281',
            "nome_completo" => "Cooperativa de Crédito Rural Coopavel"
        ]);
        \App\Models\Banco::create([
            "ispb" => "76543115",
            "nome" => "BANCO SISTEMA",
            "codigo" => '754',
            "nome_completo" => "Banco Sistema S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "76641497",
            "nome" => "DOURADA CORRETORA",
            "codigo" => '311',
            "nome_completo" => "DOURADA CORRETORA DE CÂMBIO LTDA."
        ]);
        \App\Models\Banco::create([
            "ispb" => "78157146",
            "nome" => "CREDIALIANÇA CCR",
            "codigo" => '098',
            "nome_completo" => "Credialiança Cooperativa de Crédito Rural"
        ]);
        \App\Models\Banco::create([
            "ispb" => "78626983",
            "nome" => "BCO VR S.A.",
            "codigo" => '610',
            "nome_completo" => "Banco VR S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "78632767",
            "nome" => "BCO OURINVEST S.A.",
            "codigo" => '712',
            "nome_completo" => "Banco Ourinvest S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "80271455",
            "nome" => "BCO RNX S.A.",
            "codigo" => '720',
            "nome_completo" => "BANCO RNX S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "81723108",
            "nome" => "CREDICOAMO",
            "codigo" => '010',
            "nome_completo" => "CREDICOAMO CREDITO RURAL COOPERATIVA"
        ]);
        \App\Models\Banco::create([
            "ispb" => "82096447",
            "nome" => "CREDIBRF COOP",
            "codigo" => '440',
            "nome_completo" => "CREDIBRF - COOPERATIVA DE CRÉDITO"
        ]);
        \App\Models\Banco::create([
            "ispb" => "87963450",
            "nome" => "MAGNETIS - DTVM",
            "codigo" => '442',
            "nome_completo" => "MAGNETIS - DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIÁRIOS LTDA"
        ]);
        \App\Models\Banco::create([
            "ispb" => "89960090",
            "nome" => "RB INVESTIMENTOS DTVM LTDA.",
            "codigo" => '283',
            "nome_completo" => "RB INVESTIMENTOS DISTRIBUIDORA DE TITULOS E VALORES MOBILIARIOS LIMITADA"
        ]);
        \App\Models\Banco::create([
            "ispb" => "90400888",
            "nome" => "BCO SANTANDER (BRASIL) S.A.",
            "codigo" => '033',
            "nome_completo" => "BANCO SANTANDER (BRASIL) S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "91884981",
            "nome" => "BANCO JOHN DEERE S.A.",
            "codigo" => '217',
            "nome_completo" => "Banco John Deere S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "92702067",
            "nome" => "BCO DO ESTADO DO RS S.A.",
            "codigo" => '041',
            "nome_completo" => "Banco do Estado do Rio Grande do Sul S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "92856905",
            "nome" => "ADVANCED CC LTDA",
            "codigo" => '117',
            "nome_completo" => "ADVANCED CORRETORA DE CÂMBIO LTDA"
        ]);
        \App\Models\Banco::create([
            "ispb" => "92874270",
            "nome" => "BCO DIGIMAIS S.A.",
            "codigo" => '654',
            "nome_completo" => "BANCO DIGIMAIS S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "92875780",
            "nome" => "WARREN CVMC LTDA",
            "codigo" => '371',
            "nome_completo" => "WARREN CORRETORA DE VALORES MOBILIÁRIOS E CÂMBIO LTDA."
        ]);
        \App\Models\Banco::create([
            "ispb" => "92894922",
            "nome" => "BANCO ORIGINAL",
            "codigo" => '212',
            "nome_completo" => "Banco Original S.A."
        ]);
        \App\Models\Banco::create([
            "ispb" => "94968518",
            "nome" => "EFX CC LTDA.",
            "codigo" => '289',
            "nome_completo" => "EFX CORRETORA DE CÂMBIO LTDA."
        ]);
    }

    public function geraSistemas()
    {
        Sistema::create(['nome' => 'Saikoo']);
        Sistema::create(['nome' => 'Terminal Bematech']);
        Sistema::create(['nome' => 'Mobile']);
        Sistema::create(['nome' => 'Touch']);
        Sistema::create(['nome' => 'SMS']);
        Sistema::create(['nome' => 'Comanda App']);
        Sistema::create(['nome' => 'Terminal App']);
        Sistema::create(['nome' => 'AutoAtendimento']);
        Sistema::create(['nome' => 'EstoqueApp']);
        Sistema::create(['nome' => 'OrçamentoApp']);
        Sistema::create(['nome' => 'Saikoo Veterinária']);
        Sistema::create(['nome' => 'Agenda Online App']);
        Sistema::create(['nome' => 'SaikooWeb']);
        Sistema::create(['nome' => 'Onda Eleitoral']);
        Sistema::create(['nome' => 'Website']);
        
    }

    public function geraModulos()
    {
        Modulo::create(['sistema_id' => 1, 'nome' => 'Cadastros']);
        Modulo::create(['sistema_id' => 1, 'nome' => 'Atendimento']);
        Modulo::create(['sistema_id' => 1, 'nome' => 'Estoque']);
        Modulo::create(['sistema_id' => 1, 'nome' => 'Financeiro']);
        Modulo::create(['sistema_id' => 1, 'nome' => 'Relatórios']);
        Modulo::create(['sistema_id' => 1, 'nome' => 'Cupom Fiscal']);
        Modulo::create(['sistema_id' => 1, 'nome' => 'Nota Eletrônica']);
        Modulo::create(['sistema_id' => 1, 'nome' => 'Locação']);
        Modulo::create(['sistema_id' => 1, 'nome' => 'Utilitarios']);
        Modulo::create(['sistema_id' => 1, 'nome' => 'Janelas']);
        
        Modulo::create(['sistema_id' => 4, 'nome' => 'Comanda']);
        Modulo::create(['sistema_id' => 4, 'nome' => 'Comissões']);
        Modulo::create(['sistema_id' => 4, 'nome' => 'Agenda']);
        Modulo::create(['sistema_id' => 4, 'nome' => 'Consulta de Preço']);
        Modulo::create(['sistema_id' => 4, 'nome' => 'Tela de Login']);

        Modulo::create(['sistema_id' => 3, 'nome' => 'Agenda do Dia']);
        Modulo::create(['sistema_id' => 3, 'nome' => 'Comissões']);
        Modulo::create(['sistema_id' => 3, 'nome' => 'Gestão de Clientes']);
        Modulo::create(['sistema_id' => 3, 'nome' => 'Comanda']);
        Modulo::create(['sistema_id' => 3, 'nome' => 'Orçamento']);
        Modulo::create(['sistema_id' => 3, 'nome' => 'Movimentação em Conta']);
        Modulo::create(['sistema_id' => 3, 'nome' => 'Pacotes']);
        Modulo::create(['sistema_id' => 3, 'nome' => 'Notificação']);

        Modulo::create(['sistema_id' => 5, 'nome' => 'Envio de SMS']);

        Modulo::create(['sistema_id' => 6, 'nome' => 'Comanda']);

        Modulo::create(['sistema_id' => 7, 'nome' => 'Agenda']);

        Modulo::create(['sistema_id' => 8, 'nome' => 'Venda Rápida']);

        Modulo::create(['sistema_id' => 9, 'nome' => 'Listagem de Inventário']);

        Modulo::create(['sistema_id' => 10, 'nome' => 'Menu Principal']);
        Modulo::create(['sistema_id' => 10, 'nome' => 'Orçamento']);
        Modulo::create(['sistema_id' => 10, 'nome' => 'Clientes']);
        Modulo::create(['sistema_id' => 10, 'nome' => 'Detalhe do Orçamento']);
        Modulo::create(['sistema_id' => 10, 'nome' => 'Item do Orçamento']);


        Modulo::create(['sistema_id' => 11, 'nome' => 'Cadastros']);
        Modulo::create(['sistema_id' => 11, 'nome' => 'Atendimento']);
        Modulo::create(['sistema_id' => 11, 'nome' => 'Estoque']);
        Modulo::create(['sistema_id' => 11, 'nome' => 'Financeiro']);
        Modulo::create(['sistema_id' => 11, 'nome' => 'Relatórios']);
        Modulo::create(['sistema_id' => 11, 'nome' => 'Cupom Fiscal']);
        Modulo::create(['sistema_id' => 11, 'nome' => 'Nota Eletrônica']);
        Modulo::create(['sistema_id' => 11, 'nome' => 'Locação']);
        Modulo::create(['sistema_id' => 11, 'nome' => 'Utilitarios']);
        Modulo::create(['sistema_id' => 11, 'nome' => 'Janelas']);
    }

    public function geraTelas()
    {
        Tela::create([
            'modulo_id' => '1',
            'nome' => 'Pesquisa Pessoa Física \/ Jurídica',
        ]);
        Tela::create([
            'modulo_id' => '1',
            'nome' => 'Pesquisa Produtos, Serviços e Pacotes',
        ]);
        Tela::create([
            'modulo_id' => '1',
            'nome' => 'Pesquisa de Profissionais',
        ]);
        Tela::create([
            'modulo_id' => '1',
            'nome' => 'Pesquisa de Conta Movimento',
        ]);
        Tela::create([
            'modulo_id' => '1',
            'nome' => 'Pesquisa de Bancos',
        ]);
        Tela::create([
            'modulo_id' => '1',
            'nome' => 'Pesquisa de Cartões',
        ]);
        Tela::create([
            'modulo_id' => '1',
            'nome' => 'Pesquisa de Centro de Custo',
        ]);
        Tela::create([
            'modulo_id' => '1',
            'nome' => 'Cadastro de Plano de Contas',
        ]);
        Tela::create([
            'modulo_id' => '1',
            'nome' => 'Pesquisa de Tipo de Documentos',
        ]);
        Tela::create([
            'modulo_id' => '1',
            'nome' => 'Pesquisa de Salas',
        ]);
        Tela::create([
            'modulo_id' => '1',
            'nome' => 'Pesquisa de Grupos de Produtos e Serviços',
        ]);
        Tela::create([
            'modulo_id' => '1',
            'nome' => 'Pesquisa de Unidade de Media',
        ]);
        Tela::create([
            'modulo_id' => '1',
            'nome' => 'Pesquisa de Marcas \/ Fabricantes',
        ]);
        Tela::create([
            'modulo_id' => '1',
            'nome' => 'Pesquisa de Setor',
        ]);
        Tela::create([
            'modulo_id' => '1',
            'nome' => 'Pesquisa de Tipo de Tributação',
        ]);
        Tela::create([
            'modulo_id' => '1',
            'nome' => 'Pesquisa de Feriado',
        ]);
        Tela::create([
            'modulo_id' => '1',
            'nome' => 'Pesquisa de Profissões',
        ]);
        Tela::create([
            'modulo_id' => '1',
            'nome' => 'Pesquisa de Cidades, Estados e Países',
        ]);
        Tela::create([
            'modulo_id' => '1',
            'nome' => 'Pesquisa de PrÃªmios (Programa de Fidelidade)',
        ]);
        Tela::create([
            'modulo_id' => '1',
            'nome' => 'Pesquisa de Grupo de SMS',
        ]);
        Tela::create([
            'modulo_id' => '1',
            'nome' => 'Pesquisa de C.I.D. (Classificação Internacional de Doenças)',
        ]);
        Tela::create([
            'modulo_id' => '1',
            'nome' => 'Pesquisa de Promoções',
        ]);
        Tela::create([
            'modulo_id' => '1',
            'nome' => 'Pesquisa de Modelo de Receituário',
        ]);
        Tela::create([
            'modulo_id' => '1',
            'nome' => 'Pesquisa de Modelo de Encaminhamento',
        ]);
        Tela::create([
            'modulo_id' => '1',
            'nome' => 'Pesquisa de Modelo de Exame Médico',
        ]);
        Tela::create([
            'modulo_id' => '2',
            'nome' => 'Comanda \/ Venda',
        ]);
        Tela::create([
            'modulo_id' => '2',
            'nome' => 'Comandas Finalizadas',
        ]);
        Tela::create([
            'modulo_id' => '2',
            'nome' => 'Agenda de Horário',
        ]);
        Tela::create([
            'modulo_id' => '2',
            'nome' => 'Agenda de Salas',
        ]);
        Tela::create([
            'modulo_id' => '2',
            'nome' => 'Gestão do Cliente',
        ]);
        Tela::create([
            'modulo_id' => '2',
            'nome' => 'Cancelar Pacotes de Serviços',
        ]);
        Tela::create([
            'modulo_id' => '2',
            'nome' => 'Orçamento',
        ]);
        Tela::create([
            'modulo_id' => '2',
            'nome' => 'Programa de Fidelidade',
        ]);
        Tela::create([
            'modulo_id' => '2',
            'nome' => 'Pesquisa de Avaliação Corporal',
        ]);
        Tela::create([
            'modulo_id' => '2',
            'nome' => 'Pesquisa de Atestado',
        ]);
        Tela::create([
            'modulo_id' => '2',
            'nome' => 'Pesquisa de Receituário',
        ]);
        Tela::create([
            'modulo_id' => '2',
            'nome' => 'Pesquisa de Encaminhamento',
        ]);
        Tela::create([
            'modulo_id' => '2',
            'nome' => 'Pesquisa de Ficha Anatomopatológica',
        ]);
        Tela::create([
            'modulo_id' => '2',
            'nome' => 'Pesquisa de Exame Médico',
        ]);
        Tela::create([
            'modulo_id' => '2',
            'nome' => 'Pesquisa de Orientação Pós Procedimento',
        ]);
        Tela::create([
            'modulo_id' => '3',
            'nome' => 'Pesquisa de Pedido de Compra',
        ]);
        Tela::create([
            'modulo_id' => '3',
            'nome' => 'Recebimento do Pedido de Compra',
        ]);
        Tela::create([
            'modulo_id' => '3',
            'nome' => 'Pesquisa de Nota Fiscal de Entrada',
        ]);
        Tela::create([
            'modulo_id' => '3',
            'nome' => 'Pesquisa de TransferÃªncia de Produtos',
        ]);
        Tela::create([
            'modulo_id' => '3',
            'nome' => 'Pesquisa de Saída de Produtos',
        ]);
        Tela::create([
            'modulo_id' => '3',
            'nome' => 'Inventário de Estoque',
        ]);
        Tela::create([
            'modulo_id' => '3',
            'nome' => 'Reajuste de Preço de Produtos',
        ]);
        Tela::create([
            'modulo_id' => '4',
            'nome' => 'Pesquisa de Contas a Receber',
        ]);
        Tela::create([
            'modulo_id' => '4',
            'nome' => 'Recebimento de Cartão de Crédito',
        ]);
        Tela::create([
            'modulo_id' => '4',
            'nome' => 'Recebimento de Boleto',
        ]);
        Tela::create([
            'modulo_id' => '4',
            'nome' => 'Recebimento de Boleto - Arquivo de Retorno',
        ]);
        Tela::create([
            'modulo_id' => '4',
            'nome' => 'Boleto - Gerar Arquivo de Remessa',
        ]);
        Tela::create([
            'modulo_id' => '4',
            'nome' => 'Pesquisa de Contas a Pagar',
        ]);
        Tela::create([
            'modulo_id' => '4',
            'nome' => 'Controle de Pagamento de Contas',
        ]);
        Tela::create([
            'modulo_id' => '4',
            'nome' => 'Pagamento de Adiantamentos',
        ]);
        Tela::create([
            'modulo_id' => '4',
            'nome' => 'Estorno de Pagamentos',
        ]);
        Tela::create([
            'modulo_id' => '4',
            'nome' => 'Pagamento de Comissão Individual',
        ]);
        Tela::create([
            'modulo_id' => '4',
            'nome' => 'Pagamento de Comissão em Lote',
        ]);
        Tela::create([
            'modulo_id' => '4',
            'nome' => 'Bloqueio de Comissão',
        ]);
        Tela::create([
            'modulo_id' => '4',
            'nome' => 'Pesquisa de Cheques',
        ]);
        Tela::create([
            'modulo_id' => '4',
            'nome' => 'Depósito de Cheque',
        ]);
        Tela::create([
            'modulo_id' => '4',
            'nome' => 'Devolução de Cheque',
        ]);
        Tela::create([
            'modulo_id' => '4',
            'nome' => 'Negociação de Cheque',
        ]);
        Tela::create([
            'modulo_id' => '4',
            'nome' => 'Abertura de Caixa',
        ]);
        Tela::create([
            'modulo_id' => '4',
            'nome' => 'Fechamento de Caixa',
        ]);
        Tela::create([
            'modulo_id' => '4',
            'nome' => 'Suprimento de Caixa',
        ]);
        Tela::create([
            'modulo_id' => '4',
            'nome' => 'Sangria de Caixa',
        ]);
        Tela::create([
            'modulo_id' => '4',
            'nome' => 'Pesquisa de Caixa',
        ]);
        Tela::create([
            'modulo_id' => '4',
            'nome' => 'Movimentações em Conta',
        ]);
        Tela::create([
            'modulo_id' => '7',
            'nome' => 'NF-e Configuração',
        ]);
        Tela::create([
            'modulo_id' => '7',
            'nome' => 'Cancelamento de NFe',
        ]);
        Tela::create([
            'modulo_id' => '7',
            'nome' => 'Carta de Correção da NF-e',
        ]);
        Tela::create([
            'modulo_id' => '7',
            'nome' => 'Inutilizar Numeração NF-e',
        ]);
        Tela::create([
            'modulo_id' => '7',
            'nome' => 'Pesquisa de Emissão NF-e (Devolução Entrada)',
        ]);
        Tela::create([
            'modulo_id' => '7',
            'nome' => 'Nota Fiscal Consumidor - Configuração',
        ]);
        Tela::create([
            'modulo_id' => '7',
            'nome' => 'Cancelamento de NFC-e',
        ]);
        Tela::create([
            'modulo_id' => '7',
            'nome' => 'Inutilizar Numeração NFC-e',
        ]);
        Tela::create([
            'modulo_id' => '8',
            'nome' => 'Pesquisa de Tipo de Eventos',
        ]);
        Tela::create([
            'modulo_id' => '8',
            'nome' => 'Pesquisa de Reserva Locação',
        ]);
        Tela::create([
            'modulo_id' => '8',
            'nome' => 'Devolução de Locação',
        ]);
        Tela::create([
            'modulo_id' => '8',
            'nome' => 'Notas de Débitos - Emitidas',
        ]);
        Tela::create([
            'modulo_id' => '8',
            'nome' => 'Relatório de Nota de Débito',
        ]);
        Tela::create([
            'modulo_id' => '8',
            'nome' => 'Relatório de Reserva',
        ]);
        Tela::create([
            'modulo_id' => '9',
            'nome' => 'Alterar Senha do Usuário do Sistema',
        ]);
        Tela::create([
            'modulo_id' => '9',
            'nome' => 'Pesquisa de Usuário do Sistema',
        ]);
        Tela::create([
            'modulo_id' => '9',
            'nome' => 'Pesquisa de Perfil de Acesso',
        ]);
        Tela::create([
            'modulo_id' => '9',
            'nome' => 'ParÃ¢metros do Sistema',
        ]);
        Tela::create([
            'modulo_id' => '9',
            'nome' => 'Lembretes da Semana',
        ]);
        Tela::create([
            'modulo_id' => '9',
            'nome' => 'Pesquisa de Filial',
        ]);
        Tela::create([
            'modulo_id' => '9',
            'nome' => 'Pesquisa de Fórmulas',
        ]);
        Tela::create([
            'modulo_id' => '9',
            'nome' => 'Configurar \/ Enviar SMS',
        ]);
        Tela::create([
            'modulo_id' => '9',
            'nome' => 'SPED Fiscal',
        ]);
        Tela::create([
            'modulo_id' => '9',
            'nome' => 'Gerar XML da NFS-e',
        ]);
        Tela::create([
            'modulo_id' => '9',
            'nome' => 'BackUp do Banco de Dados',
        ]);
        Tela::create([
            'modulo_id' => '9',
            'nome' => 'Configurar Impressora Texto',
        ]);
        Tela::create([
            'modulo_id' => '9',
            'nome' => 'Exportação \/ Importação de Produtos',
        ]);
        Tela::create([
            'modulo_id' => '9',
            'nome' => 'Importação Carga Tributária - IBPT',
        ]);
        Tela::create([
            'modulo_id' => '1',
            'nome' => 'Pesquisa Detalhe Produto',
        ]);
        Tela::create([
            'modulo_id' => '5',
            'nome' => 'Cadastros',
        ]);
        Tela::create([
            'modulo_id' => '5',
            'nome' => 'Agenda de Horário',
        ]);
        Tela::create([
            'modulo_id' => '5',
            'nome' => 'Comandas e Vendas',
        ]);
        Tela::create([
            'modulo_id' => '5',
            'nome' => 'Estoque',
        ]);
        Tela::create([
            'modulo_id' => '5',
            'nome' => 'Caixa',
        ]);
        Tela::create([
            'modulo_id' => '5',
            'nome' => 'Financeiro',
        ]);
        Tela::create([
            'modulo_id' => '8',
            'nome' => 'Relatório - Posição de Estoque',
        ]);
        Tela::create([
            'modulo_id' => '8',
            'nome' => 'Relatório - Plano de Conta Detalhado',
        ]);
        Tela::create([
            'modulo_id' => '11',
            'nome' => 'Inserir Serviço na Comanda',
        ]);
        Tela::create([
            'modulo_id' => '12',
            'nome' => 'Relação de Comissões',
        ]);
        Tela::create([
            'modulo_id' => '13',
            'nome' => 'Agenda',
        ]);
        Tela::create([
            'modulo_id' => '14',
            'nome' => 'Consulta de Preço',
        ]);
        Tela::create([
            'modulo_id' => '15',
            'nome' => 'Agenda do Dia',
        ]);
        Tela::create([
            'modulo_id' => '15',
            'nome' => 'Agendamento',
        ]);
        Tela::create([
            'modulo_id' => '16',
            'nome' => 'Comissões',
        ]);
        Tela::create([
            'modulo_id' => '17',
            'nome' => 'Pesquisa Cliente',
        ]);
        Tela::create([
            'modulo_id' => '17',
            'nome' => 'Tela de Opções de Consulta',
        ]);
        Tela::create([
            'modulo_id' => '17',
            'nome' => 'Opção de Consulta - Comanda',
        ]);
        Tela::create([
            'modulo_id' => '17',
            'nome' => 'Opção de Consulta - Débito',
        ]);
        Tela::create([
            'modulo_id' => '17',
            'nome' => 'Opção de Consulta - Cheque',
        ]);
        Tela::create([
            'modulo_id' => '17',
            'nome' => 'Opção de Consulta - Serviços',
        ]);
        Tela::create([
            'modulo_id' => '17',
            'nome' => 'Opção de Consulta - Produtos',
        ]);
        Tela::create([
            'modulo_id' => '18',
            'nome' => 'Listagem de Comanda',
        ]);
        Tela::create([
            'modulo_id' => '18',
            'nome' => 'Informações da Comanda',
        ]);
        Tela::create([
            'modulo_id' => '19',
            'nome' => 'Listagem de Orçamento',
        ]);
        Tela::create([
            'modulo_id' => '19',
            'nome' => 'Informações do Orçamento',
        ]);
        Tela::create([
            'modulo_id' => '20',
            'nome' => 'Movimentações em Conta',
        ]);
        Tela::create([
            'modulo_id' => '21',
            'nome' => 'Listagem de Pacotes',
        ]);
        Tela::create([
            'modulo_id' => '22',
            'nome' => 'Listagem de Notificações',
        ]);
        Tela::create([
            'modulo_id' => '2',
            'nome' => 'Venda Rápida',
        ]);
        Tela::create([
            'modulo_id' => '1',
            'nome' => 'Pesquisa de Contato com Cliente',
        ]);
        Tela::create([
            'modulo_id' => '25',
            'nome' => 'Lançamento de item',
        ]);
        Tela::create([
            'modulo_id' => '25',
            'nome' => 'Comandas',
        ]);
        Tela::create([
            'modulo_id' => '26',
            'nome' => 'Agenda',
        ]);
        Tela::create([
            'modulo_id' => '1',
            'nome' => 'Nova Tela',
        ]);
        Tela::create([
            'modulo_id' => '2',
            'nome' => 'Nova Tela',
        ]);
        Tela::create([
            'modulo_id' => '3',
            'nome' => 'Nova Tela',
        ]);
        Tela::create([
            'modulo_id' => '4',
            'nome' => 'Nova Tela',
        ]);
        Tela::create([
            'modulo_id' => '5',
            'nome' => 'Nova Tela',
        ]);
        Tela::create([
            'modulo_id' => '1',
            'nome' => 'Código Promocional',
        ]);
        Tela::create([
            'modulo_id' => '34',
            'nome' => 'Pesquisa Pessoa Física \/ Jurídica',
        ]);
        Tela::create([
            'modulo_id' => '34',
            'nome' => 'Pesquisa Produtos, Serviços e Pacotes',
        ]);
        Tela::create([
            'modulo_id' => '34',
            'nome' => 'Pesquisa de Profissionais',
        ]);
        Tela::create([
            'modulo_id' => '34',
            'nome' => 'Pesquisa de Conta Movimento',
        ]);
        Tela::create([
            'modulo_id' => '34',
            'nome' => 'Pesquisa de Bancos',
        ]);
        Tela::create([
            'modulo_id' => '34',
            'nome' => 'Pesquisa de Cartões',
        ]);
        Tela::create([
            'modulo_id' => '34',
            'nome' => 'Pesquisa de Centro de Custo',
        ]);
        Tela::create([
            'modulo_id' => '34',
            'nome' => 'Cadastro de Plano de Contas',
        ]);
        Tela::create([
            'modulo_id' => '34',
            'nome' => 'Pesquisa de Tipo de Documentos',
        ]);
        Tela::create([
            'modulo_id' => '34',
            'nome' => 'Pesquisa de Salas',
        ]);
        Tela::create([
            'modulo_id' => '34',
            'nome' => 'Pesquisa de Grupos de Produtos e Serviços',
        ]);
        Tela::create([
            'modulo_id' => '34',
            'nome' => 'Pesquisa de Unidade de Media',
        ]);
        Tela::create([
            'modulo_id' => '34',
            'nome' => 'Pesquisa de Marcas \/ Fabricantes',
        ]);
        Tela::create([
            'modulo_id' => '34',
            'nome' => 'Pesquisa de Setor',
        ]);
        Tela::create([
            'modulo_id' => '34',
            'nome' => 'Pesquisa de Tipo de Tributação',
        ]);
        Tela::create([
            'modulo_id' => '34',
            'nome' => 'Pesquisa de Feriado',
        ]);
        Tela::create([
            'modulo_id' => '34',
            'nome' => 'Pesquisa de Profissões',
        ]);
        Tela::create([
            'modulo_id' => '34',
            'nome' => 'Pesquisa de Cidades, Estados e Países',
        ]);
        Tela::create([
            'modulo_id' => '34',
            'nome' => 'Pesquisa de PrÃªmios (Programa de Fidelidade)',
        ]);
        Tela::create([
            'modulo_id' => '34',
            'nome' => 'Pesquisa de Grupo de SMS',
        ]);
        Tela::create([
            'modulo_id' => '34',
            'nome' => 'Pesquisa de C.I.D. (Classificação Internacional de Doenças)',
        ]);
        Tela::create([
            'modulo_id' => '34',
            'nome' => 'Pesquisa de Promoções',
        ]);
        Tela::create([
            'modulo_id' => '34',
            'nome' => 'Pesquisa de Modelo de Receituário',
        ]);
        Tela::create([
            'modulo_id' => '34',
            'nome' => 'Pesquisa de Modelo de Encaminhamento',
        ]);
        Tela::create([
            'modulo_id' => '34',
            'nome' => 'Pesquisa de Modelo de Exame Médico',
        ]);
        Tela::create([
            'modulo_id' => '35',
            'nome' => 'Comanda \/ Venda',
        ]);
        Tela::create([
            'modulo_id' => '35',
            'nome' => 'Comandas Finalizadas',
        ]);
        Tela::create([
            'modulo_id' => '35',
            'nome' => 'Agenda de Horário',
        ]);
        Tela::create([
            'modulo_id' => '35',
            'nome' => 'Agenda de Salas',
        ]);
        Tela::create([
            'modulo_id' => '35',
            'nome' => 'Gestão do Cliente',
        ]);
        Tela::create([
            'modulo_id' => '35',
            'nome' => 'Cancelar Pacotes de Serviços',
        ]);
        Tela::create([
            'modulo_id' => '35',
            'nome' => 'Orçamento',
        ]);
        Tela::create([
            'modulo_id' => '35',
            'nome' => 'Programa de Fidelidade',
        ]);
        Tela::create([
            'modulo_id' => '35',
            'nome' => 'Pesquisa de Avaliação Corporal',
        ]);
        Tela::create([
            'modulo_id' => '35',
            'nome' => 'Pesquisa de Atestado',
        ]);
        Tela::create([
            'modulo_id' => '35',
            'nome' => 'Pesquisa de Receituário',
        ]);
        Tela::create([
            'modulo_id' => '35',
            'nome' => 'Pesquisa de Encaminhamento',
        ]);
        Tela::create([
            'modulo_id' => '35',
            'nome' => 'Pesquisa de Ficha Anatomopatológica',
        ]);
        Tela::create([
            'modulo_id' => '35',
            'nome' => 'Pesquisa de Exame Médico',
        ]);
        Tela::create([
            'modulo_id' => '35',
            'nome' => 'Pesquisa de Orientação Pós Procedimento',
        ]);
        Tela::create([
            'modulo_id' => '36',
            'nome' => 'Pesquisa de Pedido de Compra',
        ]);
        Tela::create([
            'modulo_id' => '36',
            'nome' => 'Recebimento do Pedido de Compra',
        ]);
        Tela::create([
            'modulo_id' => '36',
            'nome' => 'Pesquisa de Nota Fiscal de Entrada',
        ]);
        Tela::create([
            'modulo_id' => '36',
            'nome' => 'Pesquisa de TransferÃªncia de Produtos',
        ]);
        Tela::create([
            'modulo_id' => '36',
            'nome' => 'Pesquisa de Saída de Produtos',
        ]);
        Tela::create([
            'modulo_id' => '36',
            'nome' => 'Inventário de Estoque',
        ]);
        Tela::create([
            'modulo_id' => '36',
            'nome' => 'Reajuste de Preço de Produtos',
        ]);
        Tela::create([
            'modulo_id' => '37',
            'nome' => 'Pesquisa de Contas a Receber',
        ]);
        Tela::create([
            'modulo_id' => '37',
            'nome' => 'Recebimento de Cartão de Crédito',
        ]);
        Tela::create([
            'modulo_id' => '37',
            'nome' => 'Recebimento de Boleto',
        ]);
        Tela::create([
            'modulo_id' => '37',
            'nome' => 'Recebimento de Boleto - Arquivo de Retorno',
        ]);
        Tela::create([
            'modulo_id' => '37',
            'nome' => 'Boleto - Gerar Arquivo de Remessa',
        ]);
        Tela::create([
            'modulo_id' => '37',
            'nome' => 'Pesquisa de Contas a Pagar',
        ]);
        Tela::create([
            'modulo_id' => '37',
            'nome' => 'Controle de Pagamento de Contas',
        ]);
        Tela::create([
            'modulo_id' => '37',
            'nome' => 'Pagamento de Adiantamentos',
        ]);
        Tela::create([
            'modulo_id' => '37',
            'nome' => 'Estorno de Pagamentos',
        ]);
        Tela::create([
            'modulo_id' => '37',
            'nome' => 'Pagamento de Comissão Individual',
        ]);
        Tela::create([
            'modulo_id' => '37',
            'nome' => 'Pagamento de Comissão em Lote',
        ]);
        Tela::create([
            'modulo_id' => '37',
            'nome' => 'Bloqueio de Comissão',
        ]);
        Tela::create([
            'modulo_id' => '37',
            'nome' => 'Pesquisa de Cheques',
        ]);
        Tela::create([
            'modulo_id' => '37',
            'nome' => 'Depósito de Cheque',
        ]);
        Tela::create([
            'modulo_id' => '37',
            'nome' => 'Devolução de Cheque',
        ]);
        Tela::create([
            'modulo_id' => '37',
            'nome' => 'Negociação de Cheque',
        ]);
        Tela::create([
            'modulo_id' => '37',
            'nome' => 'Abertura de Caixa',
        ]);
        Tela::create([
            'modulo_id' => '37',
            'nome' => 'Fechamento de Caixa',
        ]);
        Tela::create([
            'modulo_id' => '37',
            'nome' => 'Suprimento de Caixa',
        ]);
        Tela::create([
            'modulo_id' => '37',
            'nome' => 'Sangria de Caixa',
        ]);
        Tela::create([
            'modulo_id' => '37',
            'nome' => 'Pesquisa de Caixa',
        ]);
        Tela::create([
            'modulo_id' => '37',
            'nome' => 'Movimentações em Conta',
        ]);
        Tela::create([
            'modulo_id' => '38',
            'nome' => 'NF-e Configuração',
        ]);
        Tela::create([
            'modulo_id' => '38',
            'nome' => 'Cancelamento de NFe',
        ]);
        Tela::create([
            'modulo_id' => '38',
            'nome' => 'Carta de Correção da NF-e',
        ]);
        Tela::create([
            'modulo_id' => '38',
            'nome' => 'Inutilizar Numeração NF-e',
        ]);
        Tela::create([
            'modulo_id' => '38',
            'nome' => 'Pesquisa de Emissão NF-e (Devolução Entrada)',
        ]);
        Tela::create([
            'modulo_id' => '38',
            'nome' => 'Nota Fiscal Consumidor - Configuração',
        ]);
        Tela::create([
            'modulo_id' => '38',
            'nome' => 'Cancelamento de NFC-e',
        ]);
        Tela::create([
            'modulo_id' => '38',
            'nome' => 'Inutilizar Numeração NFC-e',
        ]);
        Tela::create([
            'modulo_id' => '41',
            'nome' => 'Pesquisa de Tipo de Eventos',
        ]);
        Tela::create([
            'modulo_id' => '41',
            'nome' => 'Pesquisa de Reserva Locação',
        ]);
        Tela::create([
            'modulo_id' => '41',
            'nome' => 'Devolução de Locação',
        ]);
        Tela::create([
            'modulo_id' => '41',
            'nome' => 'Notas de Débitos - Emitidas',
        ]);
        Tela::create([
            'modulo_id' => '41',
            'nome' => 'Relatório de Nota de Débito',
        ]);
        Tela::create([
            'modulo_id' => '41',
            'nome' => 'Relatório de Reserva',
        ]);
        Tela::create([
            'modulo_id' => '42',
            'nome' => 'Alterar Senha do Usuário do Sistema',
        ]);
        Tela::create([
            'modulo_id' => '42',
            'nome' => 'Pesquisa de Usuário do Sistema',
        ]);
        Tela::create([
            'modulo_id' => '42',
            'nome' => 'Pesquisa de Perfil de Acesso',
        ]);
        Tela::create([
            'modulo_id' => '42',
            'nome' => 'ParÃ¢metros do Sistema',
        ]);
        Tela::create([
            'modulo_id' => '42',
            'nome' => 'Lembretes da Semana',
        ]);
        Tela::create([
            'modulo_id' => '42',
            'nome' => 'Pesquisa de Filial',
        ]);
        Tela::create([
            'modulo_id' => '42',
            'nome' => 'Pesquisa de Fórmulas',
        ]);
        Tela::create([
            'modulo_id' => '42',
            'nome' => 'Configurar \/ Enviar SMS',
        ]);
        Tela::create([
            'modulo_id' => '42',
            'nome' => 'SPED Fiscal',
        ]);
        Tela::create([
            'modulo_id' => '42',
            'nome' => 'Gerar XML da NFS-e',
        ]);
        Tela::create([
            'modulo_id' => '42',
            'nome' => 'BackUp do Banco de Dados',
        ]);
        Tela::create([
            'modulo_id' => '42',
            'nome' => 'Configurar Impressora Texto',
        ]);
        Tela::create([
            'modulo_id' => '42',
            'nome' => 'Exportação \/ Importação de Produtos',
        ]);
        Tela::create([
            'modulo_id' => '42',
            'nome' => 'Importação Carga Tributária - IBPT',
        ]);
        Tela::create([
            'modulo_id' => '34',
            'nome' => 'Pesquisa Detalhe Produto',
        ]);
        Tela::create([
            'modulo_id' => '38',
            'nome' => 'Cadastros',
        ]);
        Tela::create([
            'modulo_id' => '38',
            'nome' => 'Agenda de Horário',
        ]);
        Tela::create([
            'modulo_id' => '38',
            'nome' => 'Comandas e Vendas',
        ]);
        Tela::create([
            'modulo_id' => '38',
            'nome' => 'Estoque',
        ]);
        Tela::create([
            'modulo_id' => '38',
            'nome' => 'Caixa',
        ]);
        Tela::create([
            'modulo_id' => '38',
            'nome' => 'Financeiro',
        ]);
        Tela::create([
            'modulo_id' => '41',
            'nome' => 'Relatório - Posição de Estoque',
        ]);
        Tela::create([
            'modulo_id' => '41',
            'nome' => 'Relatório - Plano de Conta Detalhado',
        ]);
        Tela::create([
            'modulo_id' => '2',
            'nome' => 'Venda Rápida',
        ]);
        Tela::create([
            'modulo_id' => '34',
            'nome' => 'Pesquisa de Contato com Cliente',
        ]);
        Tela::create([
            'modulo_id' => '34',
            'nome' => 'Nova Tela',
        ]);
        Tela::create([
            'modulo_id' => '35',
            'nome' => 'Nova Tela',
        ]);
        Tela::create([
            'modulo_id' => '36',
            'nome' => 'Nova Tela',
        ]);
        Tela::create([
            'modulo_id' => '37',
            'nome' => 'Nova Tela',
        ]);
        Tela::create([
            'modulo_id' => '38',
            'nome' => 'Nova Tela',
        ]);
        Tela::create([
            'modulo_id' => '34',
            'nome' => 'Código Promocional',
        ]);
        Tela::create([
            'modulo_id' => '9',
            'nome' => 'Configurar TEF - Pinpad',
        ]);
        Tela::create([
            'modulo_id' => '2',
            'nome' => 'Ficha de Anamnese',
        ]);
        Tela::create([
            'modulo_id' => '35',
            'nome' => 'Atendimento Animal',
        ]);
        Tela::create([
            'modulo_id' => '7',
            'nome' => 'NFS-e',
        ]);
    }

    public function geraConfigIndiceReajuste()
    {
        ConfiguracaoReajusteMassa::create([
            'nome' => 'Reajuste padrão anual',
            'data_inicio' => now(),
            'cadastrado_em' => now(),
            'atualizado_em' => now(),
        ]);
    }
}
