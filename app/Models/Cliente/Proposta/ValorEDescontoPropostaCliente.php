<?php

namespace App\Models\Cliente\Proposta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ValorEDescontoPropostaCliente extends Model
{
    use HasFactory;

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $table = 'valores_e_descontos_propostas_clientes';

    protected $fillable = [
        'descricao',
        'proposta_id',
        'tipo_recorrencia_cobranca_id',
        'qtd_profissionais',
        'valor',
        'tipo_desconto_id',
        'valor_desconto',
    ];

    public function proposta(): BelongsTo
    {
        return $this->belongsTo(PropostaCliente::class, 'proposta_id');
    }
}
