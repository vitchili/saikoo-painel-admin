<?php

namespace App\Models\Cliente\Proposta\Enum;

enum TipoRecorrenciaCobrancaProposta: int
{
    case UNICA = 1;
    
    case MENSAL = 2;
    
    public function label(): string
    {
        return match ($this) {
            self::UNICA => 'Única',
            self::MENSAL => 'Mensal',
        };
    }
}
