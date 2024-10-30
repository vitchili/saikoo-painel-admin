<?php

namespace App\Observers;

use App\Gateway\Bitpag\CobrancaBitpag;
use App\Models\Cliente\Cliente;
use App\Models\Cliente\Fatura\FaturaCliente;
use App\Models\Cliente\Serial\SerialCliente;
use App\Models\Cliente\Servico\ServicoCliente;
use App\Models\Cliente\Servico\TipoServicoCliente;
use App\Services\NotificacaoExceptionGeralService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FaturaClienteObserver
{
    /**
     * Handle the FaturaCliente "created" event.
     */
    public function created(FaturaCliente $faturaCliente): void
    {
        $qtdServicos = DB::table('servicos_faturas')->where('fatura_id', 0)->distinct()->get()->toArray();

        DB::table('servicos_faturas')->where('fatura_id', 0)->distinct()->limit(count($qtdServicos))->update([
            'fatura_id' => $faturaCliente->id
        ]);

        $ultimaParcela = FaturaCliente::orderBy('id', 'desc')->first();

        $vencimentoOriginal = new Carbon($faturaCliente->vencimento);
        $vencimentoOriginal->toDateString();

        if ($ultimaParcela->incremento_parcela < $ultimaParcela->qtd) {
            $novoModel = $faturaCliente->replicate();
            $novoModel->vencimento = Carbon::parse($vencimentoOriginal)->addMonthsNoOverflow((int) 12 / $faturaCliente->qtd)->toDateString(); 
            $novoModel->incremento_parcela = $ultimaParcela->incremento_parcela + 1;

            if ($novoModel->incremento_parcela > 1 && $faturaCliente->referencia != 'Sistemas') {
                $novoModel->referencia = $faturaCliente->referencia;
            }
            
            if ($novoModel->gerar_serial) {
                $serial = new SerialCliente();
                $serial->id_cliente = $novoModel->id_cliente;
                $serial->vencimento_serial = $novoModel->vencimento;
                $serial->save();
                $novoModel->serial = $serial->serial;
            }

            $novoModel->save();
        }
    }

    /**
     * Handle the FaturaCliente "creating" event.
     */
    public function creating(FaturaCliente $faturaCliente): void
    {
        try {
            DB::beginTransaction();

            $faturaCliente->validade_final = 'Nao';
            $faturaCliente->cpf_cnpj = preg_replace('/[^0-9]/', '', Cliente::findOrFail($faturaCliente->id_cliente)->cpf_cnpj);
            $faturaCliente->codigo_cliente = Cliente::findOrFail($faturaCliente->id_cliente)->codigo;

            if (empty($faturaCliente->incremento_parcela) || $faturaCliente->incremento_parcela == 1) {
                if ($faturaCliente->gerar_serial) {
                    $serial = new SerialCliente();
                    $serial->id_cliente = $faturaCliente->id_cliente;
                    $serial->vencimento_serial = $faturaCliente->vencimento;
                    $serial->save();
                    $faturaCliente->serial = $serial->serial;
                }
            }
            
            $servicosCliente = ServicoCliente::find($faturaCliente->servicos); //Servico do Cliente (contem id_servico e id_cliente)

            foreach ($servicosCliente as $servicoCliente) {
                $tiposServicosCliente = TipoServicoCliente::find($servicoCliente->id_servico); //Tipo de Servico (id_servico do Servico do cliente)

                if ($tiposServicosCliente->nome === 'Sistemas') {
                    $faturaCliente->referencia = 'Sistemas';
                    break;
                }
            }

            if (! empty($faturaCliente->servicos)) {
                for($i = 0; $i<$faturaCliente->qtd; $i++) {
                    foreach ($faturaCliente->servicos as $servico) {
                        DB::table('servicos_faturas')->insert([
                            'fatura_id' => 0,
                            'servico_id' => (int) $servico,
                        ]);
                    }
                }
    
            }
            unset($faturaCliente->servicos);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            new NotificacaoExceptionGeralService($e->getMessage());
        }
    }

    /**
     * Handle the FaturaCliente "updated" event.
     */
    public function updating(FaturaCliente $faturaCliente): void
    {
        $faturaAntigaGerarSerial = $faturaCliente->getOriginal('gerar_serial');

        if (! $faturaAntigaGerarSerial && $faturaCliente->gerar_serial) {
            $serial = new SerialCliente();
            $serial->vencimento_serial = $faturaCliente->vencimento;
            $serial->save();
        }
    }

    /**
     * Handle the FaturaCliente "deleted" event.
     */
    public function deleted(FaturaCliente $faturaCliente): void
    {
        //
    }

    /**
     * Handle the FaturaCliente "restored" event.
     */
    public function restored(FaturaCliente $faturaCliente): void
    {
        //
    }

    /**
     * Handle the FaturaCliente "force deleted" event.
     */
    public function forceDeleted(FaturaCliente $faturaCliente): void
    {
        //
    }
}
