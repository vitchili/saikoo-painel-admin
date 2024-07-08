<?php

namespace App\Observers;

use App\Models\Cliente\Cliente;
use App\Models\Cliente\Fatura\FaturaCliente;
use Carbon\Carbon;

class FaturaClienteObserver
{
    /**
     * Handle the FaturaCliente "created" event.
     */
    public function created(FaturaCliente $faturaCliente): void
    {
     
    }

    /**
     * Handle the FaturaCliente "created" event.
     */
    public function creating(FaturaCliente $faturaCliente): void
    {
        $faturaCliente->validade_final = 'Nao';
        $faturaCliente->cpf_cnpj = preg_replace('/[^0-9]/', '', Cliente::findOrFail($faturaCliente->id_cliente)->cpf_cnpj);
        $faturaCliente->codigo_cliente = Cliente::findOrFail($faturaCliente->id_cliente)->codigo;

        $vencimentoOriginal = new Carbon($faturaCliente->vencimento);
        $vencimentoOriginal->toDateString();
        
        $ultimaFatura = FaturaCliente::where('id_cliente', '=', $faturaCliente->id_cliente)->orderBy('id', 'desc')->first();

        for($i=1; $i<=$faturaCliente->qtd; $i++) {
            $novoVencimento = Carbon::parse($vencimentoOriginal)->addMonthNoOverflow($i)->toDateString();

            FaturaCliente::create([
                'id_cliente' => $ultimaFatura->id_cliente,
                'codigo_cliente' => $ultimaFatura->codigo_cliente,
                'vencimento' => $novoVencimento,
                'valor' => $faturaCliente->valor,
                // 'serial' => $faturaCliente->serial,
                'cpf_cnpj' => $ultimaFatura->cpf_cnpj,
                'formapagamento' => $faturaCliente->formapagamento,
                'referencia' => $faturaCliente->referencia,
                'info_add' => $faturaCliente->info_add,
                'obs' => $faturaCliente->obs,
                'url_checkout' => $faturaCliente->url_checkout,
                'data' => now(),
            ]);
        }
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
