<?php

namespace App\Gateway\Bitpag;

use App\Models\Cliente\Cliente;
use App\Models\Cliente\Fatura\FaturaCliente;
use App\Models\Cliente\Servico\Enum\PeriodicidadeServico;
use App\Rules\ValidacaoCpfCnpj;
use App\Rules\ValidacaoTelefone;
use App\Services\NotificacaoExceptionBitPagService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class CobrancaBitpag extends BaseClientBitpag
{
    public function consultarCobrancas(?int $page = 1, array $filters = []): array
    {
        try {
            $response = Http::withHeaders($this->getHeaders())->get(
                $this->getBaseAuth()['baseUrl'] . '/charge', [
                'page' => $page,
                'search' => $filters['search'] ?? null,
                'from' => $filters['from'] ?? null,
                'to' => $filters['to'] ?? null,
                'status' => $filters['status'] ?? null,
            ]);
            
            if (! empty($response->json()['errors'])) {
                throw new \Exception($response->json()['message'], $response->status());
            }

            return $response->json();
        } catch (\Exception $e) {
            new NotificacaoExceptionBitPagService($e->getMessage());
            return [
                'status' => $e->getCode(),
                'data' => $e->getMessage(),
            ];
        }
    }

    public function cadastrarCobranca(FaturaCliente $cobranca, array $dadosSensiveis = []): array
    {
        $tipoCobrancaBitPag = 'R';

        if ($cobranca->qtd == 1) {
            $tipoCobrancaBitPag = 'U';
        }elseif ($cobranca->qtd > 1) {
            $tipoCobrancaBitPag = 'R'; //Verificar se manteremos P ou R.
        }

        $payload = match($tipoCobrancaBitPag) {
            'U' => array_merge($this->getBasePayloadCliente($cobranca), $this->getBasePayloadCobrancaUnica($cobranca), $this->getBasePayloadPagamentoCartaoCredito($cobranca, $dadosSensiveis)),
            'P' => array_merge($this->getBasePayloadCliente($cobranca), $this->getBasePayloadCobrancaParcela($cobranca), $this->getBasePayloadPagamentoCartaoCredito($cobranca, $dadosSensiveis)),
            'R' => array_merge($this->getBasePayloadCliente($cobranca), $this->getBasePayloadCobrancaRecorrente($cobranca), $this->getBasePayloadPagamentoCartaoCredito($cobranca, $dadosSensiveis)),
        };

        try {
            $response = Http::withHeaders($this->getHeaders())->post(
                $this->getBaseAuth()['baseUrl'] . '/charge', $payload);

            if (! empty($response->json()['errors'])) {
                throw new \Exception($response->json()['message'], $response->status());
            }

            $cobranca->cobranca_bitpag_id = $response['recurrence']['hash_id'];
            $cobranca->update();

            return $response->json();
        } catch (\Exception $e) {
            new NotificacaoExceptionBitPagService($e->getMessage());
            return [
                'status' => $e->getCode(),
                'data' => $e->getMessage(),
            ];
        }
    }

    public function getBasePayloadCliente(FaturaCliente $cobranca): array
    {
        $cliente = $cobranca->cliente;

        return [
            'document' => strval(ValidacaoCpfCnpj::transformarApenasNumeros($cliente->cpf_cnpj)),
            'name' => $cliente->nome,
            'email' => $cliente->email,
            'gender' => 'O',
            'birth_date' => ValidacaoCpfCnpj::cpfOuCnpj($cliente->cpf_cnpj) == ValidacaoCpfCnpj::CPF ? 
                Carbon::parse($cliente->data_nasc_resp)->format('Y-m-d') : 
                Carbon::parse($cliente->data_cadastro)->format('Y-m-d'),
            'zipcode' => $cliente->cep,
            'address' => $cliente->end,
            'number_address' => $cliente->numero,
            'complement_address' => $cliente->complemento,
            'district' => $cliente->bairro,
            'city' => $cliente->cidade,
            'state' => $cliente->uf,
            'country' => 'Brasil',
            'phone' => strval(ValidacaoTelefone::transformarApenasNumeros($cliente->telefone)),
            'type_charge' => 'c',
        ];
    }

    public function getBasePayloadCobrancaUnica(FaturaCliente $cobranca): array
    {
        return [
            'type' => 'U',
            'leverage_days_single' => "de 1 a 99 | {Campo Obrigatório se o type escolhido for u (Cobrança única)}",
            'leverage_min_percent_single' => "de 0.0 a 100.0 | {Campo Obrigatório se o type escolhido for u (Cobrança única)}",
            'description_single_charge' => "Cobrança referente à... | {Campo Obrigatório se o type escolhido for u (Cobrança única)}",
            'amount' => "R$ 100,00 (Pode-se enviar com R$) | {Campo Obrigatório se o type escolhido for u (Cobrança única)}",
            'due_date_single_charge' => "2024-01-01 (Formato Y-m-d) | {Campo Obrigatório se o type escolhido for u (Cobrança única)}",
            'charge_method' => "Sim ou Não (1 - sim | 0 - Não)",
            'method' => "2 - Cartão de Crédito | 4 - Boleto | 7 - PIX {Campo Obrigatório se charge_method = 1}",
        ];
    }

    public function getBasePayloadCobrancaParcela(FaturaCliente $cobranca): array
    {
        $servicos = $cobranca->servicos;

        $periodicidade = match($servicos[0]->periodicidade) {
            PeriodicidadeServico::MENSAL->value => 'monthly',
            PeriodicidadeServico::TRIMESTRAL->value => 'quarterly',
            PeriodicidadeServico::SEMESTRAL->value => 'semester',
            PeriodicidadeServico::ANUAL->value => 'yearly',
            default => throw new \Exception('Nenhuma periodicidade cadastrada para o serviço'),
        };

        $tipoPagamento = match($cobranca->formapagamento) {
            'Boleto' => 4,
            'Cartão de crédito' => 2,
            'PIX' => 7,
            default => throw new \Exception('Nenhuma forma de pagamento cadastrada'),
        };

        return [
            'type' => 'p',
            'description_installment_amount' => $cobranca->info_add,
            'recurrence_interval_installment' => $periodicidade,
            'due_date_installment_billing' => $cobranca->vencimento,
            'expiration_day_installments' => (int) Carbon::parse($cobranca->vencimento)->format('d'),
            'total_installment' => PeriodicidadeServico::from($servicos[0]->periodicidade)->qtdParcelas(),
            'installment_amount' =>  number_format($cobranca->valor, 2, ',', ''),
            'charge_method' => 1,
            'method' => $tipoPagamento,
            'leverage_days_installment' => 0,
            'leverage_min_percent_installment' => 0,
        ];
    }

    public function getBasePayloadCobrancaRecorrente(FaturaCliente $cobranca): array
    {
        $servicos = $cobranca->servicos;

        $periodicidade = match($servicos[0]->periodicidade) {
            PeriodicidadeServico::MENSAL->value => 'monthly',
            PeriodicidadeServico::TRIMESTRAL->value => 'quarterly',
            PeriodicidadeServico::SEMESTRAL->value => 'semester',
            PeriodicidadeServico::ANUAL->value => 'yearly',
            default => throw new \Exception('Nenhuma periodicidade cadastrada para o serviço'),
        };

        $tipoPagamento = match($cobranca->formapagamento) {
            'Boleto' => 4,
            'Cartão de crédito' => 2,
            'PIX' => 7,
            default => throw new \Exception('Nenhuma forma de pagamento cadastrada'),
        };

        return [
            'type' => 'r',
            'description_recurrence' => strip_tags($cobranca->info_add),
            'recurrence_interval' => $periodicidade,
            'due_date_recurrence' => $cobranca->vencimento,
            'expiration_day_recurrence' => (int) Carbon::parse($cobranca->vencimento)->format('d'),
            'amount_recurrence' => number_format($cobranca->valor, 2, ',', ''),
            'charge_method' => 1,
            'method' => $tipoPagamento,
        ];
    }

    public function getBasePayloadPagamentoCartaoCredito(FaturaCliente $cobranca, array $dadosSensiveis = []): array
    {
        return $cobranca->formapagamento == 'Cartão de crédito' && ! empty($dadosSensiveis) ? [
            'number' => $dadosSensiveis['number'],
            'cvv' => $dadosSensiveis['cvv'],
            'expiration_date' => $dadosSensiveis['expiration_date'],
            'holder_name' => $dadosSensiveis['holder_name']
        ] : [];
    }
}