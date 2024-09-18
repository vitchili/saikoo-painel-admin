<?php

namespace App\Console\Commands;

use App\Gateway\ConsultaIndicesIGPM;
use App\Models\Igpm;
use Illuminate\Console\Command;

class ConsultarIndicesIGPM extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:consultar-indices-igpm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consultar índices IGPM e gerar no banco de dados caso não tenha cadastrado.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $indicesCadastrados = Igpm::latest()->first();

        $bancoCentral = new ConsultaIndicesIGPM();
        $indices = $bancoCentral->consultarHistoricoIndicesIGPM();
        $indiceMaisRecente = $indices[count($indices) - 1];

        if (empty($indicesCadastrados) || ($indicesCadastrados->data != $indiceMaisRecente['data'] && $indicesCadastrados->valor != $indiceMaisRecente['valor'])) {
            Igpm::create([
                'data' => $indiceMaisRecente['data'],
                'valor' => $indiceMaisRecente['valor'],
            ]);
        }
    }
}
