<?php

namespace App\Models\Cliente\TicketDesenvolvimento\Enum;

enum SituacaoTicketDesenvolvimentoEnum: int
{
    case AGUARDANDO_ANALISE = 1;
    
    case AGUARDANDO_DESENVOLVIMENTO = 2;

    case EM_DESENVOLVIMENTO = 3;

    case AGUARDANDO_HOMOLOGACAO = 4;
    
    case EM_HOMOLOGACAO = 5;

    case HOMOLOGADO = 6;

    case DEVOLVIDO_PARA_ANALISE = 7;

    case DEVOLVIDO_PARA_DESENVOLVIMENTO = 8;

    case NAO_IRA_DESENVOLVER = 9;

    case CONCLUIDO = 10;
    
    public function label(): string
    {
        return match ($this) {
            self::AGUARDANDO_ANALISE => 'Aguardando Análise',
            self::AGUARDANDO_DESENVOLVIMENTO => 'Aguardando Desenvolvimento',
            self::EM_DESENVOLVIMENTO => 'Em Desenvolvimento',
            self::AGUARDANDO_HOMOLOGACAO => 'Aguardando Homologação',
            self::EM_HOMOLOGACAO => 'Em Homologação',
            self::HOMOLOGADO => 'Homologado',
            self::DEVOLVIDO_PARA_ANALISE => 'Devolvido para análise',
            self::DEVOLVIDO_PARA_DESENVOLVIMENTO => 'Devolvido para desenvolvimento',
            self::NAO_IRA_DESENVOLVER => 'Não irá desenvolver',
            self::CONCLUIDO => 'Concluído',
        };
    }
}
