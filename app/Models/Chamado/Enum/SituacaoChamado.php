<?php

namespace App\Models\Chamado\Enum;

enum SituacaoChamado: int
{
    case ABERTO = 1;
    
    case CONFIRMADO = 2;
    
    case EM_ATENDIMENTO = 3;
    
    case CONCLUIDO = 4;
    
    case CANCELADO = 5;

    public function label(): string
    {
        return match ($this) {
            self::ABERTO => 'Em Aberto',
            self::CONFIRMADO => 'Confirmado',
            self::EM_ATENDIMENTO => 'Em Atendimento',
            self::CONCLUIDO => 'Concluído',
            self::CANCELADO => 'Cancelado'
        };
    }
}
