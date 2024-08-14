<?php

namespace App\Console\Commands;

use App\Gateway\ConsultaIndicesIGPM;
use App\Models\Igpm;
use Illuminate\Console\Command;

class GerarTodosIndicesIGPM extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:gerar-indices-igpm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gerar todos índices IGPM cadastrados no Banco Central. Executar uma unica vez.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $bancoCentral = new ConsultaIndicesIGPM();
        $indices = $bancoCentral->consultarHistoricoIndicesIGPM();

        foreach ($indices as $indice) {
            Igpm::create([
                'data' => $indice['data'],
                'valor' => $indice['valor'],
            ]);
        }
    }
}
