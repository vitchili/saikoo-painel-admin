<?php

namespace App\Models\Cliente\Servico\Enum;


enum PeriodicidadeServico: string
{
    case NENHUM = 'Nenhum';
    
    case MENSAL = 'MES';

    case TRIMESTRAL = 'TRIMESTRAL';
    
    case SEMESTRAL = 'SEMESTRE';
    
    case ANUAL = 'ANO';
    
    public function label(): string
    {
        return match ($this) {
            self::NENHUM => 'Nenhum',
            self::MENSAL => 'Mensal',
            self::TRIMESTRAL => 'Trimestral',
            self::SEMESTRAL => 'Semestral',
            self::ANUAL => 'Anual',
        };
    }
}
