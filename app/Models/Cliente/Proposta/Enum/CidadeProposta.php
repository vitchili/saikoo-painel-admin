<?php

namespace App\Models\Cliente\Proposta\Enum;

enum CidadeProposta: int
{
    case CUIABA_VARZEA_GRANDE = 1;
    
    case OUTRAS_MT = 2;
    
    case OUTROS_ESTADOS = 3;
    
    public function label(): string
    {
        return match ($this) {
            self::CUIABA_VARZEA_GRANDE => 'Cuiabá Várzea Grande',
            self::OUTRAS_MT => 'Outras cidades MT',
            self::OUTROS_ESTADOS => 'Outros estados',
        };
    }
}
