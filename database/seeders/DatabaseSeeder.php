<?php

namespace Database\Seeders;

use App\Models\Chamado\DepartamentoChamado;
use App\Models\Chamado\MeioAberturaChamado;
use App\Models\Chamado\SituacaoChamado;
use App\Models\Cliente\TipoCliente;
use App\Models\Cliente\TipoContatoPessoaCliente;
use App\Models\Cliente\TipoRedeSocialCliente;
use App\Models\PeriodicidadeLembrete;
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

        /* Situacao do chamado */
        SituacaoChamado::create([
            'nome' => 'Aberto',
        ]);

        SituacaoChamado::create([
            'nome' => 'Confirmado',
        ]);

        SituacaoChamado::create([
            'nome' => 'Em atendimento',
        ]);

        SituacaoChamado::create([
            'nome' => 'Concluído',
        ]);

        SituacaoChamado::create([
            'nome' => 'Cancelado',
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

    }
}
