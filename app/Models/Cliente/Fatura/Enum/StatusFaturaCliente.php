<?php

namespace App\Models\Cliente\Fatura\Enum;

enum StatusFaturaCliente: string
{
    case AGUARDANDO_PAGAMENTO = 'Aguardando Pagto';
    
    case APROVADO = 'Aprovado';
    
    case CANCELADO = 'Cancelado';
    
    case EM_ABERTO = 'Em aberto';
    
    case INADIMPLENTE = 'Inadimplente';

    case ERRO = 'Erro BitPag';
    
    public function label(): string
    {
        return match ($this) {
            self::AGUARDANDO_PAGAMENTO => 'Aguardando Pagto',
            self::APROVADO => 'Aprovado',
            self::CANCELADO => 'Cancelado',
            self::EM_ABERTO => 'Em aberto',
            self::INADIMPLENTE => 'Inadimplente',
            self::ERRO => 'Erro'
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::AGUARDANDO_PAGAMENTO => 'warning',
            self::APROVADO => 'success',
            self::CANCELADO => 'danger',
            self::EM_ABERTO => 'primary',
            self::INADIMPLENTE => 'danger',
            self::ERRO => 'danger',
        };
    }
}
