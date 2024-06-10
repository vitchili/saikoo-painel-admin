<?php

namespace App\Models\Cliente\Contato\Enum;

enum SituacaoContato: int
{

    case DESCONHECIDO = 0;
    
    case ABERTO = 1;
    
    case ENCERRADO = 2;
    
    public function label(): string
    {
        return match ($this) {
            self::ABERTO => 'Aberto',
            self::ENCERRADO => 'Encerrado',
            self::DESCONHECIDO => 'Desconhecido',
        };
    }

    public static function getEnumArray(): array {
        $enumArray = [];
        
        foreach (self::cases() as $case) {
            $enumArray[$case->name] = $case->value;
        }
        
        return $enumArray;
    }
}
