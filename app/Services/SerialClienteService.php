<?php
namespace App\Services;

use App\Models\Cliente\Cliente;
use App\Rules\ValidacaoCpfCnpj;

class SerialClienteService
{
    public array $mapa;

    public function __construct(public Cliente $cliente, public string $dataVencimento)
    {
        $this->cliente->cpf_cnpj = $this->validarCpfCnpj($cliente->cpf_cnpj);
        
        $this->dataVencimento = $this->validarDataVencimento($dataVencimento);

        $this->mapa = $this->gerarMapaHash();
    }

    public function gerarSerial(): string
    {
        $serial = '';

        for ($i = 0; $i < strlen($this->cliente->cpf_cnpj); $i++){
          $serial .= $this->mapa[substr($this->cliente->cpf_cnpj, $i, 1)];
        }  
  
        for ($i = 0; $i < strlen($this->dataVencimento); $i++){
          $serial .= $this->mapa[substr($this->dataVencimento, $i, 1)];
        }  

        $tamanho = strlen($this->cliente->cpf_cnpj);  
  
        if ($tamanho >= 14) {
          $serialA = substr($serial,0,9);
          $serialB = substr($serial,9,9);
          $serialC = substr($serial,18,9);
          $serialD = substr($serial,27,9);
          $serialE = substr($serial,36,99);
        } elseif ($tamanho == 11) {
          $serialA = substr($serial,0,9);
          $serialB = substr($serial,9,7);
          $serialC = substr($serial,16,7);
          $serialD = substr($serial,23,7);
          $serialE = substr($serial,30,99);
        } else {
            throw new \Exception('CPF ou CNPJ inválidos ao gerar serial.');
        }

        return $serialA.'-'.$serialB.'-'.$serialC.'-'.$serialD.'-'.$serialE;  
    }

    private function gerarMapaHash(): array
    {
        $mapa = [];

        $mapa[0] = 'H1';
        $mapa[1] = 'Y2';
        $mapa[2] = 'X3';
        $mapa[3] = 'W4';
        $mapa[4] = 'V5';
        $mapa[5] = 'U6';
        $mapa[6] = 'T7';
        $mapa[7] = 'S8';
        $mapa[8] = 'R9';
        $mapa[9] = 'Q1';
        $mapa[10] = 'P2';
        $mapa[11] = 'O3';
        $mapa[12] = 'N4';
        $mapa[13] = 'M5';
        $mapa[14] = 'L6';
        $mapa[15] = 'K7';
        $mapa[16] = 'J8';
        $mapa[17] = 'I9';
        $mapa[18] = 'H1';
        $mapa[19] = 'G2';
        $mapa[20] = 'F3';
        $mapa[21] = 'E4';
        $mapa[22] = 'D5';
        $mapa[23] = 'C6';
        $mapa[24] = 'B7';
        $mapa[25] = 'A8';

        return $mapa;
    }

    private function validarCpfCnpj(string $cpfCnpj): string
    {
        $validacaoCpfCnpj = new ValidacaoCpfCnpj();
        $validacaoCpfCnpj->validar($cpfCnpj);
        
        return preg_replace('/\D/', '', $cpfCnpj);
    }

    private function validarDataVencimento(string $dataVencimento): string
    {
        $dataVencimento = preg_replace('/\D/', '', $dataVencimento);

        if (strlen($dataVencimento) != 8) {
            throw new \Exception('Data de vencimento inválida.');
        }

        return $dataVencimento;
    }
}