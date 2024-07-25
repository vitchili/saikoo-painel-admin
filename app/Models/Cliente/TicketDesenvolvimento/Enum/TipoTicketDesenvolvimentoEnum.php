<?php

namespace App\Models\Cliente\TicketDesenvolvimento\Enum;

enum TipoTicketDesenvolvimentoEnum: int
{
    case NOVO_REQUISITO = 1;
    
    case ERRO = 2;
    
    public function label(): string
    {
        return match ($this) {
            self::NOVO_REQUISITO => 'Novo Requisito',
            self::ERRO => 'Erro',
        };
    }
}
