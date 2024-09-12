<?php

namespace App\Models\Cliente\TicketDesenvolvimento\Enum;

enum PrioridadeTicketDesenvolvimentoEnum: int
{
    case MINIMA = 1;
    
    case MEDIA = 2;
    
    case MAXIMA = 3;
    
    public function label(): string
    {
        return match ($this) {
            self::MINIMA => 'Mínima',
            self::MEDIA => 'Média',
            self::MAXIMA => 'Máxima',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::MINIMA => 'primary',
            self::MEDIA => 'warning',
            self::MAXIMA => 'danger',
        };
    }
}
