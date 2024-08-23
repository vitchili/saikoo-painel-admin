<?php

namespace App\Observers;

use App\Models\Cliente\Cliente;
use App\Models\Cliente\Fatura\FaturaCliente;
use App\Models\Cliente\Servico\TipoServicoCliente;
use Carbon\Carbon;

class FaturaClienteObserver
{
    public array $servicos;
    public int $qtdParcelas;
    public int $parcelaAtual = 1;

    /**
     * Handle the FaturaCliente "created" event.
     */
    public function created(FaturaCliente $faturaCliente): void
    {
        $vencimentoOriginal = new Carbon($faturaCliente->vencimento);
        $vencimentoOriginal->toDateString();

        if (! empty($this->parcelaAtual) && ! empty($this->qtdParcelas) && $this->parcelaAtual < $this->qtdParcelas) {
            $novoModel = $faturaCliente->replicate();
            $novoModel->vencimento = Carbon::parse($vencimentoOriginal)->addMonthNoOverflow($this->parcelaAtual)->toDateString();
            $novoModel->save();

            $this->parcelaAtual++;
        }

    }

    /**
     * Handle the FaturaCliente "created" event.
     */
    public function creating(FaturaCliente $faturaCliente): void
    {
        $faturaCliente->validade_final = 'Nao';
        $faturaCliente->cpf_cnpj = preg_replace('/[^0-9]/', '', Cliente::findOrFail($faturaCliente->id_cliente)->cpf_cnpj);
        $faturaCliente->codigo_cliente = Cliente::findOrFail($faturaCliente->id_cliente)->codigo;
        $faturaCliente->valor /= 10000;

        $servicos = TipoServicoCliente::whereIn('id', $faturaCliente->servicos)->get();
        $referencia = '';
        
        foreach ($servicos as $servico) {
            $referencia .= $servico->nome . ', ';
        }
        
        $referencia = rtrim($referencia);
        $faturaCliente->referencia = $referencia;

        $this->servicos = $faturaCliente->servicos;
        $this->qtdParcelas = $faturaCliente->qtd;
        $this->parcelaAtual = 1;
        
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
