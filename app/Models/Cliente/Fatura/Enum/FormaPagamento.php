<?php

namespace App\Models\Cliente\Fatura\Enum;

enum FormaPagamento: string
{
    case BOLETO = 'Boleto';
    
    case CARTAO_DE_CREDITO = 'Cartão de crédito';
    
    case CHEQUE = 'Cheque';
    
    case DEPOSITO_BANCARIO = 'Depósito bancário';
    
    case DINHEIRO = 'Dinheiro';
    
    case PAGAMENTO_ONLINE = 'Pagamento Online';

    public function label(): string
    {
        return match ($this) {
            self::BOLETO => 'Boleto',
            self::CARTAO_DE_CREDITO => 'Cartão de crédito',
            self::CHEQUE => 'Cheque',
            self::DEPOSITO_BANCARIO => 'Depósito bancário',
            self::DINHEIRO => 'Dinheiro',
            self::PAGAMENTO_ONLINE => 'Pagamento Online'
        };
    }
}
