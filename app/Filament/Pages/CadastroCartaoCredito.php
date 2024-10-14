<?php

namespace App\Filament\Pages;

use App\Gateway\Bitpag\CobrancaBitpag;
use App\Models\Cliente\Fatura\FaturaCliente;
use App\Models\Cliente\Servico\Enum\PeriodicidadeServico;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CadastroCartaoCredito extends Page
{
    protected static string $view = 'filament.pages.cadastrar-cartao';
    protected static ?string $slug = 'cadastrar-cartao';
    protected static ?string $navigationParentItem = 'Hide';
    protected static ?string $title = 'Meus Cartões de Crédito';

    public $numeroCartao = '';
    public $nomeCartao = '';
    public $mesAnoVencimento = '';
    public $cvv = '';

    public $faturaSelecionada = [];
    public $cartoesCadastrados = [];
    public $valorTotalAtual = 0;

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('Cliente');
    }

    public function mount()
    {
        $cliente = auth()->user()->cliente;
        $primeirasFaturas = FaturaCliente::where('id_cliente', $cliente->id)
            ->where('formapagamento', 'Cartão de Crédito')
            ->where('incremento_parcela', '1')
            ->whereNotNull('cobranca_bitpag_id')
            ->get();

        foreach ($primeirasFaturas as $fatura) {
            $servicosStr = '';
            
            foreach ($fatura->servicos as $servicoCliente) {
                $servicosStr .= $servicoCliente->servicoCliente->nome . '; ';
            }

            $this->cartoesCadastrados[] = [
                'servicos' => $servicosStr,
                'periodicidade' => PeriodicidadeServico::aPartirDaQtdParcelas($fatura->qtd)->label(),
                'valor' => $fatura->valor,
                'final_cartao' => $fatura->final_cartao,
            ];
        }
    }

    public function updatedNumeroCartao($value)
    {
        $this->numeroCartao = preg_replace('/[^\d-]/', '', $value);
        $this->numeroCartao = preg_replace('/(\d{4})(?=\d)/', '$1-', $this->numeroCartao);
        $this->numeroCartao = substr($this->numeroCartao, 0, 19);
    }

    public function updatedNomeCartao($value)
    {
        $this->nomeCartao = strtoupper($value);
    }

    public function updatedMesAnoVencimento($value)
    {
        $this->mesAnoVencimento = preg_replace('/\D/', '', $value);
        $this->mesAnoVencimento = substr($this->mesAnoVencimento, 0, 4);
        $this->mesAnoVencimento = substr($this->mesAnoVencimento, 0, 2) . '/' . substr($this->mesAnoVencimento, 2);
    }

    public function updatedFaturaSelecionada($value)
    {
        $this->valorTotalAtual = FaturaCliente::findOrFail($value)->valor;
    }

    public function updatedCvv($value)
    {
        $this->cvv = preg_replace('/\D/', '', $value);
        $this->cvv = substr($this->cvv, 0, 3);
    }

    protected function getFormSchema(): array
    {
        $cliente = auth()->user()->cliente;
        $primeirasFaturas = FaturaCliente::where('id_cliente', $cliente->id)
            ->where('formapagamento', 'Cartão de Crédito')
            ->where('incremento_parcela', '1')
            ->whereNull('cobranca_bitpag_id')
            ->get();

        $options = [];
        foreach ($primeirasFaturas as $fatura) {
            $servicosStr = '';
            foreach ($fatura->servicos as $servicoCliente) {
                $servicosStr .= $servicoCliente->servicoCliente->nome . '; ';
            }

            $options = [
                $fatura->id => 'Fatura ' . 
                PeriodicidadeServico::aPartirDaQtdParcelas($fatura->qtd)->labelMinuscula() . 
                " no valor de " . 'R$' . $fatura->valor . " referente a " . $servicosStr
            ];
        }

        return [
            Select::make('faturaSelecionada')
                ->label('Selecione uma fatura pendente')
                ->options($options)
                ->allowHtml()
                ->searchable()
                ->reactive()
        ];
    }

    public function save()
    {
        try {
            DB::beginTransaction();
    
            $fatura = FaturaCliente::findOrFail($this->faturaSelecionada);
            $dadosSensiveis = [
                'number' => str_replace([' ', '-'], '', $this->numeroCartao),
                'cvv' => $this->cvv,
                'expiration_date' => $this->mesAnoVencimento,
                'holder_name' => $this->nomeCartao,
            ];
    
            $bitPagCobranca = new CobrancaBitpag();
            $result = $bitPagCobranca->cadastrarCobranca($fatura, $dadosSensiveis);
    
            $fatura->final_cartao = substr($this->numeroCartao, -4);
            $fatura->save();
    
            if($fatura->qtd > 1){
                for ($i = 1; $i < $fatura->qtd; $i++) {
                    $fatura = FaturaCliente::findOrFail((int) $this->faturaSelecionada + (int) $i);
                    $fatura->final_cartao = substr($this->numeroCartao, -4);
                    $fatura->save();
                }
            }
    
            Notification::make()->success()->title("Cartão de crédito vinculado com sucesso.")->send();
    
            DB::commit();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();

        }
    }
}
