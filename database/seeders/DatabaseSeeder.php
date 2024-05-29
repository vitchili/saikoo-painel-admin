<?php

namespace Database\Seeders;

use App\Models\Chamado\DepartamentoChamado;
use App\Models\Chamado\MeioAberturaChamado;
use App\Models\Chamado\SituacaoChamado;
use App\Models\Cliente\TipoCliente;
use App\Models\Cliente\TipoContatoPessoaCliente;
use App\Models\Periodicidade;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /* Periodicidade do chamado */
        Periodicidade::create([
            'nome' => 'Atípico',
        ]);

        Periodicidade::create([
            'nome' => 'Diário',
        ]);

        Periodicidade::create([
            'nome' => 'Semanal',
        ]);

        Periodicidade::create([
            'nome' => 'Quinzenal',
        ]);

        Periodicidade::create([
            'nome' => 'Mensal',
        ]);

        Periodicidade::create([
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

    }
}
