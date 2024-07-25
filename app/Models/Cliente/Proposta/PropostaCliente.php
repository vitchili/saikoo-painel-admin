<?php

namespace App\Models\Cliente\Proposta;

use App\Models\Cliente\Cliente;
use App\Models\Cliente\Servico\TipoServicoCliente;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PropostaCliente extends Model
{
    use HasFactory;

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $table = 'propostas_clientes';

    protected $fillable = [
        'cliente_id',
        'responsavel_id',
        'cidade_id',
        'apresentacao_info_opcionais',
        'apresentacao_split_pagamento',
        'apresentacao_sms_mensal',
        'apresentacao_saikoo_mobile',
        'apresentacao_modulos_fiscais',
        'apresentacao_agenda_online',
        'apresentacao_cartao_comanda',
        'apresentacao_microterminal_comanda',
        'apresentacao_terminal_comanda_touch_screen',
        'apresentacao_terminal_comanda_tablet',
        'apresentacao_requisitos_minimos_instalacao',
        'info',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function valoresEDescontosProposta(): HasMany
    {
        return $this->hasMany(ValorEDescontoPropostaCliente::class, 'proposta_id');
    }

    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }

    public function servicosPropostaCliente(): HasMany
    {
        return $this->hasMany(ServicoPropostaCliente::class, 'proposta_id');
    }

    public function servicos(): HasMany
    {
        return $this->hasMany(ServicoPropostaCliente::class, 'proposta_id');
    }
}
