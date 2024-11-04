<?php

namespace App\Models\Cliente\Fatura\Enum;

enum StatusPagamentoBitPag: string
{
    case PROCESSANDO = 'processing';
    
    case PENDENTE = 'pending';
    
    case PAGO = 'paid';
    
    case ERRO = 'error';
    
    case CANCELANDO = 'canceling';

    case CANCELADO = 'cancelled';
    
    case ATRASADO = 'overdue';
    
    case ESTORNADO = 'reversed';
    
    case CONTESTADO = 'chargedback';
    
    public function label(): string
    {
        return match ($this) {
            self::PROCESSANDO => 'Processando',
            self::PENDENTE => 'Pendente',
            self::PAGO => 'Pago',
            self::ERRO => 'Erro',
            self::CANCELANDO => 'Cancelando',
            self::CANCELADO => 'Cancelado',
            self::ATRASADO => 'Atrasado',
            self::ESTORNADO => 'Estornado',
            self::CONTESTADO => 'Contestado',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PROCESSANDO => 'primary',
            self::PAGO => 'success',
            self::PENDENTE => 'warning',
            self::ERRO => 'danger',
            self::CANCELANDO => 'danger',
            self::CANCELADO => 'danger',
            self::ATRASADO => 'warning',
            self::ESTORNADO => 'danger',
            self::CONTESTADO => 'danger',
        };
    }
}
