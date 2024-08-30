<?php

namespace App\Gateway\Bitpag;

use App\Models\Cliente\Cliente;
use App\Rules\ValidacaoCpfCnpj;
use App\Rules\ValidacaoTelefone;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class ClienteBitPag extends BaseClientBitpag
{
    public function consultarClientes(?int $page = 1, ?string $search = ''): array
    {
        try {
            $response = Http::withHeaders($this->getHeaders())->get(
                $this->getBaseAuth()['baseUrl'] . '/client', [
                'page' => $page,
                'search' => $search,
            ]);
            
            if (! empty($response->json()['errors'])) {
                throw new \Exception($response->json()['message'], $response->status());
            }

            return $response->json();
        } catch (\Exception $e) {
            return [
                'status' => $e->getCode(),
                'data' => $e->getMessage(),
            ];
        }
    }

    public function cadastrarCliente(Cliente $cliente): array
    {   
        $payload = [
            'document' => strval(ValidacaoCpfCnpj::transformarApenasNumeros($cliente->cpf_cnpj)),
            'name' => $cliente->nome,
            'email' => $cliente->email_resp ?? $cliente->email,
            'gender' => 'O',
            'birth_date' => ValidacaoCpfCnpj::cpfOuCnpj($cliente->cpf_cnpj) == ValidacaoCpfCnpj::CPF ? 
                Carbon::parse($cliente->data_nasc_resp)->format('Y-m-d') : 
                Carbon::parse($cliente->data_cadastro)->format('Y-m-d'),
            'zipcode' => $cliente->cep ?? '',
            'address' => $cliente->end ?? '',
            'number_address' => $cliente->numero ?? '',
            'complement_address' => $cliente->complemento ?? '',
            'district' => $cliente->bairro ?? '',
            'city' => $cliente->cidade ?? '',
            'state' => $cliente->uf ?? '',
            'country' => 'Brasil',
            'phone' => ! empty($cliente->telefone) ? strval(ValidacaoTelefone::transformarApenasNumeros($cliente->telefone)) : '',
        ];

        try {
            $response = Http::withHeaders($this->getHeaders())->post(
                $this->getBaseAuth()['baseUrl'] . '/client', $payload);
                
            if (! empty($response->json()['errors'])) {
                throw ValidationException::withMessages([
                    'erro' => $response->json()['message']
                ]);
            }

            $cliente->cliente_bitpag_id = $response['client']['hash_id'];
            $cliente->save();

            return $response->json();
        } catch (\Exception $e) {
            return [
                'status' => $e->getCode(),
                'data' => $e->getMessage(),
            ];
        }
    }
}