<?php

namespace App\Gateway\Bitpag;

use App\Models\Cliente\Cliente;
use App\Models\Cliente\Fatura\Enum\FormaPagamento;
use App\Models\Cliente\Fatura\Enum\StatusFaturaCliente;
use App\Models\Cliente\Fatura\FaturaCliente;
use App\Models\Cliente\Servico\Enum\PeriodicidadeServico;
use App\Models\Cliente\Servico\ServicoCliente;
use App\Models\Cliente\Servico\TipoServicoCliente;
use App\Rules\ValidacaoCpfCnpj;
use App\Rules\ValidacaoTelefone;
use App\Services\NotificacaoExceptionBitPagService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CobrancaBitpag extends BaseClientBitpag
{
    public function consultarCobrancas(?int $page = 1, array $filters = []): array
    {
        try {
            $response = Http::withHeaders($this->getHeaders())->get(
                $this->getBaseAuth()['baseUrl'] . '/charge',
                [
                    'page' => $page,
                    'search' => $filters['search'] ?? null,
                    'from' => $filters['from'] ?? null,
                    'to' => $filters['to'] ?? null,
                    'status' => $filters['status'] ?? null,
                ]
            );

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
        
        if ($cobranca->formapagamento === FormaPagamento::PIX->value || 
            $cobranca->formapagamento === FormaPagamento::BOLETO->value || 
            $cobranca->qtd == 1
        ) {
            $tipoCobrancaBitPag = 'U';
        } elseif ($cobranca->formapagamento !== FormaPagamento::BOLETO->value && $cobranca->qtd > 1) {
            $tipoCobrancaBitPag = 'P'; //Verificar se manteremos P ou R.
        }

        $payload = match ($tipoCobrancaBitPag) {
            'U' => array_merge($this->getBasePayloadCliente($cobranca), $this->getBasePayloadCobrancaUnica($cobranca), $this->getBasePayloadPagamentoCartaoCredito($cobranca, $dadosSensiveis)),
            'P' => array_merge($this->getBasePayloadCliente($cobranca), $this->getBasePayloadCobrancaParcela($cobranca), $this->getBasePayloadPagamentoCartaoCredito($cobranca, $dadosSensiveis)),
            'R' => array_merge($this->getBasePayloadCliente($cobranca), $this->getBasePayloadCobrancaRecorrente($cobranca), $this->getBasePayloadPagamentoCartaoCredito($cobranca, $dadosSensiveis)),
        };

        try {
            DB::beginTransaction();

            $response = Http::withHeaders($this->getHeaders())->post(
                $this->getBaseAuth()['baseUrl'] . '/charge',
                $payload
            );

            if (! empty($response->json()['errors'])) {
                Log::error($response->json()['errors']);
                throw new \Exception($response->json()['message'], $response->status());
            }

            $cobranca->cobranca_bitpag_id = $response['recurrence']['hash_id'] ?? $response['charge']['hash_id'];
            $cobranca->status = StatusFaturaCliente::AGUARDANDO_PAGAMENTO->value;
            if ($response['charge'] && $response['charge']['method_payment'] == 'Boleto') {
                $cobranca->url_boleto = $response['charge']['payments'][0]['document_url'];
            }

            if ($response['charge'] && $response['charge']['method_payment'] == 'PIX') {
                $cobranca->qr_code_pix = $response['charge']['payments'][0]['document_url'];
                $cobranca->data_expiracao_pix = $response['charge']['payments'][0]['expiration'];
                $cobranca->digitavel_pix = $response['charge']['payments'][0]['document_hash'];
            }

            $cobranca->update();

            Log::info($response->json());

            DB::commit();

            return $response->json();
        } catch (\Exception $e) {
            new NotificacaoExceptionBitPagService($e->getMessage());
            DB::rollback();

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
        $servicos = $cobranca->servicos;

        $periodoServico = ServicoCliente::with('servicoCliente')->find($servicos[0])->first();

        $tipoPagamento = match ($cobranca->formapagamento) {
            FormaPagamento::BOLETO->value => 4,
            FormaPagamento::CARTAO_DE_CREDITO->value => 2,
            FormaPagamento::PIX->value => 7,
            default => throw new \Exception('Nenhuma forma de pagamento cadastrada'),
        };

        return [
            'type' => 'u',
            'leverage_days_single' => 1,
            'leverage_min_percent_single' => 0,
            'description_single_charge' => $cobranca->info_add ?? "Cobrança referente a contratação de: '{$periodoServico->servicoCliente->nome}'",
            'amount' => number_format($cobranca->valor_atualizado ?? $cobranca->valor, 2, ',', ''),
            'due_date_single_charge' => $cobranca->vencimento_boleto ? Carbon::parse($cobranca->vencimento_boleto)->format('Y-m-d') : Carbon::parse($cobranca->vencimento)->format('Y-m-d'),
            'description_installment_amount' => $cobranca->info_add,
            'due_date_installment_billing' => $cobranca->vencimento_boleto ?? $cobranca->vencimento,
            'expiration_day_installments' => $cobranca->vencimento_boleto ? (int) Carbon::parse($cobranca->vencimento_boleto)->format('d') : (int) Carbon::parse($cobranca->vencimento)->format('d'),
            'total_installment' => PeriodicidadeServico::from($periodoServico->periodicidade)->qtdParcelas(),
            'installment_amount' =>  number_format($cobranca->valor_atualizado ?? $cobranca->valor, 2, ',', ''),
            'charge_method' => 1,
            'method' => $tipoPagamento,
            'leverage_days_installment' => 1,
            'leverage_min_percent_installment' => 0,
        ];
    }

    public function getBasePayloadCobrancaParcela(FaturaCliente $cobranca): array
    {
        $servicos = $cobranca->servicos;
        $periodoServico = $servicos[0];

        $periodicidade = match ($periodoServico->periodicidade) {
            PeriodicidadeServico::MENSAL->value => 'monthly',
            PeriodicidadeServico::TRIMESTRAL->value => 'quarterly',
            PeriodicidadeServico::SEMESTRAL->value => 'semester',
            PeriodicidadeServico::ANUAL->value => 'yearly',
            default => throw new \Exception('Nenhuma periodicidade cadastrada para o serviço'),
        };

        $tipoPagamento = match ($cobranca->formapagamento) {
            FormaPagamento::BOLETO->value => 4,
            FormaPagamento::CARTAO_DE_CREDITO->value => 2,
            FormaPagamento::PIX->value => 7,
            default => throw new \Exception('Nenhuma forma de pagamento cadastrada'),
        };

        return [
            'type' => 'p',
            'description_installment_amount' => $cobranca->info_add ?? "Cobrança referente a contratação de: '{$periodoServico->servicoCliente->nome}'",
            'recurrence_interval_installment' => $periodicidade,
            'due_date_installment_billing' => $cobranca->vencimento,
            'expiration_day_installments' => (int) Carbon::parse($cobranca->vencimento)->format('d'),
            'total_installment' => PeriodicidadeServico::from($periodoServico->periodicidade)->qtdParcelas(),
            'installment_amount' =>  number_format($cobranca->valor_atualizado ?? $cobranca->valor, 2, ',', ''),
            'charge_method' => 1,
            'method' => $tipoPagamento,
            'leverage_days_installment' => 1,
            'leverage_min_percent_installment' => 0,
        ];
    }

    public function getBasePayloadCobrancaRecorrente(FaturaCliente $cobranca): array
    {
        $servicos = $cobranca->servicos;

        $periodoServico = ServicoCliente::with('servicoCliente')->find($servicos[0]);

        $periodicidade = match ($periodoServico->periodicidade) {
            PeriodicidadeServico::MENSAL->value => 'monthly',
            PeriodicidadeServico::TRIMESTRAL->value => 'quarterly',
            PeriodicidadeServico::SEMESTRAL->value => 'semester',
            PeriodicidadeServico::ANUAL->value => 'yearly',
            default => throw new \Exception('Nenhuma periodicidade cadastrada para o serviço'),
        };

        $tipoPagamento = match ($cobranca->formapagamento) {
            FormaPagamento::BOLETO->value => 4,
            FormaPagamento::CARTAO_DE_CREDITO->value => 2,
            FormaPagamento::PIX->value => 7,
            default => throw new \Exception('Nenhuma forma de pagamento cadastrada'),
        };

        return [
            'type' => 'r',
            'description_recurrence' => strip_tags($cobranca->info_add),
            'recurrence_interval' => $periodicidade,
            'due_date_recurrence' => $cobranca->vencimento,
            'expiration_day_recurrence' => (int) Carbon::parse($cobranca->vencimento)->format('d'),
            'amount_recurrence' => number_format($cobranca->valor_atualizado ?? $cobranca->valor, 2, ',', ''),
            'charge_method' => 1,
            'method' => $tipoPagamento,
            'leverage_days_installment' => 1,
            'leverage_min_percent_installment' => 0,
        ];
    }

    public function getBasePayloadPagamentoCartaoCredito(FaturaCliente $cobranca, array $dadosSensiveis = []): array
    {
        return $cobranca->formapagamento == 'Cartão de crédito' && ! empty($dadosSensiveis) ? [
            'number' => str_replace([' ', '-'], '', $dadosSensiveis['number']),
            'cvv' => $dadosSensiveis['cvv'],
            'expiration_date' => $dadosSensiveis['expiration_date'],
            'holder_name' => $dadosSensiveis['holder_name']
        ] : [];
    }
}
