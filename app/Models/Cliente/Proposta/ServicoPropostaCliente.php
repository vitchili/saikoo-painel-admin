<?php

namespace App\Models\Cliente\Proposta;

use App\Models\Cliente\Servico\TipoServicoCliente;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicoPropostaCliente extends Model
{
    use HasFactory, SoftDeletes;

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $table = 'servicos_propostas_clientes';

    protected $fillable = [
        'proposta_id',
        'servico_id',
        'qtd',
        'valor',
        'calc_por_qtd',
        'cobrar_instalacao',
    ];

    public function proposta(): BelongsTo
    {
        return $this->belongsTo(PropostaCliente::class, 'proposta_id');
    }

    public function tipoServico(): BelongsTo
    {
        return $this->belongsTo(TipoServicoCliente::class, 'servico_id');
    }
}
