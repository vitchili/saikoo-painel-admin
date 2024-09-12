<?php

namespace App\Models\Cliente\Fatura\Enum;

enum FormaPagamento: string
{
    case BOLETO = 'Boleto';
    
    case CARTAO_DE_CREDITO = 'Cartão de crédito';
    
    //case CHEQUE = 'Cheque';
    
    case PIX = 'Pix';
    
    case DINHEIRO = 'Dinheiro';
    
    //case PAGAMENTO_ONLINE = 'Pagamento Online';

    public function label(): string
    {
        return match ($this) {
            self::BOLETO => 'Boleto',
            self::CARTAO_DE_CREDITO => 'Cartão de crédito',
            //self::CHEQUE => 'Cheque',
            self::PIX => 'Pix',
            self::DINHEIRO => 'Dinheiro',
            //self::PAGAMENTO_ONLINE => 'Pagamento Online'
        };
    }
}
