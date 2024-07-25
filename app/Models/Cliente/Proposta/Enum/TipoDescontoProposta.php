<?php

namespace App\Models\Cliente\Proposta\Enum;

enum TipoDescontoProposta: int
{
    case NENHUM = 1;
    
    case REAIS = 2;
    
    case PORCENTAGEM = 3;
    
    public function label(): string
    {
        return match ($this) {
            self::NENHUM => 'Nenhum',
            self::REAIS => 'Reais',
            self::PORCENTAGEM => 'Porcentagem',
        };
    }
}
