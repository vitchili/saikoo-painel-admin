<?php

namespace App\Models\Cliente\Servico\Enum;


enum ParametroComissao: string
{
    case NENHUM = 'Nenhum';
    
    case VENCIMENTOS = 'Vencimentos dos pagamentos';
    
    case DATA_COMANDA = 'Data da comanda';
    
    public function label(): string
    {
        return match ($this) {
            self::NENHUM => 'Nenhum',
            self::VENCIMENTOS => 'Vencimentos dos pagamentos',
            self::DATA_COMANDA => 'Data da comanda'
        };
    }
}
