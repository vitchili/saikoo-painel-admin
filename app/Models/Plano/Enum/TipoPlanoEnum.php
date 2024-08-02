<?php

namespace App\Models\Plano\Enum;

enum TipoPlanoEnum: int
{
    case SISTEMA = 1;
    
    case TREINAMENTO = 2;
    
    case SUPORTE_TELEFONICO = 3;
    
    case HOSPEDAGEM = 4;
    
    case DOMINIO = 5;

    public function label(): string
    {
        return match ($this) {
            self::SISTEMA => 'Sistema',
            self::TREINAMENTO => 'Treinamento',
            self::SUPORTE_TELEFONICO => 'Suporte Telefônico',
            self::HOSPEDAGEM => 'Hospegagem',
            self::DOMINIO => 'Domínio'
        };
    }
}
