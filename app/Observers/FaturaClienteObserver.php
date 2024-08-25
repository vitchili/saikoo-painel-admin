<?php

namespace App\Observers;

use App\Models\Cliente\Cliente;
use App\Models\Cliente\Fatura\FaturaCliente;
use App\Models\Cliente\Servico\TipoServicoCliente;
use Carbon\Carbon;

class FaturaClienteObserver
{
    public $referencia = 'Servicos';

    /**
     * Handle the FaturaCliente "created" event.
     */
    public function created(FaturaCliente $faturaCliente): void
    {
        $ultimaParcela = FaturaCliente::orderBy('id', 'desc')->first();
        $ultimaParcela->valor = $faturaCliente->valor / 1000;
        $ultimaParcela->save();

        $vencimentoOriginal = new Carbon($faturaCliente->vencimento);
        $vencimentoOriginal->toDateString();

        if ($ultimaParcela->incremento_parcela < $ultimaParcela->qtd) {
            $novoModel = $faturaCliente->replicate();
            $novoModel->vencimento = Carbon::parse($vencimentoOriginal)->addMonthNoOverflow(1)->toDateString(); 
            $novoModel->incremento_parcela = $ultimaParcela->incremento_parcela + 1;
            $novoModel->save();
        }
    }

    /**
     * Handle the FaturaCliente "creating" event.
     */
    public function creating(FaturaCliente $faturaCliente): void
    {
        $faturaCliente->validade_final = 'Nao';
        $faturaCliente->cpf_cnpj = preg_replace('/[^0-9]/', '', Cliente::findOrFail($faturaCliente->id_cliente)->cpf_cnpj);
        $faturaCliente->codigo_cliente = Cliente::findOrFail($faturaCliente->id_cliente)->codigo;

        if (! empty($faturaCliente->servicos[0])) {
            $this->referencia = TipoServicoCliente::find($faturaCliente->servicos[0])->nome;
        }

        $faturaCliente->referencia = $this->referencia;

        unset($faturaCliente->servicos);
    }

    /**
     * Handle the FaturaCliente "updated" event.
     */
    public function updated(FaturaCliente $faturaCliente): void
    {
        //
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
