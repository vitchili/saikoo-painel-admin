<?php

namespace App\Console\Commands;

use App\Models\Lembrete\Lembrete;
use App\Models\Lembrete\PeriodicidadeLembrete;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GerarLembretesPeriodicidade extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:gerar-lembretes-periodicidade';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gerar a periodicidade dos lembretes.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $lembretes = Lembrete::with('tecnicos')
            ->where('periodicidade_id', '!=', PeriodicidadeLembrete::PERIODICIDADE_ATIPICO)
            ->whereRaw('DATE(data_hora_inicio) = CURDATE()') 
            ->get();
            
        $novoLembrete = new Lembrete();

        foreach($lembretes as $lembrete) {
            if(
                $lembrete->periodicidade_id == PeriodicidadeLembrete::PERIODICIDADE_DIARIO 
            ) {
                $novoLembrete = $lembrete->replicate();
                $novoLembrete->data_hora_inicio = Carbon::parse($lembrete->data_hora_inicio)->addDay();
                $novoLembrete->data_hora_fim = Carbon::parse($lembrete->data_hora_fim)->addDay();
                $novoLembrete->cadastrado_em = now();
            }

            if(
                $lembrete->periodicidade_id == PeriodicidadeLembrete::PERIODICIDADE_SEMANAL 
            ) {
                $novoLembrete = $lembrete->replicate();
                $novoLembrete->data_hora_inicio = Carbon::parse($lembrete->data_hora_inicio)->addWeek();
                $novoLembrete->data_hora_fim = Carbon::parse($lembrete->data_hora_fim)->addWeek();
                $novoLembrete->cadastrado_em = now();
            }

            if(
                $lembrete->periodicidade_id == PeriodicidadeLembrete::PERIODICIDADE_QUINZENAL 
            ) {
                $novoLembrete = $lembrete->replicate();
                $novoLembrete->data_hora_inicio = Carbon::parse($lembrete->data_hora_inicio)->addWeeks(2);
                $novoLembrete->data_hora_fim = Carbon::parse($lembrete->data_hora_fim)->addWeeks(2);
                $novoLembrete->cadastrado_em = now();
            }

            if(
                $lembrete->periodicidade_id == PeriodicidadeLembrete::PERIODICIDADE_MENSAL 
            ) {
                $novoLembrete = $lembrete->replicate();
                $novoLembrete->data_hora_inicio = Carbon::parse($lembrete->data_hora_inicio)->addMonth();
                $novoLembrete->data_hora_fim = Carbon::parse($lembrete->data_hora_fim)->addMonth();
                $novoLembrete->cadastrado_em = now();
            }

            if(
                $lembrete->periodicidade_id == PeriodicidadeLembrete::PERIODICIDADE_ANUAL 
            ) {
                $novoLembrete = $lembrete->replicate();
                $novoLembrete->data_hora_inicio = Carbon::parse($lembrete->data_hora_inicio)->addYear();
                $novoLembrete->data_hora_fim = Carbon::parse($lembrete->data_hora_fim)->addYear();
                $novoLembrete->cadastrado_em = now();
            }

            $novoLembrete->save();

            foreach ($lembrete->tecnicos as $tecnico) {
                $novoLembrete->tecnicos()->attach($tecnico->id);
            }
        }
    }
}
