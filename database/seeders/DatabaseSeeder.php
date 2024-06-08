<?php

namespace Database\Seeders;

use App\Models\Chamado\DepartamentoChamado;
use App\Models\Chamado\MeioAberturaChamado;
use App\Models\Chamado\SituacaoChamado;
use App\Models\Chamado\TipoChamado;
use App\Models\Cliente\Servico\TipoServicoCliente;
use App\Models\Cliente\TipoCliente;
use App\Models\Cliente\TipoContatoPessoaCliente;
use App\Models\Cliente\TipoRedeSocialCliente;
use App\Models\Diversos\Veiculo;
use App\Models\Lembrete\PeriodicidadeLembrete;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
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
    }
}
