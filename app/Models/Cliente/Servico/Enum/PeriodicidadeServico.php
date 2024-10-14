<?php

namespace App\Models\Cliente\Servico\Enum;


enum PeriodicidadeServico: string
{
    case NENHUM = 'NENHUM';
    
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

    public function labelMinuscula(): string
    {
        return match ($this) {
            self::NENHUM => 'única',
            self::MENSAL => 'mensal',
            self::TRIMESTRAL => 'trimestral',
            self::SEMESTRAL => 'semestral',
            self::ANUAL => 'anual',
        };
    }

    public function qtdParcelas(): string
    {
        return match ($this) {
            self::NENHUM => 1,
            self::MENSAL => 12,
            self::TRIMESTRAL => 4,
            self::SEMESTRAL => 2,
            self::ANUAL => 1,
        };
    }

    public static function aPartirDaQtdParcelas(int $qtd): self
    {
        return match ($qtd) {
            1 => self::NENHUM,
            12 => self::MENSAL,
            4 => self::TRIMESTRAL,
            2 => self::SEMESTRAL,
            1 => self::ANUAL,
        };
    }
}
