<?php

namespace App\Models\Cliente\Contato\Enum;

enum SituacaoContato: int
{
    case ABERTO = 1;
    
    case ENCERRADO = 2;
    
    public function label(): string
    {
        return match ($this) {
            self::ABERTO => 'Aberto',
            self::ENCERRADO => 'Encerrado'
        };
    }
}
